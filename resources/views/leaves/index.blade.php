{{-- @extends('layouts.app') --}}

{{-- @section('content')
	<h1>Leaves</h1>

	@if(count($leaves) > 0)
		<table class="table table-striped">
			<tr>
				<th>Name</th>
				<th>Date</th>
				<th></th>
				<th></th>
			</tr>
			@foreach($leaves as $leave)
				<tr>
					<td>{{$leave->user->name}}</td>
					<td>{{$leave->date}}</td>
				</tr>
			@endforeach
		</table>

	@else
		<h1>No leaves found!</h1>
	@endif
@endsection --}}


@extends('layouts.app')
@if(Auth::check())
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Leaves</div>

                <div class="card-body">
                   {{--  @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif --}}
                    @if(Auth::user()->type != 3)
                    	<a href="/leaves/create" class="btn btn-primary">Add Leave</a>
                    @endif
                    <hr>
                    {{-- <h3>Your Posts</h3> --}}

                    @if(count($leaves) > 0)
						<table class="table table-striped">
							<tr>
								<th>Name</th>
								<th>Date</th>
								<th>Adjusted With</th>
								<th>Adjusted On</th>
								<th>Time</th>
								<th></th>
								<th></th>
							</tr>
							@foreach($leaves as $leave)
								<tr>
									<td>{{$leave->user->name}}</td>
									<td>{{$leave->date}}</td>
									<td>{{App\User::find($leave->adjusted_with)->name}}</td>
									<td>{{$leave->adjusted_on}}</td>
									<td>{{$leave->timeslot}}</td>
									@if($leave->user->id == Auth::user()->id)
										<td><a href="/leaves/{{$leave->id}}/edit" class="btn btn-primary">Edit</a></td>
										<td>{!! Form::open(['action' => ['LeavesController@destroy',$leave->id], 'method' => 'POST', 'class' => 'pull-right']) !!}
                                            {{ Form::hidden('_method','DELETE') }}
                                            {{ Form::submit('Delete',['class' => 'btn btn-danger']) }}
                                            {!! Form::close() !!}</td>
									@else
										<td></td>
										<td></td>
									@endif
								</tr>
							@endforeach
						</table>
					@else
						<h1>No leaves found!</h1>
					@endif
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@endif
