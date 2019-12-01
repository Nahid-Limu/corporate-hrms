<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use Carbon\Carbon;
use Validator;
use App\Repositories\Settings;
class LeaveController extends Controller
{
    protected $settings;

    public function __construct()
    {
        // create object of settings class
        $this->settings = new Settings();
    }
    /**
    * Retive Leave from table and show in blade
    */
    public function leave_list()
    {   
          $this->checkuserRole(['admin','super-admin','branch-manager'],'');

        $leave_list = DB::table('tb_leave_type')->orderBy('id', 'desc')
            ->get(['id','leave_type','total_days','policy','status']);
        if(request()->ajax())
        {
            return datatables()->of($leave_list)
                    ->addColumn('action', function($data){
                        $button = '<button type="button" name="edit" id="'.$data->id.'" class="edit btn btn-blue btn-xs" data-toggle="modal" data-target="#editLeave" data-placement="top" title="Edit"><i class="fa fa-edit"></i></button>';
                        $button .= '&nbsp;&nbsp;';
                        if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('super-admin')){
                        return $button;
                        }
                    })
                    ->rawColumns(['action'])
                    ->addIndexColumn()
                    ->make(true);
        }

        return view('backend.leave.leave_type_list');
    }

    /**
     * add new Branch
     */
    public function leave_add(Request $request)
    {
       $rules = array(
            'leave_type'=>'required|unique:tb_leave_type',
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $leave_create = DB::table('tb_leave_type')->insert([
            'leave_type'=>$request->leave_type,
            'total_days'=>$request->total_days,
            'policy'=>$request->policy,
            'created_at'=>Carbon::now()->toDateTimeString(),
            'updated_at'=>Carbon::now()->toDateTimeString()
        ]);

        if ($leave_create) {
            return response()->json(['success' => 'Leave type has been successfully added.']);
            //return "Department added Successfully";
         } else {
            return 0;
         }
    }

    /**
     * Edit leave modal
     */
    public function leave_edit($id)
    {
        $leave = DB::table('tb_leave_type')->where('id',$id)->first(['id','leave_type','total_days','policy','status']);
        return response()->json($leave);
    }

    /**
     * Update leave
     */
    public function leave_update(Request $request)
    {
        $rules = array(
            'edit_leave_type'=>'required',
        );
        $error = Validator::make($request->all(), $rules);
        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $leave =  DB::table('tb_leave_type')
            ->where('leave_type',$request->edit_leave_type)
            ->first();

        if ($leave) {
            $leave_update =  DB::table('tb_leave_type')
            ->where('id',$request->id)
            ->update(
                [
                    'total_days' =>$request->edit_total_days,
                    'policy' =>$request->edit_policy,
                    'status' =>$request->status
                ]
            );
            if ($leave_update) {
                return response()->json(['success' => 'Leave Type Exist !!! Othrt Information has been successfully updated.']);
                //return "Department added Successfully";
            }else {
                return response()->json(['falied' => 'Update Nothing.']);
            }
        }else {
            $leave_update =  DB::table('tb_leave_type')
            ->where('id',$request->id)
            ->update(
                [
                    'leave_type' =>$request->edit_leave_type,
                    'total_days' =>$request->edit_total_days,
                    'policy' =>$request->edit_policy,
                    'status' =>$request->status
                ]
            );
            if ($leave_update) {
                return response()->json(['success' => 'Information has been successfully updated.']);
                //return "Department added Successfully";
            } else {
                return response()->json(['falied' => 'Update Nothing.']);
            }
        }

    }

    public function leave_assign_view()
    {
          $this->checkuserRole(['admin','super-admin','branch-manager'],'');

        return view('backend.leave.assign_leve');
    }

    /**
     * Get all active leave type.
     */
    public function get_leave_type($id)
    {
        $emp = DB::table('tb_employee')->find($id);
        if ($emp->emp_gender_id == 2) {
            $leave_type = $this->settings->all_leave_type();
            return view('backend.ajax.get_leave_type',compact('leave_type'));
        }else {
            $leave_type = DB::table('tb_leave_type')->where('status',1)->whereNotIn('id', [1])->get();
            return view('backend.ajax.get_leave_type',compact('leave_type'));
        }
    }

    /**
     * maternity_leave days.
     */
    public function maternity_leave($leave_type)
    {
        $days = DB::table('tb_leave_type')->where('id',1)->first(['total_days']);
        return response()->json($days);
    }


    /**
     * Assign leave.
     */
    public function leave_assign(Request $request)
    {
        if($request->hasFile('attachment')) {

                $attachment = $request->file('attachment');
                $new_file = 'leave'.'-'.time().'.'.$attachment->getClientOriginalExtension();
                $attachment->move(public_path('leave_attachment'), $new_file);
                //$asset = asset('leave_attachment').'/'.$new_file ;
                $tb_leave = DB::table('tb_leave_application')->insert([
                            'unique_id'=>time(),
                            'emp_id'=>$request->employee_id,
                            'leave_type_id'=>$request->leave_type_id,
                            'leave_starting_date'=>$request->leave_starting_date,
                            'leave_ending_date'=>$request->leave_ending_date,
                            'actual_days'=>$request->actual_days,
                            'approved_by'=>Auth::user()->id,
                            'attachment'=>$new_file,
                            'description'=>$request->description,
                            'status'=>0,
                            'created_at'=>Carbon::now()->toDateTimeString(),
                            'updated_at'=>Carbon::now()->toDateTimeString()
                        ]);

                        if ($tb_leave) {
                            return response()->json(['success' => 'Leave Assign Successfully.']);
                        } else {
                            return response()->json(['failed' => 'Leave Assign Failed.']);
                        }
                //return response()->json($request->all());

        }else {

            $tb_leave = DB::table('tb_leave_application')->insert([
                            'unique_id'=>time(),
                            'emp_id'=>$request->employee_id,
                            'leave_type_id'=>$request->leave_type_id,
                            'leave_starting_date'=>$request->leave_starting_date,
                            'leave_ending_date'=>$request->leave_ending_date,
                            'actual_days'=>$request->actual_days,
                            'approved_by'=>Auth::user()->id,
                            'description'=>$request->description,
                            'status'=>0,
                            'created_at'=>Carbon::now()->toDateTimeString(),
                            'updated_at'=>Carbon::now()->toDateTimeString()
                    ]);

                    if ($tb_leave) {
                        return response()->json(['success' => 'Leave Assign Successfully.']);
                    } else {
                        return response()->json(['failed' => 'Leave Assign Failed.']);
                    }
        }
    }

    /**
     * Get assign_leave_list
     */
    public function leave_assign_list($id)
    {
        $leave_assign_list = DB::table('tb_leave_application')
        ->leftJoin('tb_employee','tb_leave_application.emp_id','=','tb_employee.id')
        ->leftJoin('tb_leave_type','tb_leave_application.leave_type_id','=','tb_leave_type.id')
        ->leftJoin('users','tb_leave_application.approved_by','=','users.id')
        ->select(DB::raw("CONCAT(tb_employee.emp_first_name,' ',tb_employee.emp_lastName) as emp_name"),'tb_leave_type.leave_type','tb_leave_application.leave_starting_date','tb_leave_application.leave_ending_date','tb_leave_application.actual_days','users.name as approve_by','tb_leave_application.status as request_status')
        ->where('tb_leave_application.emp_id', $id)
        ->get();
        //dd($leave_assign_list);
        if (count($leave_assign_list) > 0) {
            //return response()->json($leave_assign_list);
            return response()->json(['success' => $leave_assign_list]);
        }else {
            return response()->json(['error' => 'No assigned leave']);
        }
    }

    /**
     * check is leave availabe or not for employee
     */
    public function leave_available_check($id,$e_id)
    {
        $leave_type = DB::table('tb_leave_type')->where('id',$id)->where('status',1)->first(['total_days']);
        $total_leave_taken = DB::table('tb_leave_application')
                    ->where('emp_id',$e_id)
                    ->where('leave_type_id',$id)
                    ->whereYear('created_at', Carbon::now()->year)
                    // ->select(DB::raw("SUM(actual_days) as leave_taken"))
                    // ->get();
                    ->sum('actual_days');
        //dd();
        if ($id == 1 && $total_leave_taken ) {
            return response()->json(['maternity' => 'Maternity leave Already taken']);
        }else {
            $available = $leave_type->total_days - $total_leave_taken;
            if ($available <= 0) {
                return response()->json(['error' => 'No leave available']);
            }else {
                return response()->json(['leave' => $available]);
            }

        }

        //return response()->json($total_leave_taken);

    }

    /**
     * Leave approve, reject view
     */
    public function leave_status()
    {   
          $this->checkuserRole(['admin','super-admin','branch-manager'],'');


        if(auth()->user()->hasRole(['admin','super-admin'])){
            $leave_application = DB::table('tb_leave_application')
        ->leftJoin('tb_employee','tb_leave_application.emp_id','=','tb_employee.id')
        ->leftJoin('tb_designations','tb_employee.emp_designation_id','=','tb_designations.id')
        ->leftJoin('tb_leave_type','tb_leave_application.leave_type_id','=','tb_leave_type.id')
        ->leftJoin('users','tb_leave_application.approved_by','=','users.id')
        ->select('tb_leave_application.id','tb_leave_application.unique_id','tb_employee.id as eid','tb_employee.employeeId',
            DB::raw("CONCAT(tb_employee.emp_first_name,' ',tb_employee.emp_lastName) as emp_name"),
            'tb_designations.designation_name','tb_leave_type.leave_type',
            DB::raw('MIN(tb_leave_application.leave_starting_date) as leave_starting_date'),
            DB::raw('MAX(tb_leave_application.leave_ending_date) as leave_ending_date'),
            DB::raw('SUM(actual_days) actual_days'),
            'users.name as approve_by',
            'tb_leave_application.status')
        ->groupBy('unique_id')
        ->get();
       
        return view('backend.leave.leave_status',compact('leave_application'));
        }else{ 

              $branch_id=$this->settings->branchname_loginemployee();
                $leave_application = DB::table('tb_leave_application')
        ->leftJoin('tb_employee','tb_leave_application.emp_id','=','tb_employee.id')
        ->leftJoin('tb_designations','tb_employee.emp_designation_id','=','tb_designations.id')
        ->leftJoin('tb_leave_type','tb_leave_application.leave_type_id','=','tb_leave_type.id')
        ->leftJoin('users','tb_leave_application.approved_by','=','users.id')
        ->select('tb_leave_application.id','tb_leave_application.unique_id','tb_employee.id as eid','tb_employee.employeeId',
            DB::raw("CONCAT(tb_employee.emp_first_name,' ',tb_employee.emp_lastName) as emp_name"),
            'tb_designations.designation_name','tb_leave_type.leave_type',
            DB::raw('MIN(tb_leave_application.leave_starting_date) as leave_starting_date'),
            DB::raw('MAX(tb_leave_application.leave_ending_date) as leave_ending_date'),
            DB::raw('SUM(actual_days) actual_days'),
            'users.name as approve_by',
            'tb_leave_application.status')
             ->where('tb_employee.branch_id', $branch_id->id)
        ->groupBy('unique_id')
        ->get();
        //dd($leave_application);
        return view('backend.leave.leave_status',compact('leave_application'));
        }
   
    }

    /**
     * Leave approve
     */
    public function leave_status_approve($id)
    {

        $leave = DB::table('tb_leave_application')->where('id',$id)->first();

       // dd($leave);
        if ($leave) {

            $start = $leave->leave_starting_date;
            $end = $leave->leave_ending_date;


            if (date("m",strtotime($start)) == date("m",strtotime($end))) {
                $new_end = Carbon::createFromFormat('Y-m-d', $start)->endOfMonth()->toDateString();
                $diff_in_days =  Carbon::createFromFormat('Y-m-d', $start)->subDays(1)->diffInDays(Carbon::createFromFormat('Y-m-d', $end));

                $leave_application =  DB::table('tb_leave_application')
                ->where('id',$id)
                ->update(
                    [
                        'leave_starting_date' =>$start,
                        'leave_ending_date' =>$end,
                        'status' =>1,
                        'approved_by'=>Auth::user()->id,
                        'updated_at'=>Carbon::now()->toDateTimeString()
                    ]
                );

                //dd($start,$end,$diff_in_days);

                if ($leave_application) {
                    return response()->json(['success' => 'Leave Approved Successfully.']);
                } else {
                    return response()->json(['falied' => 'Leave Approved Failed !!!']);
                }


            }elseif (date("m",strtotime($start))+1 == date("m",strtotime($end))) {
                $new_end = Carbon::createFromFormat('Y-m-d', $start)->endOfMonth()->toDateString();
                $total1 =  Carbon::createFromFormat('Y-m-d', $start)->subDays(1)->diffInDays(Carbon::createFromFormat('Y-m-d', $start)->endOfMonth());

                //dd($start,$new_end,$diff_in_days);

                $new_start = Carbon::createFromFormat('Y-m-d', $end)->startOfMonth()->toDateString();
                $total2 =  Carbon::createFromFormat('Y-m-d', $end)->addDays(1)->diffInDays(Carbon::createFromFormat('Y-m-d', $end)->startOfMonth());

                //dd($start,$new_end,$total1,$new_start,$end,$total2);

                $leave_application = [
                    [
                        'unique_id'=>$leave->unique_id,
                        'emp_id'=>$leave->emp_id,
                        'leave_type_id'=>$leave->leave_type_id,
                        'leave_starting_date'=>$start,
                        'leave_ending_date'=>$new_end,
                        'actual_days'=>$total1,
                        'approved_by'=>Auth::user()->id,
                        'attachment'=>$leave->attachment,
                        'description'=>$leave->description,
                        'status'=>1,
                        'created_at'=>Carbon::now()->toDateTimeString(),
                        'updated_at'=>Carbon::now()->toDateTimeString()
                    ],
                    [
                        'unique_id'=>$leave->unique_id,
                        'emp_id'=>$leave->emp_id,
                        'leave_type_id'=>$leave->leave_type_id,
                        'leave_starting_date'=>$new_start,
                        'leave_ending_date'=>$end,
                        'actual_days'=>$total2,
                        'approved_by'=>Auth::user()->id,
                        'attachment'=>$leave->attachment,
                        'description'=>$leave->description,
                        'status'=>1,
                        'created_at'=>Carbon::now()->toDateTimeString(),
                        'updated_at'=>Carbon::now()->toDateTimeString()
                    ]
                ];

                $leave_application = DB::table('tb_leave_application')->insert($leave_application);
                DB::table('tb_leave_application')->where('id',$id)->delete();
                if ($leave_application) {
                    return response()->json(['success' => 'Leave Approved Successfully.']);
                } else {
                    return response()->json(['falied' => 'Leave Approved Failed !!!']);
                }


            } else {
                for($i= date("m",strtotime($start)); $i<=date("m",strtotime($end)); $i++) {

                    if ($i == date("m",strtotime($start))){

                        $new_end = Carbon::createFromFormat('Y-m-d', $start)->endOfMonth()->toDateString();
                        $total1 =  Carbon::createFromFormat('Y-m-d', $start)->subDays(1)->diffInDays(Carbon::createFromFormat('Y-m-d', $start)->endOfMonth());
                        //echo $start.'<br>'.$new_end.'<br>'.$total1.'<br>';

                        $leave_application =  DB::table('tb_leave_application')->insert([
                            'unique_id'=>$leave->unique_id,
                            'emp_id'=>$leave->emp_id,
                            'leave_type_id'=>$leave->leave_type_id,
                            'leave_starting_date'=>$start,
                            'leave_ending_date'=>$new_end,
                            'actual_days'=>$total1,
                            'approved_by'=>Auth::user()->id,
                            'attachment'=>$leave->attachment,
                            'description'=>$leave->description,
                            'status'=>1,
                            'created_at'=>Carbon::now()->toDateTimeString(),
                            'updated_at'=>Carbon::now()->toDateTimeString()
                            ]);

                    }else if ($i == date("m",strtotime($end))){
                        $new_start = Carbon::createFromFormat('Y-m-d', $end)->startOfMonth()->toDateString();
                        $total2 =  Carbon::createFromFormat('Y-m-d', $end)->addDays(1)->diffInDays(Carbon::createFromFormat('Y-m-d', $end)->startOfMonth());
                        //echo $new_start.'<br>'.$end.'<br>'.$total2.'<br>';

                        $leave_application =  DB::table('tb_leave_application')->insert([
                            'unique_id'=>$leave->unique_id,
                            'emp_id'=>$leave->emp_id,
                            'leave_type_id'=>$leave->leave_type_id,
                            'leave_starting_date'=>$new_start,
                            'leave_ending_date'=>$end,
                            'actual_days'=>$total2,
                            'approved_by'=>Auth::user()->id,
                            'attachment'=>$leave->attachment,
                            'description'=>$leave->description,
                            'status'=>1,
                            'created_at'=>Carbon::now()->toDateTimeString(),
                            'updated_at'=>Carbon::now()->toDateTimeString()
                            ]);

                    }else {
                        //$sd = date("Y",strtotime($start))."-".$i;
                        $date = Carbon::parse(date("Y",strtotime($start))."-".$i)->toDateString();
                        //$ed = Carbon::parse(date("Y",strtotime($start))."-".$i)->toDateString();
                        $sd = Carbon::createFromFormat('Y-m-d', $date)->startOfMonth()->toDateString();
                        //echo '<br>';
                        $ed = Carbon::createFromFormat('Y-m-d', $date)->endOfMonth()->toDateString();
                        //echo '<br>';
                        $total =  Carbon::createFromFormat('Y-m-d', $date)->startOfMonth()->subDays(1)->diffInDays(Carbon::createFromFormat('Y-m-d', $date)->endOfMonth()).'<br>';

                        $leave_application =  DB::table('tb_leave_application')->insert([
                            'unique_id'=>$leave->unique_id,
                            'emp_id'=>$leave->emp_id,
                            'leave_type_id'=>$leave->leave_type_id,
                            'leave_starting_date'=>$sd,
                            'leave_ending_date'=>$ed,
                            'actual_days'=>$total,
                            'approved_by'=>Auth::user()->id,
                            'attachment'=>$leave->attachment,
                            'description'=>$leave->description,
                            'status'=>1,
                            'created_at'=>Carbon::now()->toDateTimeString(),
                            'updated_at'=>Carbon::now()->toDateTimeString()
                            ]);
                    }

                }
                DB::table('tb_leave_application')->where('id',$id)->delete();
                return response()->json(['success' => 'Leave Approved Successfully.']);
            }
        } else {
            return 'no record';
        }


    }

    /**
     * Leave reject
     */
    public function leave_status_reject($unique_id)
    {
        $leave_application =  DB::table('tb_leave_application')
                ->where('unique_id',$unique_id)
                ->update(
                    [
                        'status' =>2,
                        'approved_by'=>Auth::user()->id,
                        'updated_at'=>Carbon::now()->toDateTimeString()
                    ]
                );
        if ($leave_application) {
            return response()->json(['success' => 'Leave Reject Successfully.']);
        } else {
            return response()->json(['falied' => 'Leave Reject Failed !!!']);
        }
    }

    /**
     * Leave approve again
     */
    public function leave_status_approve_again($unique_id)
    {
        $leave_application =  DB::table('tb_leave_application')
                ->where('unique_id',$unique_id)
                ->update(
                    [
                        'status' =>1,
                        'approved_by'=>Auth::user()->id,
                        'updated_at'=>Carbon::now()->toDateTimeString()
                    ]
                );
        if ($leave_application) {
            return response()->json(['success' => 'Leave Pending Successfully.']);
        } else {
            return response()->json(['falied' => 'Leave Pending Failed !!!']);
        }
    }
}
