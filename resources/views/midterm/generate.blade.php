@extends('layouts.app')
@if(Auth::check())
@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        {{-- <div class="row row-centered-pos"> --}}
        <div class="col-xs-20">
            <div class="card" style="width: 80rem; overflow: auto"> 
                <div class="card-header" style="width: 87rem;">Midterm Report</div>
                  
                <div class="card-body" style="width: 87rem;">
                    @if (session('status'))
                        {{-- <h1>Created</h1> --}}
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                
                    {{-- <a href="{{route('reports.generate',1)}}" class="btn btn-success">Export to Excel</a> --}}
                    {!! Form::open(['action' => 'MidtermController@excel', 'method' => 'PUT', 'class' => 'pull-right']) !!}
                        @foreach($subjects as $subject)
                            <?php
                                $data = array();
                                $data['course_code'] = $subject['course_code'];
                                $data['name'] = $subject['name'];
                                
                                $data["total_hours"] = $subject["total_hours"]; 
                                $data["hours_taken"] = $subject["hours_taken"];      

                                $data["total_practicals"] = $subject["total_practicals"];
                                $data["practicals_taken"] = $subject["practicals_taken"];

                                $data["total_tutorials"] = $subject["total_tutorials"];
                                $data["tutorials_taken"] = $subject["tutorials_taken"];

                                $data["total_assignments"] = $subject["total_assignments"];
                                $data["assignments_taken"] = $subject["assignments_taken"];

                                $data["syllabus_covered"] = $subject["syllabus_covered"];

                                $data["leaves"] = $subject["leaves"];

                                $data["total_remaining"]  = $subject["total_remaining"];
                                //$data["adjusted_details"] = $subject["adjusted_details"];
                            ?>
                          
                            <input type="hidden" name="data[]" value={{ json_encode(json_encode($data)) }}>
                        @endforeach
                      
                        {{Form::hidden('_method','PUT')}}
                        {{Form::submit('Export to Excel',['class' => 'btn btn-success'])}}
                    {!! Form::close() !!}
        

                    <hr>
                    {{-- <h3>Your Posts</h3> --}}

                    {{-- @if(count($subjects) > 0) --}}
						<table class="table table-striped"> 
    							<tr>
    								{{-- <th class="col-xs-1">Month</th> --}}
    								<th class="col-xs-1">Course code</th>
                                    <th class="col-xs-1">Name</th>
                                    <th class="col-xs-1">Total TH hours allotted by syllabus</th>
                                    <th class="col-xs-1">Actual hours conducted till date</th>
                                    <th class="col-xs-1">Total practicals mentioned in the syllabus</th>
                                    <th class="col-xs-1">Actual practicals till date</th>
                                    <th class="col-xs-1">Total tutorials mentioned in the syllabus</th>
                                    <th class="col-xs-1">Actual tutorials conducted till date</th>
                                    <th class="col-xs-1">Total assignments mentioned in the syllabus</th>
                                    <th class="col-xs-1">Actual assignments conducted till date</th>
                                    <th class="col-xs-1">% of syllabus covered till date</th>
                                    <th class="col-xs-1">Total leaves</th>
                                    <th class="col-xs-1">Adjusted TH+PR covered on date  with time details</th>
                                    <th class="col-xs-1">No. of TH+PR available to complete syllabus till term end</th>
                                </tr>

                     @foreach($subjects as $subject)
                   
                                <tr>
                                    <td>{{$subject["course_code"]}}</td>
                                    <td>{{$subject["name"]}}</td>
                                    <td>{{$subject["total_hours"]}}</td>
                                    <td>{{$subject["hours_taken"]}}</td>
                                    <td>{{$subject["total_practicals"]}}</td>
                                    <td>{{$subject["practicals_taken"]}}</td>
                                    <td>{{$subject["total_tutorials"]}}</td>
                                    <td>{{$subject["tutorials_taken"]}}</td>
                                    <td>{{$subject["total_assignments"]}}</td>
                                    <td>{{$subject["assignments_taken"]}}</td>
                                    <td>{{$subject["syllabus_covered"]}}</td>
                                    <td>{{$subject["leaves"]}}</td>
                                    <td><a href="/midterm/{{$subject["course_code"]}}/<?php echo $from?>/<?php echo $to?>" class="btn btn-info-sm">Click here</a></td>
                                    <td >{{$subject["total_remaining"]}}</td>
                                </tr>
                    @endforeach
							
						</table>
					{{-- @else --}}
						{{-- <h1>No topics found!</h1> --}}
					{{-- @endif --}}
                </div>
            </div>
        </div>
    </div>
</div>
<br>



{{-- <script type="text/javascript">
    function getArray(data){
        console.log("hello");
        // $('#hidden').val(JSON.stringfy(data));
    }
</script> --}}
@endsection
@endif
 
       