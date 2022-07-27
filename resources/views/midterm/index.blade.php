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
                <div class="card-header">Midterm Report</div>

                <div class="card-body">
    {{-- <h1>Add Class</h1> --}}
                    <br>
                        @if(Auth::user()->type == 3)
                            <div class="container-fluid">
                                {!! Form::open(['action' => 'MidtermController@generate', 'method' => 'POST']) !!}
                                    <div class="form-group">
                                        {{ Form::label('department','Department') }}
                                            <div class="col-sm-5">
                                                {{ Form::select('department', ['COMPS' => 'COMPUTER', 'IT' => 'IT', 'EXTC-A' => 'EXTC-A', 'EXTC-B' => 'EXTC-B','ETRX' => 'ETRX'], null, ['class' => 'form-control', 'placeholder' => 'Select Department']) }}
                                            </div>
                                    </div>
                        @endif

                        @if(Auth::user()->type == 2)
                            <div class="container-fluid">
                                {!! Form::open(['action' => 'MidtermController@generate', 'method' => 'POST']) !!}
                                    <div class="form-group">
                                        {{ Form::label('department','Department') }}
                                            <div class="col-sm-5">
                                                {{-- {{ Form::select('department', ['COMPS' => 'COMPUTER', 'IT' => 'IT', 'EXTC-A' => 'EXTC-A', 'EXTC-B' => 'EXTC-B','ETRX' => 'ETRX'], Auth::user()->department, ['class' => 'form-control','selected']) }} --}}

                                                {{ Form::text('department',Auth::user()->department,['class' => 'form-control','readonly' => 'true']) }}

                                            </div>
                                    </div>
                        @endif

                            <div class="form-group">
                                {{ Form::label('year','Year') }}
                                <div class="col-sm-5">
                                    {{ Form::select('year', ['FE' => 'FE', 'SE' => 'SE', 'TE' => 'TE', 'BE' => 'BE'], null, ['placeholder' => 'Select Year', 'class' => 'form-control']) }} 
                                </div>
                            </div>

                            <div class="form-group">
                                {{ Form::label('batch','Batch') }}
                                <div class="col-sm-5">
                                    {{ Form::select('batch',['' => "Select Batch"], null, ['class' => 'form-control']) }}
                                </div>
                            </div>

                            <div class="form-group">
                                {{ Form::label('from','From') }}
                                <div class='input-group date col-sm-5' id='datetimepicker1'>
                                   {{-- <input id="datepicker" width="276" /> --}}
                                   {{Form::text('from','',['id' => 'from'])}}
                                </div>
                            </div>

                            <div class="form-group">
                                {{ Form::label('to','To') }}
                                <div class='input-group date col-sm-5' id='datetimepicker2'>
                                   {{-- <input id="datepicker" width="276" /> --}}
                                   {{Form::text('to','',['id' => 'to'])}}
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

<script type="text/javascript">
    // $("select[name='department']").change(function(){
        // var department = $(this).val();
    $('#from').datepicker({
        uiLibrary: 'bootstrap4',
        format: 'yyyy-mm-dd'
    });

    $('#to').datepicker({
        uiLibrary: 'bootstrap4',
        format: 'yyyy-mm-dd'
    });

    $("select[name='year']").change(function(){
        
        var year = $(this).val();
        var token = $("input[name='_token']").val();
        @if(Auth::user()->type == 3){
            var department = $("select[name='department']").val();
        }
        @else{
            var department = $("input[name='department']").val();
            // console.log(department);
        }
        @endif
        
        
        $.ajax({
            url: "<?php echo route('ajax-batch') ?>",
            method: 'POST',
            data: {department:department, year:year, _token:token},
            success: function(data) {
                $("select[name='batch']").html('');
                $("select[name='batch']").html(data.options);
            }
        });  
       
    });
    // });
</script>
@endsection 
@endif