<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Classes;
use App\Models\Topic;
use App\Models\Subject;
use App\Models\Lecture;
use App\Models\Topics_taken;
use Auth;

class LecturesController extends Controller
{
    public function index(){
    	return view("lectures.index");
    }

    public function ajaxSubject(Request $request){
        if($request->ajax()){
            // $class_id = DB::table('classes')->select('select id from classes where department=? and year=? and status=? group by batch desc limit 1',[$request->department,$request->year,1]);
            $class_id = DB::table('classes')->where([['department','=',$request->department],['year','=',$request->year],['status','=',1]])->orderBy('batch','desc')->pluck('id')[0];
            $subjects = DB::table('subjects')->where([['classes_id','=',$class_id],['status','=',1]])->pluck('name','id')->all();
            $data = view('lectures.ajax_subjects',compact('subjects'))->render();
            return response()->json(['options' => $data]);
            // var_dump($class_id);
        }

    }

    public function list(Request $request){
    	// return $request;
    	// $data = array();
        $rules = [
            'year' => 'required',
            'subject' => 'required',
            'type' => 'required',
            'students_present' => 'required|numeric'
        ];

        if($request->adjust == 1){
            $rules['timeslot'] = 'required';
        }
        $this->validate($request,$rules);

    	$subject = Subject::find($request->subject);
    	$department = $request->department;
        $year = $request->year;
        $subject_id = $request->subject;
        $type = $request->type;
        $students_present = $request->students_present;
        $adjusted = $request->adjust;
        $timeslot = $request->timeslot;

        // $topics = $subject->topics->where('state','=',0)->where('status','=',1)->where('type','=',$request->type)->sortBy('due_date');

        $topics = $subject->topics->where('status','=',1)->where('type','=',$request->type)->sortBy('due_date');

    	// return $request;
    	return view('lectures.list')->with(['department' => $department,'year' => $year,'subject_id' => $subject_id,'type' => $type,'students_present' => $students_present,'adjusted' => $adjusted,'timeslot' => $timeslot,'topics' => $topics]);

    }

    public function store(Request $request,$data){
        // $data = explode(" ",$data);
        $data = json_decode($data);
        $id = explode(',',$request->input('hidden'));
        // return $data;
        // echo "hello";

        $lecture = new Lecture;
        $lecture->user_id = Auth::user()->id;
        $lecture->subject_id = $data[2];
        $lecture->type = $data[3]; 
        $lecture->isAdjusted = $data[5];
        $lecture->timeslot = $data[6];
        $lecture->created_by = Auth::user()->id;
        $lecture->save();
        $count = sizeof($id);

        for($i=0;$i<$count;$i++){
            $topic_taken = new Topics_taken;
            $topic_taken->lecture_id = $lecture->id;
            $topic_taken->topic_id = $id[$i];
            $topic_taken->students_present = $data[4];
            $topic_taken->created_by = Auth::user()->id;
            $topic_taken->save();

            $topic = Topic::find($id[$i]);
            $topic->state = 1;
            $topic->save();
        }

        // return view('lectures.index')->with('success','Successfully created');
        return redirect('/lectures')->with('success','Successfully created');
    }
}
