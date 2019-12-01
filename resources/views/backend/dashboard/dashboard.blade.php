@extends('layout.master')
@section('title', 'Dashboard')
@section('extra_css')
<style type="text/css">
    .myAnimation .animated {
        -webkit-animation-duration: 4s !important;
        animation-duration: 4s !important;
        -webkit-animation-fill-mode: both;
        animation-fill-mode: both;
    }
   #tab-general .portlet {
        border: 1px solid #e5e5e5;
   }
    #footer{
        position: static;
    }
    #footer .copyright {
        width: 95%;
    }
</style>
@endsection
@section('content')
    <?php 
    
        function en2bnNumber($number){
            $search_array= array('0','1','2','3','4','5','6','7','8','9','Jan','Feb','Mar','Apr','May',
                'Jun','Jul','Aug','Sep','Oct','Nov','Dec');
            $replace_array= array('০','১','২','৩','৪','৫','৬','৭','৮','৯','জানুয়ারী','ফেব্রুয়ারী','মার্চ',
                'এপ্রিল','মে','জুন','জুলাই','অগাস্ট','সেপ্টেম্বর','অক্টোবর','নভেম্বর','ডিসেম্বর');
            $output = str_replace($search_array, $replace_array, $number);
            return $output;
        }
    ?>
    <!--BEGIN TITLE & BREADCRUMB PAGE-->
    <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
        <div class="page-header pull-left">
            <div class="page-title"><?php if(Lang::has('dashboard.dashboard')){ echo Lang::get('dashboard.dashboard'); }else{ echo "Dashboard"; } ?></div>
        </div>
        <ol class="breadcrumb page-breadcrumb pull-right">
            <li><i class="fa fa-home"></i>&nbsp;<a href="{{url('/')}}"><?php if(Lang::has('dashboard.home')){ echo Lang::get('dashboard.home'); }else{ echo "Home"; } ?></a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
            <li class="hidden"><a href="#"><?php if(Lang::has('dashboard.dashboard')){ echo Lang::get('dashboard.dashboard'); }else{ echo "Dashboard"; } ?></a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
            <li class="active"><?php if(Lang::has('dashboard.dashboard')){ echo Lang::get('dashboard.dashboard'); }else{ echo "Dashboard"; } ?></li>
        </ol>
        <div class="clearfix"></div>
    </div>
    <!--END TITLE & BREADCRUMB PAGE-->
    <div class="page-content">
        <div id="tab-general">
            <div id="sum_box" class="row mbl myAnimation">
                <a target="_BLANK" href="{{route('dashboard.employee_list', base64_encode('all_employee_list'))}}">
                    <div class="col-sm-6 col-md-3  animated bounceInUp">
                        <div class="panel db mbm my_panel my_panel_1">
                            <div class="panel-body ">
                                <div class="col-sm-4 col-xs-4">
                                    <div class="icon_body">
                                        <i class="my_icon fa fa-users"></i>
                                    </div>

                                </div>
                                <div class="col-sm-8 col-xs-8">
                                    <div class="my_panel_right">
                                            @if (Lang::locale()=='bn') 
                                              <h5>{{en2bnNumber(sprintf('%03d',$dashboard['all_employee_list']))}}</h5>
                                          
                                             @else 
                                                 <h5>{{sprintf('%03d',$dashboard['all_employee_list'])}}</h5>
                                            @endif
                                       
                                        <p><?php if(Lang::has('dashboard.employee')){ echo Lang::get('dashboard.employee'); }else{ echo "Employee"; } ?></p>
                                     
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>
                </a>

                <a target="_BLANK" href="{{route('dashboard.employee_list', base64_encode('active_employee_list'))}}">
                    <div class="col-sm-6 col-md-3 animated bounceInDown">
                        <div class="panel db mbm my_panel my_panel_3">
                            <div class="panel-body ">
                                <div class="col-sm-4 col-xs-4">
                                    <div class="icon_body">
                                        <i class="my_icon fa fa-check-circle-o"></i>
                                    </div>

                                </div>
                                <div class="col-sm-8 col-xs-8">
                                    <div class="my_panel_right">
                                            @if (Lang::locale()=='bn') 
                                             <h5>{{en2bnNumber(sprintf('%03d',$dashboard['active_employee_list']))}}</h5>
                                          
                                             @else 
                                                <h5>{{sprintf('%03d',$dashboard['active_employee_list'])}}</h5>
                                            @endif
                                       
                                        <p><?php if(Lang::has('dashboard.active_employee')){ echo Lang::get('dashboard.active_employee'); }else{ echo "Active Employee"; } ?></p>
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>
                </a>

                <a target="_BLANK" href="{{route('dashboard.employee_list', base64_encode('inactive_employee_list'))}}">
                    <div class="col-sm-6 col-md-3 animated bounceInDown">
                        <div class="panel db mbm my_panel my_panel_11">
                            <div class="panel-body ">
                                <div class="col-sm-4 col-xs-4">
                                    <div class="icon_body">
                                        <i class="my_icon fa fa-times-circle-o"></i>
                                    </div>

                                </div>
                                <div class="col-sm-8 col-xs-8">
                                    <div class="my_panel_right">
                                         @if (Lang::locale()=='bn') 
                                           <h5>{{en2bnNumber(sprintf('%03d',$dashboard['inactive_employee_list']))}}</h5>
                                        
                                            @else 
                                                 <h5>{{sprintf('%03d',$dashboard['inactive_employee_list'])}}</h5>
                                        @endif
                                        <p><?php if(Lang::has('dashboard.inactive_employee')){ echo Lang::get('dashboard.inactive_employee'); }else{ echo "Inactive Employee"; } ?></p>
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>
                </a>

                <a target="_BLANK" href="{{route('dashboard.employee_list', base64_encode('active_male_employee_list'))}}">
                    <div class="col-sm-6 col-md-3 animated bounceInUp">
                        <div class="panel  db mbm my_panel my_panel_4">
                            <div class="panel-body ">
                                <div class="col-sm-4 col-xs-4">
                                    <div class="icon_body">
                                        <i class="my_icon fa fa-male"></i>
                                    </div>

                                </div>
                                <div class="col-sm-8 col-xs-8">
                                    <div class="my_panel_right">
                                         @if (Lang::locale()=='bn') 
                                            <h5>{{en2bnNumber(sprintf('%03d',$dashboard['active_male_employee_list']))}}</h5>
                                        
                                            @else 
                                                <h5>{{sprintf('%03d',$dashboard['active_male_employee_list'])}}</h5>
                                        @endif
                                       
                                        <p><?php if(Lang::has('dashboard.male_employee')){ echo Lang::get('dashboard.male_employee'); }else{ echo "Male Employee"; } ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>

                <a target="_BLANK" href="{{route('dashboard.employee_list', base64_encode('active_female_employee_list'))}}">
                    <div class="col-sm-6 col-md-3 animated bounceInLeft">
                        <div class="panel  db mbm my_panel my_panel_16">
                            <div class="panel-body ">
                                <div class="col-sm-4 col-xs-4">
                                    <div class="icon_body">
                                        <i class="my_icon fa fa-female"></i>
                                    </div>

                                </div>
                                <div class="col-sm-8 col-xs-8">
                                    <div class="my_panel_right">
                                        @if (Lang::locale()=='bn') 
                                           <h5>{{en2bnNumber(sprintf('%03d',$dashboard['active_female_employee_list']))}}</h5>
                                        
                                            @else 
                                               <h5>{{sprintf('%03d',$dashboard['active_female_employee_list'])}}</h5>
                                        @endif
                                        
                                        <p><?php if(Lang::has('dashboard.female_employee')){ echo Lang::get('dashboard.female_employee'); }else{ echo "Female Employee"; } ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>

                <a target="_BLANK" href="{{route('favourites_list')}}">
                    <div class="col-sm-6 col-md-3 animated bounceIn">
                        <div class="panel  db mbm my_panel my_panel_6">
                            <div class="panel-body ">
                                <div class="col-sm-4 col-xs-4">
                                    <div class="icon_body">
                                        <i class="my_icon fa fa-heart"></i>
                                    </div>

                                </div>
                                <div class="col-sm-8 col-xs-8">
                                    <div class="my_panel_right">
                                        @if (Lang::locale()=='bn') 
                                            <h5>{{en2bnNumber(sprintf('%03d',$dashboard['favourites_employee']))}}</h5>
                                        
                                            @else 
                                                <h5>{{sprintf('%03d',$dashboard['favourites_employee'])}}</h5>
                                        @endif
                                       
                                        <p><?php if(Lang::has('dashboard.favourite_employee')){ echo Lang::get('dashboard.favourite_employee'); }else{ echo "Favourite Employee"; } ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
                <a target="_BLANK" href="{{route('group_list')}}">
                    <div class="col-sm-6 col-md-3 animated bounceIn">
                        <div class="panel db mbm my_panel my_panel_7">
                            <div class="panel-body ">
                                <div class="col-sm-4 col-xs-4">
                                    <div class="icon_body">
                                        <i class="my_icon fa fa-th-large"></i>
                                    </div>

                                </div>
                                <div class="col-sm-8 col-xs-8">
                                    <div class="my_panel_right">
                                        @if (Lang::locale()=='bn') 
                                            <h5>{{en2bnNumber(sprintf('%03d',$dashboard['employee_group']))}}</h5>
                                        
                                            @else 
                                                <h5>{{sprintf('%03d',$dashboard['employee_group'])}}</h5>
                                        @endif
                                        
                                        <p><?php if(Lang::has('dashboard.employee_group')){ echo Lang::get('dashboard.employee_group'); }else{ echo "Employee Group"; } ?></p>
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>
                </a>

                <a target="_BLANK" href="{{route('branch_list')}}">
                    <div class="col-sm-6 col-md-3 animated bounceInRight">
                        <div class="panel  db mbm my_panel my_panel_8">
                            <div class="panel-body ">
                                <div class="col-sm-4 col-xs-4">
                                    <div class="icon_body">
                                        <i class="my_icon fa fa-share-alt"></i>
                                    </div>

                                </div>
                                <div class="col-sm-8 col-xs-8">
                                    <div class="my_panel_right">
                                         @if (Lang::locale()=='bn') 
                                             <h5>{{en2bnNumber(sprintf('%03d',$dashboard['branch']))}}</h5>
                                        
                                            @else 
                                                 <h5>{{sprintf('%03d',$dashboard['branch'])}}</h5>
                                        @endif
                                       
                                        <p><?php if(Lang::has('dashboard.branch')){ echo Lang::get('dashboard.branch'); }else{ echo "Branch"; } ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>

                <a target="_BLANK" href="{{route('designations_list')}}">
                    <div class="col-sm-6 col-md-3 animated bounceInLeft">
                        <div class="panel  db mbm my_panel my_panel_9">
                            <div class="panel-body ">
                                <div class="col-sm-4 col-xs-4">
                                    <div class="icon_body">
                                        <i class="my_icon fa fa-list-ul"></i>
                                    </div>

                                </div>
                                <div class="col-sm-8 col-xs-8">
                                    <div class="my_panel_right">
                                        @if (Lang::locale()=='bn') 
                                             <h5>{{en2bnNumber(sprintf('%03d',$dashboard['designations']))}}</h5>
                                        
                                            @else 
                                                 <h5>{{sprintf('%03d',$dashboard['designations'])}}</h5>
                                        @endif
                                        
                                        <p><?php if(Lang::has('dashboard.designation')){ echo Lang::get('dashboard.designation'); }else{ echo "Designation"; } ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>

                <a target="_BLANK" href="{{route('department_list')}}">
                    <div class="col-sm-6 col-md-3 animated bounceIn">
                        <div class="panel  db mbm my_panel my_panel_10">
                            <div class="panel-body ">
                                <div class="col-sm-4 col-xs-4">
                                    <div class="icon_body">
                                        <i class="my_icon fa fa-joomla"></i>
                                    </div>

                                </div>
                                <div class="col-sm-8 col-xs-8">
                                    <div class="my_panel_right">
                                          @if (Lang::locale()=='bn') 
                                              <h5>{{en2bnNumber(sprintf('%03d',$dashboard['departments']))}}</h5>
                                        
                                            @else 
                                                  <h5>{{sprintf('%03d',$dashboard['departments'])}}</h5>
                                        @endif
                                       
                                        <p><?php if(Lang::has('dashboard.department')){ echo Lang::get('dashboard.department'); }else{ echo "Department"; } ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>

                <a target="_BLANK" href="{{route('clients_list')}}">
                    <div class="col-sm-6 col-md-3 animated bounceIn">
                        <div class="panel  db mbm my_panel my_panel_2">
                            <div class="panel-body ">
                                <div class="col-sm-4 col-xs-4">
                                    <div class="icon_body">
                                        <i class="my_icon fa fa-crosshairs"></i>
                                    </div>

                                </div>
                                <div class="col-sm-8 col-xs-8">
                                    <div class="my_panel_right">
                                       
                                          @if (Lang::locale()=='bn') 
                                               <h5>{{en2bnNumber(sprintf('%03d',$dashboard['clients']))}}</h5>
                                        
                                            @else 
                                                   <h5>{{sprintf('%03d',$dashboard['clients'])}}</h5>
                                        @endif
                                        <p><?php if(Lang::has('dashboard.clients')){ echo Lang::get('dashboard.clients'); }else{ echo "Clients"; } ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>

                <a target="_BLANK" href="{{route('project_list')}}">
                    <div class="col-sm-6 col-md-3 animated bounceInRight">
                        <div class="panel  db mbm my_panel my_panel_13">
                            <div class="panel-body ">
                                <div class="col-sm-4 col-xs-4">
                                    <div class="icon_body">
                                        <i class="my_icon fa fa-briefcase"></i>
                                    </div>

                                </div>
                                <div class="col-sm-8 col-xs-8">
                                    <div class="my_panel_right">
                                         @if (Lang::locale()=='bn') 
                                         <h5>{{en2bnNumber(sprintf('%03d',$dashboard['projects']))}}</h5>
                                            @else 
                                                   <h5>{{sprintf('%03d',$dashboard['projects'])}}</h5>
                                        @endif
                                       
                                        
                                        <p><?php if(Lang::has('dashboard.project')){ echo Lang::get('dashboard.project'); }else{ echo "Project"; } ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>

                <a target="_BLANK" href="{{route('training_view')}}">
                    <div class="col-sm-6 col-md-3 animated bounceInDown">
                        <div class="panel  db mbm my_panel my_panel_12">
                            <div class="panel-body ">
                                <div class="col-sm-4 col-xs-4">
                                    <div class="icon_body">
                                        <i class="my_icon fa fa-bullhorn"></i>
                                    </div>

                                </div>
                                <div class="col-sm-8 col-xs-8">
                                    <div class="my_panel_right">
                                          @if (Lang::locale()=='bn') 
                                         <h5>{{en2bnNumber(sprintf('%03d',$dashboard['training']))}}</h5>
                                            @else 
                                            <h5>{{sprintf('%03d',$dashboard['training'])}}</h5>
                                        @endif
                                        
                                        <p><?php if(Lang::has('dashboard.training')){ echo Lang::get('dashboard.training'); }else{ echo "Training"; } ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>

                <a target="_BLANK" href="{{route('shift_list')}}">
                    <div class="col-sm-6 col-md-3 animated bounceInUp">
                        <div class="panel  db mbm my_panel my_panel_14">
                            <div class="panel-body ">
                                <div class="col-sm-4 col-xs-4">
                                    <div class="icon_body">
                                        <i class="my_icon fa fa-chain"></i>
                                    </div>

                                </div>
                                <div class="col-sm-8 col-xs-8">
                                    <div class="my_panel_right">
                                           @if (Lang::locale()=='bn') 
                                         <h5>{{en2bnNumber(sprintf('%03d',$dashboard['shift']))}}</h5>
                                            @else 
                                            <h5>{{sprintf('%03d',$dashboard['shift'])}}</h5>
                                        @endif
                                        
                                        <p><?php if(Lang::has('dashboard.working_shift')){ echo Lang::get('dashboard.working_shift'); }else{ echo "Working Shift"; } ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
                
                <div class="col-sm-6 col-md-3  animated bounceInUp">
                    <div class="panel  db mbm my_panel my_panel_15">
                        <div class="panel-body ">
                            <div class="col-sm-4 col-xs-4">
                                <div class="icon_body">
                                    <i class="my_icon fa fa-calendar"></i>
                                </div>

                            </div>
                            <div class="col-sm-8 col-xs-8">
                                <div class="my_panel_right">
                                     @if (Lang::locale()=='bn') 
                                         <h5>{{en2bnNumber(sprintf('%03d',$dashboard['today_attendance']))}}</h5>
                                            @else 
                                            <h5>{{sprintf('%03d',$dashboard['today_attendance'])}}</h5>
                                        @endif
                                    
                                    <p><?php if(Lang::has('dashboard.today_attendance')){ echo Lang::get('dashboard.today_attendance'); }else{ echo "Today Attendance"; } ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <a target="_BLANK" href="{{route('meeting_list')}}">
                    <div class="col-sm-6 col-md-3 animated bounceInDown">
                        <div class="panel  db mbm my_panel my_panel_5">
                            <div class="panel-body ">
                                <div class="col-sm-4 col-xs-4">
                                    <div class="icon_body">
                                        <i class="my_icon fa fa-clock-o"></i>
                                    </div>

                                </div>
                                <div class="col-sm-8 col-xs-8">
                                    <div class="my_panel_right">
                                        @if (Lang::locale()=='bn') 
                                         <h5>{{en2bnNumber(sprintf('%03d',$dashboard['meeting']))}}</h5>
                                            @else 
                                             <h5>{{sprintf('%03d',$dashboard['meeting'])}}</h5>
                                        @endif
                                       
                                        <p><?php if(Lang::has('dashboard.upcoming_meetings')){ echo Lang::get('dashboard.upcoming_meetings'); }else{ echo "Upcoming Meetings"; } ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>


            </div>




            <div class="row mbl myAnimation">
                <div class="col-lg-3 animated bounceInLeft">
                    <div class="portlet box">
                        <div class="portlet-body">
                            <canvas id="activeInactiveEmployeeRatio" width="250px" height="295px"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 animated bounceInLeft">
                    <div class="portlet box">
                        <div class="portlet-body">
                            <canvas id="maleFemaleRatio" width="270px" height="320px"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 animated bounceInRight">
                    <div class="portlet box">
                        <div class="portlet-body">
                            <canvas id="presentStatistic" height="250px;"></canvas>
                        </div>
                    </div>
                </div>
            </div>

        </div>


        <div class="row mbl myAnimation">
            
            <div class="col-md-4 ">
                <div class="table-warper-body">
                    <div class="table-heading-part bg_style_8">
                        <h5><a href="#" class="dash_a"><i class="fa fa-users"></i> <strong><?php if(Lang::has('dashboard.new_employee_list')){ echo Lang::get('dashboard.new_employee_list'); }else{ echo "New Employee List"; } ?></strong></a></h5>
                    </div>

                    <div class="scroll-body scroll_body_employee">
                        <table class="table table-hover table-striped table-border">
                            <tbody>
                                @forelse($newEmployeeList as $nel)
                                    <tr>
                                        <td>
                                        <a target="_BLANK" href="{{route('employee.profile', base64_encode($nel->id))}}">
                                            <b class="">{{$nel->emp_first_name}} {{$nel->emp_lastName}} ({{$nel->employeeId}} )</b>
                                            <br>
                                            <span class="">Joining Date: <b>{{date('d-M-Y', strtotime($nel->emp_joining_date))}}</b></span>,
                                            <span class="">Branch : <b>{{$nel->branch_name}}</b></span><br />
                                            <span class="">Department: <b>{{$nel->department_name}}</b></span>,
                                            <span class="">Designation: <b>{{$nel->designation_name}}</b></span>
                                        </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td>No employee found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>

            <div class="col-md-4 ">
                <div class="table-warper-body">
                    <div class="table-heading-part bg_style_2">
                        <h5><a href="#" class="dash_a"><i class="fa fa-clock-o"></i> <strong><?php if(Lang::has('dashboard.today_late_employee_list')){ echo Lang::get('dashboard.today_late_employee_list'); }else{ echo "Today's Late Employee List"; } ?></strong></a></h5>
                    </div>

                    <div class="scroll-body scroll_body_employee">
                        <table class="table table-hover table-striped table-border">
                            <tbody>
                                @forelse($lateEmployeeList as $nel)
                                    <tr>
                                        <td>
                                        <a target="_BLANK" href="{{route('employee.profile', base64_encode($nel->id))}}">
                                            <b class="">{{$nel->emp_first_name}} {{$nel->emp_lastName}} ({{$nel->employeeId}} )</b>
                                            <br>
                                            <span class="">Joining Date: <b>{{date('d-M-Y', strtotime($nel->emp_joining_date))}}</b></span>,
                                            <span class="">Branch : <b>{{$nel->branch_name}}</b></span><br />
{{--                                            <span class="">Department: <b>{{$nel->department_name}}</b></span>,--}}
{{--                                            <span class="">Designation: <b>{{$nel->designation_name}}</b></span>--}}
                                            <span class="">Entry Time: <b>{{\Carbon\Carbon::parse($nel->in_time)->format('h:m A')}}</b></span>
                                        </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td>No employee found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>

            <div class="col-md-4 ">
                <div class="table-warper-body">
                    <div class="table-heading-part bg_style_3">
                        <h5><a href="#" class="dash_a"><i class="fa fa-times-circle-o"></i> <strong><?php if(Lang::has('dashboard.upcoming_notice_and_announcement')){ echo Lang::get('dashboard.upcoming_notice_and_announcement'); }else{ echo "Upcoming Notice And Announcement"; } ?></strong></a></h5>
                    </div>

                    <div class="scroll-body scroll_body_employee">
                        <table class="table table-hover table-striped table-border">
                            <tbody>
                                @forelse($upcomingNotice as $nel)
                                    <tr>
                                        <td>
                                        <a href="#">
                                            <span class="">{{$nel->description}}</span>
                                            <br>
                                            <span class="">End Date : <b>{{date('d-M-Y', strtotime($nel->end_date))}}</b></span><br/>
                                        </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td>No employee found.</td>
                                    </tr>
                                @endforelse

                            </tbody>
                        </table>

                    </div>
                </div>
            </div>

            <div class="col-md-12"><hr></div>

            <div class="col-md-4 ">
                <div class="table-warper-body">
                    <div class="table-heading-part bg_style_4">

                        <h5><a href="#" class="dash_a"><i class="fa fa-bullhorn"></i> <strong><?php if(Lang::has('dashboard.today_Onleave_employee_list')){ echo Lang::get('dashboard.today_Onleave_employee_list'); }else{ echo "Today's Onleave Employee List"; } ?></strong></a></h5>

                    </div>

                    <div class="scroll-body scroll_body_employee">
                        <table class="table table-hover table-striped table-border">
                            <tbody>
                                @forelse($leaveEmployeeList as $nel)
                                    <tr>
                                        <td>
                                        <a target="_BLANK" href="{{route('employee.profile', base64_encode($nel->id))}}">
                                            <b class="">{{$nel->emp_first_name}} {{$nel->emp_lastName}} ({{$nel->employeeId}} )</b>
                                            <br>
                                            <span class="">Joining Date: <b>{{date('d-M-Y', strtotime($nel->emp_joining_date))}}</b></span>,
                                            <span class="">Branch : <b>{{$nel->branch_name}}</b></span><br />
                                            <span class="">Department: <b>{{$nel->department_name}}</b></span>,
                                            <span class="">Designation: <b>{{$nel->designation_name}}</b></span>
                                        </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td>No employee found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>

            <div class="col-md-4 ">
                <div class="table-warper-body">
                    <div class="table-heading-part bg_style_5">
                        <h5><a target="_blank" href="{{route('leave_status')}}" class="dash_a"><i class="fa fa-codepen" aria-hidden="true" style="margin-right:7px;"></i><strong><?php if(Lang::has('dashboard.pending_leave_request')){ echo Lang::get('dashboard.pending_leave_request'); }else{ echo "Pending Leave Request"; } ?></strong></a></h5>
                    </div>

                    <div class="scroll-body scroll_body_employee">
                        <table class="table table-hover table-striped table-border">
                            <tbody>
                                @forelse($pendingEmployeeList as $nel)
                                    <tr>
                                        <td>
                                        <a href="#">
                                            <b class="">{{$nel->emp_first_name}} {{$nel->emp_lastName}} ({{$nel->employeeId}} )</b>
                                            <br>
                                            <span class="">Joining Date: <b>{{date('d-M-Y', strtotime($nel->emp_joining_date))}}</b></span>,
                                            <span class="">Branch : <b>{{$nel->branch_name}}</b></span><br />
                                            <span class="">Start Date: <b>{{\Carbon\Carbon::parse($nel->leave_starting_date)->format('d M Y')}}</b></span>,
                                            <span class="">End Date: <b>{{\Carbon\Carbon::parse($nel->leave_ending_date)->format('d M Y')}}</b></span>
                                        </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td>No employee found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>

            <div class="col-md-4 ">
                <div class="table-warper-body">
                    <div class="table-heading-part bg_style_6">
                        <h5><a href="#" class="dash_a"><i class="fa fa-users"></i> <strong><?php if(Lang::has('dashboard.today_expense_list')){ echo Lang::get('dashboard.today_expense_list'); }else{ echo "Today's Expense List"; } ?></strong></a></h5>
                    </div>

                    <div class="scroll-body scroll_body_employee">
                        <table class="table table-hover table-striped table-border">
                            <tbody>
                                @forelse($expenseList as $nel)
                                    <tr>
                                        <td>
                                        <a href="#">
                                            <b class="">{{$nel->emp_first_name}} {{$nel->emp_lastName}} ({{$nel->employeeId}} )</b>
                                            <br>
                                            <span class="">Expense Amount: <b>{{$nel->amount}}</b></span>,
                                            <span class="">Category : <b>{{$nel->category_name}}</b></span><br />
                                            <span class="">Date: <b>{{$nel->expanse_date}}</b></span>
                                            <span class="">Status:
                                                @if($nel->status==0)
                                                <b class="red-text">Pending</b>
                                                @else
                                                <b>Approved</b>
                                                @endif
                                            </span>

                                        </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td>No record found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection
@section('extra_js')
{{ Html::script('corporate/js/Chart.js') }}
<script>
     var ctx1 = document.getElementById("activeInactiveEmployeeRatio").getContext('2d');
     var myChart1 = new Chart(ctx1, {
         type: 'doughnut',
         data: {
             labels: ["Active Employee", "Inactive Employee"],
                      legend: {
                          labels: {
                              fontColor: "white",
                              fontSize: 18
                          }
                    },
             datasets: [{
                 label: '# ',
                 data: [{{$dashboard['active_employee_list']}},{{$dashboard['inactive_employee_list']}} ],
                 backgroundColor: [
                     'rgba(0,204,0,0.7)',
                     'rgba(233,30,99, 0.7)'
                 ],
                 borderColor: [
                     'rgba(1,1,1,0.1)',
                     'rgba(1,1,1,0.1)'

                 ],
                 borderWidth: 1
              }]
         },
         options: {
         }
     });


     var ctx2 = document.getElementById("maleFemaleRatio").getContext('2d');
     var myChart2 = new Chart(ctx2, {
         type: 'doughnut',
         data: {
             labels: ["Male", "Female", "Others"],
                      legend: {
                          labels: {
                              fontColor: "white",
                              fontSize: 18
                          }
                    },
             datasets: [{
                 label: '# ',
                 data: [{{$dashboard['active_male_employee_list']}}, {{$dashboard['active_female_employee_list']}}, {{$dashboard['active_employee_list']-($dashboard['active_male_employee_list']+$dashboard['active_female_employee_list'])}}],
                 backgroundColor: [
                     'rgba(79, 132, 209, 0.7)',
                     'rgba(233,30,99, 0.7)',
                     'rgba(213,0,249, 0.7)'
                 ],
                 borderColor: [
                     'rgba(1,1,1,0.1)',
                     'rgba(1,1,1,0.1)',
                     'rgba(1,1,1,0.1)'

                 ],
                 borderWidth: 1
              }]
         },
         options: {
         }
     });


     var ctx = document.getElementById("presentStatistic").getContext('2d');
     var myChart = new Chart(ctx, {
         type: 'line',
         data: {

             labels: [
                 "{{$presentData[0]['date']}}","{{$presentData[1]['date']}}","{{$presentData[2]['date']}}",
                 "{{$presentData[3]['date']}}","{{$presentData[4]['date']}}","{{$presentData[5]['date']}}",
                 "{{$presentData[6]['date']}}","{{$presentData[7]['date']}}","{{$presentData[8]['date']}}",
                 "{{$presentData[9]['date']}}","{{$presentData[10]['date']}}","{{$presentData[11]['date']}}",
                 "{{$presentData[12]['date']}}","{{$presentData[13]['date']}}","{{$presentData[14]['date']}}",
                 "{{$presentData[15]['date']}}","{{$presentData[16]['date']}}","{{$presentData[17]['date']}}",
                 "{{$presentData[18]['date']}}","{{$presentData[19]['date']}}","{{$presentData[20]['date']}}",
                 "{{$presentData[21]['date']}}","{{$presentData[22]['date']}}","{{$presentData[23]['date']}}",
                 "{{$presentData[24]['date']}}","{{$presentData[25]['date']}}","{{$presentData[26]['date']}}",
                 "{{$presentData[27]['date']}}","{{$presentData[28]['date']}}","{{$presentData[29]['date']}}"],
             datasets: [{
                 label: 'Present Statistic',
                 data: ["{{$presentData[0]['present']}}","{{$presentData[1]['present']}}","{{$presentData[2]['present']}}",
                     "{{$presentData[3]['present']}}","{{$presentData[4]['present']}}","{{$presentData[5]['present']}}",
                     "{{$presentData[6]['present']}}","{{$presentData[7]['present']}}","{{$presentData[8]['present']}}",
                     "{{$presentData[9]['present']}}","{{$presentData[10]['present']}}","{{$presentData[11]['present']}}",
                     "{{$presentData[12]['present']}}","{{$presentData[13]['present']}}","{{$presentData[14]['present']}}",
                     "{{$presentData[15]['present']}}","{{$presentData[16]['present']}}","{{$presentData[17]['present']}}",
                     "{{$presentData[18]['present']}}","{{$presentData[19]['present']}}","{{$presentData[20]['present']}}",
                     "{{$presentData[21]['present']}}","{{$presentData[22]['present']}}","{{$presentData[23]['present']}}",
                     "{{$presentData[24]['present']}}","{{$presentData[25]['present']}}","{{$presentData[26]['present']}}",
                     "{{$presentData[27]['present']}}","{{$presentData[28]['present']}}","{{$presentData[29]['present']}}",],
                 backgroundColor:
                    'rgba(0, 128, 0, 0.5)',
                borderColor:
                     'rgba(1 , 1, 1, 0.3)',
                 borderWidth: 1
             }]
         },
         options: {
            scales: {
                 yAxes: [{
                     ticks: {
                         beginAtZero:true
                     }
                 }]
             }

         }

     });


</script>
@endsection
