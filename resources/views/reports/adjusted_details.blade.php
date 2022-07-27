@extends('layouts.app')
@if(Auth::check())
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Adjusted Lecture Details</div>
                  
                <div class="card-body">
                    @if (session('status'))
                        {{-- <h1>Created</h1> --}}
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif                
                    <hr>

                    @if(count($adjusted_details) > 0)
						<table class="table table-striped">
							<tr>
								<th>Adjusted On</th>
								<th>Time</th>
							</tr>
							@foreach($adjusted_details as $ad)
    								<tr>
    									<td>{{$ad->created_at->format('d-m-Y')}}</td>
                                        <td>{{$ad->timeslot}}</td>
    								</tr>
							@endforeach
						</table>
					@else
						<h1>No records found!</h1>
					@endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@endif
