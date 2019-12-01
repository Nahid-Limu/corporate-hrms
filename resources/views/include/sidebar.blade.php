<?php
$url=request()->route()->getName();
?>
<nav id="sidebar" role="navigation" data-step="2" data-intro="Template has &lt;b&gt;many navigation styles&lt;/b&gt;" data-position="right" class="navbar-default navbar-static-side ">
    <div class="sidebar-collapse menu-scroll">
        <ul id="side-menu" class="nav">
            <li class="user-panel">
                <div class="thumb"><img src="{{asset('images/profile_2.png')}}" alt="" class="img-circle"/></div>
                <div class="info"><p style="">{{auth()->user()->name}}</p>
                </div>
                <div class="clearfix"></div>
            </li>
            <li  @if($url === 'dashboard') class="active" @endif><a href="{{route('dashboard')}}"><i class="fa fa-tachometer fa-fw">
                        <div class="icon-bg bg-orange"></div>
                    </i><span class="menu-title"><?php if(Lang::has('sidebar.dashboard')){ echo Lang::get('sidebar.dashboard'); }else{ echo "Dashboard"; } ?></span></a></li>


             @permission('manage_employee')
            <li @if($url === 'employee_list' || $url === 'employee_create' || $url === 'group_employee_list' || $url==='group_list' || $url==='favourites_list' || $url === 'employee_assets_list' || $url==='employee.profile') class="active" @endif><a href="#"><i class="fa fa-users">
                        <div class="icon-bg bg-violet"></div>
                    </i><span class="menu-title"><?php if(Lang::has('sidebar.manage_employee')){ echo Lang::get('sidebar.manage_employee'); }else{ echo "Manage Employee"; } ?></span><span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <ul class="nav nav-third-level">
                        <li @if($url === 'employee_list') class="active" @endif><a href="{{route('employee_list')}}"><i class="fa fa-angle-double-right"></i><span class="submenu-title"><?php if(Lang::has('sidebar.employee_list')){ echo Lang::get('sidebar.employee_list'); }else{ echo "Employee List"; } ?></span></a></li>
                    </ul>
                    <ul class="nav nav-third-level">
                        <li @if($url === 'employee_create') class="active" @endif><a href="{{route('employee_create')}}"><i class="fa fa-angle-double-right"></i><span class="submenu-title"><?php if(Lang::has('sidebar.add_new_employee')){ echo Lang::get('sidebar.add_new_employee'); }else{ echo "Add New Employee"; } ?></span></a></li>
                    </ul>
                    <ul class="nav nav-third-level">
                        <li @if($url === 'group_employee_list' || $url==='group_list') class="active" @endif><a href="#"><i class="fa fa-angle-double-right"></i><span class="submenu-title"><?php if(Lang::has('sidebar.employee_group')){ echo Lang::get('sidebar.employee_group'); }else{ echo "Employee Group"; } ?></span><span class="fa arrow"></span></a>
                            <ul class="nav nav-third-level">
                                <li @if($url === 'group_employee_list') class="active" @endif><a href="{{route('group_employee_list')}}"><i class="fa fa-angle-double-right"></i><span class="submenu-title"><?php if(Lang::has('sidebar.employee_group_list')){ echo Lang::get('sidebar.employee_group_list'); }else{ echo "Employee Group List"; } ?></span></a></li>
                                <li @if($url === 'group_list') class="active" @endif><a href="{{route('group_list')}}"><i class="fa fa-angle-double-right"></i><span class="submenu-title"><?php if(Lang::has('sidebar.group_list')){ echo Lang::get('sidebar.group_list'); }else{ echo "Group List"; } ?></span></a></li>


                            </ul>
                        </li>
                    </ul>
                    <ul class="nav nav-third-level">
                        <li @if($url === 'employee_assets_list') class="active" @endif><a href="{{route('employee_assets_list')}}"><i class="fa fa-angle-double-right"></i><span class="submenu-title"><?php if(Lang::has('sidebar.employee_assets_list')){ echo Lang::get('sidebar.employee_assets_list'); }else{ echo "Employee Assets List"; } ?></span></a></li>
                    </ul>
                    <ul class="nav nav-third-level">
                        <li @if($url === 'favourites_list') class="active" @endif><a href="{{route('favourites_list')}}"><i class="fa fa-angle-double-right"></i><span class="submenu-title"><?php if(Lang::has('sidebar.employee_favourites_list')){ echo Lang::get('sidebar.employee_favourites_list'); }else{ echo "Favourites List"; } ?></span></a></li>
                    </ul>
                     <!-- <ul class="nav nav-third-level">
                        <li @if($url === 'employee/rating') class="active" @endif>
                            <a href="{{route('employee_rating')}}">
                                <i class="fa fa-angle-double-right"></i>
                                <span class="submenu-title">Rating</span>
                            </a>
                        </li>
                    </ul> -->
                </ul>
            </li>
            @endpermission


            @permission('manage_attendance')
            <li @if($url === 'attendance_file.create' || $url === 'attendance.index' || $url ==='attendance.manual_attendance'|| $url ==='attendance.delete_attendance'|| $url ==='attendance.create_attendance'|| $url ==='attendance.edit_attendance') class="active" @endif><a href="#"><i class="fa fa-empire">
                        <div class="icon-bg bg-violet"></div>
                    </i><span class="menu-title"><?php if(Lang::has('sidebar.manage_attendance')){ echo Lang::get('sidebar.manage_attendance'); }else{ echo "Manage Attendance"; } ?></span><span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <ul class="nav nav-third-level">
                        <li @if($url === 'attendance_file.create') class="active" @endif><a href="{{route('attendance_file.create')}}"><i class="fa fa-angle-double-right"></i><span class="submenu-title"><?php if(Lang::has('sidebar.upload_proccess')){ echo Lang::get('sidebar.upload_proccess'); }else{ echo "Upload & Process"; } ?></span></a></li>
                    </ul>
                    <ul class="nav nav-third-level">
                        <li @if($url === 'attendance.index') class="active" @endif><a href="{{route('attendance.index')}}"><i class="fa fa-angle-double-right"></i><span class="submenu-title"><?php if(Lang::has('sidebar.attendance_files')){ echo Lang::get('sidebar.attendance_files'); }else{ echo "Attendance Files"; } ?></span></a></li>
                    </ul>
                    <ul class="nav nav-third-level">
                        <li @if($url === 'attendance.manual_attendance') class="active" @endif><a href="{{route('attendance.manual_attendance')}}"><i class="fa fa-angle-double-right"></i><span class="submenu-title"><?php if(Lang::has('sidebar.manual_attendance')){ echo Lang::get('sidebar.manual_attendance'); }else{ echo "Manual Attendance"; } ?></span></a></li>
                    </ul>
                </ul>
            </li>
            @endpermission


            @permission('manage_task')
            <li @if($url === 'task_list' ||$url === 'assign_task_view' )  {{'in'}}  class="active" @endif><a href="#"><i class="fa fa-thumb-tack">
                        <div class="icon-bg bg-violet"></div>
                    </i><span class="menu-title"><?php if(Lang::has('sidebar.manage_task')){ echo Lang::get('sidebar.manage_task'); }else{ echo "Manage Task"; } ?></span><span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <ul class="nav nav-third-level">
                        <li @if($url === 'assign_task_view') class="active" @endif><a href="{{route('assign_task_view')}}"><i class="fa fa-angle-double-right"></i><span class="submenu-title"><?php if(Lang::has('sidebar.assign_task')){ echo Lang::get('sidebar.assign_task'); }else{ echo "Assign Task"; } ?></span></a></li>
                    </ul>
                    <ul class="nav nav-third-level">
                        <li @if($url === 'task_list') class="active" @endif><a href="{{route('task_list')}}"><i class="fa fa-angle-double-right"></i><span class="submenu-title"><?php if(Lang::has('sidebar.task_list')){ echo Lang::get('sidebar.task_list'); }else{ echo "Task List"; } ?></span></a></li>
                    </ul>
                    <ul class="nav nav-third-level">
                        <li @if($url === 'employee_task_list') class="active" @endif><a href="{{route('employee_task_list')}}"><i class="fa fa-angle-double-right"></i><span class="submenu-title"><?php if(Lang::has('sidebar.employee_task')){ echo Lang::get('sidebar.employee_task'); }else{ echo "Employee Task"; } ?></span></a></li>
                    </ul>
                </ul>
            </li>
            @endpermission


            @permission('manage_project')
            <li @if($url === 'clients_list' ||$url === 'project_list' ||$url === 'assign_project' )  {{'in'}}  class="active" @endif><a href="#"><i class="fa fa-tasks">
                        <div class="icon-bg bg-violet"></div>
                    </i><span class="menu-title"><?php if(Lang::has('sidebar.employee_task')){ echo Lang::get('sidebar.employee_task'); }else{ echo "Manage Project"; } ?></span><span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <ul class="nav nav-third-level">
                            <li @if($url === 'clients_list') class="active" @endif><a href="{{route('clients_list')}}"><i class="fa fa-angle-double-right"></i><span class="submenu-title"><?php if(Lang::has('sidebar.client_list')){ echo Lang::get('sidebar.client_list'); }else{ echo "Client List"; } ?></span></a></li>
                            <li @if($url === 'project_list') class="active" @endif><a href="{{route('project_list')}}"><i class="fa fa-angle-double-right"></i><span class="submenu-title"><?php if(Lang::has('sidebar.project_list')){ echo Lang::get('sidebar.project_list'); }else{ echo "Project  List"; } ?></span></a></li>
                            <li @if($url === 'assign_project') class="active" @endif><a href="{{route('assign_project')}}"><i class="fa fa-angle-double-right"></i><span class="submenu-title"><?php if(Lang::has('sidebar.assign_project')){ echo Lang::get('sidebar.assign_project'); }else{ echo "Assign Project"; } ?></span></a></li>
                    </ul>
                </ul>
            </li>
            @endpermission

            @permission('manage_training')
            <li @if($url === 'training_view' || $url==='training_assign' )  {{'in'}}  class="active" @endif><a href="#"><i class="fa fa-book">
                        <div class="icon-bg bg-violet"></div>
                    </i><span class="menu-title"><?php if(Lang::has('sidebar.manage_training')){ echo Lang::get('sidebar.manage_training'); }else{ echo "Manage Training"; } ?></span><span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <ul class="nav nav-third-level">
                        <li @if($url === 'training_view') class="active" @endif><a href="{{route('training_view')}}"><i class="fa fa-angle-double-right"></i><span class="submenu-title"><?php if(Lang::has('sidebar.training_view')){ echo Lang::get('sidebar.training_view'); }else{ echo "Training List"; } ?></span></a></li>
                        <li @if($url === 'training_assign') class="active" @endif><a href="{{route('training_assign')}}"><i class="fa fa-angle-double-right"></i><span class="submenu-title"><?php if(Lang::has('sidebar.training_assign')){ echo Lang::get('sidebar.training_assign'); }else{ echo "Assign Training"; } ?></span></a></li>
                    </ul>
                </ul>
            </li>
            @endpermission

            @permission('file_management')
            <li @if($url === 'file_share' || $url==='employee_panel_file_share_list')  {{'in'}}  class="active" @endif><a href="#"><i class="fa fa-file">
                        <div class="icon-bg bg-violet"></div>
                    </i><span class="menu-title"><?php if(Lang::has('sidebar.manage_file')){ echo Lang::get('sidebar.manage_file'); }else{ echo "File Management"; } ?></span><span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <ul class="nav nav-third-level">
                        <li @if($url === 'file_share') class="active" @endif><a href="{{route('file_share')}}"><i class="fa fa-angle-double-right"></i><span class="submenu-title"><?php if(Lang::has('sidebar.file_share')){ echo Lang::get('sidebar.file_share'); }else{ echo "Share File"; } ?></span></a></li>
                    </ul>

                   @if(auth()->user()->hasrole('employee'))
                    <ul class="nav nav-third-level">
                        <li @if($url === 'employee_panel_file_share_list') class="active" @endif><a href="{{url('employee/panel/file/share/list')}}"><i class="fa fa-angle-double-right"></i><span class="submenu-title"><?php if(Lang::has('sidebar.share_list')){ echo Lang::get('sidebar.share_list'); }else{ echo "Share List"; } ?></span></a></li>
                    </ul>
                   @endif
                </ul>
            </li>
            @endpermission




            @permission('manage_leave')
            <li @if($url === 'leave_list' ||$url === 'leave_assign_view' ||$url === 'weekleave_list' ||$url === 'festival_leave_list' ||$url === 'leave_status' )  {{'in'}}  class="active" @endif><a href="#"><i class="fa fa-road">
                        <div class="icon-bg bg-violet"></div>
                    </i><span class="menu-title"><?php if(Lang::has('sidebar.manage_leave')){ echo Lang::get('sidebar.manage_leave'); }else{ echo "Manage Leave"; } ?></span><span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">

                    <ul class="nav nav-third-level">
                        <li @if($url === 'leave_assign_view') class="active" @endif><a href="{{route('leave_assign_view')}}"><i class="fa fa-angle-double-right"></i><span class="submenu-title"><?php if(Lang::has('sidebar.leave_assign_view')){ echo Lang::get('sidebar.leave_assign_view'); }else{ echo "Assign Leave"; } ?></span></a></li>
                    </ul>
                    <ul class="nav nav-third-level">
                        <li @if($url === 'leave_list') class="active" @endif><a href="{{route('leave_list')}}"><i class="fa fa-angle-double-right"></i><span class="submenu-title"><?php if(Lang::has('sidebar.leave_list')){ echo Lang::get('sidebar.leave_list'); }else{ echo "Leave Settings"; } ?></span></a></li>
                    </ul>
                    <ul class="nav nav-third-level">
                        <li @if($url === 'weekleave_list') class="active" @endif><a href="{{route('weekleave_list')}}"><i class="fa fa-angle-double-right"></i><span class="submenu-title"><?php if(Lang::has('sidebar.weekleave_list')){ echo Lang::get('sidebar.weekleave_list'); }else{ echo "Week leave"; } ?></span></a></li>
                    </ul>
                    <ul class="nav nav-third-level">
                        <li @if($url === 'festival_leave_list') class="active" @endif><a href="{{route('festival_leave_list')}}"><i class="fa fa-angle-double-right"></i><span class="submenu-title"><?php if(Lang::has('sidebar.festival_leave_list')){ echo Lang::get('sidebar.festival_leave_list'); }else{ echo "Festival Leave"; } ?></span></a></li>
                    </ul>
                    <ul class="nav nav-third-level">
                        <li @if($url === 'leave_status') class="active" @endif><a href="{{route('leave_status')}}"><i class="fa fa-angle-double-right"></i><span class="submenu-title"><?php if(Lang::has('sidebar.leave_status')){ echo Lang::get('sidebar.leave_status'); }else{ echo "Approve/Reject Leave"; } ?></span></a></li>
                    </ul>
                </ul>
            </li>
            @endpermission

            @permission('payroll')
            <li @if($url==='salarygrade_list' || $url==='salary_assign_view' || $url === 'Process_status_list' || $url==='process_salary_view' || $url==='emp_salary_list' || $url==='salary_settings' )  {{'in'}}  class="active" @endif><a href="#"><i class="fa fa-usd">
                        <div class="icon-bg bg-violet"></div>
                    </i><span class="menu-title"><?php if(Lang::has('sidebar.payroll')){ echo Lang::get('sidebar.payroll'); }else{ echo "Payroll"; } ?></span><span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <ul class="nav nav-third-level">
                        <li @if($url === 'salary_assign_view') class="active" @endif><a href="{{route('salary_assign_view')}}"><i class="fa fa-angle-double-right"></i><span class="submenu-title"><?php if(Lang::has('sidebar.salary_assign_view')){ echo Lang::get('sidebar.salary_assign_view'); }else{ echo "Assign Salary"; } ?></span></a></li>
                    </ul>
                    <ul class="nav nav-third-level">
                        <li @if($url === 'emp_salary_list') class="active" @endif><a href="{{route('emp_salary_list')}}"><i class="fa fa-angle-double-right"></i><span class="submenu-title"><?php if(Lang::has('sidebar.emp_salary_list')){ echo Lang::get('sidebar.emp_salary_list'); }else{ echo "Salary List"; } ?></span></a></li>
                    </ul>
                    <ul class="nav nav-third-level">
                        <li @if($url === 'process_salary_view') class="active" @endif><a href="{{route('process_salary_view')}}"><i class="fa fa-angle-double-right"></i><span class="submenu-title"><?php if(Lang::has('sidebar.process_salary_view')){ echo Lang::get('sidebar.process_salary_view'); }else{ echo "Process Salary"; } ?></span></a></li>
                    </ul>
                    <ul class="nav nav-third-level">
                        <li @if($url === 'salarygrade_list') class="active" @endif><a href="{{route('salarygrade_list')}}"><i class="fa fa-angle-double-right"></i><span class="submenu-title"><?php if(Lang::has('sidebar.salarygrade_list')){ echo Lang::get('sidebar.salarygrade_list'); }else{ echo "Grade Settings"; } ?></span></a></li>
                    </ul>
                    <ul class="nav nav-third-level">
                        <li @if($url === 'salary_settings') class="active" @endif><a href="{{route('salary_settings')}}"><i class="fa fa-angle-double-right"></i><span class="submenu-title"><?php if(Lang::has('sidebar.salary_settings')){ echo Lang::get('sidebar.salary_settings'); }else{ echo "Salary Settings"; } ?></span></a></li>
                    </ul>
                    <ul class="nav nav-third-level">
                        <li @if($url === 'Process_status_list') class="active" @endif><a href="{{route('Process_status_list')}}"><i class="fa fa-angle-double-right"></i><span class="submenu-title"><?php if(Lang::has('sidebar.Process_status_list')){ echo Lang::get('sidebar.Process_status_list'); }else{ echo "Process Salary Status "; } ?></span></a></li>
                    </ul>
                </ul>
            </li>
            @endpermission

            @permission('benefit')
            <li @if($url==='benefit_list'  || $url==='employee_provident_list'  || $url==='festival_bonussinglepage'  || $url==='severance_list' )  {{'in'}}  class="active" @endif><a href="#"><i class="fa fa-smile-o">
                        <div class="icon-bg bg-violet"></div>
                    </i><span class="menu-title"><?php if(Lang::has('sidebar.benefit')){ echo Lang::get('sidebar.benefit'); }else{ echo "Benefit"; } ?></span><span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <ul class="nav nav-third-level">
                        <li @if($url === 'benefit_list') class="active" @endif><a href="{{route('benefit_list')}}"><i class="fa fa-angle-double-right"></i><span class="submenu-title"><?php if(Lang::has('sidebar.benefit_list')){ echo Lang::get('sidebar.benefit_list'); }else{ echo "Benefit List"; } ?></span></a></li>
                    </ul>
                    <ul class="nav nav-third-level">
                        <li @if($url === 'employee_provident_list') class="active" @endif><a href="{{route('employee_provident_list')}}"><i class="fa fa-angle-double-right"></i><span class="submenu-title"><?php if(Lang::has('sidebar.employee_provident_list')){ echo Lang::get('sidebar.employee_provident_list'); }else{ echo "Provident Fund"; } ?></span></a></li>
                    </ul>
                    <ul class="nav nav-third-level">
                        <li @if($url === 'festival_bonussinglepage') class="active" @endif><a href="{{route('festival_bonussinglepage')}}"><i class="fa fa-angle-double-right"></i><span class="submenu-title"><?php if(Lang::has('sidebar.festival_bonussinglepage')){ echo Lang::get('sidebar.festival_bonussinglepage'); }else{ echo "Festival Bonus"; } ?></span></a></li>
                    </ul>
                    <ul class="nav nav-third-level">
                        <li @if($url === 'severance_list') class="active" @endif><a href="{{route('severance_list')}}"><i class="fa fa-angle-double-right"></i><span class="submenu-title"><?php if(Lang::has('sidebar.severance_list')){ echo Lang::get('sidebar.severance_list'); }else{ echo "Severance Package"; } ?></span></a></li>
                    </ul>
                </ul>
            </li>
            @endpermission


            @permission('manage_expense')
            <li @if($url==='expansecategory_list' || $url==='expanse_list' || $url === 'employee_wise_expanse_summary' || $url === 'expense_status_list')   {{'in'}}  class="active" @endif><a href="#"><i class="fa fa-money">
                        <div class="icon-bg bg-violet"></div>
                    </i><span class="menu-title"> <?php if(Lang::has('sidebar.manage_expense')){ echo Lang::get('sidebar.manage_expense'); }else{ echo "Manage Expense"; } ?></span><span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <ul class="nav nav-third-level">
                        <li @if($url === 'expanse_list') class="active" @endif><a href="{{route('expanse_list')}}"><i class="fa fa-angle-double-right"></i><span class="submenu-title"><?php if(Lang::has('sidebar.expanse_list')){ echo Lang::get('sidebar.expanse_list'); }else{ echo "Expense List"; } ?></span></a></li>
                    </ul>
                    <ul class="nav nav-third-level">
                        <li @if($url === 'expansecategory_list') class="active" @endif><a href="{{route('expansecategory_list')}}"><i class="fa fa-angle-double-right"></i><span class="submenu-title"><?php if(Lang::has('sidebar.expansecategory_list')){ echo Lang::get('sidebar.expansecategory_list'); }else{ echo "Expense Category"; } ?></span></a></li>
                    </ul>
                    <ul class="nav nav-third-level">
                        <li @if($url === 'employee_wise_expanse_summary') class="active" @endif><a href="{{route('employee_wise_expanse_summary')}}"><i class="fa fa-angle-double-right"></i><span class="submenu-title"><?php if(Lang::has('sidebar.employee_wise_expanse_summary')){ echo Lang::get('sidebar.employee_wise_expanse_summary'); }else{ echo "Expense Summary"; } ?></span></a></li>
                    </ul>
                    <ul class="nav nav-third-level">
                        <li @if($url === 'expense_status_list') class="active" @endif><a href="{{route('expense_status_list')}}"><i class="fa fa-angle-double-right"></i><span class="submenu-title"> <?php if(Lang::has('sidebar.expense_status_list')){ echo Lang::get('sidebar.expense_status_list'); }else{ echo "Pending Expense"; } ?></span></a></li>
                    </ul>


                </ul>
            </li>
            @endpermission


            @permission('manage_users')
            <li @if( $url==='meeting_list' || $url === 'meeting_employee_list' || $url === 'announcement_list')  {{'in'}}  class="active" @endif><a href="#"><i class="fa fa-calendar">
                        <div class="icon-bg bg-violet"></div>
                    </i><span class="menu-title"><?php if(Lang::has('sidebar.manage_meeting')){ echo Lang::get('sidebar.manage_meeting'); }else{ echo "Manage Meeting"; } ?></span><span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <ul class="nav nav-third-level">
                        <li @if($url === 'meeting_list') class="active" @endif><a href="{{route('meeting_list')}}"><i class="fa fa-angle-double-right"></i><span class="submenu-title"><?php if(Lang::has('sidebar.meeting_list')){ echo Lang::get('sidebar.meeting_list'); }else{ echo "Meeting List"; } ?></span></a></li>
                        <li @if($url === 'meeting_employee_list') class="active" @endif><a href="{{route('meeting_employee_list')}}"><i class="fa fa-angle-double-right"></i><span class="submenu-title"><?php if(Lang::has('sidebar.meeting_employee_list')){ echo Lang::get('sidebar.meeting_employee_list'); }else{ echo "Meeting Employee List"; } ?></span></a></li>
                        <li @if($url === 'announcement_list') class="active" @endif><a href="{{route('announcement_list')}}"><i class="fa fa-angle-double-right"></i><span class="submenu-title"><?php if(Lang::has('sidebar.announcement_list')){ echo Lang::get('sidebar.announcement_list'); }else{ echo "Announcement List"; } ?></span></a></li>
                    </ul>
                </ul>
            </li>
            @endpermission



            @permission('manage_users')
            <li @if( $url==='employee_report' || $url==='attendance.report_index' || $url==='salary_report.index' || $url==='report.current.month.leave' || $url==='report.date.wise.leave' || $url==='employee_search' || $url==='report.branch_employee' || $url==='report.department_employee' || $url==='report.designation_employee' || $url==='report.report_project' || $url==='project_search' || $url==='high_priority_project' || $url==='low_priority_project' || $url==='report.project_datewise' || $url==='report.client_view' || $url==='report.report_client_list' || $url==='report.report_client_project' || $url==='report.report_meeting' || $url==='report.report_training' || $url==='report.report_date_wise_training' || $url==='report.leave' || $url==='report.date.wise.leave' || $url==='leave_report_type_datewise')  {{'in'}}  class="active" @endif><a href="#"><i class="fa fa-list ">
                        <div class="icon-bg bg-violet"></div>
                    </i><span class="menu-title"><?php if(Lang::has('sidebar.manage_report')){ echo Lang::get('sidebar.manage_report'); }else{ echo "Manage Report"; } ?></span><span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <ul class="nav nav-third-level">
                        <li @if($url === 'employee_report' || $url==='employee_search' || $url==='report.branch_employee' || $url==='report.department_employee' || $url==='report.designation_employee') class="active" @endif><a href="{{route('employee_report')}}"><i class="fa fa-angle-double-right">
                        </i><span class="submenu-title"><?php if(Lang::has('sidebar.employee_report')){ echo Lang::get('sidebar.employee_report'); }else{ echo "Employee"; } ?></span></a></li>
                    </ul>
                    <ul class="nav nav-third-level">
                       <li @if($url === 'report.report_project' || $url==='project_search' || $url==='high_priority_project' || $url==='low_priority_project' || $url==='report.project_datewise') class="active" @endif><a href="{{route('report.report_project')}}"><i class="fa fa-angle-double-right"></i><span class="submenu-title"><?php if(Lang::has('sidebar.report_project')){ echo Lang::get('sidebar.report_project'); }else{ echo "Project"; } ?></span></a></li>
                    </ul>
                    <ul class="nav nav-third-level">
                        <li @if($url === 'report.client_view' || $url==='report.report_client_list' || $url==='report.report_client_project') class="active" @endif><a href="{{route('report.client_view')}}"><i class="fa fa-angle-double-right"></i><span class="submenu-title"><?php if(Lang::has('sidebar.client_view')){ echo Lang::get('sidebar.client_view'); }else{ echo "Client"; } ?></span></a></li>
                    </ul>

                    <ul class="nav nav-third-level">
                        <li @if($url === 'report.report_meeting') class="active" @endif><a href="{{route('report.report_meeting')}}"><i class="fa fa-angle-double-right"></i><span class="submenu-title"><?php if(Lang::has('sidebar.report_meeting')){ echo Lang::get('sidebar.report_meeting'); }else{ echo "Meeting"; } ?></span></a></li>
                    </ul>

                    <ul class="nav nav-third-level">
                        <li @if($url === 'report.report_training' || $url==='report.report_date_wise_training') class="active" @endif><a href="{{route('report.report_training')}}"><i class="fa fa-angle-double-right"></i><span class="submenu-title"><?php if(Lang::has('sidebar.report_training')){ echo Lang::get('sidebar.report_training'); }else{ echo "Training"; } ?></span></a></li>
                     </ul>

                    <ul class="nav nav-third-level">
                        <li @if($url === 'salary_report.index') class="active" @endif><a href="{{route('salary_report.index')}}"><i class="fa fa-angle-double-right"></i><span class="submenu-title"><?php if(Lang::has('sidebar.salary_report')){ echo Lang::get('sidebar.salary_report'); }else{ echo "Salary"; } ?></span></a></li>
                    </ul>
                    <ul class="nav nav-third-level">
                        <li @if($url === 'attendance.report_index') class="active" @endif><a href="{{route('attendance.report_index')}}"><i class="fa fa-angle-double-right"></i><span class="submenu-title"><?php if(Lang::has('sidebar.attendance')){ echo Lang::get('sidebar.attendance'); }else{ echo "Attendance"; } ?></span></a></li>
                    </ul>
                    <ul class="nav nav-third-level">
                        <li @if($url === 'report.leave' || $url==='report.date.wise.leave' || $url==='leave_report_type_datewise') class="active" @endif><a href="{{route('report.leave')}}"><i class="fa fa-angle-double-right"></i><span class="submenu-title"><?php if(Lang::has('sidebar.leave')){ echo Lang::get('sidebar.leave'); }else{ echo "Leave"; } ?></span></a></li>
                   </ul>
                </ul>
            </li>
            <li @if($url === 'users.index' || $url==='users.create' || $url === 'roles.index' || $url==='roles.create' || $url === 'permissions.create' || $url==='permissions.index' )  {{'in'}} class="active"  @endif><a href="#"><i class="fa fa-users">
                        <div class="icon-bg bg-violet"></div>
                    </i><span class="menu-title"><?php if(Lang::has('sidebar.ad_user_Management')){ echo Lang::get('sidebar.ad_user_Management'); }else{ echo "User Management"; } ?></span><span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li @if($url === 'users.index' || $url==='users.create') class="active" @endif><a href="#"><i class="fa fa-angle-right"></i><span class="submenu-title"><?php if(Lang::has('sidebar.users')){ echo Lang::get('sidebar.users'); }else{ echo "Users"; } ?></span><span class="fa arrow"></span></a>
                            <ul class="nav nav-third-level">
                                <li @if($url === 'users.index') class="active" @endif><a href="{{route('users.index')}}"><i class="fa fa-angle-double-right"></i><span class="submenu-title"><?php if(Lang::has('sidebar.users_list')){ echo Lang::get('sidebar.users_list'); }else{ echo "User List"; } ?></span></a></li>
                                  @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('super-admin'))
                                <li @if($url === 'users.create') class="active" @endif><a href="{{route('users.create')}}"><i class="fa fa-angle-double-right"></i><span class="submenu-title"><?php if(Lang::has('sidebar.add_new_users')){ echo Lang::get('sidebar.add_new_users'); }else{ echo "Add New"; } ?></span></a></li>
                                @endif
                            </ul>
                        </li>
                    </ul>

                      @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('super-admin'))
                    <ul class="nav nav-second-level ">
                        <li @if($url === 'roles.index' || $url==='roles.create') class="active" @endif><a href="#"><i class="fa fa-angle-right"></i><span class="submenu-title"><?php if(Lang::has('sidebar.role')){ echo Lang::get('sidebar.role'); }else{ echo "Role"; } ?></span><span class="fa arrow"></span></a>
                            <ul class="nav nav-third-level">
                                <li @if($url === 'roles.index') class="active" @endif><a href="{{route('roles.index')}}"><i class="fa fa-angle-double-right"></i><span class="submenu-title"><?php if(Lang::has('sidebar.role_list')){ echo Lang::get('sidebar.role_list'); }else{ echo "Role List"; } ?></span></a></li>
                                <li @if($url === 'roles.create') class="active" @endif><a href="{{route('roles.create')}}"><i class="fa fa-angle-double-right"></i><span class="submenu-title"><?php if(Lang::has('sidebar.role_add_new')){ echo Lang::get('sidebar.role_add_new'); }else{ echo "Add New"; } ?></span></a></li>
                            </ul>
                        </li>
                    </ul>
                    <ul class="nav nav-second-level">
                        <li @if($url === 'permissions.index' || $url==='permissions.create') class="active" @endif><a href="#"><i class="fa fa-angle-right"></i><span class="submenu-title"><?php if(Lang::has('sidebar.permission')){ echo Lang::get('sidebar.permission'); }else{ echo "Permission"; } ?></span><span class="fa arrow"></span></a>
                            <ul class="nav nav-third-level">
                                <li @if($url === 'permissions.index') class="active" @endif><a href="{{route('permissions.index')}}"><i class="fa fa-angle-double-right"></i><span class="submenu-title"><?php if(Lang::has('sidebar.permission_list')){ echo Lang::get('sidebar.permission_list'); }else{ echo "Permission List"; } ?></span></a></li>
                                <li @if($url === 'permissions.create') class="active" @endif><a href="{{route('permissions.create')}}"><i class="fa fa-angle-double-right"></i><span class="submenu-title"> <?php if(Lang::has('sidebar.permission_add_new')){ echo Lang::get('sidebar.permission_add_new'); }else{ echo "Add New"; } ?></span></a></li>
                            </ul>
                        </li>
                    </ul>
                    @endif
              </li>
            @endpermission 


            @if(auth()->user()->hasRole(['admin','super-admin']))
            <li @if( $url==='complain.new_complain')  {{'in'}}  class="active" @endif><a href="#"><i class="fa fa-calendar">
                        <div class="icon-bg bg-violet"></div>
                    </i><span class="menu-title"><?php if(Lang::has('sidebar.manage_complain')){ echo Lang::get('sidebar.manage_complain'); }else{ echo "Manage Complain"; } ?></span><span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <ul class="nav nav-third-level">
                        <li @if($url === 'complain.new_complain') class="active" @endif><a href="{{route('complain.new_complain')}}"><i class="fa fa-angle-double-right"></i><span class="submenu-title"><?php if(Lang::has('sidebar.new_complain')){ echo Lang::get('sidebar.new_complain'); }else{ echo "New Complain"; } ?></span></a></li>
                        <li @if($url === 'complain.complain_list') class="active" @endif><a href="{{route('complain.complain_list')}}"><i class="fa fa-angle-double-right"></i><span class="submenu-title"><?php if(Lang::has('sidebar.complain_list')){ echo Lang::get('sidebar.complain_list'); }else{ echo "Complain List"; } ?></span></a></li>
                    </ul>
                </ul>
            </li>
            @endif
            

            @permission('settings')
            <li @if($url === 'department_list' || $url==='designations_list' || $url==='branch_list' || $url==='leave_list'
            || $url==='company_information_view' || $url==='shift_list' || $url==='employee_provident_list' )  {{'in'}}  class="active" @endif><a href="#"><i class="fa fa-cogs">
                        <div class="icon-bg bg-violet"></div>
                    </i><span class="menu-title"><?php if(Lang::has('sidebar.settings')){ echo Lang::get('sidebar.settings'); }else{ echo "Settings"; } ?></span><span class="fa arrow"></span></a>
                <ul class="nav nav-second-level ">
                    <ul class="nav nav-third-level">
                        <li @if($url === 'department_list') class="active" @endif><a href="{{route('department_list')}}"><i class="fa fa-angle-double-right"></i><span class="submenu-title"><?php if(Lang::has('sidebar.department')){ echo Lang::get('sidebar.department'); }else{ echo "Department"; } ?></span></a></li>
                    </ul>
                    <ul class="nav nav-third-level">
                        <li @if($url === 'designations_list') class="active" @endif><a href="{{route('designations_list')}}"><i class="fa fa-angle-double-right"></i><span class="submenu-title"><?php if(Lang::has('sidebar.designation')){ echo Lang::get('sidebar.designation'); }else{ echo "Designation"; } ?><?php if(Lang::has('sidebar.permission_add_new')){ echo Lang::get('sidebar.permission_add_new'); }else{ echo "Add New"; } ?></span></a></li>
                    </ul>
                    <ul class="nav nav-third-level">
                        <li @if($url === 'branch_list') class="active" @endif><a href="{{route('branch_list')}}"><i class="fa fa-angle-double-right"></i><span class="submenu-title"><?php if(Lang::has('sidebar.branch')){ echo Lang::get('sidebar.branch'); }else{ echo "Branch"; } ?></span></a></li>
                    </ul>
                    <ul class="nav nav-third-level">
                        <li @if($url === 'shift_list') class="active" @endif><a href="{{route('shift_list')}}"><i class="fa fa-angle-double-right"></i><span class="submenu-title"><?php if(Lang::has('sidebar.shift')){ echo Lang::get('sidebar.shift'); }else{ echo "Shift"; } ?></span></a></li>
                    </ul>

                    <ul class="nav nav-third-level">
                        <li @if($url === 'company_information_view') class="active" @endif><a href="{{route('company_information_view')}}"><i class="fa fa-angle-double-right"></i><span class="submenu-title"><?php if(Lang::has('sidebar.company_info')){ echo Lang::get('sidebar.company_info'); }else{ echo "Company Info"; } ?></span></a></li>
                    </ul>
                    <ul class="nav nav-third-level">
                        <li @if($url === 'chat_list') class="active" @endif><a href="{{route('chat_list')}}"><i class="fa fa-angle-double-right"></i><span class="submenu-title"><?php if(Lang::has('sidebar.chat')){ echo Lang::get('sidebar.chat'); }else{ echo "Chat"; } ?></span></a></li>
                    </ul>
                    <ul class="nav nav-third-level">
                        <li @if($url === '/theme_list') class="active" @endif><a href="{{route('theme_list')}}"><i class="fa fa-angle-double-right"></i><span class="submenu-title"><?php if(Lang::has('sidebar.change_theme_style')){ echo Lang::get('sidebar.change_theme_style'); }else{ echo "Change Theme Style"; } ?></span></a></li>
                    </ul>

                </ul>
            </li>
            @endpermission


            @if(auth()->user()->hasRole('employee'))
            <li @if($url === 'assign_project_list_employee')  {{'in'}}  class="active" @endif><a href="#"><i class="fa fa-tasks">
                    <div class="icon-bg bg-violet"></div>
                </i><span class="menu-title">Project</span><span class="fa arrow"></span></a>
            <ul class="nav nav-second-level">
                <ul class="nav nav-third-level">
                        <li @if($url === 'assign_project_list_employee') class="active" @endif><a href="{{route('assign_project_list_employee')}}"><i class="fa fa-angle-double-right"></i><span class="submenu-title">Assign Project list</span></a></li>
                  </ul>
              </ul>
           </li>
        @endif


            @if(auth()->user()->hasRole('employee'))
            <li @if( $url==='attendance.individual_attendance_report')  {{'in'}}  class="active" @endif><a href="#"><i class="fa   fa-empire">
                    <div class="icon-bg bg-violet"></div>
                </i><span class="menu-title">Attendance</span><span class="fa arrow"></span></a>
              <ul class="nav nav-second-level">
                <ul class="nav nav-third-level">
                        <li @if($url === 'report/individual_attendance_report') class="active" @endif><a href="{{url('report/individual_attendance_report')}}"><i class="fa fa-angle-double-right"></i><span class="submenu-title">Attendance Report</span></a></li>
                </ul>
              </ul>
           </li>
           @endif


           @if(auth()->user()->hasRole('employee'))
           <li @if( $url==='employee_panel_leave_request' || $url==='festival_leave_listemployee')  {{'in'}}  class="active" @endif><a href="#"><i class="fa fa-road">
                   <div class="icon-bg bg-violet"></div>
               </i><span class="menu-title">Leave Management</span><span class="fa arrow"></span></a>
             <ul class="nav nav-second-level">
               <ul class="nav nav-third-level">
                       <li @if($url === 'employee_panel_leave_request') class="active" @endif><a href="{{url('employee/panel/leave/request')}}"><i class="fa fa-angle-double-right"></i><span class="submenu-title">Leave Request</span></a></li>
               </ul>
               <ul class="nav nav-third-level">
                       <li @if($url === 'festival_leave_listemployee') class="active" @endif><a href="{{url('listemployee/festival_leave/list')}}"><i class="fa fa-angle-double-right"></i><span class="submenu-title">Festival Leave</span></a></li>
               </ul>
             </ul>
          </li>
          @endif


           @if(auth()->user()->hasRole('employee'))
           <li @if( $url==='employee_panel_task_list')  {{'in'}}  class="active" @endif><a href="#"><i class="fa fa-thumb-tack">
                   <div class="icon-bg bg-violet"></div>
               </i><span class="menu-title">Task</span><span class="fa arrow"></span></a>
             <ul class="nav nav-second-level">
               <ul class="nav nav-third-level">
                       <li @if($url === 'employee_panel_task_list') class="active" @endif><a href="{{url('employee/panel/task/list')}}"><i class="fa fa-angle-double-right"></i><span class="submenu-title">Assign Task List</span></a></li>
               </ul>
             </ul>
          </li>
          @endif

          @if(auth()->user()->hasRole('employee'))
          <li @if( $url==='employee_panel_training_list')  {{'in'}}  class="active" @endif><a href="#"><i class="fa fa-book">
                  <div class="icon-bg bg-violet"></div>
              </i><span class="menu-title">Training</span><span class="fa arrow"></span></a>
            <ul class="nav nav-second-level">
              <ul class="nav nav-third-level">
                      <li @if($url === 'employee_panel_training_list') class="active" @endif><a href="{{url('employee/panel/training/list')}}"><i class="fa fa-angle-double-right"></i><span class="submenu-title">Assign Training List</span></a></li>
              </ul>
            </ul>
         </li>
         @endif


        @if(auth()->user()->hasRole('employee'))
            <li @if( $url==='employee_panel_meetingg_list')  {{'in'}}  class="active" @endif><a href="#"><i class="fa fa-calendar">
                 <div class="icon-bg bg-violet"></div>
            </i><span class="menu-title">Meeting</span><span class="fa arrow"></span></a>
            <ul class="nav nav-second-level">
             <ul class="nav nav-third-level">
                     <li @if($url === 'employee_panel_meetingg_list') class="active" @endif><a href="{{url('employee/panel/meeting/list')}}"><i class="fa fa-angle-double-right"></i><span class="submenu-title">Assign Meeting List</span></a></li>
             </ul>
           </ul>
        </li>
        @endif 


        @if(auth()->user()->hasRole('employee'))
            <li @if($url==='employee_wise_expanse_report' || $url==='expanse_list' || $url === 'employee_wise_expanse_summary' || $url === 'expense_status_list')   {{'in'}}  class="active" @endif><a href="#"><i class="fa fa-money">
                        <div class="icon-bg bg-violet"></div>
                    </i><span class="menu-title">Manage Expense</span><span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <ul class="nav nav-third-level">
                        <li @if($url === 'expanse_list') class="active" @endif><a href="{{route('expanse_list')}}"><i class="fa fa-angle-double-right"></i><span class="submenu-title">Expense List</span></a></li>
                    </ul>
                    {{-- <ul class="nav nav-third-level">
                        <li @if($url === 'expansecategory_list') class="active" @endif><a href="{{route('expansecategory_list')}}"><i class="fa fa-angle-double-right"></i><span class="submenu-title">Expense Category</span></a></li>
                    </ul>
                    <ul class="nav nav-third-level">
                        <li @if($url === 'employee_wise_expanse_summary') class="active" @endif><a href="{{route('employee_wise_expanse_summary')}}"><i class="fa fa-angle-double-right"></i><span class="submenu-title">Expense Summary</span></a></li>
                    </ul>
                    <ul class="nav nav-third-level">
                        <li @if($url === 'expense_status_list') class="active" @endif><a href="{{route('expense_status_list')}}"><i class="fa fa-angle-double-right"></i><span class="submenu-title">Pending Expense</span></a></li>
                    </ul> --}}

                    <ul class="nav nav-third-level">
                        <li @if($url === 'employee_wise_expanse_report') class="active" @endif><a href="{{route('employee_wise_expanse_report')}}"><i class="fa fa-angle-double-right"></i><span class="submenu-title">Expanse Report</span></a></li>
                    </ul>
                </ul>
            </li>
        @endif 

        @if(auth()->user()->hasRole('employee'))
            <li @if( $url==='search_employee')  {{'in'}}  class="active" @endif><a href="#"><i class="fa fa-users">
                        <div class="icon-bg bg-violet"></div>
                    </i><span class="menu-title">Employee</span><span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <ul class="nav nav-third-level">
                        <li @if($url === 'search_employee') class="active" @endif><a href="{{route('search_employee')}}"><i class="fa fa-angle-double-right"></i><span class="submenu-title">Search Employee</span></a></li>
                    </ul>
                </ul>
            </li>
        @endif
        <br>
        </ul>
    </div>
</nav>
