@extends('layouts.app')
@if(Auth::check())
@if(Auth::user()->type == 3)
@section('content')
	{{-- <h1>Add Class</h1> --}}
    <br>
	<div class="container-fluid">
    	{!! Form::open(['action' => ['ClassesController@update',$class->id], 'method' => 'POST']) !!}
        	<div class="form-group">
        		{{ Form::label('department','Department') }}
                <div class="col-sm-5">
                    {{ Form::select('department', ['COMPS' => 'COMPUTER', 'IT' => 'IT', 'EXTC-A' => 'EXTC-A', 'EXTC-B' => 'EXTC-B','ETRX' => 'ETRX'], $class->department, ['class' => 'form-control']) }}
                </div>
        	</div>

        	<div class="form-group">
        		{{ Form::label('year','Year') }}
                <div class="col-sm-5">
                    {{ Form::select('year', ['FE' => 'FE', 'SE' => 'SE', 'TE' => 'TE', 'BE' => 'BE'], $class->year, ['class' => 'form-control']) }}	
                </div>
        	</div>

            <div class="form-group">
                {{ Form::label('strength','Strength') }}
                <div class="col-sm-5">
                    {{ Form::text('strength',$class->strength,['placeholder' => 'Enter class strength', 'class' => 'form-control']) }}
                </div>
            </div>

             <div class="form-group">
                {{ Form::label('batch','Batch') }}
                <div class="col-sm-5">
                    {{ Form::text('batch',$class->batch,['placeholder' => 'eg. 2018-19', 'class' => 'form-control']) }}
                </div>
            </div>

            <div class="col-sm-offset-2 col-sm-10">
                {{ Form::hidden('_method','PUT') }}
                {{ Form::submit('Submit',['class' => 'btn btn-primary']) }}
            </div>
    	{!! Form::close() !!}
    </div>

@endsection	
@endif
@endif