@extends('layouts.app')
@if(Auth::check())
@section('content')
	{{-- <h1>Add Class</h1> --}}
    {{-- <br> --}}
    <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Subjects</div>

                <div class="card-body">

                	<div class="container-fluid">
                    	{!! Form::open(['action' => ['SubjectsController@update',$subject->id,implode(array($teachers))], 'method' => 'PUT']) !!}
                            <div class="form-group">
                                {{ Form::label('department','Department') }}
                                <div class="col-sm-5">
                                    {{ Form::text('department',$subject->classes->department,['class' => 'form-control','readonly' => 'true']) }}
                                </div>
                            </div>

                            <div class="form-group">
                                {{ Form::label('year','Year') }}
                                <div class="col-sm-5">
                                    {{ Form::text('year',$subject->classes->year,['class' => 'form-control','readonly' => 'true']) }}
                                </div>
                            </div>

                        	<div class="form-group">
                        		{{ Form::label('teacher','Teacher') }}
                                <div class="col-sm-5">
                                    {{ Form::select('teacher',$teachers, $subject->user, ['class' => 'form-control']) }}
                                </div>
                        	</div>

                            <div class="form-group">
                                {{ Form::label('code','Course code') }}
                                <div class="col-sm-5">
                                    {{ Form::text('code',$subject->course_code,['placeholder' => 'Enter course code', 'class' => 'form-control']) }}
                                </div>
                            </div>

                            <div class="form-group">
                                {{ Form::label('name','Name') }}
                                <div class="col-sm-5">
                                    {{ Form::text('name',$subject->name,['placeholder' => 'Enter subject name', 'class' => 'form-control']) }}
                                </div>
                            </div>

                             <div class="form-group">
                                {{ Form::label('total_hours','Total hours') }}
                                <div class="col-sm-5">
                                    {{ Form::text('total_hours',$subject->total_hours,['placeholder' => 'Enter total hours', 'class' => 'form-control']) }}
                                </div>
                            </div>

                            <div class="form-group">
                                {{ Form::label('total_practicals','Total practicals') }}
                                <div class="col-sm-5">
                                    {{ Form::text('total_practicals',$subject->total_practicals,['placeholder' => 'Enter total practicals', 'class' => 'form-control']) }}
                                </div>
                            </div>

                            <div class="form-group">
                                {{ Form::label('total_tutorials','Total tutorials') }}
                                <div class="col-sm-5">
                                    {{ Form::text('total_tutorials',$subject->total_tutorials,['placeholder' => 'Enter total tutorials', 'class' => 'form-control']) }}
                                </div>
                            </div>

                            <div class="form-group">
                                {{ Form::label('total_assignments','Total assignments') }}
                                <div class="col-sm-5">
                                    {{ Form::text('total_assignments',$subject->total_assignments,['placeholder' => 'Enter total assignments', 'class' => 'form-control']) }}
                                </div>
                            </div>

                            <br>
                            <div class="col-sm-offset-2 col-sm-10">
                                {{ Form::hidden('_method','PUT') }}
                                {{ Form::submit('Submit',['class' => 'btn btn-primary']) }}
                            </div>
                    	{!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection	
@endif