@extends('layouts.app')
@if(Auth::check())
@section('content')
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Subjects</div>

                <div class="card-body">

                	<div class="container-fluid">
                    	{!! Form::open(['action' => ['SubjectsController@store',$class_id, implode(array($teachers))], 'method' => 'POST']) !!}
                           <input type="hidden" name="lec[]" id="lec" value=''>
                           <input type="hidden" name="pracs[]" id="pracs" value=''>
                            <div class="form-group">
                                {{ Form::label('department','Department') }}
                                <div class="col-sm-5">
                                    {{ Form::text('department',$class->department,['class' => 'form-control','readonly' => 'true']) }}
                                </div>
                            </div>

                            <div class="form-group">
                                {{ Form::label('year','Year') }}
                                <div class="col-sm-5">
                                    {{ Form::text('year',$class->year,['class' => 'form-control','readonly' => 'true']) }}
                                </div>
                            </div>

                        	<div class="form-group">
                        		{{ Form::label('teacher','Teacher') }}
                                <div class="col-sm-5">
                                    {{ Form::select('teacher',$teachers, null, ['class' => 'form-control', 'placeholder' => 'Select Teacher']) }}
                                </div>
                        	</div>

                            <div class="form-group">
                                {{ Form::label('code','Course code') }}
                                <div class="col-sm-5">
                                    {{ Form::text('code','',['placeholder' => 'Enter course code', 'class' => 'form-control']) }}
                                </div>
                            </div>

                            <div class="form-group">
                                {{ Form::label('name','Name') }}
                                <div class="col-sm-5">
                                    {{ Form::text('name','',['placeholder' => 'Enter subject name', 'class' => 'form-control']) }}
                                </div>
                            </div>

                             <div class="form-group">
                                {{ Form::label('total_hours','Total hours') }}
                                <div class="col-sm-5">
                                    {{ Form::text('total_hours','',['placeholder' => 'Enter total hours', 'class' => 'form-control']) }}
                                </div>
                            </div>

                            <div class="form-group">
                                {{ Form::label('total_practicals','Total practicals') }}
                                <div class="col-sm-5">
                                    {{ Form::text('total_practicals','',['placeholder' => 'Enter total practicals', 'class' => 'form-control']) }}
                                </div>
                            </div>

                            <div class="form-group">
                                {{ Form::label('total_tutorials','Total tutorials') }}
                                <div class="col-sm-5">
                                    {{ Form::text('total_tutorials','',['placeholder' => 'Enter total tutorials', 'class' => 'form-control']) }}
                                </div>
                            </div>

                            <div class="form-group">
                                {{ Form::label('total_assignments','Total assignments') }}
                                <div class="col-sm-5">
                                    {{ Form::text('total_assignments','',['placeholder' => 'Enter total assignments', 'class' => 'form-control']) }}
                                </div>
                            </div>

                             <div class="form-group">  
                                {{ Form::label('sem','Semester') }}
                                <div class="col-sm-5">
                                    {{ Form::radio('sem',0,false,['id' => 'even']) }}
                                    {{ Form::label('sem_label','Even sem') }}
                                    {{ Form::radio('sem',1,false,['id' => 'odd']) }}
                                    {{ Form::label('sem_label','Odd sem') }}
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
    var months = ['January','February','March','April','May','June','July','August','September','October','November','December'];
    $('input[type="radio"]').change(function(){
        var lec_arr = [];
        var prac_arr = [];
        // console.log($('input[type="radio"]:checked').val());
        if($('input[type="radio"]:checked').val() == 0){
            var i = 0;
            for(i=0;i<5;i++){
                var x = prompt("Lectures planned in ".concat(months[i]),"0");
                lec_arr.push(x);
                var x = prompt("Practicals planned in ".concat(months[i]),"0");
                prac_arr.push(x);
            }
            // console.log(data);
        }
        if($('input[type="radio"]:checked').val() == 1){
            var i = 6;
            for(i=6;i<11;i++){
                var x = prompt("No. of lectures planned in ".concat(months[i]),"0");
                lec_arr.push(x);
                var x = prompt("No. of practicals planned in ".concat(months[i]),"0");
                prac_arr.push(x);
            }
            // console.log(data);
        }
        getData(lec_arr,prac_arr);
    });

    function getData(lec_arr,prac_arr){
        $('#lec').attr('value',lec_arr);
        $('#pracs').attr('value',prac_arr);
        // console.log(lec_arr);
    }
    
</script>
@endsection	
@endif