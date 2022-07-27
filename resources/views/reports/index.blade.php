@extends('layouts.app')
@if(Auth::check())
@section('content')
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>

    <br>
    <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Monthly Report</div>

                <div class="card-body">
    {{-- <h1>Add Class</h1> --}}
                    <br>
                        @if(Auth::user()->type == 3)
                            <div class="container-fluid">
                                {!! Form::open(['action' => 'ReportsController@generate', 'method' => 'POST']) !!}
                                    <div class="form-group">
                                        {{ Form::label('department','Department') }}
                                            <div class="col-sm-5">
                                                {{ Form::select('department', ['COMPS' => 'COMPUTER', 'IT' => 'IT', 'EXTC-A' => 'EXTC-A', 'EXTC-B' => 'EXTC-B','ETRX' => 'ETRX'], null, ['class' => 'form-control', 'placeholder' => 'Select Department']) }}
                                            </div>
                                    </div>
                        @endif

                        @if(Auth::user()->type == 2)
                            <div class="container-fluid">
                                {!! Form::open(['action' => ['ReportsController@generate',0], 'method' => 'POST']) !!}
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
                                    {{ Form::label('month','Month') }}
                                    <div class="col-sm-5">
                                        {{ Form::select('month',['01' => 'Jan','02' => 'Feb','03' => 'Mar','04' => 'Apr','05' => 'May','06' => 'Jun','07' => 'Jul','08' => 'Aug','09' => 'Sept','10' => 'Oct','11' => 'Nov','12' => 'Dec'], null, ['class' => 'form-control','placeholder' => 'Select Month']) }}
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