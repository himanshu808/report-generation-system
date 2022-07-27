@extends('layouts.app')
@if(Auth::check())
@section('content')
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/gijgo@1.9.10/js/gijgo.min.js" type="text/javascript"></script>
    <link href="https://cdn.jsdelivr.net/npm/gijgo@1.9.10/css/gijgo.min.css" rel="stylesheet" type="text/css" />

    <br>
    <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Lectures</div>

                <div class="card-body">
    {{-- <h1>Add Class</h1> --}}
                    <br>
                    @if(Auth::check())
                            <div class="container-fluid">
                                {!! Form::open(['action' => 'LecturesController@list', 'method' => 'POST','onSubmit' => 'return getStatus()']) !!}
                                    {{Form::hidden('adjust','',['id' => 'adjust'])}}
                                    <div class="form-group">
                                        {{ Form::label('department','Department') }}
                                            <div class="col-sm-5">
                                                {{ Form::text('department',Auth::user()->department,['class' => 'form-control','readonly' => 'true']) }}
                                            </div>
                                    </div>
                     

                            <div class="form-group">
                                {{ Form::label('year','Year') }}
                                <div class="col-sm-5">
                                    {{ Form::select('year', ['FE' => 'FE', 'SE' => 'SE', 'TE' => 'TE', 'BE' => 'BE'], null, ['placeholder' => 'Select Year', 'class' => 'form-control']) }} 
                                </div>
                            </div>

                            <div class="form-group">
                                {{ Form::label('subject','Subject') }}
                                <div class="col-sm-5">
                                    {{ Form::select('subject',['' => "Select Subject"], null, ['class' => 'form-control']) }}
                                </div>
                            </div>

                            <div class="form-group">
                                {{ Form::label('type','Type') }}
                                <div class="col-sm-5">
                                    {{ Form::select('type', [1 => 'Theory', 2 => 'Practical', 3 => 'Tutorial', 4 => 'Assignment'], null, ['placeholder' => 'Select Type', 'class' => 'form-control']) }} 
                                </div>
                            </div>

                            <div class="form-group">
                                        {{ Form::label('students_present','Students present') }}
                                            <div class="col-sm-5">
                                                {{ Form::text('students_present','',['class' => 'form-control','placeholder' => 'No. of students present']) }}
                                            </div>
                            </div>

                            {{-- ADJUSTED CHECKBOX --}}

                            {{-- <div class="form-group"> --}}
                                <table>
                                    <tr>
                                        <td>{{ Form::label('adjusted','Adjusted') }}</td>
                                {{-- <div class="col-sm-5"> --}}
                                
                                        <td style="padding:8px">{{Form::checkbox('adjusted','',false,['id' => 'adjusted','onClick' => 'enableDisable(this.checked)'])}}</td>
                                    </tr>
                                </table>
                                {{-- </div> --}}
                            {{-- </div> --}}

                            {{-- <div class="form-group">
                                        {{ Form::label('timeslot','Timeslot') }}
                                            <div class="col-sm-5">
                                                {{ Form::text('timeslot','',['class' => 'form-control','placeholder' => 'eg. 11:00:00','disabled' => 'true']) }}
                                            </div>
                            </div> --}}

                            <div class="form-group">
                                {{ Form::label('timeslot','Time') }}
                                <div class='input-group date col-sm-5' id='datetimepicker3'>    
                                   {{-- <input id="timepicker" width="276" /> --}}
                                   {{Form::text('timeslot','',['id' => 'timeslot','disabled' => 'true'])}}
                                </div>
                            </div>

                            <br>
                            <br>
                            <div class="col-sm-offset-2 col-sm-10">
                               {{ Form::submit('Submit',['class' => 'btn btn-primary']) }}
                            </div>
                        {!! Form::close() !!}
                    @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

<script type="text/javascript">
    // $("select[name='department']").change(function(){
        // var department = $(this).val();
        $("select[name='year']").change(function(){
            var department = $("input[name='department']").val();
            var year = $(this).val();
            var token = $("input[name='_token']").val();
            // console.log(department);
            
            $.ajax({
                url: "<?php echo route('ajax-subject') ?>",
                method: 'POST',
                data: {department:department, year:year,_token:token},
                success: function(data) {
                    $("select[name='subject']").html('');
                    $("select[name='subject']").html(data.options);
                }
            });  
           
        });
    // });

    function getStatus(){
        if($('#adjusted').is(':checked')){
            $('#adjust').val(1);
            console.log(1);
        }
        else{
            $('#adjust').val(0);
        }
    }

    function enableDisable(state){
        // console.log("gfd");
        // document.getElementById('timeslot').disabled = !state;
        $('#timeslot').attr('disabled',!state);
        // $('#timeslot').timepicker(!state ? "disable" : "enable");

    }

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