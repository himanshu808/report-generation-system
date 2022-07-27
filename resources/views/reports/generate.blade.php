@extends('layouts.app')
@if(Auth::check())
@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        {{-- <div class="row row-centered-pos"> --}}
        <div class="col-xs-20">
            <div class="card" style="width: 80rem; overflow: auto"> 
                <div class="card-header" style="width: 87rem;">Report</div>
                  
                <div class="card-body" style="width: 87rem;">
                    @if (session('status'))
                        {{-- <h1>Created</h1> --}}
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                
                    {{-- <a href="{{route('reports.generate',1)}}" class="btn btn-success">Export to Excel</a> --}}
                    {!! Form::open(['action' => 'ReportsController@excel', 'method' => 'PUT', 'class' => 'pull-right']) !!}
                        @foreach($subjects as $subject)
                            <?php
                                $monthNum = $subject["month"];
                                $dateObj = DateTime::createFromFormat('!m', $monthNum);
                                $monthName = $dateObj->format('F');

                                $data = array();
                                $data['month'] = $monthName;
                                $data['course_code'] = $subject['course_code'];
                                $data['name'] = $subject['name'];
                                
                                $data["lectures_planned"] = $subject["lectures_planned"]; 
                                $data["lectures_taken"] = $subject["lectures_taken"];      

                                $data["practicals_planned"] = $subject["practicals_planned"];
                                $data["practicals_taken"] = $subject["practicals_taken"];

                                $data["tutorials_planned"] = $subject["tutorials_planned"];
                                $data["tutorials_taken"] = $subject["tutorials_taken"];

                                $data["assignments_planned"] = $subject["assignments_planned"];
                                $data["assignments_taken"] = $subject["assignments_taken"];

                                $data["syllabus_covered"] = $subject["syllabus_covered"];

                                $data["leaves"] = $subject["leaves"];
                                $data["total_adjusted"] = $subject["adjusted_lectures"] + $subject["adjusted_practicals"];

                                $data["extra"] = ($subject["lectures_planned"] + $subject["practicals_planned"]) - ($subject["lectures_taken"] + $subject["practicals_taken"]); 
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
    								<th class="col-xs-1">Month</th>
    								<th class="col-xs-1">Course code</th>
                                    <th class="col-xs-1">Name</th>
                                    <th class="col-xs-1">Total TH hours planned as per Teaching Plan in the month</th>
                                    <th class="col-xs-1">Actual hours conducted till EOM</th>
                                    <th class="col-xs-1">Total practicals planned as per Lab Plan in the month</th>
                                    <th class="col-xs-1">Actual practicals till EOM</th>
                                    <th class="col-xs-1">Total tutorials planned in the month</th>
                                    <th class="col-xs-1">Actual tutorials conducted till EOM</th>
                                    <th class="col-xs-1">Total assignments planned in the month</th>
                                    <th class="col-xs-1">Actual assignments conducted till EOM</th>
                                    <th class="col-xs-1">% of syllabus covered till EOM</th>
                                    <th class="col-xs-1">Total leaves</th>
                                    <th class="col-xs-1">No. of TH + PR adjusted with other faculty in the month</th>
                                    <th class="col-xs-1">Adjusted TH+PR covered on date  with time details
                                       {{--  <table class="table table-striped" style="table-layout: inline-block;">
                                            <tr>
                                                <th class="col-xs-1">Date</th>
                                                <th class="col-xs-1">Time</th>
                                            </tr>
                                        </table> --}}
                                        
                                    </th>
                                    <th class="col-xs-1">Extra TH+PR to be conducted on to cover adjustments</th>
                                </tr>

                     @foreach($subjects as $subject)
                        <?php
                            $monthNum = $subject["month"];
                            $dateObj = DateTime::createFromFormat('!m', $monthNum);
                            $monthName = $dateObj->format('F');
                        ?>
                                <tr>
                                    <td><?php echo substr($monthName,0,3)?></td>
                                    <td>{{$subject["course_code"]}}</td>
                                    <td>{{$subject["name"]}}</td>
                                    <td>{{$subject["lectures_planned"]}}</td>
                                    <td>{{$subject["lectures_taken"]}}</td>
                                    <td>{{$subject["practicals_planned"]}}</td>
                                    <td>{{$subject["practicals_taken"]}}</td>
                                    <td>{{$subject["tutorials_planned"]}}</td>
                                    <td>{{$subject["tutorials_taken"]}}</td>
                                    <td>{{$subject["assignments_planned"]}}</td>
                                    <td>{{$subject["assignments_taken"]}}</td>
                                    <td>{{$subject["syllabus_covered"]}}</td>
                                    <td>{{$subject["leaves"]}}</td>
                                    <td>{{$subject["total_adjusted"]}}</td>
                                    <td><a href="/reports/{{$subject["course_code"]}}/<?php echo $monthNum?>" class="btn btn-info-sm">Click here</a></td>
                                    <td >{{$subject["extra"]}}</td>
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



<script type="text/javascript">
    function getArray(data){
        console.log("hello");
        // $('#hidden').val(JSON.stringfy(data));
    }
</script>
@endsection
@endif
 
       