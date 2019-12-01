<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use Carbon\Carbon;
use Validator;
use App\Repositories\Settings;

class SalaryController extends Controller
{
    protected $settings;

    public function __construct()
    {
        // create object of settings class
        $this->settings = new Settings();
    }

    /**
     * assigin salary view
     */
    public function salary_assign_view()
    
    {
        $this->checkuserRole(['admin','super-admin','branch-manager'],'');
        return view('backend.salary.salary_assign');

    }

    /**
     * Get employee salary details in table
     */
    public function emp_salary_details($id)
    {
        $emp_salary_details =  DB::table('tb_payroll_salary')
            ->leftJoin('tb_employee','tb_payroll_salary.emp_id','=','tb_employee.id')
            ->leftJoin('tb_salary_grade','tb_payroll_salary.grade_id','=','tb_salary_grade.id')
            ->select(DB::raw("CONCAT(tb_employee.emp_first_name,' ',tb_employee.emp_lastName) as emp_name"),
                'tb_salary_grade.grade_name','tb_payroll_salary.basic_salary','tb_payroll_salary.house_rant',
                'tb_payroll_salary.medical','tb_payroll_salary.transport','tb_payroll_salary.food','tb_payroll_salary.other',
                'tb_payroll_salary.total_salary','tb_payroll_salary.provident_fund_percent','tb_payroll_salary.provident_fund_amount',
                DB::raw("(SELECT total_salary - provident_fund_amount FROM tb_payroll_salary  WHERE emp_id = $id) as net_salary")
            )
            ->where('tb_payroll_salary.emp_id', $id)
            ->get();
        //dd($emp_salary_details);
        if (count($emp_salary_details) > 0) {
            return response()->json(['success' => $emp_salary_details]);
        }else {
            return response()->json(['error' => 'No Salary Assigned']);
        }
    }


    /**
     * assign salary to employee
     */
    public function salary_assign(Request $request)
    {



        $check_exist =  DB::table('tb_payroll_salary')->where('emp_id',$request->employee_id)->first();
        $provident_percent =  $request->provident_fund_percent;

        if ($check_exist) {
            $total = $request->basic+$request->house+$request->medical+$request->transportation+$request->food+$request->other;
            $provident_amount = ($total * $provident_percent) /100;
            $salary_assign = DB::table('tb_payroll_salary')
                ->where('id',$check_exist->id)
                ->update([
                    'grade_id'=>$request->salary_grade_id,
                    'basic_salary'=>$request->basic,
                    'house_rant'=>$request->house,
                    'medical'=>$request->medical,
                    'transport'=>$request->transportation,
                    'food'=>$request->food,
                    'other'=>$request->other,
                    'total_salary'=>$total,
                    'provident_fund_percent'=>$provident_percent,
                    'provident_fund_amount'=>$provident_amount,
                    'created_at'=>Carbon::now()->toDateTimeString(),
                    'updated_at'=>Carbon::now()->toDateTimeString()
                ]);

            if ($salary_assign) {
                return response()->json(['success' => 'Salary has been successfully assigned']);
            }
        }else {
            $total = $request->basic+$request->house+$request->medical+$request->transportation+$request->food+$request->other;
            $provident_amount = ($total * $provident_percent) /100;
            $salary_assign = DB::table('tb_payroll_salary')->insert([
                'emp_id'=>$request->employee_id,
                'grade_id'=>$request->salary_grade_id,
                'basic_salary'=>$request->basic,
                'house_rant'=>$request->house,
                'medical'=>$request->medical,
                'transport'=>$request->transportation,
                'food'=>$request->food,
                'other'=>$request->other,
                'total_salary'=>$total,
                'provident_fund_percent'=>$provident_percent,
                'provident_fund_amount'=>$provident_amount,
                'created_at'=>Carbon::now()->toDateTimeString(),
                'updated_at'=>Carbon::now()->toDateTimeString()
            ]);

            if ($salary_assign) {
                return response()->json(['success' => 'Salary has been successfully assigned']);
            }
        }
    }

    /**
     * Get employee salary list in table
     */
    public function emp_salary_list()
    {
        $emp_salary_list = DB::table('tb_payroll_salary')->orderBy('tb_payroll_salary.id', 'desc')
            ->leftJoin('tb_employee','tb_payroll_salary.emp_id','=','tb_employee.id')
            ->leftJoin('tb_salary_grade','tb_payroll_salary.grade_id','=','tb_salary_grade.id')
            ->select('tb_payroll_salary.id','tb_employee.employeeId',
                DB::raw("CONCAT(tb_employee.emp_first_name,' ',tb_employee.emp_lastName) as emp_name"),
                'tb_salary_grade.grade_name','tb_payroll_salary.basic_salary','tb_payroll_salary.total_salary',
                'tb_payroll_salary.provident_fund_percent','tb_payroll_salary.provident_fund_amount'
            )
            ->get();
        //dd($emp_salary_list);
        if(request()->ajax())
        {
            return datatables()->of($emp_salary_list)
                ->addColumn('action', function($data){
                    $button = '<button type="button" name="view" id="'.$data->employeeId.'" class="view btn btn-blue btn-xs" data-toggle="modal" data-target="#viewSalary" data-placement="top" title="View"><i class="fa fa-eye"></i></button>';
                    $button .= '&nbsp;&nbsp;';
                    $button .= '<button type="button" name="edit" id="'.$data->id.'" class="edit btn btn-blue btn-xs" data-toggle="modal" data-target="#editSalary" data-placement="top" title="Edit"><i class="fa fa-edit"></i></button>';
                    return $button;
                })
                ->addColumn('employeeId', function($data){
                    $button = '<a href="'.route('employee.profile', base64_encode($data->id)).'" target="_blank" data-toggle="tooltip" data-placement="top" title="View Profile" style="color: #319DB5"><b>'.$data->employeeId.'</b></a>';
                    $button .= '&nbsp;&nbsp;';

                    return $button;
                })
                ->editColumn('provident_fund_percent', function ($data) {
                    return $data->provident_fund_percent.' %';
                })

                ->editColumn('net_salary', function ($data) {
                    return $data->total_salary - $data->provident_fund_amount;
                })

                ->rawColumns(['employeeId','action'])
                ->make(true);
        }

        return view('backend.salary.employee_salary_list');
    }

    /**
     * View employee salary details in modal
     */
    public function employee_salary_details($id)
    {
        $emp_salary_details = DB::table('tb_payroll_salary')
            ->leftJoin('tb_employee','tb_payroll_salary.emp_id','=','tb_employee.id')
            ->leftJoin('tb_salary_grade','tb_payroll_salary.grade_id','=','tb_salary_grade.id')
            ->select('tb_payroll_salary.id','tb_employee.employeeId',
                DB::raw("CONCAT(tb_employee.emp_first_name,' ',tb_employee.emp_lastName) as emp_name"),
                'tb_salary_grade.id as grade_id','tb_salary_grade.grade_name','tb_payroll_salary.basic_salary',
                'tb_payroll_salary.house_rant','tb_payroll_salary.medical','tb_payroll_salary.transport',
                'tb_payroll_salary.food','tb_payroll_salary.other','tb_payroll_salary.total_salary',
                'tb_payroll_salary.provident_fund_percent','tb_payroll_salary.provident_fund_amount',
                DB::raw("(SELECT total_salary - provident_fund_amount FROM tb_payroll_salary  WHERE emp_id = $id) as net_salary")
            )
            ->where('tb_payroll_salary.id',$id)
            ->first();
        return response()->json($emp_salary_details);
    }

    /**
     * update employee salary details from Salary List modal
     */
    public function employee_salary_update(Request $request)
    {
        $total = $request->edit_basic_salary+$request->edit_house_rant+$request->edit_medical+$request->edit_transport+$request->edit_food+$request->edit_other;
        $update_salary =  DB::table('tb_payroll_salary')
            ->where('id',$request->id)
            ->update(
                [
                    'grade_id' =>$request->salary_grade_id,
                    'basic_salary' =>$request->edit_basic_salary,
                    'house_rant' =>$request->edit_house_rant,
                    'medical' =>$request->edit_medical,
                    'transport' =>$request->edit_transport,
                    'food' =>$request->edit_food,
                    'other' =>$request->edit_other,
                    'total_salary' =>$total

                ]
            );
        if ($update_salary) {
            return response()->json(['success' => 'Salary has been successfully updated']);
        } else {
            return response()->json(['falied' => 'Update Nothing.']);
        }
    }

    /**
     * salary settings view
     */
    public function salary_settings()
    {
        $this->checkuserRole(['admin','super-admin','branch-manager'],'');
        $salary_settings = DB::table('tb_salary_settings')->get(['id','title','status']);
        //dd($salary_settings);
        return view('backend.salary.salary_settings', compact('salary_settings'));
    }

    /**
     * salary settings update
     */
    public function salary_settings_update(Request $request)
    {

        if ($request->on ) {
            $data =  DB::table('tb_salary_settings')
                ->update(
                    [
                        'status' =>0,
                    ]
                );

            foreach ($request->on as $key => $id) {
                $update =  DB::table('tb_salary_settings')
                    ->where('id',$id)
                    ->update(
                        [
                            'status' =>1,
                        ]
                    );
            }
            return response()->json(['success' => 'Settings has been successfully updated.']);
            //return redirect()->back()->with('success','Update Settings');

        }else {
            $data =  DB::table('tb_salary_settings')
                ->update(
                    [
                        'status' =>0,
                    ]
                );
            return response()->json(['success' => 'Settings has been successfully updated.']);
            //return redirect()->back()->with('success','Update Settings');
        }

    }


    /**
     * Process salary view
     */
    public function process_salary_view()
    {

        return view('backend.salary.process_salary');
    }

    /**
     * Process salary process
     */
    public function process_salary($year_month,$test=null)
    {
        $year_month=Carbon::parse($year_month)->toDateString();
        $month = date("m",strtotime($year_month));
        // $year = date('Y', strtotime($year_month));
        $overtime_settings = DB::table('tb_salary_settings')->where('id',1)->first(['status']);
        $late_settings = DB::table('tb_salary_settings')->where('id',2)->first(['status']);
        $absent_settings = DB::table('tb_salary_settings')->where('id',3)->first(['status']);
        $current_month_day=date('t',strtotime($year_month));

        $check_salary_assign = DB::table('tb_payroll_salary')->COUNT();
        if ($check_salary_assign > 0) {

            if ($year_month) {
                $check_salary = DB::table('process_status')
                    ->whereDate('p_satatus_salary_month_year', $year_month)
                    ->where('process_salary_status', 1)
                    ->get();
                if (count($check_salary) > 0) {
                    return response()->json(['falied' => "Salary Process Already Completed."]);


                }
                else {
                    $check_process=DB::table('tb_salary_process')->where('salary_month_year', $year_month)->count();
                    if($check_process>0) {
                        DB::table('tb_salary_process')->where('salary_month_year', $year_month)->delete();
                        DB::table('tb_provident_fund_amount')->where('salary_month_year', $year_month)->delete();
                    }
                    $all_salary = DB::table('tb_payroll_salary')->get();

                    foreach ($all_salary as $key => $salary) {
                        // overtime claculate start
                        if ($overtime_settings->status == 1) {
                            $overtime = DB::table('tb_attendance')
                                ->leftJoin('tb_employee','tb_attendance.emp_id','=','tb_employee.id')
                                ->leftJoin('tb_shift','tb_employee.emp_shift_id','=','tb_shift.id')
                                ->whereMonth('tb_attendance.attendance_date', '=', $month)
                                ->where('tb_attendance.emp_id', '=', $salary->emp_id)
                                ->sum( DB::raw('TIMESTAMPDIFF(HOUR,exit_time,out_time)') );
                        } else {
                            $overtime = 0;
                        }
                        // overtime calculate end

                        // late calculate start
                        if ($late_settings->status == 1) {
                            $late = DB::table('tb_attendance')
                                ->leftJoin('tb_employee','tb_attendance.emp_id','=','tb_employee.id')
                                ->leftJoin('tb_shift','tb_employee.emp_shift_id','=','tb_shift.id')
                                ->whereMonth('tb_attendance.attendance_date', '=', $month)
                                ->where('tb_attendance.emp_id', '=', $salary->emp_id)
                                ->whereRaw('in_time > entry_time')
                                ->COUNT('tb_attendance.id');
                        } else {
                            $late = 0;
                        }

                        // late claculate end

                        // absent claculate start
                        $first_day = Carbon::createFromFormat('Y-m-d', $year_month)->startOfMonth()->toDateString();
                        $last_day = Carbon::createFromFormat('Y-m-d', $year_month)->endOfMonth()->toDateString();

                        if ($absent_settings->status == 1) {
                            $leave = DB::table('tb_leave_application')->where('emp_id',$salary->emp_id)->whereMonth('leave_starting_date', $month)->sum('actual_days');
                            $attendance = DB::table('tb_attendance')->where('emp_id',$salary->emp_id)->whereMonth('attendance_date', $month)->COUNT();
                            $weekend = $this->settings->weekdayCalculator($first_day,$last_day);
                            $working_day = $this->settings->dayCalculator($first_day,$last_day );
                            $absent = $working_day  - ($attendance + $leave);
                        } else {
                            $leave = DB::table('tb_leave_application')->where('emp_id',$salary->emp_id)->whereMonth('leave_starting_date', $month)->sum('actual_days');
                            $attendance = DB::table('tb_attendance')->where('emp_id',$salary->emp_id)->whereMonth('attendance_date', $month)->COUNT();
                            $weekend = $this->settings->weekdayCalculator($first_day,$last_day);
                            $working_day = $this->settings->dayCalculator($first_day,$last_day );
                            $absent = 0;
                        }
                        // absent claculate end

                        //festival leave

                        // $festival_first_day = Carbon::createFromFormat('Y-m-d', $year_month)->startOfMonth()->toDateString();
                        // $festivallast_day = Carbon::createFromFormat('Y-m-d', $year_month)->endOfMonth()->toDateString();


                        // $festival_leave_total = DB::table('tb_festival_leave')->whereMonth('start_date', $month)->COUNT();

                        //tb_festival_leave

                        // festival bonus calculate start
                        $festival_bonus = DB::table('tb_festival_bonus')->where('emp_id',$salary->emp_id)->whereMonth('date', $month)->first(['festival_bonus']);
                        if ($festival_bonus) {
                            $bonus = $festival_bonus->festival_bonus;
                        } else {
                            $bonus = 0;
                        }
                        // festival bonus calculate end



                        $deduction = round($salary->basic_salary/$current_month_day*$absent,2);
                        $Gross_amount = $salary->basic_salary+$salary->house_rant+$salary->medical+$salary->transport+$salary->food+$salary->other;
                        $oneady_amount =  $Gross_amount/$working_day;
                        $working_hour = 8;
                        $hour_amount =  $oneady_amount/$working_hour;

                        $festivalleave = $this->settings->festivalLeaveCalculator($first_day,$last_day);

                        if($test=='reduction_tax'){
                            // $net_salary_p = ($salary->total_salary+$bonus)-$deduction;
                            $net_salary_p = $salary->total_salary;
                            $salary_percentage1 = 0;
                            $salary_percentage2 =0;
                            $salary_percentage3 =0;
                            $salary_percentage4 = 0;
                            $salary_percentage5 =0;

                            $net_salarytax=  $net_salary_p*12;

                            if( $net_salarytax>250000){
                                $net_salarytax1 = $net_salarytax-250000;
                                if($net_salarytax1<400000){
                                    $salary_percentage1= $net_salarytax1*10/100;
                                }
                                if( $net_salarytax1>400000){
                                    $salary_percentage1= 400000*10/100;
                                    $net_salarytax2 = $net_salarytax1-400000;
                                }
                                else{
                                    $net_salarytax2 =0;
                                }
                                if( $net_salarytax2<500000){
                                    $salary_percentage2= $net_salarytax2*15/100;
                                }
                                if( $net_salarytax2>500000){
                                    $salary_percentage2= 500000*15/100;
                                    $net_salarytax3 = $net_salarytax2-500000;
                                }else{
                                    $net_salarytax3 =0;
                                }
                                if( $net_salarytax3<600000){
                                    $salary_percentage3= $net_salarytax3*20/100;
                                }
                                if( $net_salarytax3>600000){
                                    $salary_percentage3= 600000*20/100;
                                    $net_salarytax4 = $net_salarytax3-600000;
                                }
                                else{
                                    $net_salarytax4 =0;
                                }
                                if( $net_salarytax4<3000000){
                                    $salary_percentage4= $net_salarytax4*25/100;
                                }
                                if( $net_salarytax4==3000000){
                                    $salary_percentage4= 3000000*25/100;
                                    $net_salarytax5 = $net_salarytax3-3000000;
                                }else{
                                    $net_salarytax5 =0;
                                }
                                if( $net_salarytax5>3000000){
                                    $salary_percentage5= $net_salarytax5*30/100;
                                }
                            }

                            $bdyear_tax=$salary_percentage1+$salary_percentage2+$salary_percentage3+$salary_percentage4+$salary_percentage5;
                            $bdmonth_tax = $bdyear_tax/12;
                        }

                        else{
                            $bdmonth_tax = 0;
                        }




                        $salary_process[] = [
                            'emp_id'=>$salary->emp_id,
                            'salary_month_year'=>Carbon::parse($year_month)->toDateString(),
                            'grade_id'=>$salary->grade_id,
                            'basic_salary'=>$salary->basic_salary,
                            'house_rant'=>$salary->house_rant,
                            'medical'=>$salary->medical,
                            'transport'=>$salary->transport,
                            'food'=>$salary->food,
                            'other'=>$salary->other,
                            'bonus'=>$bonus,
                            'absent_deduction_amount'=>$deduction,
                            'net_salary'=>($salary->total_salary+$bonus+$overtime*$hour_amount)-($deduction+$bdmonth_tax+$salary->provident_fund_amount),
                            // 'bdtax'=>$bdtax,
                            'bdtax'=>$bdmonth_tax,
                            'working_day'=>$working_day,
                            'present'=>$attendance,
                            'weekend'=>$weekend,
                            'leave'=>$leave,
                            'hour_amount'=>$hour_amount,
                            // 'leave'=>$festival_leave_total,
                            'festivalleave'=>$festivalleave,
                            'overtime'=>$overtime,
                            'late'=>$late,
                            'absent'=>$absent,
                            'status'=>0,
                            'created_at'=>Carbon::now()->toDateTimeString(),
                            'updated_at'=>Carbon::now()->toDateTimeString()
                        ];


                        $tb_provident_fund[] = [
                            'emp_id'=>$salary->emp_id,
                            'salary_month_year'=>Carbon::parse($year_month)->toDateString(),
                            'provident_fund_amount'=>$salary->provident_fund_amount,
                            'provident_fund_percent'=>$salary->provident_fund_percent,
                            'status'=>0,
                            'created_at'=>Carbon::now()->toDateTimeString(),
                            'updated_at'=>Carbon::now()->toDateTimeString()
                        ];


                        $check_salary_process_status = DB::table('process_status')
                            ->whereDate('p_satatus_salary_month_year', $year_month)
                            ->get();
                        //return  $check_salary;
                        if (count($check_salary_process_status) > 0) {


                        }
                        else{

                            //  process_status
                            $salary_process_status = DB::table('process_status')->insert([
                                'p_satatus_salary_month_year'=>Carbon::parse($year_month)->toDateString(),
                                'process_salary_status' => 0,
                                'created_at'  =>Carbon::now()->toDateTimeString(),
                                'updated_at'  =>Carbon::now()->toDateTimeString(),

                            ]);
                        }





                    }
                    DB::table('tb_salary_process')->insert($salary_process);
                    DB::table('tb_provident_fund_amount')->insert($tb_provident_fund);
                    return response()->json(['success' => 'Salary Process has been successfully completed.']);
                }
            }

            else {
                return response()->json(['error' => 'Process Failed']);
            }

        }else {
            return response()->json(['error' => 'Assign Salary First']);
        }

    }
}
