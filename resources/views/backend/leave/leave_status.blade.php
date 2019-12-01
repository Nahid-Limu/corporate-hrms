@extends('layout.master')
@section('title', 'Leave Status')
@section('content')
    <!--BEGIN TITLE & BREADCRUMB PAGE-->
    <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
        <div class="page-header pull-left">
            <div class="page-title">Leave Status</div>
        </div>
        <ol class="breadcrumb page-breadcrumb pull-right">
            <li><i class="fa fa-home"></i>&nbsp;<a href="{{url('/')}}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
            <li><a href="#">Leave</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
            <li class="active">Leave Status</li>
        </ol>
        <div class="clearfix"></div>
    </div>
    <!--END TITLE & BREADCRUMB PAGE-->

    <!--Flash Message Start-->
    @if(Session::has('success'))
            <p id="alert_message" class="alert alert-success">{{ Session::get('success') }}</p>
    @endif
    @if(Session::has('error'))
        <p id="alert_message" class="alert alert-error">{{ Session::get('error') }}</p>
    @endif
    @if(Session::has('delete'))
        <p id="alert_message" class="alert alert-danger">{{ Session::get('delete') }}</p>
    @endif
    <!--Flash Message End-->
 
    <div class="page-content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel leave-panel panel-blue">
                    <div class="panel-header">
                        Leave Request Management
                    </div>
                    <div class="panel-content leave-panel-content">
                        <ul class="nav nav-tabs nav-primary">
                            <li class="active"><a href="#tab2_1" data-toggle="tab" aria-expanded="true"><i class="fa fa-pause"></i>Pending Request</a></li>
                            <li class=""><a href="#tab2_2" data-toggle="tab" aria-expanded="false"><i class="fa fa-check"></i>Approved</a></li>
                            <li class=""><a href="#tab2_3" data-toggle="tab" aria-expanded="false"><i class="fa fa-times"></i>Rejected</a></li>
                        </ul>

                        <div class="tab-content" id="lode-content">
                            <div class="tab-pane fade active in" id="tab2_1">
                                
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                        
                                            <th>SN</th>
                                            <th>Employee ID</th>
                                            <th>Name</th>
                                            <th>Designation</th>
                                            <th>Leave type</th>
                                            <th>Period</th>
                                            <th>Working Days</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $sn =1;
                                            @endphp
                                            @foreach ($leave_application as $leave)
                                                @if ($leave->status == 0)
                                                <tr>
                                                    <input name="id" type="hidden" value="1">
                                                    
                                                    <td>{{$sn++}}</td>
                                                    <td>
                                                        <a href="{{route('employee.profile', base64_encode($leave->eid))}}" target="_blank" data-toggle="tooltip" data-placement="top" title="View Profile" style="color: #319DB5"><b>{{$leave->employeeId}}</b></a>
                                                    </td>
                                                    <td>{{$leave->emp_name}}</td>
                                                    <td>{{$leave->designation_name}}</td>
                                                    <td>{{$leave->leave_type}}</td>
                                                    <td>
                                                        @if ($leave->leave_starting_date)
                                                        <span class="text-green">{{Carbon\Carbon::parse($leave->leave_starting_date)->isoFormat('MMM Do YY')}}</span> <b>-to-</b> <span class="text-danger">{{Carbon\Carbon::parse($leave->leave_ending_date)->isoFormat('MMM Do YY')}}</span>
                                                        @endif 
                                                    </td>
                                                    <td>{{$leave->actual_days}}</td>
                                                    <td>
                                                        <button type="button" id="{{$leave->id}}" class="btn btn-success btn-xs approve" data-toggle="tooltip" data-placement="top" title="Approve Request"><i class="fa fa-check"></i></button>
                                                        <button type="button" id="{{$leave->unique_id}}" class="btn btn-danger btn-xs reject" data-toggle="tooltip" data-placement="top" title="Reject Request"><i class="fa fa-times"></i></button>
                                                    </td>
                                                </tr>    
                                                @endif   
                                            @endforeach                                    
                                                                         

                                         </tbody>
                                    
                                    </table>

                                        <input type="hidden" name="user_name" value="Admin">
                                        <input type="hidden" name="user_id" value="1">  
                                    </div>
                            </div>   
                            <div class="tab-pane fade" id="tab2_2">
                                
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th>SN</th>
                                            <th>Employee Id</th>
                                            <th>Name</th>
                                            <th>Designation</th>
                                            <th>Leave type</th>
                                            <th>Period</th>
                                            <th>Working Days</th>
                                            <th>Approved By</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                                                                
                                            @foreach ($leave_application as $leave)
                                                @if ($leave->status == 1)
                                                <tr>
                                                    <input name="id" type="hidden" value="1">
                                                    
                                                    <td>{{$sn++}}</td>
                                                    <td>
                                                        <a href="{{route('employee.profile', base64_encode($leave->eid))}}" target="_blank" data-toggle="tooltip" data-placement="top" title="View Profile" style="color: #319DB5"><b>{{$leave->employeeId}}</b></a>
                                                    </td>
                                                    <td>{{$leave->emp_name}}</td>
                                                    <td>{{$leave->designation_name}}</td>
                                                    <td>{{$leave->leave_type}}</td>
                                                    <td>
                                                        @if ($leave->leave_starting_date)
                                                        <span class="text-green">{{Carbon\Carbon::parse($leave->leave_starting_date)->isoFormat('MMM Do YY')}}</span> <b>-to-</b> <span class="text-danger">{{Carbon\Carbon::parse($leave->leave_ending_date)->isoFormat('MMM Do YY')}}</span>
                                                        @endif 
                                                    </td>
                                                    <td>{{$leave->actual_days}}</td>
                                                    <td>{{$leave->approve_by}}</td>
                                                    <td>
                                                        <button type="button" id="{{$leave->unique_id}}" class="btn btn-danger btn-xs reject" data-toggle="tooltip" data-placement="top" title="Reject Request"><i class="fa fa-times"></i></button>
                                                    </td>
                                                </tr>    
                                                @endif   
                                            @endforeach  
                                        </tbody>
                                    
                                    </table>

                                        <input type="hidden" name="user_name" value="Admin">
                                        <input type="hidden" name="user_id" value="1">  
                                    </div>
                            </div> 
                            <div class="tab-pane fade" id="tab2_3">
                                
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                        
                                            <th>SN</th>
                                            <th>Employee ID</th>
                                            <th>Name</th>
                                            <th>Designation</th>
                                            <th>Leave type</th>
                                            <th>Period</th>
                                            <th>Working Days</th>
                                            <th>Reject By</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                                                                
                                            @foreach ($leave_application as $leave)
                                                @if ($leave->status == 2)
                                                <tr>
                                                    <input name="id" type="hidden" value="1">
                                                    
                                                    <td>{{$sn++}}</td>
                                                    <td>
                                                            <a href="{{route('employee.profile', base64_encode($leave->eid))}}" target="_blank" data-toggle="tooltip" data-placement="top" title="View Profile" style="color: #319DB5"><b>{{$leave->employeeId}}</b></a>
                                                    </td>
                                                    <td>{{$leave->emp_name}}</td>
                                                    <td>{{$leave->designation_name}}</td>
                                                    <td>{{$leave->leave_type}}</td>
                                                    <td>
                                                        @if ($leave->leave_starting_date !=null)
                                                        <span class="text-green">{{Carbon\Carbon::parse($leave->leave_starting_date)->isoFormat('MMM Do YY')}}</span> <b>-to-</b> <span class="text-danger">{{Carbon\Carbon::parse($leave->leave_ending_date)->isoFormat('MMM Do YY')}}</span>
                                                        @endif 
                                                    </td>
                                                    <td>{{$leave->actual_days}}</td>
                                                    <td>{{$leave->approve_by}}</td>
                                                    <td>
                                                        <button type="button" id="{{$leave->unique_id}}" class="btn btn-success btn-xs approve_again" data-toggle="tooltip" data-placement="top" title="Approve Request"><i class="fa fa-check"></i></button>
                                                    </td>
                                                </tr>    
                                                @endif   
                                            @endforeach 
                                        </tbody>
                                    
                                    </table>

                                        <input type="hidden" name="user_name" value="Admin">
                                        <input type="hidden" name="user_id" value="1">  
                                    </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

@section('extra_js')
<script>
    $(document).ready(function(){

        //Approve Leave
        $( ".approve" ).click(function() {
            var id = $(this).attr('id');
            //alert(id);
            $.ajax({
                type: "GET",
                url:"{{url('leave_approve')}}"+"/"+id,
                dataType:"json",
                success:function(response){
                    //console.log(response);
                    if(response.falied)
                    {
                        swal(response.falied, "", "error");
                    }
                    if(response.success)
                    {
                        //$("#lode-content").load(" #lode-content");
                        $('.page-content').load(location.href + " .page-content");
                        swal(response.success, "", "success");
                        
                    }
                }
            })
        });

        //Reject Leave
        $( ".reject" ).click(function() {
            var unique_id = $(this).attr('id');
            //alert(unique_id);
            $.ajax({
                type: "GET",
                url:"{{url('leave_reject')}}"+"/"+unique_id,
                dataType:"json",
                success:function(response){
                    //console.log(response);
                    if(response.falied)
                    {
                        swal(response.falied, "", "error");
                    }
                    if(response.success)
                    {
                        //$("#lode-content").load(" #lode-content");
                        $('.page-content').load(location.href + " .page-content");
                        swal(response.success, "", "success");
                        
                    }
                }
            })
        });
        
        //approve_again Leave
        $( ".approve_again" ).click(function() {
            var unique_id = $(this).attr('id');
            //alert(unique_id);
            $.ajax({
                type: "GET",
                url:"{{url('leave_approve_again')}}"+"/"+unique_id,
                dataType:"json",
                success:function(response){
                    //console.log(response);
                    if(response.falied)
                    {
                        swal(response.falied, "", "error");
                    }
                    if(response.success)
                    {
                        //$("#lode-content").load(" #lode-content");
                        $('.page-content').load(location.href + " .page-content");
                        swal(response.success, "", "success");
                        
                    }
                }
            })
        });
    
    });
    </script>
@endsection