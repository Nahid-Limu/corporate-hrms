@extends('layout.master')
@section('title', 'Employee Profile')
@section('content')
    <!--BEGIN TITLE & BREADCRUMB PAGE-->
    <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
        <div class="page-header pull-left">
            <div class="page-title">Profile</div>
        </div>
        <ol class="breadcrumb page-breadcrumb pull-right">
            <li><i class="fa fa-home"></i>&nbsp;<a href="{{url('/')}}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
            <li><a href="#">Employee</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
            <li class="active">Employee Profile</li>
        </ol>
        <div class="clearfix"></div>
    </div>
    <!--END TITLE & BREADCRUMB PAGE-->
    <div class="page-content">
        {{ Html::script('corporate/js/sweetalert.min.js') }}
        @if(Session::has('success'))
        <script>
            var msg =' <?php echo Session::get('success');?>'
            swal(msg, "", "success");
        </script>
        @endif
        @if(Session::has('delete'))
        <script>
            var msg =' <?php echo Session::get('delete');?>'
            swal(msg, "", "warning");
        </script>
        @endif
        <!--password update modal-->
         @include('backend.employee.modal.password_update')
        <!--Password update Modal-->

        <!--image update modal-->
        @include('backend.employee.modal.image_update')
        <!--image update Modal-->

        <!--profile update modal-->
        @include('backend.employee.modal.update_profile')
        <!--profile update Modal-->

        <!--educational info add modal-->
        @include('backend.employee.modal.education_add')
        <!--educational info add modal-->

       <div class="panel-body profile-panel-body">
           <div id="sum_box" class="row mbl">
               <div class="col-md-3">
                   <div class="panel mbm">
                       <div class="panel-body">
                           <div class="profile_img row" >
                               <div class="panel-img col-sm-12">
                                   <center>
                                       @if($employee_profile->emp_photo=='')
                                           <div class="text-center mbl"><center><img width="250PX" src="{{asset('employee_image/profile_image.jpg')}}" alt="employee image" class="img-responsive"/></center></div>
                                       @else
                                           <div class="text-center mbl"><center><img width="250px" src="{{asset('employee_image/'.$employee_profile->emp_photo)}}" alt="employee image" class="img-responsive"/></center></div>
                                       @endif
                                   </center>
                                <!--    <div style="text-align: center">
                                       <i  class="fa fa-star"></i>
                                       <i  class="fa fa-star"></i>
                                       <i  class="fa fa-star"></i>
                                       <i  class="fa fa-star"></i>
                                   </div> -->

                               </div>
                           </div>
                           <br>
                           <div class="col-sm-6">
                               <a href="#" data-toggle="modal" data-target="#passwordUpdate" class="btn btn-warning btn-xs"><i class="fa fa-edit"></i> Password </a>
                           </div>
                           <div class="col-sm-6" style="text-align: right;">
                               <a href="#" data-toggle="modal"
                                  data-target="#editPhoto"  class="btn btn-warning btn-xs"><i class="fa fa-edit"></i> Photo </a>
                           </div>
                           <hr>
                           <div class="profile_details">
                               <ul>
                                   <li>
                                       <p>Branch</p>
                                       <p> <span>{{$employee_profile->branch_name}}</span> </p>
                                   </li>
                                   <li>
                                       <p>Department</p>
                                       <p> <span>{{$employee_profile->department_name}}</span> </p>
                                   </li>
                                   <li>
                                       <p>Designation</p>
                                       <p> <span>{{$employee_profile->designation_name}}</span> </p>
                                   </li>
                                   <li>
                                       <p>Full Name <span>*</span></p>
                                       <p> <span>{{$employee_profile->emp_first_name}} {{$employee_profile->emp_lastName}}</span> </p>
                                   </li>
                                   <li>
                                       <p>Employee ID</p>
                                       <p> <span>{{$employee_profile->employeeId}}</span> </p>
                                   </li>
                                   <li>
                                       <p>Card No</p>
                                       <p> <span>{{$employee_profile->emp_card_number}}</span> </p>
                                   </li>
                                   <li>
                                       <p>Status </p>
                                       <p>
                                           @if($employee_profile->emp_account_status==1)
                                               <span class="text-success">Active</span>
                                               @else
                                               <span class="text-danger">Inactive</span>
                                           @endif
                                       </p>
                                   </li>
                               </ul>
                           </div>
                       </div>
                   </div>
               </div>

               <div class="col-md-9">
                   <div class="panel">
                       <div class="panel-body profile-panel-body">
                           <ul class="nav nav-tabs" id="myTab">
                               <li class="active"><a href="#profile" data-toggle="tab" aria-expanded="true"><i class="fa fa-user"></i> Profile</a></li>
                               <li><a href="#education" data-toggle="tab" aria-expanded="false"><i class="fa fa-book"></i> Educational Information</a></li>
                               <li><a href="#training" data-toggle="tab" aria-expanded="false"><i class="fa fa-empire"></i> Training</a></li>
                               <li><a href="#salary" data-toggle="tab" aria-expanded="false"><i class="fa fa-money"></i> Salary</a></li>
                               <li><a href="#download" data-toggle="tab" aria-expanded="false"><i class="fa fa-download"></i> Download</a></li>
                           </ul>
                           <div id="generalTabContent" class="tab-content profile-tab-content">
                               <!-- profile -->
                               <div id="profile" class="tab-pane fade in active">
                                   <form action="#" class="form-horizontal from_group_bottom_none">
                                       <div class="row pb-r">
                                           <div class="col-md-8">
                                               <p class="content_heading">
                                                   <label for="" class="left_label"><i class="fa fa-angle-up"></i></label>
                                                   Personal Information
                                                   <i class="right_label fa fa-info-circle"></i>
                                               </p>
                                           </div>
                                           <div class="col-md-4">
                                               <a href="#" class="btn edit_btn btn-xs no-event-btn" data-toggle="modal"
                                                       data-target="#{{$employee_profile->emp_id}}"><i class="fa fa-edit"></i>Edit</a>
                                           </div>
                                           <hr>
                                           <div class="col-md-6">
                                               <div class="form-group">
                                                   <label for="" class="col-md-5 col-sm-4 col-xs-5 control-label">Full Name: </label>
                                                   <div class="col-md-7 col-sm-8 col-xs-7">
                                                       <p class="form-control-static">{{$employee_profile->emp_first_name}} {{$employee_profile->emp_lastName}} &nbsp</p>
                                                   </div>
                                               </div>
                                           </div>

                                           <div class="col-md-6">
                                               <div class="form-group">
                                                   <label for="" class="col-md-5 col-sm-4 col-xs-5 control-label">Employee ID: </label>
                                                   <div class="col-md-7 col-sm-8 col-xs-7">
                                                       <p class="form-control-static">{{$employee_profile->employeeId}} &nbsp</p>
                                                   </div>
                                               </div>
                                           </div>

                                           <div class="col-md-6">
                                               <div class="form-group">
                                                   <label for="" class="col-md-5 col-sm-4 col-xs-5 control-label">Card No: </label>
                                                   <div class="col-md-7 col-sm-8 col-xs-7">
                                                       <p class="form-control-static">{{$employee_profile->emp_card_number}} &nbsp</p>
                                                   </div>
                                               </div>
                                           </div>

                                           <div class="col-md-6">
                                               <div class="form-group">
                                                   <label for="" class="col-md-5 col-sm-4 col-xs-5 control-label">Father Name: </label>
                                                   <div class="col-md-7 col-sm-8 col-xs-7">
                                                       <p class="form-control-static">{{$employee_profile->emp_father_name}} &nbsp</p>
                                                   </div>
                                               </div>
                                           </div>

                                           <div class="col-md-6">
                                               <div class="form-group">
                                                   <label for="" class="col-md-5 col-sm-4 col-xs-5 control-label">Mother Name: </label>
                                                   <div class="col-md-7 col-sm-8 col-xs-7">
                                                       <p class="form-control-static">{{$employee_profile->emp_mother_name}} &nbsp</p>
                                                   </div>
                                               </div>
                                           </div>

                                           <div class="col-md-6">
                                               <div class="form-group">
                                                   <label for="" class="col-md-5 col-sm-4 col-xs-5 control-label">Religion: </label>
                                                   <div class="col-md-7 col-sm-8 col-xs-7">
                                                       <p class="form-control-static">{{$employee_profile->emp_religion}} &nbsp</p>
                                                   </div>
                                               </div>
                                           </div>

                                           <div class="col-md-6">
                                               <div class="form-group">
                                                   <label for="" class="col-md-5 col-sm-4 col-xs-5 control-label">Current Address: </label>
                                                   <div class="col-md-7 col-sm-8 col-xs-7">
                                                       <p class="form-control-static">{{$employee_profile->emp_current_address}} &nbsp</p>
                                                   </div>
                                               </div>
                                           </div>

                                           <div class="col-md-6">
                                               <div class="form-group">
                                                   <label for="" class="col-md-5 col-sm-4 col-xs-5 control-label">Permanent Address: </label>
                                                   <div class="col-md-7 col-sm-8 col-xs-7">
                                                       <p class="form-control-static">{{$employee_profile->emp_parmanent_address}} &nbsp</p>
                                                   </div>
                                               </div>
                                           </div>

                                           <div class="col-md-6">
                                               <div class="form-group">
                                                   <label for="" class="col-md-5 col-sm-4 col-xs-5 control-label">Branch: </label>
                                                   <div class="col-md-7 col-sm-8 col-xs-7">
                                                       <p class="form-control-static">{{$employee_profile->branch_name}} &nbsp</p>
                                                   </div>
                                               </div>
                                           </div>

                                           <div class="col-md-6">
                                               <div class="form-group">
                                                   <label for="" class="col-md-5 col-sm-4 col-xs-5 control-label">Department: </label>
                                                   <div class="col-md-7 col-sm-8 col-xs-7">
                                                       <p class="form-control-static">{{$employee_profile->department_name}} &nbsp</p>
                                                   </div>
                                               </div>
                                           </div>

                                           <div class="col-md-6">
                                               <div class="form-group">
                                                   <label for="" class="col-md-5 col-sm-4 col-xs-5 control-label">Designation: </label>
                                                   <div class="col-md-7 col-sm-8 col-xs-7">
                                                       <p class="form-control-static">{{$employee_profile->designation_name}} &nbsp</p>
                                                   </div>
                                               </div>
                                           </div>

                                           <div class="col-md-6">
                                               <div class="form-group">
                                                   <label for="" class="col-md-5 col-sm-4 col-xs-5 control-label">Joining Date: </label>
                                                   <div class="col-md-7 col-sm-8 col-xs-7">
                                                       <p class="form-control-static">{{date('F-d-Y',strtotime($employee_profile->emp_joining_date))}} &nbsp</p>
                                                   </div>
                                               </div>
                                           </div>

                                           <div class="col-md-6">
                                               <div class="form-group">
                                                   <label for="" class="col-md-5 col-sm-4 col-xs-5 control-label">Date Of Birth: </label>
                                                   <div class="col-md-7 col-sm-8 col-xs-7">
                                                       <p class="form-control-static">{{date('F-d-Y',strtotime($employee_profile->emp_dob))}} &nbsp</p>
                                                   </div>
                                               </div>
                                           </div>

                                           <div class="col-md-6">
                                               <div class="form-group">
                                                   <label for="" class="col-md-5 col-sm-4 col-xs-5 control-label">Nationality: </label>
                                                   <div class="col-md-7 col-sm-8 col-xs-7">
                                                       <p class="form-control-static">{{$employee_profile->emp_nationality}} &nbsp</p>
                                                   </div>
                                               </div>
                                           </div>

                                           <div class="col-md-6">
                                               <div class="form-group">
                                                   <label for="" class="col-md-5 col-sm-4 col-xs-5 control-label">National Id: </label>
                                                   <div class="col-md-7 col-sm-8 col-xs-7">
                                                       <p class="form-control-static">{{$employee_profile->emp_nid}} &nbsp</p>
                                                   </div>
                                               </div>
                                           </div>

                                           <div class="col-md-6">
                                               <div class="form-group">
                                                   <label for="" class="col-md-5 col-sm-4 col-xs-5 control-label">Blood group: </label>
                                                   <div class="col-md-7 col-sm-8 col-xs-7">
                                                       <p class="form-control-static">

                                                              @if($employee_profile->emp_blood_group==1)
                                                                  A+
                                                               @endif
                                                               @if($employee_profile->emp_blood_group==2)
                                                                   B+
                                                               @endif
                                                               @if($employee_profile->emp_blood_group==3)
                                                                   AB+
                                                               @endif
                                                               @if($employee_profile->emp_blood_group==4)
                                                                   O+
                                                               @endif
                                                               @if($employee_profile->emp_blood_group==5)
                                                                   A-
                                                               @endif
                                                               @if($employee_profile->emp_blood_group==6)
                                                                   B-
                                                               @endif
                                                               @if($employee_profile->emp_blood_group==7)
                                                                   AB-
                                                               @endif
                                                               @if($employee_profile->emp_blood_group==8)
                                                                   O-
                                                               @endif
                                                               &nbsp</p>
                                                           </div>
                                                      </div>
                                                </div>
                                           <div class="col-md-6">
                                               <div class="form-group">
                                                   <label for="" class="col-md-5 col-sm-4 col-xs-5 control-label">Email: </label>
                                                   <div class="col-md-7 col-sm-8 col-xs-7">
                                                       <p class="form-control-static">{{$employee_profile->emp_email}} &nbsp</p>
                                                   </div>
                                               </div>
                                           </div>

                                           <div class="col-md-6">
                                               <div class="form-group">
                                                   <label for="" class="col-md-5 col-sm-4 col-xs-5 control-label">Probation Period: </label>
                                                   <div class="col-md-7 col-sm-8 col-xs-7">
                                                       <p class="form-control-static">
                                                           @php
                                                               $expectedDate=\Carbon\Carbon::now()->subMonths($employee_profile->emp_probation_period);
                                                               $joiningDate=\Carbon\Carbon::parse($employee_profile->emp_joining_date);
                                                               $difference = $joiningDate->diffInMonths($expectedDate);
                                                           @endphp
                                                           Remaining Probation Period:<span class="employee-profile-text">
                                                               @if($expectedDate<$joiningDate)
                                                                   <span class="red-text">{{$difference}}</span> Month/s</span>
                                                               @else
                                                               <span class="green-text">Completed</span>
                                                               @endif
                                                            &nbsp</p>
                                                   </div>
                                               </div>
                                           </div>

                                           <div class="col-md-6">
                                               <div class="form-group">
                                                   <label for="" class="col-md-5 col-sm-4 col-xs-5 control-label">Marital Status: </label>
                                                   <div class="col-md-7 col-sm-8 col-xs-7">
                                                       <p class="form-control-static">
                                                           @if($employee_profile->emp_marital_status==1)
                                                               Single
                                                           @endif
                                                           @if($employee_profile->emp_marital_status==2)
                                                               Married
                                                           @endif
                                                           @if($employee_profile->emp_marital_status==3)
                                                                Divorced
                                                           @endif
                                                           &nbsp</p>
                                                   </div>
                                               </div>
                                           </div>

                                           <div class="col-md-6">
                                               <div class="form-group">
                                                   <label for="" class="col-md-5 col-sm-4 col-xs-5 control-label">Bank Account: </label>
                                                   <div class="col-md-7 col-sm-8 col-xs-7">
                                                       <p class="form-control-static">{{$employee_profile->emp_bank_account}} &nbsp</p>
                                                   </div>
                                               </div>
                                           </div>

                                           <div class="col-md-6">
                                               <div class="form-group">
                                                   <label for="" class="col-md-5 col-sm-4 col-xs-5 control-label">Bank Information: </label>
                                                   <div class="col-md-7 col-sm-8 col-xs-7">
                                                       <p class="form-control-static">{{$employee_profile->emp_bank_info}} &nbsp</p>
                                                   </div>
                                               </div>
                                           </div>


                                           <div class="col-md-6">
                                               <div class="form-group">
                                                   <label for="" class="col-md-5 col-sm-4 col-xs-5 control-label">Mobile: </label>
                                                   <div class="col-md-7 col-sm-8 col-xs-7">
                                                       <p class="form-control-static">{{$employee_profile->emp_phone}} &nbsp</p>
                                                   </div>
                                               </div>
                                           </div>


                                           <div class="col-md-6">
                                               <div class="form-group">
                                                   <label for="" class="col-md-5 col-sm-4 col-xs-5 control-label">Emergency Phone: </label>
                                                   <div class="col-md-7 col-sm-8 col-xs-7">
                                                       <p class="form-control-static">{{$employee_profile->emp_emergency_phone}} &nbsp</p>
                                                   </div>
                                               </div>
                                           </div>

                                           <div class="col-md-6">
                                               <div class="form-group">
                                                   <label for="" class="col-md-5 col-sm-4 col-xs-5 control-label">Emergency Address: </label>
                                                   <div class="col-md-7 col-sm-8 col-xs-7">
                                                       <p class="form-control-static">{{$employee_profile->emp_emergency_address}} &nbsp</p>
                                                   </div>
                                               </div>
                                           </div>

                                           <div class="col-md-6">
                                               <div class="form-group">
                                                   <label for="" class="col-md-5 col-sm-4 col-xs-5 control-label">Gender: </label>
                                                   <div class="col-md-7 col-sm-8 col-xs-7">
                                                       <p class="form-control-static">@if($employee_profile->emp_gender_id==1) Male @else Female @endif &nbsp</p>
                                                   </div>
                                               </div>
                                           </div>

                                           <div class="col-md-6">
                                               <div class="form-group">
                                                   <label for="" class="col-md-5 col-sm-4 col-xs-5 control-label">Shift: </label>
                                                   <div class="col-md-7 col-sm-8 col-xs-7">
                                                       <p class="form-control-static">{{$employee_profile->shift_name}} &nbsp</p>
                                                   </div>
                                               </div>
                                           </div>

                                           <div class="col-md-6">
                                               <div class="form-group">
                                                   <label for="" class="col-md-5 col-sm-4 col-xs-5 control-label">Date of Discontinuation: </label>
                                                   <div class="col-md-7 col-sm-8 col-xs-7">
                                                       <p class="form-control-static">
                                                           @if($employee_profile->date_of_discontinuation !=null)
                                                           {{\Carbon\Carbon::parse($employee_profile->date_of_discontinuation)->format('j F Y') }}
                                                           @endif &nbsp
                                                       </p>
                                                   </div>
                                               </div>
                                           </div>

                                           <div class="col-md-6">
                                               <div class="form-group">
                                                   <label for="" class="col-md-5 col-sm-4 col-xs-5 control-label">Reason of Discontinuation: </label>
                                                   <div class="col-md-7 col-sm-8 col-xs-7">
                                                       <p class="form-control-static">{{ $employee_profile->reason_of_discontinuation }} &nbsp</p>
                                                   </div>
                                               </div>
                                           </div>

                                           <div class="col-md-6">
                                               <div class="form-group">
                                                   <label for="" class="col-md-5 col-sm-4 col-xs-5 control-label">Overtime Status: </label>
                                                   <div class="col-md-7 col-sm-8 col-xs-7">
                                                       <p class="form-control-static">@if($employee_profile->emp_ot_status==1) On @else Off @endif &nbsp</p>
                                                   </div>
                                               </div>
                                           </div>

                                           <div class="col-md-6">
                                               <div class="form-group">
                                                   <label for="" class="col-md-5 col-sm-4 col-xs-5 control-label">Employee Status: </label>
                                                   <div class="col-md-7 col-sm-8 col-xs-7">
                                                       <p class="form-control-static">@if($employee_profile->emp_account_status==1)
                                                               <span class="text-success">Active</span>
                                                           @else
                                                               <span class="text-danger">Inactive</span>
                                                           @endif &nbsp</p>
                                                   </div>
                                               </div>
                                           </div>


                                           <div class="col-md-8">
                                               <p class="content_heading">
                                                   <label for="" class="left_label"><i class="fa fa-angle-up"></i></label>
                                                    Task List - {{date('F')}}
                                                   <i class="right_label fa fa-info-circle"></i>
                                               </p>
                                           </div>

                                           <div class="col-md-12">
                                           <div class="table-responsive">
                                               <table class="table table-striped table-bordered table-hover">
                                                   <thead>
                                                    @if (!$task_list->isEmpty())
                                                        
                                                   <tr>
                                                       <th>Task</th>
                                                       <th>Start Time</th>
                                                       <th>End Time</th>
                                                       <th>Assign Date</th>
                                                       <th>Status</th>
                                                   </tr>
                                                   @else
                                                   @endif
                                                   </thead>
                                                   <tbody>
                                                   @if(!$task_list->isEmpty())
                                                       @foreach($task_list as $task_lists)
                                                           <tr>
                                                               <td>{{$task_lists->title}}</td>
                                                               <td>{{date('H:i:a',strtotime($task_lists->start_time))}}</td>
                                                               <td>{{date('H:i:a',strtotime($task_lists->end_time))}}</td>
                                                               <td>{{date('F-d-Y',strtotime($task_lists->assign_date))}}</td>
                                                               <td>
                                                                   @if($task_lists->task_assign_status==1)
                                                                       <span class="text-warning">INCOMPLETE</span>
                                                                   @else
                                                                       <span class="text-success">COMPLETE</span>
                                                                   @endif
                                                               </td>
                                                           </tr>
                                                       @endforeach
                                                   @else
                                                       <h5>Sorry no task found</h5>
                                                   @endif
                                                   </tbody>
                                               </table>
                                           </div>
                                        </div>

                                           {{--<div class="col-md-8">--}}
                                               {{--<p class="content_heading">--}}
                                                   {{--<label for="" class="left_label"><i class="fa fa-angle-up"></i></label>--}}
                                                   {{--Leave Details--}}
                                                   {{--<i class="right_label fa fa-info-circle"></i>--}}
                                               {{--</p>--}}
                                           {{--</div>--}}

                                           {{--<div class="col-md-12">--}}
                                               {{--<div class="table-responsive">--}}
                                                   {{--<table class="table table-striped table-bordered table-hover">--}}
                                                       {{--<thead>--}}
                                                       {{--<tr>--}}
                                                           {{--<th>Leave Name</th>--}}
                                                           {{--<th>Total Days</th>--}}
                                                           {{--<th>Available Days</th>--}}
                                                           {{--<th>Leave Taken</th>--}}
                                                       {{--</tr>--}}
                                                       {{--</thead>--}}
                                                       {{--<tbody>--}}
                                                       {{--<tr>--}}
                                                           {{--<td>1</td>--}}
                                                           {{--<td>Table cell</td>--}}
                                                           {{--<td>Table cell</td>--}}
                                                           {{--<td>Table cell</td>--}}
                                                       {{--</tr>--}}
                                                       {{--</tbody>--}}
                                                   {{--</table>--}}
                                               {{--</div>--}}
                                           {{--</div>--}}


                                           <div class="col-md-8">
                                               <p class="content_heading">
                                                   <label for="" class="left_label"><i class="fa fa-angle-up"></i></label>
                                                   Attendance Details - {{$attendace->month}}
                                                   <i class="right_label fa fa-info-circle"></i>
                                               </p>
                                           </div>

                                           <div class="col-md-12">
                                               <div class="table-responsive">
                                                   <table class="table table-striped table-bordered table-hover">
                                                       <thead>
                                                       <tr>
                                                           <th>Month</th>
                                                           <th>Working Days</th>
                                                           <th>Present</th>
                                                           <th>Absent</th>
                                                           <th>Leave</th>
                                                       </tr>
                                                       </thead>
                                                       <tbody>
                                                       <tr>
                                                           <td>{{$attendace->month}}</td>
                                                           <td>{{$attendace->working_days}}</td>
                                                           <td>{{$attendace->present}}</td>
                                                           <td>{{$attendace->working_days-$attendace->present-$attendace->leave}}</td>
                                                           <td>{{$attendace->leave}}</td>
                                                       </tr>
                                                       </tbody>
                                                   </table>
                                               </div>
                                           </div>
                                       </div>
                                   </form>
                               </div>
                               <!-- profile -->

                               <!-- education -->
                               <div id="education" class="tab-pane fade in">
                                   <div class="row mbl">
                                       <div>
                                           <div class="col-md-8 col-sm-12">
                                               <p class="content_heading">
                                                   <label for="" class="left_label"><i class="fa fa-angle-up"></i></label>
                                                    Educational Information:
                                                   <i class="right_label fa fa-info-circle"></i>
                                               </p>
                                           </div>
                                           <div class="subject-result-a">
                                               <div class="col-md-12 bottom-padding-12 ID-97">
                                                   <div class="table-responsive">
                                                       <table class="table table-striped table-bordered table-hover">
                                                           <thead>
                                                           <tr>
                                                               <th>Exam Name</th>
                                                               <th>Institution</th>
                                                               <th>Result</th>
                                                               <th>Scale</th>
                                                               <th>Passing Year</th>
                                                               <th>Action</th>
                                                           </tr>
                                                           </thead>
                                                           <tbody>
                                                           @foreach($employee_education as $employee_educations)
                                                           <tr>
                                                               <td>{{$employee_educations->emp_exam_title}}</td>
                                                               <td>{{$employee_educations->emp_Institution_name}}</td>
                                                               <td>{{$employee_educations->emp_result}}</td>
                                                               <td>{{$employee_educations->emp_scale}}</td>
                                                               <td>{{$employee_educations->emp_passing_year}}</td>
                                                               <td><button type="button" data-toggle="modal" data-target="#{{$employee_educations->edu_id}}" class="btn btn-warning btn-xs"><i class="fa fa-pencil"></i> </button> <a onclick="return confirm('Are You Sure?')" href="{{url('employee/education/delete'.'/'.$employee_educations->edu_id)}}" class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i> </a> </td>
                                                           </tr>
                                                           <div id="{{$employee_educations->edu_id}}" class="modal fade" role="dialog">
                                                               <div class="modal-dialog">
                                                                   <!-- Modal content-->
                                                                   <div class="modal-content">
                                                                       <div class="modal-header">
                                                                           <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                           <h5 class="modal-title">Update Educational Information</h5>
                                                                       </div>
                                                                       <div class="modal-body">
                                                                           <div class="row">
                                                                               {!! Form::open(['method'=>'POST','route'=>'employee.education.update','files'=>true]) !!}
                                                                               <div class="col-md-12">

                                                                                   <div class="form-group">
                                                                                       <label for="department_name">Examination Name <span style="color:red">*</span> </label>
                                                                                       <input type="text" class="form-control" id="exam_name" name="emp_exam_title" autocomplete="off" value="{{$employee_educations->emp_exam_title}}" required>
                                                                                   </div>

                                                                                   <div class="form-group">
                                                                                       <label for="department_name">Institution <span style="color:red">*</span> </label>
                                                                                       <input type="text" class="form-control" id="institution" name="emp_Institution_name" value="{{$employee_educations->emp_Institution_name}}" autocomplete="off" required>
                                                                                   </div>

                                                                                   <div class="form-group">
                                                                                       <label for="department_name">Exam Result <span style="color:red">*</span> </label>
                                                                                       <input type="text"  class="form-control" id="exam_result" name="emp_result" autocomplete="off" value="{{$employee_educations->emp_result}}" required>
                                                                                   </div>

                                                                                   <div class="form-group">
                                                                                       <label for="department_name">Scale</label>
                                                                                       <input type="text" class="form-control" id="scale" name="emp_scale" value="{{$employee_educations->emp_scale}}" autocomplete="off">
                                                                                   </div>

                                                                                   <div class="form-group">
                                                                                       <label for="passing_year">Passing Year <span style="color:red">*</span> </label>
                                                                                       <input type="text" class="form-control" id="passing_year" name="emp_passing_year" autocomplete="off"  value="{{$employee_educations->emp_passing_year}}" required>
                                                                                   </div>

                                                                                   <div class="form-group">
                                                                                       <label for="attachment">Attachment</label>
                                                                                       <input type="file" class="form-control" id="attachment" name="emp_attachment" autocomplete="off">
                                                                                   </div>
                                                                                   <input type="hidden" name="edu_id" value="{{$employee_educations->edu_id}}">
                                                                                   <div class="form-group">
                                                                                       <button id="add_vendor_btn" type="Submit" class="btn btn-primary"><i class="fa fa-save"></i> Save Information</button>
                                                                                   </div>
                                                                               </div>
                                                                               {!! Form::close() !!}
                                                                           </div>
                                                                       </div>
                                                                   </div>
                                                               </div>
                                                            </div>
                                                           @endforeach
                                                           </tbody>
                                                       </table>
                                                       <div  class="col-md-12">
                                                           <div style="width: 25%; margin: 0 auto">
                                                               <a href="#" style="margin-top: 30px; text-align: center;" data-toggle="modal"
                                                                  data-target="#addEducation" class="btn btn-green"> <i class="fa fa-plus-circle"></i> New Educational Information </a>
                                                           </div>
                                                       </div>
                                                   </div>
                                               </div>
                                           </div>
                                       </div>
                                   </div>
                               </div>
                               <!-- education -->

                               <!-- training -->
                               <div id="training" class="tab-pane fade in">
                                   <h4>Coming Soon</h4>
                                   {{--<div class="row mbl">--}}
                                       {{--<div  class="col-md-12">--}}
                                           {{--<div class="col-md-8">--}}
                                               {{--<p class="content_heading">--}}
                                                   {{--<label for="" class="left_label"><i class="fa fa-angle-up"></i></label>--}}
                                                   {{--Training History Of {{date('F')}}--}}
                                                   {{--<i class="right_label fa fa-info-circle"></i>--}}
                                               {{--</p>--}}
                                           {{--</div>--}}

                                           {{--<div class="col-md-12">--}}
                                               {{--<div class="table-responsive">--}}
                                                   {{--<table class="table table-striped table-bordered table-hover">--}}
                                                       {{--<thead>--}}
                                                       {{--<tr>--}}
                                                           {{--<th>Month</th>--}}
                                                           {{--<th>Present</th>--}}
                                                           {{--<th>Absent</th>--}}
                                                           {{--<th>Leave</th>--}}
                                                       {{--</tr>--}}
                                                       {{--</thead>--}}
                                                       {{--<tbody>--}}
                                                       {{--<tr>--}}
                                                           {{--<td>1</td>--}}
                                                           {{--<td>Table cell</td>--}}
                                                           {{--<td>Table cell</td>--}}
                                                           {{--<td>Table cell</td>--}}
                                                       {{--</tr>--}}
                                                       {{--</tbody>--}}
                                                   {{--</table>--}}
                                               {{--</div>--}}
                                           {{--</div>--}}
                                       {{--</div>--}}
                                   {{--</div>--}}
                               </div>
                               <!-- training -->

                               <!-- salary -->
                               <div id="salary" class="tab-pane fade in">
                                   <div class="col-md-8">
                                       <p class="content_heading">
                                           <label for="" class="left_label"><i class="fa fa-angle-up"></i></label>
                                           Current Salary @foreach($current_salary as $salary) {{$salary->total_salary}} @endforeach
                                           <i class="right_label fa fa-info-circle"></i>
                                       </p>
                                   </div>
                                   <hr>
                                   <div class="col-md-12">
                                       <div class="table-responsive">
                                           <table class="table table-striped table-bordered table-hover">
                                               <thead>
                                               <tr>
                                                   <th>Grade</th>
                                                   <th>Basic</th>
                                                   <th>House</th>
                                                   <th>Medical</th>
                                                   <th>Transport</th>
                                                   <th>Food</th>
                                                   <th>Others</th>
                                               </tr>
                                               </thead>
                                               <tbody>
                                                @if($current_salary->isEmpty()) 
                                                <h6 class="text-center">No Salary Record Found</h6>
                                                @else 
                                               @foreach($current_salary as $salary)
                                               <tr>
                                                   <td>{{$salary->grade_name}}</td>
                                                   <td>{{$salary->basic_salary}}</td>
                                                   <td>{{$salary->house_rant}}</td>
                                                   <td>{{$salary->medical}}</td>
                                                   <td>{{$salary->transport}}</td>
                                                   <td>{{$salary->food}}</td>
                                                   <td>@if($salary->other=='')0
                                                    @else 
                                                    {{$salary->other}}
                                                    @endif
                                                  </td>
                                               </tr>
                                               @endforeach
                                               @endif
                                               </tbody>
                                           </table>
                                       </div>
                                   </div>
                               </div>
                               <!-- salary -->

                               <!-- download -->
                               <div id="download" class="tab-pane fade in">
                                   <div class="col-md-12">
                                       <a style="padding: 5px" href="{{url('employee/download/id/card'.'/'.$employee_profile->emp_id)}}" class="btn-success"><i class="fa fa-download"></i> Identity card</a>
                                   </div>
                                   <br>
                                   <br>
                                   <br>

                                   <div class="col-md-12">
                                       <a style="padding: 5px" href="{{url('employee/download/job/application/letter'.'/'.$employee_profile->emp_id)}}" class="btn-success"><i class="fa fa-download"></i> Job Application Letter</a>
                                   </div>
                                   <br>
                                   <br>
                                   <br>


                                   <div class="col-md-12">
                                       <a style="padding: 5px" href="{{url('employee/download/appointment/letter'.'/'.$employee_profile->emp_id)}}" class="btn-success"><i class="fa fa-download"></i> Appointment letter</a>
                                   </div>
                                   <br>
                                   <br>
                                   <br>


                                   <div class="col-md-12">
                                       <a style="padding: 5px" href="{{url('employee/download/resignation/letter'.'/'.$employee_profile->emp_id)}}" class="btn-dark"><i class="fa fa-download"></i> Resignation Letter</a>
                                   </div>
                                   <br>
                                   <br>
                                   <br>

                               </div>
                               <!-- download -->
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
        $('#date_of_birth').datetimepicker({
            format: 'L',
            minDate: new Date()
        });
        $('#joining_date').datetimepicker({
            todayBtn: "linked",
            language: "it",
            autoclose: true,
            todayHighlight: true,
            dateFormat: 'dd/mm/yyyy',
            pickTime: false
        });
        $('#date_off_discontinue').datetimepicker({
            format: 'L',
            minDate: new Date()
        });
        $("#branch").select2();
        $("#department").select2();
        $("#designation").select2();
        $("#shift").select2();

        $('a[data-toggle="tab"]').on('show.bs.tab', function(e) {
            localStorage.setItem('activeTab', $(e.target).attr('href'));
        });
        var activeTab = localStorage.getItem('activeTab');
        if(activeTab){
            $('#myTab a[href="' + activeTab + '"]').tab('show');
        }
    </script>
@endsection