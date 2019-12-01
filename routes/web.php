<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/AccessDenied','AccessController@AccessDenied');
Route::get('/clear-cache', function() {
    Artisan::call('cache:clear');
    return "Cache is cleared";
});

Route::get('/','DashboardController@dashboard_view')->name('dashboard');
Auth::routes();
/* Logout route start */
Route::get('/logout', 'Auth\LoginController@logout');
/* Logout route end */
Route::get('locale/{lang}', function ($lang) {
    Session::put('locale', $lang);
    return redirect()->back();
});

Route::group(['middleware'=>'auth'], function () {
    // ===================================== ./dashboard start=======================================
    Route::get('/','DashboardController@dashboard_view')->name('dashboard');
    // ===================================== ./dashboard end=======================================

    // ===================================== ./Role start=============================================
    Route::resource('/roles', 'RoleController');
    // ===================================== ./Role end=============================================

    // ===================================== Permissions start======================================
    Route::resource('/permissions', 'PermissionController');
    Route::post('/permissions/search', 'PermissionController@search')->name('permissions.search');
    // ===================================== Permissions end=====================================

    // ====================================User start==============================================
    Route::resource('/users', 'UserController');
    Route::post('/users/delete/{id}','UserController@users_delete')->name('users_delete');
    // ====================================User end================================================

    // ====================================Dashboard Area  start=====================================
    Route::get('/dashboard/employee_list/{group}','DashboardController@employee_list')->name('dashboard.employee_list');
    // ====================================Dashboard Area  end========================================


    // ====================================Department start=====================================
    Route::get('/department_list','DepartmentController@department_list')->name('department_list');
    // ====================================Department end========================================

    // ====================================Employee start=====================================
    Route::get('/employee/list','EmployeeController@employee_list')->name('employee_list');
    Route::get('/employee/create','EmployeeController@create_employee')->name('employee_create');
    Route::post('/employee/add','EmployeeController@employee_store')->name('employee.store');
    Route::post('/employee/update','EmployeeController@employee_update')->name('employee.update');
    Route::get('/employee/profile/{id}','EmployeeController@employee_profile')->name('employee.profile');
    Route::post('/employee/password/update','EmployeeController@employee_password')->name('employee.password');
    Route::post('/employee/password_update','EmployeeController@employee_update_password')->name('employee.update_password');
    Route::post('/employee/image/update','EmployeeController@employee_image')->name('employee.image');
    Route::post('/employee/education/store','EmployeeController@employee_education')->name('employee.education');
    Route::post('/employee/education/update','EmployeeController@employee_education_update')->name('employee.education.update');
    Route::get('/employee/education/delete/{id}','EmployeeController@employee_education_delete')->name('employee.education.delete');
    Route::get('/employee/download/id/card/{id}','EmployeeController@download_id_card');
    Route::get('/employee/download/job/application/letter/{id}','EmployeeController@download_job_application_letter');
    Route::get('/employee/download/appointment/letter/{id}','EmployeeController@download_appointment_letter');
    Route::get('/employee/download/resignation/letter/{id}','EmployeeController@download_resignation_letter');
     Route::get('/employee/rating','EmployeeController@employeeRating')->name('employee_rating');
     Route::get('/search_employee','EmployeeController@search_employee')->name('search_employee');
     Route::get('/employee/short_profile','EmployeeController@short_profile')->name('employee.short_profile');
    // ====================================Employee end========================================

    // ====================================Department start===============================================
    Route::get('/department/list','DepartmentController@department_list')->name('department_list');
    Route::post('/department/add','DepartmentController@department_add')->name('department_add');
    Route::get('department_edit/{id}','DepartmentController@department_edit')->name('department_edit');
    Route::post('/department/update','DepartmentController@department_update')->name('department_update');
    // ====================================Department end=================================================

    // ====================================Designations start===============================================
    Route::get('/designations/list','DesignationsController@designations_list')->name('designations_list');
    Route::post('/designation/add','DesignationsController@designation_add')->name('designation_add');
    Route::get('designation_edit/{id}','DesignationsController@designation_edit')->name('designation_edit');
    Route::post('/designation/update','DesignationsController@designation_update')->name('designation_update');
    // ====================================Designations end=================================================

    // ====================================Branch start===============================================
    Route::get('/branch/list','BranchController@branch_list')->name('branch_list');
    Route::post('/branch/add','BranchController@branch_add')->name('branch_add');
    Route::get('branch_edit/{id}','BranchController@branch_edit')->name('branch_edit');
    Route::post('/branch/update','BranchController@branch_update')->name('branch_update');
    // ====================================Branch end=================================================

    // ====================================Leave start===============================================
    Route::get('/leave/list','LeaveController@leave_list')->name('leave_list');
    Route::post('/leave/add','LeaveController@leave_add')->name('leave_add');
    Route::get('leave_edit/{id}','LeaveController@leave_edit')->name('leave_edit');
    Route::post('/leave/update','LeaveController@leave_update')->name('leave_update');
    Route::get('/leave/assign/view','LeaveController@leave_assign_view')->name('leave_assign_view');
    Route::get('maternity_leave/{leave_type}','LeaveController@maternity_leave')->name('maternity_leave');
    Route::post('/leave/assign','LeaveController@leave_assign')->name('leave_assign');
    Route::get('/leave/assigned/list/{id}','LeaveController@leave_assign_list')->name('leave_assign_list');
    Route::get('/leave/available/leave/{id}/{e_id}','LeaveController@leave_available_check')->name('leave_available_check');
    Route::get('/leave/status','LeaveController@leave_status')->name('leave_status');
    Route::get('leave_approve/{id}','LeaveController@leave_status_approve')->name('leave_status_approve');
    Route::get('leave_reject/{unique_id}','LeaveController@leave_status_reject')->name('leave_status_reject');
    Route::get('leave_pending/{unique_id}','LeaveController@leave_status_pending')->name('leave_status_pending');
    Route::get('leave_approve_again/{unique_id}','LeaveController@leave_status_approve_again')->name('leave_status_approve_again');
    // ====================================Leave end=================================================

    // ====================================salary start=====================================
    Route::get('/salary/list','SalaryController@salary_assign_view')->name('salary_assign_view');
    Route::post('/salary/assign','SalaryController@salary_assign')->name('salary_assign');
    Route::get('/salary/assigned/details/{id}','SalaryController@emp_salary_details')->name('emp_salary_details');
    Route::get('/employee/salary/list','SalaryController@emp_salary_list')->name('emp_salary_list');
    Route::get('/employee/salary/details/{id}','SalaryController@employee_salary_details')->name('employee_salary_details');
    Route::post('/employee/salary/update','SalaryController@employee_salary_update')->name('employee_salary_update');

    Route::get('/salary/settings','SalaryController@salary_settings')->name('salary_settings');
    Route::post('/salary/settings/update','SalaryController@salary_settings_update')->name('salary_settings_update');

    Route::get('/salary/process/view','SalaryController@process_salary_view')->name('process_salary_view');
    Route::get('/salary/process/{year_month}/{test}','SalaryController@process_salary')->name('process_salary');

    // /demo is for test
//    Route::get('/demo','SalaryController@test2')->name('test');
    // ====================================salary end========================================


    // ==================================== Salary Report Start=====================================
    Route::get('/report/salary','SalaryReportController@index')->name('salary_report.index');
    Route::get('/report/salary_month','SalaryReportController@salary_month')->name('salary_report.salary_month');
    Route::get('/report/salary_month_employee','SalaryReportController@salary_month_employee')->name('salary_report.salary_month_employee');
    Route::get('/report/salary_sheet','SalaryReportController@salary_sheet')->name('salary_report.salary_sheet');
    Route::post('/report/pay_slip','SalaryReportController@pay_slip')->name('salary_report.pay_slip');
    // Route::get('/report/salary/pdf/{year_month}','SalaryReportController@salary_report_pdf')->name('salary_report.salary_report_pdf');
     Route::post('report/salary/month/wise','SalaryReportController@month_wise_salary_report')->name('salary_report.month_wise_salary_report');

      Route::get('/branch/department/{id}','SalaryReportController@branchDepartment')->name('branch_Department');
    Route::get('/department/employee/{id}','SalaryReportController@departmentEmployee')->name('department_employee');


    // ==================================== Salary Report End ========================================


    // ====================================Company Information start==================================
    Route::get('/companyInfo/view','CompanyInformationController@company_information_view')->name('company_information_view');
    Route::post('/companyInfo/add','CompanyInformationController@companyInfo_add')->name('companyInfo_add');
    Route::get('company_edit/{id}','CompanyInformationController@company_edit')->name('company_edit');
    Route::post('/companyInfo/update','CompanyInformationController@company_update')->name('company_update');
    // ====================================Company Information end====================================

    // ====================================Shift start===============================================
    Route::get('/shift/list','ShiftController@shift_list')->name('shift_list');
    Route::post('/shift/add','ShiftController@shift_add')->name('shift_add');
    Route::get('shift_edit/{id}','ShiftController@shift_edit')->name('shift_edit');
    Route::post('/shift/update','ShiftController@shift_update')->name('shift_update');
    // ====================================Shift end=================================================

    // ====================================Task start===============================================
    Route::get('/task/list','TaskController@task_list')->name('task_list');
    Route::post('/task/add','TaskController@task_add')->name('task_add');
    Route::get('task_edit/{id}','TaskController@task_edit')->name('task_edit');
    Route::post('/task/update','TaskController@task_update')->name('task_update');
    Route::get('/task/view/{id}','TaskController@task_view')->name('task_view');
    Route::post('/task/delete/{id}','TaskController@task_delete')->name('task_delete');
    Route::get('/task/assign/view','TaskController@assign_task_view')->name('assign_task_view');
    Route::post('/task/assigned','TaskController@task_assigned')->name('task_assigned');
    Route::get('/task/assigned/list/{id}','TaskController@assign_task_list')->name('assign_task_list');



    Route::get('/task/employee/list','TaskController@employee_task_list')->name('employee_task_list');
    Route::post('/task/employee/show','TaskController@employee_task_show')->name('employee_task_list_show');
    //Route::get('/task/employee/list/{id}','TaskController@employee_get_view_list')->name('employee_get_view_list');
    //Route::get('/task/employee/list/view/{branch_id}/{dept_id}','TaskController@employee_get_view_list')->name('employee_get_view_list');

    Route::get('/task/branch/employee/{id}','TaskController@employee_branch_wise')->name('employee_branch_wise');
    Route::get('/task/department/employee/{dept_id}','TaskController@employee_department_wise')->name('employee_department_wise');
    Route::get('/task/designation/employee/{desig_id}','TaskController@employee_designation_wise')->name('employee_designation_wise');

    // ====================================Task end=================================================

    // ====================================Severance start===============================================
    Route::get('/severance/list','SeverancePackageController@severance_list')->name('severance_list');
    Route::post('/severance/add','SeverancePackageController@severance_add')->name('severance_add');
    Route::get('severance_edit/{id}','SeverancePackageController@severance_edit')->name('severance_edit');
    Route::post('/severance/update','SeverancePackageController@severance_update')->name('severance_update');
    // ====================================Severance end=================================================

    // ====================================Severance Package start===============================================
    Route::get('/severance/package/list','SeverancePackageEmployeeController@severance_package_list')->name('severance_package_list');
    Route::post('/severance/package/add','SeverancePackageEmployeeController@severance_package_add')->name('severance_package_add');
    Route::get('severance_package_edit/{id}','SeverancePackageEmployeeController@severance_package_edit')->name('severance_package_edit');
    // Route::post('/severance/package/update','SeverancePackageEmployeeController@severance_package_update')->name('severance_package_update');
    Route::get('branch/severance/employee/{id}','SeverancePackageEmployeeController@severanceemployeeId');
    // ====================================Severance Package end=================================================

    // ====================================Weekleave start===============================================
    Route::get('/weekleave/list','WeekLeaveController@weekleave_list')->name('weekleave_list');
    Route::post('/weekleave/add','WeekLeaveController@weekleave_add')->name('weekleave_add');
    Route::get('weekleave_edit/{id}','WeekLeaveController@weekleave_edit')->name('weekleave_edit');
    Route::post('/weekleave/update','WeekLeaveController@weekleave_update')->name('weekleave_update');
    // ====================================Weekleave end=================================================

    // ====================================Expanse start===============================================
    Route::get('/expansecategory/list','ExpanseCategoryController@expansecategory_list')->name('expansecategory_list');
    Route::post('/expansecategory/add','ExpanseCategoryController@expansecategory_add')->name('expansecategory_add');
    Route::get('expansecategory_edit/{id}','ExpanseCategoryController@expansecategory_edit')->name('expansecategory_edit');
    Route::post('/expansecategory/update','ExpanseCategoryController@expansecategory_update')->name('expansecategory_update');
    // ====================================Expanse end=================================================

    // ====================================salary_grade start===============================================
    Route::get('salary_grade/list','SalaryGradeController@salarygrade_list')->name('salarygrade_list');
    Route::post('salary_grade/add','SalaryGradeController@salarygrade_add')->name('salarygrade_add');
    Route::get('salary_grade_edit/{id}','SalaryGradeController@salarygrade_edit')->name('salarygrade_edit');
    Route::post('salary_grade/update','SalaryGradeController@salarygrade_update')->name('salarygrade_update');
    Route::get('salary_grade/{id}','SalaryGradeController@salary_grade')->name('salary_grade');
    // ====================================salary_grade end=================================================

    // ====================================group start===============================================
    Route::get('group/list','GroupController@group_list')->name('group_list');
    Route::post('group/add','GroupController@group_add')->name('group_add');
    Route::get('group_edit/{id}','GroupController@group_edit')->name('group_edit');
    Route::post('group/update','GroupController@group_update')->name('group_update');
    Route::get('branch/group/employee/{id}','GroupController@branchemployeeId');
    // Route::get('branch/allbranch','GroupController@allbranch');
    Route::get('/ajax/get_all_branch','GroupController@get_all_branch')->name('ajax.get_all_branch');
    // ====================================group end=================================================

    // ====================================AJAX REQUESTS route start===================================
    Route::get('/ajax/get_branch','BranchController@get_branch')->name('ajax.get_branch');
    Route::get('/ajax/get_employee/{id}','EmployeeController@get_employee')->name('ajax.get_employee');
    Route::get('/ajax/get_employee_for_report/{id}','EmployeeController@get_employee_for_report');
    Route::get('/ajax/get_task','TaskController@get_task')->name('ajax.get_task');
    Route::get('/ajax/get_salary/grade','SalaryGradeController@get_grade')->name('ajax.get_grade');
    Route::get('/ajax/get_leave_type/{id}','LeaveController@get_leave_type')->name('ajax.get_leave_type');
    Route::get('/ajax/get_all_employee','GroupController@get_employeegroup')->name('ajax.get_employeegroup');
    Route::get('/ajax/autocomplete/employee','EmployeeController@autocomplete_employee')->name('autocomplete.employee');
    Route::get('/ajax/get_task_status','TaskController@get_task_status')->name('ajax.get_task_status');

    // ====================================AJAX REQUESTS route end======================================

    // ====================================benefit start===============================================
    Route::get('benefit/list','BenefitController@benefit_list')->name('benefit_list');
    Route::post('benefit/add','BenefitController@benefit_add')->name('benefit_add');
    Route::get('benefit_edit/{id}','BenefitController@benefit_edit')->name('benefit_edit');
    Route::post('benefit/update','BenefitController@benefit_update')->name('benefit_update');
    Route::get('branch/benefit/employee/{id}','BenefitController@branchbenefit');
    Route::get('/ajax/benefit/bnemployee','BenefitController@get_employeebenefit')->name('ajax.get_employeebenefit');
    // ====================================benefit end=================================================

    // ==================================== Employee provident list start===============================================
    Route::get('/employee/provident/list','ProvidentFundController@employee_provident_fund')->name('employee_provident_list');
    Route::get('/provident_fund_percent_edit/{id}','ProvidentFundController@provident_percent_edit')->name('provident_edit');
    Route::post('/provident/percent/update','ProvidentFundController@provident_percent_update')->name('provident_percent_update');
    // Route::get('branch/provident/employee/{id}','ProvidentFundAmountController@providentemployeeId');
    // ==================================== Employee provident list end=================================================

    // ==================================== group employee start===============================================
    Route::get('group_employee/list','GroupEmployeeController@group_employee_list')->name('group_employee_list');
    Route::post('group_employee/add','GroupEmployeeController@group_employee_add')->name('group_employee_add');
    Route::get('group_employee_edit/{id}','GroupEmployeeController@group_employee_edit')->name('group_employee_edit');
    Route::post('group_employee/update','GroupEmployeeController@group_employee_update')->name('group_employee_update');
    Route::get('branch/employee/{id}','GroupEmployeeController@employeeId');
    // ==================================== group employee  end=================================================

    // ==================================== favourites employee start===============================================
    Route::get('favourites/list','FavouritesController@favourites_list')->name('favourites_list');
    Route::post('favourites/add','FavouritesController@favourites_add')->name('favourites_add');
    Route::get('favourites_edit/{id}','FavouritesController@favourites_edit')->name('favourites_edit');
    Route::post('favourites/update','FavouritesController@favourites_update')->name('favourites_update');
    Route::get('branch/favourites/employee/{id}','FavouritesController@favouritesemployeeId');
    // ==================================== favourites employee  end=================================================

    // ==================================== Attendance Module Start===============================================
    Route::get('attendance/file_create','AttendanceController@create')->name('attendance_file.create');
    Route::post('attendance/file_store','AttendanceController@store')->name('attendance_file.store');
    Route::get('attendance/file_process/{id}','AttendanceController@file_process')->name('attendance_file.process');
    Route::get('ajax/process_file/{id}','AttendanceController@ajax_process_file')->name('ajax.process_file');
    Route::get('/attendance','AttendanceController@index')->name('attendance.index');
    Route::get('/manual_attendance','AttendanceController@manual_attendance')->name('attendance.manual_attendance');
    Route::get('attendance/create','AttendanceController@create_attendance')->name('attendance.create_attendance');
    Route::post('attendance/store','AttendanceController@store_attendance')->name('attendance.store_attendance');
    Route::get('attendance/edit','AttendanceController@edit_attendance')->name('attendance.edit_attendance');
    Route::get('attendance/get_data/{emp_id}/{date}','AttendanceController@get_attendance_data')->name('attendance.get_data');
    Route::patch('attendance/update/{emp_id}/{date}','AttendanceController@update_attendance')->name('attendance.update_attendance');
    Route::delete('attendance/destroy/{emp_id}/{date}','AttendanceController@destroy_attendance')->name('attendance.destroy_attendance');
    Route::get('attendance/delete','AttendanceController@delete_attendance')->name('attendance.delete_attendance');
    Route::get('attendance/create_date_wise','AttendanceController@create_attendance_date')->name('attendance.create_attendance_date');
    Route::post('attendance/manual_attendance_date_wise_data','AttendanceController@manual_attendance_date_wise_data')->name('attendance.manual_attendance_date_wise_data');
    Route::post('attendance/manual_attendance_data_store','AttendanceController@manual_attendance_data_store')->name('attendance.manual_attendance_data_store');
    // ==================================== Attendance Module End=================================================


    // ==================================== Attendance Report Start===============================================
    Route::get('/report/attendance','AttendanceReportController@index')->name('attendance.report_index');
    Route::get('/report/attendance_report','AttendanceReportController@attendance_report')->name('attendance.attendance_report');
    Route::post('/report/attendance_report_data','AttendanceReportController@attendance_report_data')->name('attendance.attendance_report_data');
    Route::post('/report/attendance_report_export','AttendanceReportController@attendance_report_export')->name('attendance.attendance_report_export');

    Route::get('/report/present_report','AttendanceReportController@present_report')->name('attendance.present_report');
    Route::post('/report/present_report_data','AttendanceReportController@present_report_data')->name('attendance.present_report_data');
    Route::post('/report/present_report_export','AttendanceReportController@present_report_export')->name('attendance.present_report_export');

    Route::get('/report/late_report','AttendanceReportController@late_report')->name('attendance.late_report');
    Route::post('/report/late_report_data','AttendanceReportController@late_report_data')->name('attendance.late_report_data');
    Route::post('/report/late_report_export','AttendanceReportController@late_report_export')->name('attendance.late_report_export');

    Route::get('/report/absent_report','AttendanceReportController@daily_absent_report')->name('attendance.daily_absent_report');
    Route::post('/report/absent_report_data','AttendanceReportController@daily_absent_report_data')->name('attendance.daily_absent_report_data');
    Route::post('/report/absent_report_export','AttendanceReportController@daily_absent_report_export')->name('attendance.daily_absent_report_export');

    Route::get('/report/individual_attendance_report','AttendanceReportController@individual_attendance_report')->name('attendance.individual_attendance_report');
    Route::post('/report/individual_attendance_report_data','AttendanceReportController@individual_attendance_report_data')->name('attendance.individual_attendance_report_data');
    Route::post('/report/individual_attendance_report_export','AttendanceReportController@individual_attendance_report_export')->name('attendance.individual_attendance_report_export');

    Route::get('/report/overtime_report','AttendanceReportController@overtime_report')->name('attendance.overtime_report');
    Route::post('/report/overtime_report_data','AttendanceReportController@overtime_report_data')->name('attendance.overtime_report_data');
    Route::post('/report/overtime_report_export','AttendanceReportController@overtime_report_export')->name('attendance.overtime_report_export');

    Route::get('/report/attendance_exception_report','AttendanceReportController@attendance_exception_report')->name('attendance.attendance_exception_report');
    Route::post('/report/attendance_exception_data','AttendanceReportController@attendance_exception_data')->name('attendance.attendance_exception_data');
    Route::post('/report/attendance_exception_export','AttendanceReportController@attendance_exception_export')->name('attendance.attendance_exception_export');

    // ==================================== Attendance Report End =================================================


    // ==================================== Project and Client Start ===============================================
      Route::get('clients/list','ClientController@index')->name('clients_list');
      Route::post('clients/add','ClientController@client_add')->name('clients_add');
      Route::get('clients/edit/{id}','ClientController@client_edit')->name('clients_edit');
      Route::post('clients/update/','ClientController@client_update')->name('clients_update');
      Route::get('project/list','ProjectController@index')->name('project_list');
      Route::post('project/add','ProjectController@projectStore')->name('project_add');
      Route::get('project/edit/{id}','ProjectController@projectEdit');
      Route::post('project/update','ProjectController@projectUpdate')->name('project_update');
      Route::get('branch/team/leader/{id}','ProjectController@teamLeader');
      Route::get('branch/client/{id}','ProjectController@branchClient');
      Route::get('assign/project','ProjectController@assignProject')->name('assign_project');
      Route::get('project/details/{id}','ProjectController@projectDetails');
      Route::get('assign/project/member/{id}','ProjectController@assignMember');
      Route::post('assign/project/store','ProjectController@projectAssignStore')->name('assign_project_store');
      Route::get('employee/assign/project/list','ProjectController@assignMemberProject')->name('assign_project_list_employee');
      Route::get('client/profile/{id}','ClientController@clientProfile')->name('client_profile');
      Route::get('project/profile/{id}','ProjectController@projectProfile')->name('project_profile');
      Route::get('project/assign/task/{projectid}/{memberid}','ProjectController@projectTask')->name('project_task');
      Route::post('project/assign/task/store','ProjectController@projectTaskStore')->name('project_task_store');
      Route::post('/project/assign/task/update/','ProjectController@project_assign_task_update');
      Route::post('/project/assign/task/delete/','ProjectController@project_assign_task_delete');
      Route::post('project/group/chat','ProjectController@projectGroupChat');
      Route::get('project/group/conversation/{id}','ProjectController@latestChatMessage');
      Route::get('project/employee/task/list/{id}','ProjectController@assignTaskListProject');
      Route::post('project/employee/task/status/update','ProjectController@updateTaskStatus');
    // ==================================== Project and Client End ===============================================

    // ==================================== file share start ===============================================
      Route::get('file/share','FileShareController@index')->name('file_share');
      Route::post('file/store','FileShareController@fileStore')->name('file_share_store');
    // ==================================== file share end ===============================================

    // ==================================== training start ===============================================
    Route::get('training/list','TrainingController@index')->name('training_view');
    Route::post('training/store','TrainingController@trainingStore')->name('training_store');
    Route::get('training/edit/{id}','TrainingController@trainingEdit')->name('training_edit');
    Route::post('training/update/','TrainingController@trainingUpdate')->name('training_update');
    Route::get('assign/training','TrainingController@assignTraining')->name('training_assign');
    Route::get('training/details/{id}','TrainingController@trainingDetails')->name('training_details');
    Route::get('assign/member/{id}','TrainingController@assignMember')->name('assign_member');
    Route::post('assign/member/store','TrainingController@assignMemberStore')->name('assign_member_store');
    Route::get('training/request','TrainingController@trainingRequest')->name('training_request');
    Route::get('training/approve/reject/{id}','TrainingController@trainingStatus')->name('training_status');
    // ==================================== training end ===============================================

    // ====================================Severance Package start===============================================
    // Route::get('/expanse/list', ['middleware' => ['role:admin'], 'uses' => 'ExpanseController@expanse_list'])->name('expanse_list');
    Route::get('/expense/list','ExpanseController@expanse_list')->name('expanse_list');
    Route::post('/expanse/add','ExpanseController@expanse_add')->name('expanse_add');
    Route::get('expanse_edit/{id}','ExpanseController@expanse_edit')->name('expanse_edit');
    Route::post('/expanse/update','ExpanseController@expanse_update')->name('expanse_update');
    Route::get('/expense/employee_wise_expanse_summary','ExpanseController@employee_wise_expanse_summary')->name('employee_wise_expanse_summary');
    Route::get('/expense/employee_wise_expanse_history_monthly/{id}','ExpanseController@employee_wise_expanse_history_monthly')->name('expense.employee_wise_expanse_history_monthly');
    Route::get('/expense/employee_wise_expanse_history_monthly_details/{id}/{expanse_date}','ExpanseController@employee_wise_expanse_history_monthly_details')->name('expense.employee_wise_expanse_history_monthly_details');


    Route::get('/expense_status/list','ExpanseController@expense_status_list')->name('expense_status_list');
    Route::get('expense_status_edit/{id}','ExpanseController@expense_status_edit')->name('expense_status_edit');
    Route::post('/expense_status/update','ExpanseController@expense_status_update')->name('expense_status_update');


    Route::get('employee_wise_expanse/report','ExpanseController@employee_wise_expanse_report')->name('employee_wise_expanse_report');
    Route::post('employee_wise_expanse/report/date','ExpanseController@employee_wise_expanse_report_date')->name('employee_wise_expanse_report_date');
    // ====================================Severance Package end=================================================


    // ====================================meeting start===============================================
    Route::get('/meeting/list','MeetingController@meeting_list')->name('meeting_list');
    Route::post('/meeting/add','MeetingController@meeting_add')->name('meeting_add');
    Route::get('/meeting/edit/{id}','MeetingController@meeting_edit')->name('meeting_edit');
    Route::post('/meeting/update','MeetingController@meeting_update')->name('meeting_update');
    Route::post('/meeting/delete/{id}','MeetingController@meeting_delete')->name('meeting_delete');
    // ====================================meeting end=================================================

    // ==================================== Announcement Start===============================================

    Route::get('/announcement/list','AnnouncementController@announcement_list')->name('announcement_list');
    Route::post('/announcement/add','AnnouncementController@announcement_add')->name('announcement_add');
    Route::get('/announcement/edit/{id}','AnnouncementController@announcement_edit')->name('announcement_edit');
    Route::POST('/announcementupdate','AnnouncementController@announcement_update')->name('announcement_update');
    Route::POST('/announcement/delete/{id}','AnnouncementController@announcement_delete')->name('announcement_delete');
    Route::get('/announcement/branch','AnnouncementController@get_announcement_branch')->name('announcement.get_announcement_branch');
    // ==================================== Announcement End===============================================



    // ==================================== EmployeeAssets start===============================================
    Route::get('employee_assets/list','EmployeeAssets@employee_assets_list')->name('employee_assets_list');
    Route::post('employee_assets/add','EmployeeAssets@employee_assets_add')->name('employee_assets_add');
    Route::get('employee_assets_edit/{id}','EmployeeAssets@employee_assets_edit')->name('employee_assets_edit');
     Route::post('employee_assets/update','EmployeeAssets@employee_assets_update')->name('employee_assets_update');
    // Route::get('branch/employee/{id}','EmployeeAssets@employeeId');

        Route::get('/ajax/get_all_employee_assets','EmployeeAssets@get_employeegroup_assets')->name('ajax.get_employeegroup_assets');
    // ==================================== EmployeeAssets  end=================================================



        // ==================================== FestivalLeave start===============================================
      Route::get('festival_leave/list','FestivalLeave@festival_leave_list')->name('festival_leave_list');
      Route::post('festival_leave/add','FestivalLeave@festival_leave_add')->name('festival_leave_add');
      Route::get('festival_leave_edit/{id}','FestivalLeave@festival_leave_edit')->name('festival_leave_edit');
      Route::post('festival_leave/update','FestivalLeave@festival_leave_update')->name('festival_leave_update');


      Route::get('/ajax/get_all_employee_assets','FestivalLeave@get_employeegroup_assets')->name('ajax.get_employeegroup_assets');

      Route::get('listemployee/festival_leave/list','FestivalLeave@festival_leave_list_listemployee')->name('festival_leave_listemployee');
    // ==================================== FestivalLeave  end=================================================


    // ==================================== meeting_employee start===============================================
    Route::get('/meeting_employee/list','MeetingEmployee@meeting_employee_list')->name('meeting_employee_list');
    Route::post('/meeting_employee/add','MeetingEmployee@meeting_employee_add')->name('meeting_employee_add');
    Route::get('meeting_employee_edit/{id}','MeetingEmployee@meeting_employee_edit')->name('meeting_employee_edit');
    Route::post('/meeting_employee/update','MeetingEmployee@meeting_employee_update')->name('meeting_employee_update');
    Route::get('branch/meeting/employee/{id}','MeetingEmployee@meetingemployeeId');
    Route::get('/ajax/meeting/get_all_employee','MeetingEmployee@get_meeting_employeegroup')->name('ajax.get_meeting_employeegroup');
    // ==================================== meeting_employee  end=================================================





    // ==================================== employee report start ===============================================
    Route::get('report/employee/report','EmployeeReportController@index')->name('employee_report');
    Route::get('report/search/employee','EmployeeReportController@searchEmployee')->name('employee_search');
    Route::get('report/employee/list','EmployeeReportController@employeeList');
    Route::get('search/employee/profile/','EmployeeReportController@SearchProfileEmployee');
    Route::get('report/branch/employee/','EmployeeReportController@branch_wise_employee')->name('report.branch_employee');
    Route::get('report/department/employee/','EmployeeReportController@department_wise_employee')->name('report.department_employee');
    Route::get('report/designation/employee/','EmployeeReportController@designation_wise_employee')->name('report.designation_employee');
    Route::post('report/branch/employee/show','EmployeeReportController@branch_wise_employee_show');
    Route::post('report/department/employee/show/','EmployeeReportController@department_wise_employee_show');
    Route::get('report/designation/employee/ajax/{id}','EmployeeReportController@designation_wise_employee_ajax');
    Route::post('report/designation/employee/show','EmployeeReportController@designation_wise_employee_show');
    Route::post('report/department/employee/show','EmployeeReportController@department_wise_employee_show');
    // ==================================== employee report end=================================================


   // ==================================== project report start=================================================
    Route::get('report/project/','ProjectReportController@index')->name('report.report_project');
    Route::get('report/project/search','ProjectReportController@projectSearch')->name('project_search');
    Route::post('report/branch/project/show','ProjectReportController@projectPreviewDownload');
    Route::post('report/branch/project/hign/show','ProjectReportController@projectHighPreviewDownload');
    Route::post('report/branch/project/low/show','ProjectReportController@projectLowPreviewDownload');
    Route::get('ajax/get_project/{id}','ProjectReportController@projectList_getajax');
    Route::get('report/project/high','ProjectReportController@projectHigh')->name('high_priority_project');
    Route::get('ajax/get_high_project/{id}','ProjectReportController@projectList_high');
    Route::get('report/project/low','ProjectReportController@projectLow')->name('low_priority_project');
    Route::get('ajax/get_low_project/{id}','ProjectReportController@projectList_low');
    Route::get('report/project/datewise','ProjectReportController@project_date_wise')->name('report.project_datewise');
    Route::post('report/project/datewise/preview','ProjectReportController@project_date_wise_preview_download');
    Route::get('report/project/details/profile/{id}','ProjectReportController@project_report_details_profile');
   // ==================================== project report end=================================================


  // ==================================== Client report start=================================================
    Route::get('report/client/','ClientReportController@index')->name('report.client_view');
    Route::get('report/client/list','ClientReportController@clientList')->name('report.report_client_list');
    Route::post('report/client/list/preview/download','ClientReportController@clientListPreviewPdf');
    Route::get('report/client/project','ClientReportController@clientProject')->name('report.report_client_project');
    Route::post('report/client/project/list','ClientReportController@clientProjectList');
  // ==================================== Client report end=================================================

   // ==================================== Meeting report  start===============================================
      Route::get('report/meeting','MeetingReportController@index')->name('report.report_meeting');
      Route::get('report/meeting/branch_wise_ajax/{id}','MeetingReportController@ajax_branch_meeting');
      Route::post('report/meeting/preview','MeetingReportController@meeting_report_preview_download');
   //==================================== Meeting report  end===============================================


      // ==================================== Training report  start===============================================
      Route::get('report/training','TrainingReportController@index')->name('report.report_training');
      Route::get('report/datewise/training','TrainingReportController@datewiseTraining')->name('report.report_date_wise_training');
      Route::get('report/training/request','TrainingReportController@trainingRequest');
      Route::post('report/training/date/wise','TrainingReportController@date_wise_training_report');
      Route::post('report/training/request/date/wise','TrainingReportController@date_wise_training_request');
   //==================================== Training report  end===============================================



    // ==================================== festival_bonus start===============================================
    Route::get('/bonus/page','FestivalBonus@festival_bonussinglepage')->name('festival_bonussinglepage');
    Route::get('/performance/bonus','FestivalBonus@performance_bonus')->name('performance_bonus');
    Route::get('/festival/bonus','FestivalBonus@festival_bonus')->name('festival_bonus');
    Route::get('/branch/designation/{id}','FestivalBonus@branchDesignation')->name('branch_designation');
    Route::get('/designation/employee/{id}','FestivalBonus@designationEmployee')->name('designation_employee');
    Route::post('/save/festival/bonus','FestivalBonus@save_festival_bonus')->name('save_festival_bonus');
    // ====================================festival_bonus end  =================================================

    // ====================================Weekleave start===============================================
    Route::get('/Process_status/list','ProcessStatus@Process_status_list')->name('Process_status_list');
    Route::get('Process_status_edit/{id}','ProcessStatus@Process_status_edit')->name('Process_status_edit');
    Route::post('/Process_status/update','ProcessStatus@Process_status_update')->name('Process_status_update');
    // ====================================Process_status end=================================================

    // salaray report download
    Route::get('/Process_salary/report','ClientReportController@Process_salary_report')->name('Process_salary_report');



     // ==================================== travel start===============================================
      //  Route::get('/travel','Travel@travel_create')->name('travel_create');
      //  Route::get('/branch/department_id/{id}','Travel@branchDepartment')->name('branch_department');
      //  Route::get('/test','Travel@test')->name('test');
    // ====================================travel end  =================================================




     // ====================================Employee Panel Start===============================================
       Route::get('employee/panel/profile','EmployeeController@employeeProfileForEmployeePanel');
       Route::get('employee/panel/task/list','EmployeeController@employeeTaskList')->name('employee_panel_task_list');
       Route::get('employee/panel/training/list','EmployeeController@employeeTrainingList')->name('employee_panel_training_list');
       Route::get('employee/panel/file/share/list','EmployeeController@employeeFilesheringList')->name('employee_panel_file_share_list');
       Route::get('employee/panel/meeting/list','EmployeeController@employeemeetingList')->name('employee_panel_meetingg_list');
       Route::get('system/announcement/{id}','AnnouncementController@announcements_list');
       Route::get('employee/panel/leave/request','EmployeeController@employeeLeaveRequest')->name('employee_panel_leave_request');
       Route::get('employee/panel/task/edit/{id}','EmployeeController@employeeTaskViewEdit')->name('employee_panel_task_edit_view');
       Route::post('employee/panel/task/update','EmployeeController@employeeTaskViewupdate')->name('employee_panel_task_update_view');

    // ====================================Employee Panel End===============================================

    // --------------- my profile ---------------//
    Route::get('employee/profile','EmployeeController@myProfile')->name('myProfile');
    // --------------- my profile edit ---------------//
    // ====================================Complain Panel Start===============================================
    Route::get('/complain/create','ComplainController@index')->name('complain.new_complain');
    Route::post('/complain/submit','ComplainController@complain_submit')->name('complain.submit');
    Route::get('/complain/list','ComplainController@complain_list')->name('complain.complain_list');
    // ====================================Complain Panel End===============================================


     // ====================================Leave Report Start===============================================
     Route::get('report/leave','LeaveReportController@index')->name('report.leave');
     Route::get('report/leave/month','LeaveReportController@currentMonthLeave')->name('report.current.month.leave');
     Route::get('report/leave/date/wise','LeaveReportController@date_wise_leave_report')->name('report.date.wise.leave');
     Route::post('report/leave/date/wise/show','LeaveReportController@date_wise_leave_report_show');
     Route::get('report/leave/date/wise/type','LeaveReportController@date_wise_leave_report_type')->name('leave_report_type_datewise');
     Route::post('report/leave/date/wise/type/show','LeaveReportController@date_wise_leave_report_type_show');
   // ====================================Leave Report End===============================================

    // ====================================Leave Report Start===============================================
    Route::get('chat_list','ChatController@chat_list')->name('chat_list');

    // ====================================Leave Report End===============================================

    Route::get('/theme_list','ThemeController@theme_list')->name('theme_list');
    Route::POST('/change_style','ThemeController@changeStyle')->name('change_style');





});





