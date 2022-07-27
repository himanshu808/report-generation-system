<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subject;
use App\Models\Classes;
use App\User;
use Illuminate\Support\Facades\DB;
use Auth;

class SubjectsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $classes = DB::table('classes')->pluck('batch')->unique();
        // return view('subjects.index')->with('classes',$classes);
        return view('subjects.index');
    }

    public function ajaxBatch(Request $request){
        if($request->ajax()){
            // $class_id = DB::table('classes')->where([['department','=',$request->department],['year','=',$request->year]])->pluck('id')[0];
            // $batches = DB::table('classes')->where('id','=',$class_id)->pluck('batch','id')->all();

            $batches = DB::table('classes')->where([['department','=',$request->department],['year','=',$request->year],['status','=',1]])->pluck('batch','id')->all();
            $data = view('subjects.ajax_batch',compact('batches'))->render();
            return response()->json(['options' => $data]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($class_id)
    {
        $class = Classes::find($class_id);
        $department = DB::table('classes')->where([['id','=',$class_id],['status','=',1]])->pluck('department');
        $dept = substr($department,2,2)."%";
        $teachers = DB::table('users')->where('department','like',$dept)->where('status','=',1)->pluck('name');

        return view('subjects.create')->with(['class_id' => $class_id, 'teachers' => $teachers,'class' => $class]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $class_id, $teachers)
    {
        $this->validate($request, [
            'code' => 'required',
            'name' => 'required',
            'total_hours' => 'required|numeric',
            'total_practicals' => 'required|numeric',
            'total_tutorials' => 'required|numeric',
            'total_assignments' => 'required|numeric',
            'sem' => 'required|min:1'
        ]);
        
        $lec = explode(",",$request->input('lec')[0]);
        $pracs = explode(",",$request->input('pracs')[0]);

        $teachers = str_replace(array("[","]","\""),"",explode(",",$teachers));
        $teacher = $teachers[$request->input('teacher')];
        $user_id = DB::table('users')->where([['name','=',$teacher],['status','=',1]])->pluck('id')[0];

        $subject = new Subject;
        $subject->user_id = $user_id;
        $subject->classes_id = $class_id;
        $subject->course_code = $request->input('code');
        $subject->name = $request->input('name');
        $subject->total_hours = $request->input('total_hours');
        $subject->total_practicals = $request->input('total_practicals');
        $subject->total_tutorials = $request->input('total_tutorials');
        $subject->total_assignments =$request->input('total_assignments');
        $subject->created_by = Auth::user()->id;
        $subject->save();

        if($request->sem == 0){
            for($i=0;$i<sizeof($lec);$i++){
                DB::table('month_subject')->insert(['subject_id' => $subject->id,'month_id' => $i+1,'lectures_planned' => $lec[$i],'practicals_planned' => $pracs[$i],'created_by' => Auth::user()->id]);
            }
        }
        elseif($request->sem == 1){
            $j=0;
            $i=6;
            for($j=0;$j<sizeof($lec);$j++,$i++){
                DB::table('month_subject')->insert(['subject_id' => $subject->id,'month_id' => $i+1,'lectures_planned' => $lec[$j],'practicals_planned' => $pracs[$j],'created_by' => Auth::user()->id]);
            }
        }

        $subjects = Classes::find($class_id)->subjects;
        return view('subjects.list')->with(['subjects' => $subjects, 'class_id' => $class_id, 'success' => 'Successfully created']);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $subject = Subject::find($id);
        $department = $subject->classes->department;
        $dept = substr($department,0,2)."%";
        $teachers = DB::table('users')->where('department','like',$dept)->where('status','=',1)->pluck('name');
        return view('subjects.edit')->with(['subject' => $subject, 'teachers' => $teachers]);
        // return $dept;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id, $teachers)
    {
        $this->validate($request, [
            'code' => 'required',
            'name' => 'required',
            'total_hours' => 'required|numeric',
            'total_practicals' => 'required|numeric',
            'total_tutorials' => 'required|numeric',
            'total_assignments' => 'required|numeric'
        ]);

        $subject = Subject::find($id);
        $teachers = str_replace(array("[","]","\""),"",explode(",",$teachers));
        $teacher = $teachers[$request->input('teacher')];
        $user_id = DB::table('users')->where('name','=',$teacher)->where('status','=',1)->pluck('id')[0];
        $class_id = $subject->classes->id;

        $subject->user_id = $user_id;
        $subject->classes_id = $class_id;
        $subject->course_code = $request->input('code');
        $subject->name = $request->input('name');
        $subject->total_hours = $request->input('total_hours');
        $subject->total_practicals = $request->input('total_practicals');
        $subject->total_tutorials = $request->input('total_tutorials');
        $subject->total_assignments = $request->input('total_assignments');
        $subject->updated_by = Auth::user()->id;
        $subject->save();

        $subjects = Classes::find($class_id)->subjects;
        return view('subjects.list')->with(['subjects' => $subjects, 'class_id' => $class_id, 'success' => 'Successfully updated']);
        // return $user_id;

        // return $subject;

    }   

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($sub_id, $class_id)
    {
        $subject = Subject::find($sub_id);
        $subject->status = 0;
        $subject->deleted_by = Auth::user()->id;
        $subject->save();

        $subjects = Classes::find($class_id)->subjects;
        // $data = [
        //     'subjects' => $subjects,
        //     'success' => "Successfully deleted"
        // ];
        return view('subjects.list')->with(['subjects' => $subjects, 'class_id' => $class_id, 'success' => 'Successfully deleted']);
        // return $id;
    }

    public function list(Request $request){
        $this->validate($request, [
            'department' => 'required',
            'year' => 'required',
            'batch' => 'required'
        ]);

        // $class_id = $request->input('batch') + 1;

        $class_id = $request->input('batch');
        $subjects = Classes::find($class_id)->subjects;
        return view('subjects.list')->with(['subjects' => $subjects, 'class_id' => $class_id]);
        
    }
}
