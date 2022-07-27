@extends('layouts.app')
@if(Auth::check())
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Subjects</div>
                  
                <div class="card-body">
                    @if (session('status'))
                        {{-- <h1>Created</h1> --}}
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    {{-- <a href="/subjects/create" class="btn btn-primary">Add Subject</a> --}}
                    @if(Auth::user()->type == 3)
                        {!! Form::open(['action' => ['SubjectsController@create',$class_id], 'method' => 'POST', 'class' => 'pull-right']) !!}
                        {{ Form::submit('Add Subject',['class' => 'btn btn-primary']) }}
                        {!! Form::close() !!}
                    @endif
                    <hr>
                    {{-- <h3>Your Posts</h3> --}}

                    @if(count($subjects) > 0)
						<table class="table table-striped">
							<tr>
								<th>Name</th>
								<th>Teacher</th>
                                @if(Auth::user()->type == 3)
                                    <th></th>
                                    <th></th>
                                @endif
							</tr>
							@foreach($subjects as $subject)
                                @if($subject->status == 1)
    								<tr>
    									<td>{{$subject->name}}</td>
                                        <td>{{$subject->user->name}}</td>
                                        @if(Auth::user()->type == 3)
                                            <td><a href="/subjects/{{$subject->id}}/edit" class="btn btn-primary">Edit</a></td>
                                            <td>
                                                {!! Form::open(['action' => ['SubjectsController@destroy',$subject->id,$subject->classes], 'method' => 'POST', 'class' => 'pull-right']) !!}
                                                {{ Form::hidden('_method','DELETE') }}
                                                {{ Form::submit('Delete',['class' => 'btn btn-danger']) }}
                                                {!! Form::close() !!}
                                            </td>
                                        @endif
    								</tr>
                                @endif
							@endforeach
						</table>
					@else
						<h1>No subjects found!</h1>
					@endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@endif
