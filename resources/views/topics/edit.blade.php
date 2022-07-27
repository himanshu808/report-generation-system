@extends('layouts.app')

@section('content')
	{{-- <h1>Add Class</h1> --}}
    {{-- <br> --}}
    <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Topics</div>

                <div class="card-body">

                	<div class="container-fluid">
                    	{!! Form::open(['action' => ['TopicsController@update',$topic->id], 'method' => 'PUT']) !!}
                            <div class="form-group">
                                {{ Form::label('subject','Subject') }}
                                <div class="col-sm-5">
                                    {{ Form::text('subject',$subject->name,['class' => 'form-control','readonly' => 'true']) }}
                                </div>
                            </div>

                            <div class="form-group">
                                {{ Form::label('name','Name') }}
                                <div class="col-sm-5">
                                    {{ Form::text('name',$topic->name,['class' => 'form-control']) }}
                                </div>
                            </div>
        
                            <div class="form-group">
                                {{ Form::label('due_date','Due date') }}
                                <div class="col-sm-5">
                                    {{ Form::text('due_date',$topic->due_date,['class' => 'form-control']) }}
                                </div>
                            </div>
        
                        	<div class="form-group">
                        		{{ Form::label('type','Type') }}
                                <div class="col-sm-5">
                                    {{ Form::select('type',[1 => 'Theory', 2 => 'Practical', 3 => 'Tutorial', 4 => 'Assignment'], $topic->type, ['class' => 'form-control']) }}
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