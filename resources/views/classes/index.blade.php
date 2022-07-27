@extends('layouts.app')
@if(Auth::check())
@if(Auth::user()->type == 3)
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Classes</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <a href="/classes/create" class="btn btn-primary">Add Class</a>
                    <hr>
                    {{-- <h3>Your Posts</h3> --}}

                    @if(count($classes) > 0)
						<table class="table table-striped">
							<tr>
								<th>Department</th>
								<th>Year</th>
								<th>Strength</th>
								<th>Batch</th>
                                <th></th>
                                <th></th>
							</tr>
							@foreach($classes as $class)
                                {{-- @if($class->status == 1) --}}
    								<tr>
    									<td>{{$class->department}}</td>
    									<td>{{$class->year}}</td>
                                        <td>{{$class->strength}}</td>
                                        <td>{{$class->batch}}</td>
                                        <td><a href="/classes/{{$class->id}}/edit" class="btn btn-primary">Edit</a></td>
                                        <td>
                                            {!! Form::open(['action' => ['ClassesController@destroy', $class->id], 'method' => 'POST', 'class' => 'pull-right']) !!}
                                            {{ Form::hidden('_method','DELETE') }}
                                            {{ Form::submit('Delete',['class' => 'btn btn-danger']) }}
                                            {!! Form::close() !!}
                                        </td>
    								</tr>
                                {{-- @endif --}}
							@endforeach
						</table>
					@else
						<h1>No classes found!</h1>
					@endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@endif
@endif
