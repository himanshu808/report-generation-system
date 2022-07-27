<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Topics_taken;
use App\Models\Lecture;
use App\Models\Classes;
use App\Models\Subject;
use Illuminate\Support\Facades\DB;
use Excel;
use App\Exports\MidtermExport;

class MidtermController extends Controller
{
    public function index(){
    	return view('midterm.index');
    }

    public function generate(Request $request){
    	// return $request;
        $this->validate($request,[
            'year' => 'required',
            'batch' => 'required',
            'from' => 'required',
            'to' => 'required|after:from'
        ]);
    	$from = date($request->from);
    	$to = date($request->to);

    	$subjects = Classes::find($request->input('batch'))->subjects;

    	$data = array();

    	foreach($subjects as $subject){
    		$data[$subject->name] = array();
    		$course_code = $subject->course_code;

    		$user = $subject->user;
            $user_id = $user->id;

            //TOTAL ALLOTTED
            $total_hours = $subject->total_hours;
            $total_practicals = $subject->total_practicals;
            $total_tutorials = $subject->total_tutorials;
            $total_assignments = $subject->total_assignments;

            //ACTUAL TAKEN
            $hours_taken = DB::table('lectures')->where([['subject_id','=',$subject->id],['type','=',1], ['status','=',1]])->whereBetween('created_at',[$from,$to])->count();
            $practicals_taken = DB::table('lectures')->where([['subject_id','=',$subject->id],['type','=',2], ['status','=',1]])->whereBetween('created_at',[$from,$to])->count();
            $tutorials_taken = DB::table('lectures')->where([['subject_id','=',$subject->id],['type','=',3], ['status','=',1]])->whereBetween('created_at',[$from,$to])->count();
            $assignments_taken = DB::table('lectures')->where([['subject_id','=',$subject->id],['type','=',4], ['status','=',1]])->whereBetween('created_at',[$from,$to])->count();

            //% OF SYLLABUS
            $topics = $subject->topics;
            $total_topics = sizeof($topics);
            
            // $topics_taken = DB::table('topics')->join('topics_taken','topics.id','=','topics_taken.topic_id')->where([['topics.subject_id','=',$subject->id],['topics.type','=',1],['topics.state','=',1],['topics.status','=',1]])->whereMonth('topics_taken.created_at','<=',$request->month)->count();

            $topics_taken = DB::table('topics')->join('topics_taken','topics.id','=','topics_taken.topic_id')->where([['topics.subject_id','=',$subject->id],['topics.type','=',1],['topics.state','=',1],['topics.status','=',1]])->whereBetween('topics_taken.created_at',[$from,$to])->count();
            $syllabus_covered = round(($topics_taken * 100)/$total_topics,2) ."%";

            // LEAVES
            $leaves = DB::table('leaves')->where([['user_id','=',$user_id],['status','=',1]])->whereBetween('date',[$from,$to])->count();
            if($leaves == 0){
                $leaves = "-";
            }        


            //ADJUSTED
            $adjusted_lectures = DB::table('lectures')->where([['subject_id','=',$subject->id],['type','=',1],['isAdjusted','=',1],['status','=',1]])->whereBetween('created_at',[$from,$to])->count();
            $adjusted_practicals = DB::table('lectures')->where([['subject_id','=',$subject->id],['type','=',2],['isAdjusted','=',1],['status','=',1]])->whereBetween('created_at',[$from,$to])->count();

            //ADJUSTED DETAILS
            $adjusted_details = $subject->lectures()->where([['type','<',3],['status','=',1],['isAdjusted','=',1]])->whereBetween('created_at',[$from,$to])->get();

            //TOTAL LECTURES TAKEN TILL DATE
            $lectures_taken_till_date = DB::table('lectures')->where([['subject_id','=',$subject->id],['type','=',1], ['status','=',1]])->whereDate('created_at','<',$to)->count();
            $practicals_taken_till_date = DB::table('lectures')->where([['subject_id','=',$subject->id],['type','=',2], ['status','=',1]])->whereDate('created_at','<',$to)->count();

            //DATA
            $data[$subject->name]["course_code"] = $course_code;
            $data[$subject->name]["name"] = $subject->name;

            $data[$subject->name]["total_hours"] = $total_hours; 
            $data[$subject->name]["hours_taken"] = $hours_taken;      

            $data[$subject->name]["total_practicals"] = $total_practicals;
            $data[$subject->name]["practicals_taken"] = $practicals_taken;

            $data[$subject->name]["total_tutorials"] = $total_tutorials;
            $data[$subject->name]["tutorials_taken"] = $tutorials_taken;

            $data[$subject->name]["total_assignments"] = $total_assignments;
            $data[$subject->name]["assignments_taken"] = $assignments_taken;

            $data[$subject->name]["syllabus_covered"] = $syllabus_covered;

            $data[$subject->name]["leaves"] = $leaves;

            $data[$subject->name]["lectures_remaining"] = $total_hours - $lectures_taken_till_date;
            $data[$subject->name]["practicals_remaining"] = $total_practicals - $practicals_taken_till_date;

            $data[$subject->name]["total_remaining"] = $data[$subject->name]["lectures_remaining"] + $data[$subject->name]["practicals_remaining"];

         	$data[$subject->name] = preg_replace("(^[0]+$)", "-", $data[$subject->name]);
            $data[$subject->name]["adjusted_details"] = $adjusted_details;

    	}

    	// return $data;
    	return view('midterm.generate')->with(['subjects' => $data,'from' => $from, 'to' => $to]);
    }

    public function adjustedDetails(Request $request, $course_code, $from, $to){
    	$subject_id = Subject::where('course_code','=',$course_code)->value('id');
    	$subject = Subject::find($subject_id);
    	$adjusted_details = $subject->lectures()->where([['type','<',3],['status','=',1],['isAdjusted','=',1]])->whereBetween('created_at',[$from,$to])->get();

    	// return $adjusted_details;
        return view('midterm.adjusted_details')->with('adjusted_details',$adjusted_details);

    }

    public function excel(Request $request){
    	$data = $request->input('data');
        for($i=0;$i<sizeof($data);$i++){
            $data[$i] = json_decode(json_decode($data[$i],true),true);
        }

        // return $data;
        $class_id = Subject::where('course_code','=',$data[0]['course_code'])->value('classes_id');
        $class = Classes::find($class_id);
        $dept = $class->department;
        $year = $class->year;
        $batch = $class->batch;

        return Excel::download(new MidtermExport($data),$dept.'_'.$year.'_'.$batch.'.xlsx');
    }
}
