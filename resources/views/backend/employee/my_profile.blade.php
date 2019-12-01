@extends('layout.master')
@section('title', 'My Profile')


<style>
    .panel.panel-blue.my_profile_panel{
        border:2px solid #cbcfd6!important;
        margin-top: 50px;
    }
    .my_profile_panel{
        border: 2px solid #bdbec1;

    }
    .my_profile_body{}
    .my_profile_panel_body{

        padding-top: 0px!important;
        padding-bottom: 40px!important;

    }
    .my_profile_img{

    }
    .image_part{
        width: 105px;
        margin: 0 auto;
        position: relative;
        top: -50px;
        border: 5px solid #172134;
        border-radius: 50%;
    }
    .my_profile_details {
        padding-left: 40px;
    }
    .my_profile_details .p_left{
        width:30%;
        display: inline-block;
    }
    .my_profile_details .p_right{
        width:60%;

    }
    .image_part img{
        top:-40px;
        padding: 3px;
        z-index: 999;
    }
    .my_profile_password{
        float: right;
        margin-right: 50px;
        margin-top: 20px;
    }
    .my_profile_panel .panel-heading{
        height:50px;
    }

</style>


@section('content')
    <!--BEGIN TITLE & BREADCRUMB PAGE-->
    <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
        <div class="page-header pull-left">
            <div class="page-title">My Profile</div>
        </div>
        <ol class="breadcrumb page-breadcrumb pull-right">
            <li><i class="fa fa-home"></i>&nbsp;<a href="{{url('/')}}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>

            <li class="active">My Profile</li>
        </ol>
        <div class="clearfix"></div>
    </div>
    <!--END TITLE & BREADCRUMB PAGE-->
    <div class="page-content">
        @if ($errors->any())
            <div id="alert_message" class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @if(Session::has('success'))
            <p id="alert_message" class="alert alert-success">{{ Session::get('success') }}</p>
        @endif
        @if(Session::has('error'))
            <p id="alert_message" class="alert alert-error">{{ Session::get('error') }}</p>
        @endif
        @if(Session::has('delete'))
            <p id="alert_message" class="alert alert-danger">{{ Session::get('delete') }}</p>
        @endif

        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-blue my_profile_panel">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-md-6">
                            </div>
                            <div class="col-md-6" style="text-align: right;">
                            </div>
                        </div>
                    </div>
                    <div class="panel-body my_profile_panel_body" >
                        <div class="row">
                            <div class="col-md-12 " style="margin:0 auto;">
                                <div class="my_profile_body">
                                    <div class="row my_profile_img">
                                        <div class="col-md-12">
                                            <div class="image_part">
                                                <img class="img-responsive img-circle" src="{{asset('employee_image/profile_image.jpg')}}" alt="">
                                            </div>
                                        </div>

                                    </div>
                                    <div class="row my_profile_details">
                                        <?php if(auth()->user()->hasRole(['admin','super-admin'])) { ?>
                                             <div class="col-md-6">
                                                <p> <span class="p_left">Name</span> <span class="p_right">: {{$user->name}}</span> </p>
                                            </div>
                                            <div class="col-md-6">
                                                <p> <span class="p_left">Email</span> <span class="p_right">: {{$user->email}}</span> </p>
                                            </div>
                                        <?php }else{ ?>
                                            <div class="col-md-6">
                                                <p> <span class="p_left">Fullname</span> <span class="p_right">: {{$user->emp_first_name}} {{$user->emp_lastName}}</span> </p>
                                            </div>
                                            <div class="col-md-6">
                                                <p> <span class="p_left">Employee ID</span> <span class="p_right">: {{$user->employeeId}}</span> </p>
                                            </div>
                                            <div class="col-md-6">
                                                <p> <span class="p_left">Email</span> <span class="p_right">: {{$user->emp_email}}</span> </p>
                                            </div>
                                            <div class="col-md-6">
                                                <p> <span class="p_left">Branch</span> <span class="p_right">: {{$user->branch_name}}</span> </p>
                                            </div>
                                            <div class="col-md-6">
                                                <p> <span class="p_left">Department</span> <span class="p_right">: {{$user->department_name}}</span> </p>
                                            </div>
                                            <div class="col-md-6">
                                                <p> <span class="p_left">Designation</span> <span class="p_right">: {{$user->designation_name}}</span> </p>
                                            </div>
                                            <div class="col-md-6">
                                                <p> <span class="p_left">Joining Date</span> <span class="p_right">: {{date('d-m-Y', strtotime($user->emp_joining_date))}}</span> </p>
                                            </div>
                                            <div class="col-md-6">
                                                <p> <span class="p_left">National ID</span> <span class="p_right">: {{$user->emp_nid}}</span> </p>
                                            </div>
                                            <div class="col-md-6">
                                                <p> <span class="p_left">Current Address</span> <span class="p_right">: {{$user->emp_current_address}}</span> </p>
                                            </div>
                                            <div class="col-md-6">
                                                <p> <span class="p_left">Employee Status</span> <span class="p_right">: 
                                                   @if($user->emp_account_status==1)
                                                       <span class="text-success">Active</span>
                                                   @else
                                                       <span class="text-danger">Inactive</span>
                                                   @endif &nbsp;</span> 
                                               </p>
                                            </div>
                                        <?php } ?>
                                        <div class="col-md-12">
                                            <hr>
                                           <center> 
                                            @if(auth()->user()->hasRole(['branch-manager','employee']))
                                                <a href="{{url('employee/panel/profile')}}" class="btn btn-warning btn-square btn-sm" > <i class="fa fa-plus"></i> Go to details</a>
                                            @endif
                                            <a href="" class="add-new-modal btn btn-success btn-square btn-sm" data-toggle="modal" data-target="#passwordUpdate"> <i class="fa fa-plus"></i> Update Password</a></center>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>

                        </div>
                    </div>
            </div>
        </div>
    </div>

        <div id="passwordUpdate" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title"> <i class="fa fa-key"></i> Update Password</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">

                            {!! Form::open(['method'=>'POST','route'=>'employee.update_password']) !!}
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="department_name">Previous Password <span style="color:red">*</span> </label>
                                    {!! Form::password('previous_password',['class' => 'form-control', 'required'=>'true', 'auto-complete'=>'off','placeholder'=>'Previous Password']) !!}

                                </div>
                                <div class="form-group">
                                    <label for="department_name">New Password <span style="color:red">*</span> </label>
                                    <input type="password" class="form-control" id="new_password" minlength="6" name="new_password"  autocomplete="off" placeholder="New Password" required>
                                </div>
                                <div class="form-group">
                                    <label for="department_name">Confirm Password <span style="color:red">*</span> </label>
                                    <input type="password" class="form-control" id="confirm_password" name="confirm_password"  autocomplete="off" placeholder="Confirm Password" required>
                                </div>
                                <div class="form-group">
                                    <button id="add_vendor_btn" type="Submit" class="btn btn-primary"><i class="fa fa-save"></i> Update Password</button>
                                </div>
                                <input type="hidden" name="emp_id" value="1">
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection

@section('extra_js')
    <script>

    </script>
@endsection
