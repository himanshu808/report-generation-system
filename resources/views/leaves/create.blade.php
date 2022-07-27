@extends('layouts.app')
@if(Auth::check())
@section('content')
	<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/gijgo@1.9.10/js/gijgo.min.js" type="text/javascript"></script>
    <link href="https://cdn.jsdelivr.net/npm/gijgo@1.9.10/css/gijgo.min.css" rel="stylesheet" type="text/css" />

	
    <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Leaves</div>

                <div class="card-body">

                	<div class="container-fluid">
                    	{!! Form::open(['action' => 'LeavesController@store','method' => 'POST']) !!}
                            <div class="form-group">
                                {{ Form::label('leave_date','Leave Date') }}
				                <div class='input-group date col-sm-5' id='datetimepicker1'>
				                   {{-- <input id="datepicker" width="276" /> --}}
				                   {{Form::text('leave_date','',['id' => 'leave_date'])}}
				       			</div>
							</div>
                    
                        	<div class="form-group">
                        		{{ Form::label('adjusted_with','Adjusted with') }}
                                <div class="col-sm-5">
                                    {{ Form::select('adjusted_with',$teachers, null, ['class' => 'form-control', 'placeholder' => 'Select Teacher']) }}
                                </div>
                        	</div>

                            <div class="form-group">
                                {{ Form::label('adjusted_on','Adjusted on') }}
                                <div class='input-group date col-sm-5' id='datetimepicker2'>	
				                 {{--   <input id="adjusted_on" width="276" /> --}}
				                	{{Form::text('adjusted_on','',['id' => 'adjusted_on'])}}
				       			</div>
                            </div>

                             <div class="form-group">
                                {{ Form::label('timeslot','Time') }}
                                <div class='input-group date col-sm-5' id='datetimepicker3'>	
				                   {{-- <input id="timepicker" width="276" /> --}}
				                   {{Form::text('timeslot','',['id' => 'timeslot'])}}
				       			</div>
                            </div>
                            
                            <br>
                            <div class="col-sm-offset-2 col-sm-10">
                        	   {{ Form::submit('Submit',['class' => 'btn btn-primary']) }}
                            </div>
                    	{!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

<script>
    $('#leave_date').datepicker({
        uiLibrary: 'bootstrap4',
        format: 'yyyy-mm-dd'
    });

    $('#adjusted_on').datepicker({
        uiLibrary: 'bootstrap4',
        format: 'yyyy-mm-dd'
        // timeFormat: 'hh:mm',
        // allowInputToggle: true,
        // stepping: '10',
        // disabledHours: ['0','1','2','3','4','5','6','7','8','17','18','19','20','21','22','23'],
        // timeZone: null,
        // showClear: true
    });

    $('#timeslot').timepicker({
        uiLibrary: 'bootstrap4',
        timeFormat: 'hh:mm',
        allowInputToggle: true,
        stepMinute: 10,
        timeZone: null,
        showClear: true,
    });
</script>
@endsection	
@endif