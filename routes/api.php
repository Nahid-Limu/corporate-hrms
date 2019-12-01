<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();


// });


 // =====================================   Register ============================================

Route::post('/register','Api\AuthController@register');
 // =====================================  End Register ============================================

 // =====================================   login ============================================

Route::post('/login','Api\AuthController@login');
 // =====================================  End  login ============================================



Route::group(['middleware' => 'auth:api'], function(){
 // =====================================   Logout ============================================

 Route::get('logout', 'Api\AuthController@logout');
 // =====================================  End  Logout ============================================

 // =====================================   Dashboard ============================================

 Route::get('admin/dashboard', 'Api\adminPanelController@adminDashboard');
 // =====================================  End  Dashboard ============================================

 // =====================================   All Employee Profile ============================================

 Route::get('admin/allemployee/{id}/{dpid?}', 'Api\adminPanelController@adminallEmployee');
 Route::get('admin/employee_branch/{id}', 'Api\adminPanelController@employee_branch');
 Route::get('admin/allemployee/designation/{id}/{designationid?}', 'Api\adminPanelController@admindesignationallEmployee');
 // =====================================   End All Employee Profile ============================================

 // =====================================   Employee Profile ============================================

 Route::get('admin/employee/profile/{id}','Api\adminPanelController@adminEmployeeProfile');
 // =====================================  End Employee Profile ============================================

 // =====================================  Client List ============================================

 Route::post('admin/report/client/list/preview/{id}','Api\adminPanelController@adminClientList');
 // =====================================  End Client List ============================================

 // =====================================   client Project List ============================================

 Route::post('admin/report/client/project/list/{id}','Api\adminPanelController@adminclientProjectList');
 // =====================================  End client Project List ============================================

 // =====================================  Announcement List ============================================

 Route::get('admin/announcement/list/{id}','Api\adminPanelController@adminannouncementList');
 // =====================================  End Announcement List ============================================

 // =====================================  Meeting List ============================================

 Route::get('admin/meeting/list/{id}','Api\adminPanelController@adminMeetingList');
 // =====================================  End Meeting List ============================================



 // =====================================  adminindIvidualAttendanceReport Data ============================================

 Route::post('admin/report/individual_attendance_report_data/{id}','Api\adminPanelController@adminindIvidualAttendanceReportData');
 // =====================================  End adminindIvidualAttendanceReport Data ============================================

 // =====================================  Branchget Employee ============================================

 Route::get('admin/employee/branch/{id}','Api\adminPanelController@getBranchgetEmployee');
 // ===================================== End Branchget Employee ============================================


 // =====================================  Department Employee ============================================

 Route::get('admin/employee/department/{id}','Api\adminPanelController@getDepartmentEmployee');
 // ===================================== End Department Employee ============================================


 // =====================================  Designation Employee ============================================

 Route::get('admin/employee/designation/{id}','Api\adminPanelController@getDesignationEmployee');
 // ===================================== End Designation Employee ============================================


 // =====================================  employeeWise  Expanse History Monthly ============================================

//  Route::get('admin/allemployee/', 'Api\adminPanelController@adminallEmployee');

 Route::get('admin/employee/salary/list/{id}/{dpid?}','Api\adminPanelController@empSalaryList');
 Route::get('branch/employee/salary/list/{id}/{dpid?}','Api\BrancheManagerPanelController@empSalaryList');
 // ===================================== End employeeWise  Expanse History Monthly ============================================


 // =====================================  employeeWise  Expanse History Monthly ============================================

 Route::post('admin/expense/employee_wise_expanse_history_monthly','Api\adminPanelController@employeeWiseExpanseHistoryMonthly');
 // ===================================== End employeeWise  Expanse History Monthly ============================================

// =====================================  employeeWise Expanse History Monthly Details ============================================

 Route::post('admin/expense/employee_wise_expanse_history_monthly_details','Api\adminPanelController@employeeWiseExpanseHistoryMonthlyDetails');
// ===================================== End employeeWise Expanse History Monthly Details ============================================


// ===================================== Employee Daily Absent Report Data ============================================

Route::post('admin/report/absent_report_data','Api\adminPanelController@daily_absent_report_data');

// ===================================== End Employee Daily Absent Report Data ============================================


// ===================================== Employee Late Report Data ============================================

Route::post('admin/report/late_report_data','Api\adminPanelController@late_report_data');
// ===================================== End Employee Late Report Data ============================================


// ===================================== Search Employee ============================================

Route::get('admin/search_employee','Api\adminPanelController@searchEmployee');

// ===================================== End Search Employee ============================================


// ===================================== Leave Status Pending ============================================


Route::get('admin/leave/status/pending/{id}','Api\adminPanelController@adminLeaveStatusPending');

// ===================================== End Leave Status Pending ============================================

// ===================================== Leave Status leave_status_approve ============================================


Route::get('admin/leave_status_approve/{id}','Api\adminPanelController@leave_status_approve');

// ===================================== End Leave Status leave_status_approve ============================================
// ===================================== Leave Status leave_status_rejected ============================================


Route::get('admin/leave_status_rejected/{id}','Api\adminPanelController@leave_status_rejected');

// ===================================== End Leave Status leave_status_rejected ============================================


// =====================================  Leave Status Approved ============================================

 Route::get('admin/leave/status/approved/{id}','Api\adminPanelController@adminLeaveStatusApproved');
// ===================================== End  Leave Status Approved ============================================


// =====================================  Leave Status Reject ============================================

 Route::get('admin/leave/status/reject/{id}','Api\adminPanelController@adminLeaveStatusReject');
// ===================================== End Leave Status Reject ============================================


////////////////////////////////////////  Settings ////////////////////////////////////////////////////

// ===================================== allBranch ============================================

 Route::get('allbranch','Api\SettingsController@allBranch');
 Route::get('manager/branch','Api\SettingsController@manager_branch');
// ===================================== End allBranch ============================================

// ===================================== allDepartment ============================================

 Route::get('alldepartment','Api\SettingsController@allDepartment');
// ===================================== End allDepartment =========================================


// ===================================== allDesignation ============================================

 Route::get('alldesignation','Api\SettingsController@allDesignation');
// ===================================== End allDesignation =========================================


////////////////////////////////////////  Employee////////////////////////////////////////////////////

// ===================================== employeeTaskList ============================================

 Route::get('employee/employeetasklist','Api\EmployeeController@employeeTaskList');
// ===================================== End employeeTaskList =========================================


// =====================================  employeeProfile =========================================

Route::get('employee/profile','Api\EmployeeController@myProfile');
// ===================================== End memployeeyProfile =========================================

// =====================================  employeemeetingList =========================================

 Route::get('employee/panel/meeting/list','Api\EmployeeController@employeemeetingList');
// =====================================  End employeemeetingList =====================================

// =====================================   Assign Project List Employee =====================================

Route::get('employee/assign/project/list','Api\EmployeeController@assignMemberProject');
// =====================================  End Assign Project List Employee =====================================



 // =====================================  Employee Salary List ============================================

 Route::get('employee/salary/list','Api\EmployeeController@loginEmpSalaryList');
 // ===================================== End Employee Salary List ============================================

 // =====================================Announcemen tList ============================================

Route::get('employee/announcement/list','Api\EmployeeController@announcementList');
 // ===================================== End Announcemen tList ============================================



 // ===================================== Leave Status Pending ============================================

Route::get('employe/leave/status/pending','Api\EmployeeController@employeeLeaveStatusPending');

// ===================================== End Leave Status Pending ============================================

 // ===================================== Leave Status Pending ============================================

Route::get('employe/leave/status/approved','Api\EmployeeController@employeLeaveStatusApproved');

// ===================================== End Leave Status Pending ============================================


 // ===================================== Leave Status Pending ============================================

Route::get('employe/leave/status/rejected','Api\EmployeeController@employeLeaveStatusRejected');

// ===================================== End Leave Status Pending ============================================



 // ===================================== employe individual_attendance_data ============================================

 Route::post('employe/individual_attendance_data','Api\employeeController@individual_attendance');
 Route::post('employee/report/late_report_data','Api\employeeController@late_report_data');
 Route::post('employee/report/absent_report_data','Api\employeeController@absent_report_data');

// ===================================== End employe individual_attendance_data ============================================






// =====================================   Dashboard ============================================

 Route::get('employe/dashboard', 'Api\employeeController@employeDashboard');
 // =====================================  End  Dashboard ============================================


////////////////////////////////////BrancheManager////////////////////////////////////////

// =====================================   All Employee Profile ============================================

 Route::get('branchemanager/dashboard', 'Api\BrancheManagerPanelController@BrancheDashboard');
//  Route::get('branchemanager/allemployee', 'Api\BrancheManagerPanelController@BrancheManagerallEmployee');




// ===================================== Leave Status Pending ============================================


Route::get('branchemanager/leave/status/pending','Api\BrancheManagerPanelController@branchemanagerLeaveStatusPending');

// ===================================== End Leave Status Pending ============================================

// ===================================== Leave Status leave_status_approve ============================================


Route::get('branchemanager/leave_status_approve','Api\BrancheManagerPanelController@branchemanagerLeaveStatusApproved');

// ===================================== End Leave Status leave_status_approve ============================================
// ===================================== Leave Status leave_status_rejected ============================================


Route::get('branchemanager/leave_status_rejected','Api\BrancheManagerPanelController@branchemanagerLeaveStatusReject');

// ===================================== End Leave Status leave_status_rejected ============================================


// ===================================== Leave Status leave_status_approve ============================================


Route::get('branchemanager/leave_status_approve/{id}','Api\BrancheManagerPanelController@leave_status_approve');

// ===================================== End Leave Status leave_status_approve ============================================
// ===================================== Leave Status leave_status_rejected ============================================


Route::get('branchemanager/leave_status_rejected/{id}','Api\BrancheManagerPanelController@leave_status_rejected');

// ===================================== End Leave Status leave_status_rejected ============================================


 // =====================================  Client List ============================================

 Route::get('branche/report/client/list/preview','Api\BrancheManagerPanelController@brancheClientList');
 // =====================================  End Client List ============================================



  // =====================================  brancheclientProjectList ============================================

 Route::get('branche/report/client/project/list','Api\BrancheManagerPanelController@brancheclientProjectList');
 // =====================================  End brancheclientProjectList ============================================

 // =====================================  Announcement List ============================================

 Route::get('branche/announcement/list','Api\BrancheManagerPanelController@branchannouncementList');
 // =====================================  End Announcement List ============================================

 // =====================================  Meeting List ============================================

 Route::get('branch/meeting/list','Api\BrancheManagerPanelController@branchMeetingList');
 // =====================================  End Meeting List ============================================






 // ===================================== employe individual_attendance_data ============================================

 Route::post('branche/individual_attendance_data','Api\BrancheManagerPanelController@individual_attendance');

 // =====================================  End Meeting List ============================================



  // =====================================  employeeWise  Expanse History Monthly ============================================

 Route::post('brance/expense/employee_wise_expanse_history_monthly','Api\BrancheManagerPanelController@brancemployeeWiseExpanseHistoryMonthly');
 // ===================================== End employeeWise  Expanse History Monthly ============================================



  // =====================================  employeeWise  Expanse History Monthly ============================================



 Route::get('brance/employee/salary/list/{dpid?}/{des?}','Api\BrancheManagerPanelController@empSalaryList');
 // ===================================== End employeeWise  Expanse History Monthly ============================================


 // ===================================== employeeWise  Bramche name  ============================================
 Route::get('login_branch_name','Api\BrancheManagerPanelController@get_login_branch_name');
 // ===================================== End employeeWise  Bramche name  ============================================



  Route::get('branch/employee/department/{id}', 'Api\BrancheManagerPanelController@department_employee');

  Route::get('branch/employee/designation/{id}', 'Api\BrancheManagerPanelController@designation_employee');

   // =====================================   Employee Profile ============================================

 Route::get('brance/employee/profile/{id}','Api\BrancheManagerPanelController@brancheEmployeeProfile');
 // =====================================  End Employee Profile ============================================

//////////////////////////////////// .end BrancheManager////////////////////////////////////////

 Route::get('allemployee', 'Api\employeeController@allEmployee');


 Route::get('expansecategory_list', 'Api\employeeController@expansecategory_list');

 Route::post('employee/expense/employee_wise_expanse_history_details','Api\employeeController@employeeWiseExpanseHistoryDetails');
 Route::post('employe/add/expense','Api\employeeController@expanse_add');
 Route::post('employe/leave_application','Api\employeeController@leave_application');
 Route::get('employe/leave_type','Api\employeeController@get_leave_type');

//  Route::get('employee_dashboard', 'Api\employeeController@employeeDashboard');
 });


