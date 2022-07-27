@extends('layouts.app')
@if(Auth::check())
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Topics</div>
                  
                <div class="card-body">
                    @if (session('status'))
                        {{-- <h1>Created</h1> --}}
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    
                        @if(Auth::user()->type == 3)
                            {!! Form::open(['action' => ['TopicsController@create',$subject_id], 'method' => 'POST', 'class' => 'pull-right']) !!}
                            {{ Form::submit('Add Topic',['class' => 'btn btn-primary']) }}
                            {!! Form::close() !!}
                        @endif
                        <hr>

                        @if(count($topics) > 0)
    						<table class="table table-striped">
    							<tr>
    								<th>Name</th>
    								<th>Due Date</th>
                                    <th>Type</th>
                                    <th>State</th>
                                    @if(Auth::user()->type == 3)
                                        <th></th>
                                        <th></th>
                                    @endif
    							</tr>
    							@foreach($topics as $topic)
                                    @if($topic->status == 1)
                                        @if($topic->state == 0)
            								<tr>
            									<td>{{$topic->name}}</td>
                                                <td>{{$topic->due_date}}</td>
                                                @if($topic->type == 1)
                                                    <td>Theory</td>
                                                @elseif($topic->type == 2)
                                                    <td>Practical</td>
                                                @elseif($topic->type == 3)
                                                    <td>Tutorial</td>
                                                @else
                                                    <td>Assignment</td>
                                                @endif
                                                <td>Uncovered</td>

                                               {{--  @if($topic->state == 0)
                                                    <td>Uncovered</td>
                                                @else
                                                    <td>Covered</td>
                                                @endif --}}
                                                @if(Auth::user()->type == 3)
                                                    <td><a href="/topics/{{$topic->id}}/edit" class="btn btn-primary">Edit</a></td>
                                                    <td>
                                                        {!! Form::open(['action' => ['TopicsController@destroy',$topic->id,$topic->subject_id], 'method' => 'POST', 'class' => 'pull-right']) !!}
                                                        {{ Form::hidden('_method','DELETE') }}
                                                        {{ Form::submit('Delete',['class' => 'btn btn-danger']) }}
                                                        {!! Form::close() !!}
                                                    </td>
                                                @endif
            								</tr>
                                        @endif
                                    @endif
    							@endforeach

                                @foreach($topics as $topic)
                                    @if($topic->status == 1)
                                        @if($topic->state == 1)
                                            <tr>
                                                <td>{{$topic->name}}</td>
                                                <td>{{$topic->due_date}}</td>
                                                @if($topic->type == 1)
                                                    <td>Theory</td>
                                                @elseif($topic->type == 2)
                                                    <td>Practical</td>
                                                @elseif($topic->type == 3)
                                                    <td>Tutorial</td>
                                                @else
                                                    <td>Assignment</td>
                                                @endif
                                                <td>Covered</td>

                                               {{--  @if($topic->state == 0)
                                                    <td>Uncovered</td>
                                                @else
                                                    <td>Covered</td>
                                                @endif --}}
                                                @if(Auth::user()->type == 3)
                                                    <td><a href="/topics/{{$topic->id}}/edit" class="btn btn-primary">Edit</a></td>
                                                    <td>
                                                        {!! Form::open(['action' => ['TopicsController@destroy',$topic->id,$topic->subject_id], 'method' => 'POST', 'class' => 'pull-right']) !!}
                                                        {{ Form::hidden('_method','DELETE') }}
                                                        {{ Form::submit('Delete',['class' => 'btn btn-danger']) }}
                                                        {!! Form::close() !!}
                                                    </td>
                                                @endif
                                            </tr>
                                        @endif
                                    @endif
                                @endforeach
    						</table>
    					@else
    						<h1>No topics found!</h1>
    					@endif
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endif
@endsection
