<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Classes;
use App\Models\Subject;
use App\Models\Topic;
use Illuminate\Support\Facades\DB;
use Auth;

class TopicsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('topics.index');

        // return $batches;
    }

    public function ajaxCall(Request $request){
        if($request->ajax()){
            // $class_id = DB::table('classes')->where([['department','=',$request->department],['year','=',$request->year],['batch','=',$request->batch]])->pluck('id');
            $subjects = DB::table('subjects')->where([['classes_id','=',$request->id],['status','=',1]])->pluck('name','id')->all();
            $data = view('topics.ajax_subjects',compact('subjects'))->render();
            return response()->json(['options' => $data]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($subject_id)
    {
        $subject = Subject::find($subject_id);
        return view('topics.create')->with('subject', $subject);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $subject_id)
    {
        $this->validate($request, [
            'name' => 'required',
            'type' => 'required',
            'due_date' => 'required|date_format:Y-m-d'
        ]);

        $topic = new Topic;
        $topic->subject_id = $subject_id;
        $topic->name = $request->input('name');
        $topic->due_date = $request->input('due_date');
        $topic->type = $request->input('type');
        $topic->state = 0;
        $topic->created_by = Auth::user()->id;

        $topic->save();

        $subject = Subject::find($subject_id);
        $topics = $subject->topics;

        // re/
        // return redirect('/topics/list')->with(['topics' => $topics,'subject_id' => $subject_id, 'success' => 'Successfully created']);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $topic = Topic::find($id);
        // return $topic;
        $subject = $topic->subject;

        return view('topics.edit')->with(['topic' => $topic, 'subject' => $subject]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'due_date' => 'required|date_format:Y-m-d',
            'type' => 'required'
        ]);

        $topic = Topic::find($id);
        $topic->name = $request->input('name');
        $topic->due_date = $request->input('due_date');
        $topic->type = $request->input('type');
        $topic->updated_by = Auth::user()->id;
        $topic->save();

        $subject_id = $topic->subject->id;
        $topics = Subject::find($subject_id)->topics;
        return view('topics.list')->with(['topics' => $topics,'subject_id' => $subject_id,'success' => "Successfully updated"]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($topic_id, $subject_id)
    {
        $topics = Subject::find($subject_id)->topics;

        $topic = Topic::find($topic_id);
        $topic->status = 0;
        $topic->deleted_by = Auth::user()->id;
        $topic->save();

        return view('topics.list')->with(['topics' => $topics,'subject_id' => $subject_id,'success' => "Successfully deleted"]);
    }

    public function list(Request $request){
        $this->validate($request, [
            'department' => 'required',
            'year' => 'required',
            'subject' => 'required'
        ]);

        $subject_id = $request->input('subject');
        $topics = Subject::find($subject_id)->topics;
        return view('topics.list')->with(['topics' => $topics,'subject_id' => $subject_id]);
    }
}
