@extends('layouts.app')
@if(Auth::check())
@section('content')
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>

    {{-- <br> --}}
    <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Subjects</div>

                <div class="card-body">
    {{-- <h1>Add Class</h1> --}}
                    <br>
                    <div class="container-fluid">
                        {!! Form::open(['name' => 'list', 'action' => 'SubjectsController@list', 'method' => 'POST']) !!}
                            @if(Auth::user()->type == 3)
                                <div class="form-group">
                                    {{ Form::label('department','Department') }}
                                    <div class="col-sm-5">
                                        {{ Form::select('department', ['COMPS' => 'COMPUTER', 'IT' => 'IT', 'EXTC-A' => 'EXTC-A', 'EXTC-B' => 'EXTC-B','ETRX' => 'ETRX'], null, ['class' => 'form-control', 'placeholder' => 'Select Department']) }}
                                    </div>
                                </div>
                            @else
                                <div class="form-group">
                                        {{ Form::label('department','Department') }}
                                            <div class="col-sm-5">
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

                             {{-- <div class="form-group">
                                {{ Form::label('batch','Batch') }}
                                <div class="col-sm-5">
                                    {{ Form::select('batch',$classes, null, ['class' => 'form-control', 'placeholder' => 'Select Batch']) }}
                                </div>
                            </div> --}}

                            <div class="form-group">
                                {{ Form::label('batch','Batch') }}
                                <div class="col-sm-5">
                                    {{ Form::select('batch',['' => "Select Batch"], null, ['class' => 'form-control']) }}
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
    //     var department = $(this).val();
        $("select[name='year']").change(function(){
            var year = $(this).val();
            var token = $("input[name='_token']").val();

            @if(Auth::user()->type == 3){
                var department = $("select[name='department']").val();
            }
            @else{
                var department = $("input[name='department']").val();
                console.log(department);
            }
            @endif
            $.ajax({
                url: "<?php echo route('ajax-batch') ?>",
                method: 'POST',
                data: {department:department, year:year, _token:token},
                success: function(data) {
                    $("select[name='batch'").html('');
                    $("select[name='batch'").html(data.options);
                }
            });
        });
    // });
</script>
@endsection
@endif