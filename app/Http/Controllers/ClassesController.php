<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Classes;
use Auth;

class ClassesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $classes = Classes::all()->where('status','=',1);
        return view('classes.index')->with('classes',$classes);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('classes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'department' => 'required',
            'year' => 'required',
            'strength' => 'required|numeric',
            'batch' => 'required'
        ]);

        $class = new Classes;
        $class->department = $request->input('department');
        $class->year = $request->input('year');
        $class->strength = $request->input('strength');
        $class->batch = substr($request->input('batch'),0,4);
        $class->created_by = Auth::user()->id;
        $class->save();

        return redirect('/classes')->with('success',"Successfully created");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $class = Classes::find($id);
        return view('classes.edit')->with('class',$class);
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
        $class = Classes::find($id);

        $class->department = $request->input('department');
        $class->year = $request->input('year');
        $class->strength = $request->input('strength');
        $class->batch = $request->input('batch');
        $class->updated_by = Auth::user()->id;
        $class->save();

        return redirect('/classes')->with('success','Successfully updated');


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $class = Classes::find($id);
        $class->status = 0;
        $class->deleted_by = Auth::user()->id;
        $class->save();
        return redirect('/classes')->with('success','Successfully deleted');
    }

}
