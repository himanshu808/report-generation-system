<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Topics_taken;
use App\Models\Lecture;
use App\Models\Classes;
use App\Models\Subject;
use Illuminate\Support\Facades\DB;
use Excel;
use App\Exports\ExcelExport;


class ReportsController extends Controller
{
    public function index(){
    	return view('reports.index');
    }

    public function generate(Request $request){
        //adjusted in lectures
      //ADD MONTH CLAUSE
       
    	$this->validate($request, [
    		'department' => 'required',
    		'year' => 'required',
    		'batch' => 'required',
            'month' => 'required'
    	]);

        // $class = Classes::find($request->input('batch'));
      
        $subjects = Classes::find($request->input('batch'))->subjects;
  
        // $subjects = Classes::select()->where('id','=',$request->input('batch'))->subjects;
        // return array($subjects);
    	// return view('reports.generate')->with('subjects',$subjects);
        // $c = 0;
    	$data = array();
    	foreach($subjects as $subject){
            // $c++;
          	$data[$subject->name] = array();
            $course_code = $subject->course_code;

            $user = $subject->user;
            $user_id = $user->id;;

            //PLANNED
            $lectures_planned = DB::table('month_subject')->where([['subject_id','=',$subject->id],['month_id','=',$request->month]])->value('lectures_planned');
            $practicals_planned = DB::table('month_subject')->where([['subject_id','=',$subject->id],['month_id','=',$request->month]])->value('practicals_planned');
            $tutorials_planned = DB::table('topics')->where([['subject_id','=',$subject->id],['type','=',3],['status','=',1]])->whereMonth('due_date',$request->month)->count();
            $assignments_planned = DB::table('topics')->where([['subject_id','=',$subject->id],['type','=',4],['status','=',1]])->whereMonth('due_date',$request->month)->count();

            //TAKEN
            $lectures_taken = DB::table('lectures')->where([['subject_id','=',$subject->id],['type','=',1],['status','=',1]])->whereMonth('created_at',$request->month)->count();
            $practicals_taken = DB::table('lectures')->where([['subject_id','=',$subject->id],['type','=',2],['status','=',1]])->whereMonth('created_at',$request->month)->count();
            $tutorials_taken = DB::table('lectures')->where([['subject_id','=',$subject->id],['type','=',3],['status','=',1]])->whereMonth('created_at',$request->month)->count();
            $assignments_taken = DB::table('lectures')->where([['subject_id','=',$subject->id],['type','=',4],['status','=',1]])->whereMonth('created_at',$request->month)->count();

            //% OF SYLLABUS
      		$topics = $subject->topics;
            $total_topics = sizeof($topics);
            // $topics_taken = DB::table('topics')->where([['subject_id','=',$subject->id],['type','=',1],['state','=',1]])->whereMonth('updated_at',$request->month)->count();
            $topics_taken = DB::table('topics')->join('topics_taken','topics.id','=','topics_taken.topic_id')->where([['topics.subject_id','=',$subject->id],['topics.type','=',1],['topics.state','=',1],['topics.status','=',1]])->whereMonth('topics_taken.created_at','<=',$request->month)->count();
            $syllabus_covered = round(($topics_taken * 100)/$total_topics,2) ."%";

            // LEAVES
            $leaves = DB::table('leaves')->where([['user_id','=',$user_id],['status','=',1]])->whereMonth('date',$request->month)->count();   
            if($leaves == 0){
                $leaves = "-";
            }        

            //ADJUSTED
            $adjusted_lectures = DB::table('lectures')->where([['subject_id','=',$subject->id],['type','=',1],['isAdjusted','=',1],['status','=',1]])->whereMonth('created_at',$request->month)->count();
            $adjusted_practicals = DB::table('lectures')->where([['subject_id','=',$subject->id],['type','=',2],['isAdjusted','=',1],['status','=',1]])->whereMonth('created_at',$request->month)->count();

            // if($c == 5){
            //     return $adjusted_practicals;
            // }

            //ADJUSTED DETAILS
            $adjusted_details = $subject->lectures()->where([['type','<',3],['status','=',1],['isAdjusted','=',1]])->whereMonth('created_at',$request->month)->get();

            //DATA
            $data[$subject->name]["course_code"] = $course_code;
            $data[$subject->name]["name"] = $subject->name;

            $data[$subject->name]["lectures_planned"] = $lectures_planned; 
            $data[$subject->name]["lectures_taken"] = $lectures_taken;      

            $data[$subject->name]["practicals_planned"] = $practicals_planned;
            $data[$subject->name]["practicals_taken"] = $practicals_taken;

            $data[$subject->name]["tutorials_planned"] = $tutorials_planned;
            $data[$subject->name]["tutorials_taken"] = $tutorials_taken;

            $data[$subject->name]["assignments_planned"] = $assignments_planned;
            $data[$subject->name]["assignments_taken"] = $assignments_taken;

            $data[$subject->name]["syllabus_covered"] = $syllabus_covered;

            $data[$subject->name]["leaves"] = $leaves;

            $data[$subject->name]["adjusted_lectures"] = $adjusted_lectures;
            $data[$subject->name]["adjusted_practicals"] = $adjusted_practicals;
            $data[$subject->name]["total_adjusted"] = $adjusted_lectures + $adjusted_practicals;

            $data[$subject->name]["extra"] = ($lectures_planned + $practicals_planned) - ($lectures_taken + $practicals_taken);
            
            $data[$subject->name]["total_topics"] = $total_topics;
            $data[$subject->name]["topics_taken"] = $topics_taken;
            $data[$subject->name]["month"] = $request->month;

            // $data[$subject->name] = preg_replace("(^[0]+$)", "-", $data[$subject->name]); 
            $data[$subject->name]["adjusted_details"] = $adjusted_details;
           
        }

        // return $data;    
     
        return view('reports.generate')->with("subjects",$data);   
    
        	
    }

    public function adjustedDetails(Request $request, $course_code, $month){
        // return "hello";
        $subject_id = Subject::where('course_code','=',$course_code)->value('id');
        $subject = Subject::find($subject_id);
        $adjusted_details = $subject->lectures()->where([['type','<',3],['status','=',1],['isAdjusted','=',1]])->whereMonth('created_at',$month)->get();

        // return $adjusted_details;
        return view('reports.adjusted_details')->with('adjusted_details',$adjusted_details);

    }

    public function excel(Request $request){
       
        $data = $request->input('data');

        for($i=0;$i<sizeof($data);$i++){
            $data[$i] = json_decode(json_decode($data[$i],true),true);
        }
        $class_id = Subject::where('course_code','=',$data[0]['course_code'])->value('classes_id');
        $class = Classes::find($class_id);
        $dept = $class->department;
        $year = $class->year;
        $batch = $class->batch;
        // return $data[0]['course_code'];

        // $excel_data = array_keys($data[0]);
        // for($i=0;$i<sizeof($data);$i++){
        //     $excel_data [] = array_values($data[$i]);
        // }
        // return $data[0];
        // Excel::create('data',function($excel) use ($excel_data) {
        //     $excel->setTitle('hello');
        //     $excel->sheet('sheet1', function($sheet) use ($excel_data) {
        //         $sheet->fromArray($excel_data, null, 'A1', false, false);
        //     });
        // })->download('xlsx');


        return Excel::download(new ExcelExport($data),$dept.'_'.$year.'_'.$batch.'.xlsx');

    }   

        
}
