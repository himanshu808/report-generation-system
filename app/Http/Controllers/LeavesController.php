<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Leaves;
use Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Classes;
use App\Models\Subject;
use App\User;

class LeavesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->type == 1){
            $user_id = Auth::user()->id;
            // $leaves = DB::table('leaves')->where('user_id','=',$user_id)->get();
            $leaves = Leaves::all()->where('user_id','=',$user_id)->where('status','=',1);
        }
        elseif(Auth::user()->type == 2){
            // $class_id = DB::table('classes')->where('department','=',Auth::user()->department)->value('id');
            $class_id = Classes::all()->where('department','=',Auth::user()->department)->where('status','=',1)->pluck('id');
            // return $class_id;
            // $users = DB::table('subjects')->join('classes','subjects.classes_id','=','classes.id')->where('subjects.classes_id','=',$class_id)->get('subjects.user_id');  
            $users = Subject::all()->whereIn('classes_id',$class_id)->where('status','=',1)->pluck('user_id')->unique();

            $leaves = Leaves::whereIn('user_id',$users)->where('status','=',1)->get();

        }
        else{
            $leaves = Leaves::all()->where('status','=',1);
        }
        
        return view('leaves.index')->with('leaves',$leaves);
        // return $leaves;
     
        // return "hwllo";
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $class_id = Classes::all()->where('department','=',Auth::user()->department)->where('status','=',1)->pluck('id');
        $users = Subject::all()->whereIn('classes_id',$class_id)->where('user_id','!=',Auth::user()->id)->where('status','=',1)->pluck('user_id')->unique();
        $teachers = User::all()->whereIn('id',$users)->where('status','=',1)->pluck('name','id');

        return view('leaves.create')->with('teachers',$teachers);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'leave_date' => 'required|date_format:Y-m-d',
            'adjusted_with' => 'required',
            'adjusted_on' => 'required|date:Y-m-d|after:leave_date',
            'timeslot' => 'required'
        ]);
        $leave = new Leaves;
        // return $leave;
        $leave->user_id = Auth::user()->id;
        $leave->date = $request->leave_date;
        $leave->adjusted_with = $request->adjusted_with;
        $leave->adjusted_on = $request->adjusted_on;
        $leave->timeslot = $request->timeslot;
        $leave->created_by = Auth::user()->id;

        $leave->save();

        if(Auth::user()->type == 1){
            $user_id = Auth::user()->id;
            // $leaves = DB::table('leaves')->where('user_id','=',$user_id)->get();
            $leaves = Leaves::all()->where('user_id','=',$user_id)->where('status','=',1);
        }
        else{
            // $class_id = DB::table('classes')->where('department','=',Auth::user()->department)->value('id');
            $class_id = Classes::all()->where('department','=',Auth::user()->department)->where('status','=',1)->pluck('id');
            // return $class_id;
            // $users = DB::table('subjects')->join('classes','subjects.classes_id','=','classes.id')->where('subjects.classes_id','=',$class_id)->get('subjects.user_id');  
            $users = Subject::all()->whereIn('classes_id',$class_id)->where('status','=',1)->pluck('user_id')->unique();

            $leaves = Leaves::whereIn('user_id',$users)->where('status','=',1)->get();

        }

        // return view('leaves.index')->with(['leaves' => $leaves, 'Success' => 'Successfully created']);
        return redirect('/leaves')->with(['leaves' => $leaves, 'success' => 'Successfully created']);
        // return $request;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $leave = Leaves::find($id);
        $class_id = Classes::all()->where('department','=',Auth::user()->department)->where('status','=',1)->pluck('id');
        $users = Subject::all()->whereIn('classes_id',$class_id)->where('user_id','!=',Auth::user()->id)->where('status','=',1)->pluck('user_id')->unique();
        $teachers = User::all()->whereIn('id',$users)->where('status','=',1)->pluck('name','id');

        return view('leaves.edit')->with(['leave'=> $leave,'teachers' => $teachers]);
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
        $this->validate($request,[
            'leave_date' => 'required|date_format:Y-m-d',
            'adjusted_with' => 'required',
            'adjusted_on' => 'required|date:Y-m-d|after:leave_date',
            'timeslot' => 'required'
        ]);
        $leave = Leaves::find($id);
        $leave->date = $request->leave_date;
        $leave->adjusted_with = $request->adjusted_with;
        $leave->adjusted_on = $request->adjusted_on;
        $leave->timeslot = $request->timeslot;
        $leave->updated_by = Auth::user()->id;

        $leave->save();

        if(Auth::user()->type == 1){
            $user_id = Auth::user()->id;
            // $leaves = DB::table('leaves')->where('user_id','=',$user_id)->get();
            $leaves = Leaves::all()->where('user_id','=',$user_id)->where('status','=',1);
        }
        else{
            // $class_id = DB::table('classes')->where('department','=',Auth::user()->department)->value('id');
            $class_id = Classes::all()->where('department','=',Auth::user()->department)->where('status','=',1)->pluck('id');
            // return $class_id;
            // $users = DB::table('subjects')->join('classes','subjects.classes_id','=','classes.id')->where('subjects.classes_id','=',$class_id)->get('subjects.user_id');  
            $users = Subject::all()->whereIn('classes_id',$class_id)->where('status','=',1)->pluck('user_id')->unique();

            $leaves = Leaves::whereIn('user_id',$users)->where('status','=',1)->get();

        }

        // return view('leaves.index')->with(['leaves' => $leaves, 'Success' => 'Successfully updated']);
        return redirect('/leaves')->with(['leaves' => $leaves, 'success' => 'Successfully updated']);
    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $leave = Leaves::find($id);
        $leave->status = 0;
        $leave->deleted_by = Auth::user()->id;
        $leave->save();

        if(Auth::user()->type == 1){
            $user_id = Auth::user()->id;
            // $leaves = DB::table('leaves')->where('user_id','=',$user_id)->get();
            $leaves = Leaves::all()->where('user_id','=',$user_id)->where('status','=',1);
        }
        else{
            // $class_id = DB::table('classes')->where('department','=',Auth::user()->department)->value('id');
            $class_id = Classes::all()->where('department','=',Auth::user()->department)->where('status','=',1)->pluck('id');
            // return $class_id;
            // $users = DB::table('subjects')->join('classes','subjects.classes_id','=','classes.id')->where('subjects.classes_id','=',$class_id)->get('subjects.user_id');  
            $users = Subject::all()->whereIn('classes_id',$class_id)->where('status','=',1)->pluck('user_id')->unique();

            $leaves = Leaves::whereIn('user_id',$users)->where('status','=',1)->get();

        }

        // return view('leaves.index')->with(['leaves' => $leaves, 'Success' => 'Successfully deleted']);
        return redirect('/leaves')->with(['leaves' => $leaves, 'success' => 'Successfully deleted']);
    }
}
