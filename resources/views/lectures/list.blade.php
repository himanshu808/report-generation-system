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
                    {!! Form::open(['action' => ['LecturesController@store',json_encode(array($department,$year,$subject_id,$type,$students_present,$adjusted,$timeslot))],'method' => 'POST','onSubmit' => 'return getArray()']) !!}
                    {{ Form::submit('Submit',['class' => 'btn btn-primary']) }}
                    {{Form::hidden('hidden','',['id' => 'hidden'])}}
                    {!! Form::close() !!}
                    <hr>
                    {{-- <h3>Your Posts</h3> --}}

                    @if(count($topics) > 0)
						<table class="table table-striped">
							<tr>
								<th>Name</th>
								<th>Due Date</th>
                                <th>Type</th>
                                <th>State</th>
                                <th></th>
                                {{-- <th></th> --}}
							</tr>
							@foreach($topics as $topic)
                                @if($topic->status == 1)
                                    @if($topic->state == 0)
        								<tr id={{$topic->id}}>
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

                                            <td>{{Form::checkbox('state','',false,['id' => $topic->id,'onClick' => 'getId()'])}}</td>
                                            <td>
                                               {{--  {!! Form::open(['action' => ['TopicsController@destroy',$topic->id,$topic->subject_id], 'method' => 'POST', 'class' => 'pull-right']) !!}
                                                {{ Form::hidden('_method','DELETE') }}
                                                {{ Form::submit('Delete',['class' => 'btn btn-danger']) }}
                                                {!! Form::close() !!} --}}
                                            </td>
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

                                            <td>{{Form::checkbox('state','',false,['id' => $topic->id,'onClick' => 'getId()'])}}</td>
                                            <td>
                                               {{--  {!! Form::open(['action' => ['TopicsController@destroy',$topic->id,$topic->subject_id], 'method' => 'POST', 'class' => 'pull-right']) !!}
                                                {{ Form::hidden('_method','DELETE') }}
                                                {{ Form::submit('Delete',['class' => 'btn btn-danger']) }}
                                                {!! Form::close() !!} --}}
                                            </td>
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

<script type="text/javascript">
    var checked = [];
    function getId(){
        $('input[type=checkbox]').each(function(){
            var $this = $(this);
            // var id = $(':checkbox:checked').attr('id');
            // console.log(id);
            var id = $this.attr("id");
            if($this.is(":checked")){
                if(checked.includes(id) || typeof id == "undefined"){}
                else{
                    checked.push(id);    
                }
            }
            else{
                if(checked.includes(id)){
                    var index = checked.indexOf(id);
                    checked.splice(index, 1);
                }
            }
        });
        // console.log(checked);
    }

    function getArray(){
        $('#hidden').val(checked);
    }

</script>
@endsection
@endif


