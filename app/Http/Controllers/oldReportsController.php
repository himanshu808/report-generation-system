<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Topics_taken;
use App\Models\Lecture;
use App\Models\Classes;
use Illuminate\Support\Facades\DB;


class oldReportsController extends Controller
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

    	$subjects = Classes::find($request->input('batch'))->subjects;
    	// return view('reports.generate')->with('subjects',$subjects);

    	$data = array();
    	foreach($subjects as $subject){
            $lectures_taken = array();
            $actual_lectures_taken = array();
            $actual_practicals_taken = array();
            $unique_lectures = array();
            $unique_practicals = array();
            $adjusted_lectures = 0;
            $adjusted_practicals = 0;

            // $practicals_taken = 0;
            $practicals_taken = array();
            $tutorials_taken = 0;
            $assignments_taken = 0;
          	$data[$subject->name] = array();
            $total_topics = 0;
            $course_code = $subject->course_code;
            // $leaves = 0;

            // $leaves = DB::table('leaves')->join('users','leaves.user_id','=','users.id')->join('subjects','subjects.user_id','=','users.id')->whereMonth('leaves.created_at',$request->month)->count();

            $user = $subject->user;
            $user_id = $user->id;
            //USE DATE INSTEAD OF CREATED_AT LATER
            $leaves = DB::table('leaves')->where('user_id','=',$user_id)->whereMonth('created_at',$request->month)->count();

            //number of lectures required field in topics
            // $lectures_planned = DB::table('topics')->where([['subject_id','=',$subject->id],['type','=',1]])->whereMonth('due_date',$request->month)->count();
            // $practicals_planned = DB::table('topics')->where([['subject_id','=',$subject->id],['type','=',2]])->whereMonth('due_date',$request->month)->count();

            $lectures_planned = DB::table('month_subject')->where([['subject_id','=',$subject->id],['month_id','=',$request->month]])->value('lectures_planned');
            $practicals_planned = DB::table('month_subject')->where([['subject_id','=',$subject->id],['month_id','=',$request->month]])->value('practicals_planned');
            $tutorials_planned = DB::table('topics')->where([['subject_id','=',$subject->id],['type','=',3]])->whereMonth('due_date',$request->month)->count();
            $assignments_planned = DB::table('topics')->where([['subject_id','=',$subject->id],['type','=',4]])->whereMonth('due_date',$request->month)->count();

      		$topics = $subject->topics;
            $total_topics = sizeof($topics);

            // $topics_taken = DB::table('topics')->where([['subject_id','=',$subject->id],['type','=',1],['state','=',1]])->whereMonth('updated_at',$request->month)->count();
            $topics_taken = DB::table('topics')->join('topics_taken','topics.id','=','topics_taken.topic_id')->where([['topics.subject_id','=',$subject->id],['topics.type','=',1],['topics.state','=',1]])->whereMonth('topics_taken.created_at','<=',$request->month)->count();
            $syllabus_covered = round(($topics_taken * 100)/$total_topics,2) ."%";

      		$c = 1;
      		foreach($topics as $topic){
                // $month = substr($topic->due_date,5,2);
                // echo $month."\n";
                // var_dump($topic->due_date);
                if($topic->type ==  2){
                    // $practical_count = DB::table('topics_taken')->join('topics','topics_taken.topic_id','=','topics.id')->where([['topics_taken.topic_id','=',$topic->id],['topics.type','=',2]])->whereMonth('topics_taken.created_at',$request->month)->count()[0];

                    // if($practical_count > 0){
                    //     $practicals_taken++;
                    // }

                    $practical_id = DB::table('topics_taken')->join('topics','topics_taken.topic_id','=','topics.id')->where([['topics_taken.topic_id','=',$topic->id],['topics.type','=',2]])->whereMonth('topics_taken.created_at',$request->month)->pluck('topics_taken.lecture_id');

                    // print_r($practical_id);

                    for($i=0;$i<sizeof($practical_id);$i++){
                        array_push($practicals_taken, $practical_id[$i]);
                        // $practical = Lecture::find($practical_id[$i]);
                        // if($practical->isAdjusted == 1){
                        //     $adjusted_practicals++;
                        // }
                    }

                    if(substr($topic->due_date,5,2) == $request->month){
                        $actual_practical_id = DB::table('topics_taken')->join('topics','topics_taken.topic_id','=','topics.id')->where([['topics_taken.topic_id','=',$topic->id],['topics.type','=',2]])->whereMonth('topics_taken.created_at',$request->month)->pluck('topics_taken.lecture_id');

                        // print_r($actual_practical_id);

                        for($i=0;$i<sizeof($actual_practical_id);$i++){
                            array_push($actual_practicals_taken, $actual_practical_id[$i]);
                        }
                    }


                }
                elseif($topic->type == 3) {
                    $tutorial_count = DB::table('topics_taken')->join('topics','topics_taken.topic_id','=','topics.id')->where([['topics_taken.topic_id','=',$topic->id],['topics.type','=',3]])->whereMonth('topics_taken.created_at',$request->month)->count()[0];

                    if($tutorial_count > 0){
                        $tutorials_taken++;
                    }
                }
                elseif($topic->type == 4){
                    $assignment_count = DB::table('topics_taken')->join('topics','topics_taken.topic_id','=','topics.id')->where([['topics_taken.topic_id','=',$topic->id],['topics.type','=',4]])->whereMonth('topics_taken.created_at',$request->month)->count()[0];

                    if($assignment_count > 0){
                        $assignments_taken++;
                    }
                }
                else{
                    $lecture_id = DB::table('topics_taken')->join('topics','topics_taken.topic_id','=','topics.id')->where([['topics_taken.topic_id','=',$topic->id],['topics.type','=',1]])->whereMonth('topics_taken.created_at',$request->month)->pluck('topics_taken.lecture_id');
                    
                    for($i=0;$i<sizeof($lecture_id);$i++){
                        array_push($lectures_taken, $lecture_id[$i]);
                    }

                    //lectures taken in the month in which they were planned
                    if(substr($topic->due_date,5,2) == $request->month){
                        $actual_lecture_id = DB::table('topics_taken')->join('topics','topics_taken.topic_id','=','topics.id')->where([['topics_taken.topic_id','=',$topic->id],['topics.type','=',1]])->whereMonth('topics_taken.created_at',$request->month)->whereMonth('topics.due_date',$request->month)->pluck('topics_taken.lecture_id');

                        for($i=0;$i<sizeof($actual_lecture_id);$i++){
                            array_push($actual_lectures_taken, $actual_lecture_id[$i]);
                        }
                    }

                }

               

                // $practical_id = DB::table('topics_taken')->join('topics','topics_taken.topic_id','=','topics.id')->where([['topics_taken.topic_id','=',$topic->id],['topics.type','=',2]])->pluck('topics_taken.lecture_id'); 

                // $tutorial_id = DB::table('topics_taken')->join('topics','topics_taken.topic_id','=','topics.id')->where([['topics_taken.topic_id','=',$topic->id],['topics.type','=',3]])->pluck('topics_taken.lecture_id');
                // // $tut += DB::table('topics_taken')->join('topics','topics_taken.topic_id','=','topics.id')->where([['topics_taken.topic_id','=',$topic->id],['topics.type','=',3]])->pluck('topics_taken.lecture_id')->unique()->count()[0];

                // $assignment_id = DB::table('topics_taken')->join('topics','topics_taken.topic_id','=','topics.id')->where([['topics_taken.topic_id','=',$topic->id],['topics.type','=',4]])->pluck('topics_taken.lecture_id');

               

                // for($i=0;$i<sizeof($practical_id);$i++){
                //     array_push($practicals_taken, $practical_id[$i]);
                // }

                // for($i=0;$i<sizeof($assignment_id);$i++){
                //     array_push($assignments_taken, $assignment_id[$i]);
                // }

                // for($i=0;$i<sizeof($tutorial_id);$i++){
                //     array_push($tutorials_taken, $tutorial_id[$i]);
                // }
  		    }

            //CHECK AGAIN
            $unique_lectures = array_unique($lectures_taken);
            $unique_practicals = array_unique($practicals_taken);
            
            for($i=0;$i<sizeof($unique_lectures);$i++){
                $lecture = Lecture::find($unique_lectures[$i]);
                if($lecture->isAdjusted == 1){
                    $adjusted_lectures++;
                }
            }

            for($i=0;$i<sizeof($unique_practicals);$i++){
                 $lecture = Lecture::find($unique_practicals[$i]);
                if($lecture->isAdjusted == 1){
                    $adjusted_practicals++;
                }
            }

            $total_lectures_taken = sizeof(array_unique($lectures_taken));
            $total_practicals_taken = sizeof(array_unique($practicals_taken));
            $total_actual_lectures = sizeof(array_unique($actual_lectures_taken));
            $total_actual_practicals = sizeof(array_unique($actual_practicals_taken));
            // $total_tutorials_taken = sizeof(array_unique($tutorials_taken));
            // $total_assignments_taken = sizeof(array_unique($assignments_taken));

        

            $data[$subject->name]["name"] = $subject->name;
            $data[$subject->name]["course_code"] = $course_code;

            $data[$subject->name]["lectures_planned"] = $lectures_planned;        
            $data[$subject->name]["practicals_planned"] = $practicals_planned;
            $data[$subject->name]["tutorials_planned"] = $tutorials_planned;
            $data[$subject->name]["assignments_planned"] = $assignments_planned;

      		$data[$subject->name]["lectures_taken"] = $total_lectures_taken;    		
            $data[$subject->name]["practicals_taken"] = $total_practicals_taken;
            $data[$subject->name]["tutorials_taken"] = $tutorials_taken;
            $data[$subject->name]["assignments_taken"] = $assignments_taken;

            $data[$subject->name]["extra"] = ($lectures_planned + $practicals_planned) - ($total_actual_lectures + $total_actual_practicals);
            // $data[$subject->name]["actual_lectures"] = $total_actual_lectures;
            // $data[$subject->name]["actual_practicals"] = $total_actual_practicals;
            // $data[$subject->name]["practicals_taken"] = $practicals_taken;
            
            $data[$subject->name]["total_topics"] = $total_topics;
            $data[$subject->name]["topics_taken"] = $topics_taken;
            $data[$subject->name]["syllabus_covered"] = $syllabus_covered;
            $data[$subject->name]["month"] = $request->month;
            $data[$subject->name]["leaves"] = $leaves;

            $data[$subject->name]["adjusted_lectures"] = $adjusted_lectures;
            $data[$subject->name]["adjusted_practicals"] = $adjusted_practicals;
            $data[$subject->name]["total_adjusted"] = $adjusted_lectures + $adjusted_practicals;
        }



    	return $data;
        // return view('reports.generate')->with("subjects",$data);    
    }


}
