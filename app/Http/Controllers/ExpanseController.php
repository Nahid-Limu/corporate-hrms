<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use Carbon\Carbon;
use Validator;
use App\Repositories\Settings;
use Illuminate\Http\Request;

class ExpanseController extends Controller
{
    
    protected $branche;
    public function __construct()
    {
        // create object of settings class
        $this->branche = new Settings();
    }
  

    // =====================================  EmployeeAssets List  ============================================
    
    public function expanse_list()
    { 
        
        // $this->checkPermission('manage_expense','You have not right to Access'); 

      
        if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('super-admin')){
        $branch_list=$this->branche->all_branch();
        $expanse_category = DB::table('tb_expanse_category')->select('id','category_name')->get();
        $expanse_list = DB::table('tb_expanse')->orderBy('id', 'desc')
        ->leftJoin('users','tb_expanse.created_by','=','users.id')
        ->leftJoin('tb_employee','tb_expanse.created_by','=','tb_employee.id')
        ->leftJoin('tb_expanse_category','tb_expanse.category_id','=','tb_expanse_category.id')
        ->select('tb_expanse.id','tb_expanse.amount','tb_expanse.expanse_date','tb_expanse.status','tb_expanse.attachment','users.name','tb_expanse_category.category_name','tb_employee.emp_first_name','tb_employee.employeeId')
        ->get();

        if(request()->ajax())
        {
            return datatables()->of($expanse_list)
                    ->addColumn('action', function($data){
                        $button = '<button type="button" name="edit" id="'.$data->id.'" class="edit btn btn-blue btn-xs" data-toggle="modal" data-target="#editExpanse" data-placement="top" title="Edit"><i class="fa fa-edit"></i></button>';
                        $button .= '&nbsp;&nbsp;';
                        
                        if( Auth::user()->hasPermission('expense_edit')){
                        return $button;
                        }
                    })
                    // ->editColumn('group_name', function ($group_list) {
                    //     return ucwords($group_list->group_name);
                    // })
                    // ->editColumn('emp_first_name', function ($group_list) {
                    //     return ucwords($group_list->emp_first_name);
                    // })
                    ->rawColumns(['action'])
                    ->addIndexColumn()
                    ->make(true);
        }

        return view('backend.expanse.expanse_list',compact('expanse_category','branch_list'));
        }
        elseif(auth()->user()->hasRole('branch-manager')){

        $branch_list=$this->branche->all_branch();
        $branch_id=$this->branche->branchname_loginemployee();
        $expanse_category = DB::table('tb_expanse_category')->select('id','category_name')->get();
        $expanse_list = DB::table('tb_expanse')->orderBy('id', 'desc')
        ->leftJoin('users','tb_expanse.created_by','=','users.id')
        ->leftJoin('tb_employee','tb_expanse.created_by','=','tb_employee.id')
        ->leftJoin('tb_expanse_category','tb_expanse.category_id','=','tb_expanse_category.id')
        ->select('tb_expanse.id','tb_expanse.amount','tb_expanse.expanse_date','tb_expanse.status','tb_expanse.attachment','users.name','tb_expanse_category.category_name','tb_employee.emp_first_name','tb_employee.employeeId')
        ->where('tb_employee.branch_id', $branch_id->id)
        ->get();

        if(request()->ajax())
        {
            return datatables()->of($expanse_list)
                    ->addColumn('action', function($data){
                        $button = '<button type="button" name="edit" id="'.$data->id.'" class="edit btn btn-blue btn-xs" data-toggle="modal" data-target="#editExpanse" data-placement="top" title="Edit"><i class="fa fa-edit"></i></button>';
                        $button .= '&nbsp;&nbsp;';
                        
                        if( Auth::user()->hasPermission('expense_edit')){
                        return $button;
                        }
                    })
                      ->editColumn('expanse_date', function ($expanse_list) {
                        return date("d/m/Y", strtotime($expanse_list->expanse_date));
                    })
                    ->rawColumns(['action'])
                    ->addIndexColumn()
                    ->make(true);
        }

        return view('backend.expanse.expanse_list',compact('expanse_category','branch_list'));
        }
         elseif(auth()->user()->hasRole('employee')){

        $branch_list=$this->branche->all_branch();
        $branch_id=$this->branche->branchname_loginemployee();
        $expanse_category = DB::table('tb_expanse_category')->select('id','category_name')->get();
        $expanse_list = DB::table('tb_expanse')->orderBy('id', 'desc')
        ->leftJoin('users','tb_expanse.created_by','=','users.id')
        ->leftJoin('tb_employee','tb_expanse.created_by','=','tb_employee.id')
        ->leftJoin('tb_expanse_category','tb_expanse.category_id','=','tb_expanse_category.id')
        ->select('tb_expanse.id','tb_expanse.amount','tb_expanse.expanse_date','tb_expanse.status','tb_expanse.attachment','users.name','tb_expanse_category.category_name','tb_employee.emp_first_name','tb_employee.employeeId')
        ->where('tb_employee.branch_id', $branch_id->id)
        ->where('tb_expanse.created_by','=',auth()->user()->emp_id)
        ->get();

        if(request()->ajax())
        {
            return datatables()->of($expanse_list)
                    ->addColumn('action', function($data){
                        $button = '<button type="button" name="edit" id="'.$data->id.'" class="edit btn btn-blue btn-xs" data-toggle="modal" data-target="#editExpanse" data-placement="top" title="Edit"><i class="fa fa-edit"></i></button>';
                        $button .= '&nbsp;&nbsp;';
                        
                        if( Auth::user()->hasPermission('expense_edit')){
                        return $button;
                        }
                    })
                      ->editColumn('expanse_date', function ($expanse_list) {
                        return date("d/m/Y", strtotime($expanse_list->expanse_date));
                    })
                    ->rawColumns(['action'])
                    ->addIndexColumn()
                    ->make(true);
        }

        return view('backend.expanse.expanse_list',compact('expanse_category','branch_list'));
        }else{
            return '404';
        }


        
    }  



    
    // ===================================== End expanse List  ============================================

    // =====================================  Employee wise expanse summary start ============================================
    
    public function employee_wise_expanse_summary()
    { 
        
        $this->checkPermission('manage_expense','You have not right to Access'); 

        $expanse_list = DB::table('tb_expanse')
        ->leftJoin('users','tb_expanse.created_by','=','users.id')
        ->leftJoin('tb_employee','tb_employee.id','=','users.emp_id')
        ->leftjoin('tb_departments','tb_employee.emp_department_id','=','tb_departments.id')
        ->leftjoin('tb_designations','tb_employee.emp_designation_id','=','tb_designations.id')
        ->leftjoin('tb_branch','tb_employee.branch_id','=','tb_branch.id')
        ->leftJoin('tb_expanse_category','tb_expanse.category_id','=','tb_expanse_category.id')
        ->select('tb_expanse.id','tb_expanse.created_by','tb_expanse.amount','tb_expanse.expanse_date','tb_expanse.status','tb_expanse.attachment','users.name','tb_employee.emp_first_name','tb_employee.emp_lastName','tb_departments.department_name','tb_designations.designation_name','tb_employee.employeeId','tb_branch.branch_name','tb_expanse_category.category_name', DB::raw('SUM(tb_expanse.amount) as totAmount'))
        ->groupBy('tb_expanse.created_by')
        ->get();

        if(request()->ajax())
        {
            return datatables()->of($expanse_list)
                    ->addColumn('action', function($data){
                        $button="<a class='btn btn-primary btn-xs' target='_BLANK'  href='".route('expense.employee_wise_expanse_history_monthly',base64_encode($data->created_by))."' title='View Expense History'><i class='fa fa-eye'></i></a>";
                        return $button;
                    })
                    ->rawColumns(['action'])
                    ->addIndexColumn()
                    ->make(true);
        }

        return view('backend.expanse.employee_wise_expanse_summary');
    } 
    
    // =====================================  Employee wise expanse summary End ============================================


    // =====================================  Employee wise expanse summary Monthly start ============================================
    
    public function employee_wise_expanse_history_monthly($created_by)
    { 
        
        $this->checkPermission('manage_expense','You have not right to Access'); 
        $created_by=base64_decode($created_by);
        $expanse_list = DB::table('tb_expanse')
        ->leftJoin('users','tb_expanse.created_by','=','users.id')
        ->leftJoin('tb_employee','tb_employee.id','=','users.emp_id')
        ->leftjoin('tb_departments','tb_employee.emp_department_id','=','tb_departments.id')
        ->leftjoin('tb_designations','tb_employee.emp_designation_id','=','tb_designations.id')
        ->leftjoin('tb_branch','tb_employee.branch_id','=','tb_branch.id')
        ->leftJoin('tb_expanse_category','tb_expanse.category_id','=','tb_expanse_category.id')
        ->select('tb_expanse.*','tb_employee.emp_first_name','tb_employee.emp_lastName','tb_employee.employeeId','users.name','tb_expanse_category.category_name','tb_branch.branch_name', DB::raw('SUM(tb_expanse.amount) as totAmount'))
        ->where('tb_expanse.created_by','=',$created_by)
        ->groupBy(DB::raw("MONTH(tb_expanse.expanse_date)"),DB::raw("YEAR(tb_expanse.expanse_date)"))
        ->get();

        // dd($expanse_list);
        return view('backend.expanse.employee_wise_expanse_history_monthly',compact('expanse_list'));
    } 
    
    // =====================================  Employee wise expanse summary Monthly End ============================================


    // =====================================  Employee wise expanse summary Monthly start ============================================
    
    public function employee_wise_expanse_history_monthly_details($created_by, $expanse_date)
    { 
        
        $this->checkPermission('manage_expense','You have not right to Access'); 
        $created_by=base64_decode($created_by);
        $created_at=base64_decode($expanse_date);

        $year=date('Y', strtotime($created_at));
        $month=date('m', strtotime($created_at));

        $expanse_list = DB::table('tb_expanse')
        ->leftJoin('users','tb_expanse.created_by','=','users.id')
        ->leftJoin('tb_employee','tb_employee.id','=','users.emp_id')
        ->leftjoin('tb_branch','tb_employee.branch_id','=','tb_branch.id')
        ->leftJoin('tb_expanse_category','tb_expanse.category_id','=','tb_expanse_category.id')
        ->select('tb_expanse.id','tb_expanse.created_by','tb_expanse.remarks','tb_expanse.amount','tb_expanse.expanse_date','tb_expanse.status','tb_expanse.attachment','users.name','tb_employee.emp_first_name','tb_employee.emp_lastName','tb_employee.employeeId','tb_branch.branch_name','tb_expanse_category.category_name')
        ->where('tb_expanse.created_by','=',$created_by)
        ->whereYear('tb_expanse.expanse_date', '=', $year)
        ->whereMonth('tb_expanse.expanse_date', '=', $month)
        ->get();

        // dd($expanse_list);
        return view('backend.expanse.employee_wise_expanse_history_monthly_details',compact('expanse_list'));
    } 
    
    // =====================================  Employee wise expanse summary Monthly End ============================================



    // =====================================  Group Add  ============================================
    public function expanse_add(Request $request)
    {
       $rules = array(
            'category_id'=>'required:tb_expanse', 
            'expanse_date'=>'required:tb_expanse', 
            'amount'=>'required:tb_expanse', 
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }
        // TODO: image not uplode 
        if($request->hasFile('attachment')) {
            $attachment = $request->file('attachment');
            $new_file = 'expanse_attachment' . '-' . time() . '.' . $attachment->getClientOriginalExtension();
            $attachment->move(('expanse_attachment'), $new_file);
             
            $created_by =  $request->emp_id?$request->emp_id:Auth::user()->id;

            if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('super-admin')){
                  $status = 1;
                  $approved_by=Auth::user()->id;
              }else{
                   $status = 0;
                $approved_by=null;
              }
       

                $expanse_create = DB::table('tb_expanse')->insert([
                    'category_id'=>$request->category_id,
                    'expanse_date'=>$request->expanse_date,
                    'amount'=>$request->amount,
                    'remarks'=>$request->remarks,
                    'status'=>$status,
                    'attachment'=>$new_file,
                    // 'created_by'=>Auth::user()->id,
                    'created_by'=>  $created_by,
                    'approved_by'=>$approved_by,
                    'created_at'=>Carbon::now()->toDateTimeString(),
                    'updated_at'=>Carbon::now()->toDateTimeString() 
                ]);

             return response()->json(['success' => 'Expanse has been successfully added.']);
        }
        else{   

              $created_by =  $request->emp_id?$request->emp_id:Auth::user()->id;

            if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('super-admin')){
                  $status = 1;
                  $approved_by=Auth::user()->id;
              }else{
                   $status = 0;
                   $approved_by=null;
              }
            
                $expanse_create = DB::table('tb_expanse')->insert([
                    'category_id'=>$request->category_id,
                    'expanse_date'=>$request->expanse_date,
                    'amount'=>$request->amount,
                    'remarks'=>$request->remarks,
                    'status'=>$status,
                    'created_by'=>$created_by,
                    'approved_by'=>$approved_by,
                    'created_at'=>Carbon::now()->toDateTimeString(),
                    'updated_at'=>Carbon::now()->toDateTimeString() 
                ]);
            return response()->json(['success' => 'Expense information has been successfully added.']);
        }
    } 
    // ===================================== End Group Add  ============================================




    // ===================================== Group Edit  ============================================

    public function expanse_edit($id)
    {   
      
        // $expanse_edit = DB::table('tb_expanse')->where('id',$id)->first(['id','amount','expanse_date','remarks','attachment']);
        // $expanse_edit = DB::table('tb_expanse')
        // ->where('id',$id)->first(['id','category_id','amount','expanse_date','attachment','status','remarks']);
        // return response()->json($expanse_edit);


        $expanse_edit = DB::table('tb_expanse')
             ->leftJoin('tb_expanse_category','tb_expanse.category_id','=','tb_expanse_category.id')
              ->leftJoin('tb_employee','tb_expanse.created_by','=','tb_employee.id')
              ->leftJoin('tb_branch','tb_employee.branch_id','=','tb_branch.id')
             ->select('tb_expanse.id','tb_expanse.amount','tb_expanse.expanse_date',
             'tb_expanse.attachment','tb_expanse.status','tb_expanse.remarks',
             'tb_expanse_category.category_name','tb_expanse_category.id as c_id',
             'tb_expanse.category_id as cate_id','tb_branch.id as branch_id','tb_expanse.created_by as expance_emp_id')
             ->where('tb_expanse.id',$id)
             ->first();
         return response()->json($expanse_edit);
    } 
    // ===================================== End Group Edit  ============================================


    // ===================================== Group Update  ============================================
    
    public function expanse_update(Request $request)
    {
            if($request->hasFile('edit_attachment')) {
            $attachment = $request->file('edit_attachment');
            $new_file = 'expanse_attachment' . '-' . time() . '.' . $attachment->getClientOriginalExtension();
            $attachment->move(('expanse_attachment'), $new_file);

       
            $created_by =  $request->edit_emp_id?$request->edit_emp_id:Auth::user()->id;
            $group_update =  DB::table('tb_expanse')
            ->where('id',$request->id)
            ->update(
                [
                    'category_id'=>$request->edit_category_id,
                    'expanse_date'=>$request->edit_expanse_date,
                    'amount'=>$request->edit_amount,
                    'remarks'=>$request->edit_remarks,
                    'status'=>$request->status,
                    'attachment'=>$new_file,
                    'created_by'=>$created_by,
                    'updated_at'=>Carbon::now()->toDateTimeString() 
                ]);

             return response()->json(['success' => 'Expense information has been successfully updated.']);
        }
        else{ 
            
            
              $created_by =  $request->edit_emp_id?$request->edit_emp_id:Auth::user()->id;

            $group_update =  DB::table('tb_expanse')
            ->where('id',$request->id)
            ->update(
                [
                    'category_id'=>$request->edit_category_id,
                    'expanse_date'=>$request->edit_expanse_date,
                    'amount'=>$request->edit_amount,
                    'remarks'=>$request->edit_remarks,
                    'status' =>$request->status,
                    'created_by'=>$created_by,
                    'updated_at'=>Carbon::now()->toDateTimeString() 
                ]);
            return response()->json(['success' => 'Expense information has been successfully updated.']);
        }
    } 










     public function expense_status_list()
    {   
         $this->checkuserRole(['admin','super-admin','branch-manager'],'');
        $expense_status_list = DB::table('tb_expanse')->orderBy('id', 'desc')
        // ->leftJoin('users','tb_expanse.created_by','=','users.id')
        ->leftJoin('tb_employee','tb_expanse.created_by','=','tb_employee.id')
        ->leftJoin('tb_expanse_category','tb_expanse.category_id','=','tb_expanse_category.id')
        ->select('tb_expanse.id','tb_expanse.expanse_date','tb_expanse.status','tb_expanse.amount','tb_employee.emp_first_name','tb_employee.employeeId','tb_expanse_category.category_name')
         ->where('tb_expanse.status', 0)
        ->get();
        if(request()->ajax())
        {
            return datatables()->of($expense_status_list)
                    ->addColumn('action', function($data){
                        $button = '<button type="button" name="edit" id="'.$data->id.'" class="edit btn btn-blue btn-xs" data-toggle="modal" data-target="#editExpense" data-placement="top" title="Edit"><i class="fa fa-edit"></i></button>';
                        $button .= '&nbsp;&nbsp;';
                        
                        return $button;
                    })
                    ->rawColumns(['action'])
                    ->addIndexColumn()
                    ->make(true);
        }

        return view('backend.expanse.expanse_satatus_list'); 
      
    } 
    // ===================================== End Week Leave List  ============================================

    // ===================================== Week Leave Edit  ============================================ 

    public function expense_status_edit($id)
    {
        $expense_status_edit = DB::table('tb_expanse')->where('id',$id)->first(['id','expanse_date','status']);
        return response()->json($expense_status_edit);
    }  
    // ===================================== End Week Leave Edit  ============================================ 

    // ===================================== Week Leave Update  ============================================ 

        public function expense_status_update(Request $request)
    { 

         

        $expense_status_update =  DB::table('tb_expanse')
            ->where('id',$request->id)
            ->update(
                [
                 'status'=>$request->edit_status,
                 'approved_by'=>Auth::user()->id,
                ]
            );
            

            
            if ($expense_status_update) {
                return response()->json(['success' =>'Expanse status Update only!!!']);
            }
            else {
                return response()->json(['falied' => 'Update Nothing.']);
            }
           
    }

    // ===================================== End Group Update  ============================================



    public function employee_wise_expanse_report(){
      return view('backend.report.employee.expense_date_wise_employee');
    }
    public function employee_wise_expanse_report_date(Request $request){
       if(auth()->user()->hasRole('employee')){ 


        $a =$request->startdate;
        $b =$request->enddate; 
        $from = date($a);
        $to = date($b);
        // return response()->json(['leave_application' =>$from]); 

        $branch_list=$this->branche->all_branch();
        $branch_id=$this->branche->branchname_loginemployee();
        $expanse_category = DB::table('tb_expanse_category')->select('id','category_name')->get();
        $expanse_list = DB::table('tb_expanse')->orderBy('id', 'desc')
        ->leftJoin('users','tb_expanse.created_by','=','users.id')
        ->leftJoin('tb_employee','tb_expanse.created_by','=','tb_employee.id')
        ->leftJoin('tb_expanse_category','tb_expanse.category_id','=','tb_expanse_category.id')
        ->select('tb_expanse.id','tb_expanse.amount','tb_expanse.expanse_date','tb_expanse.status','tb_expanse.attachment','users.name','tb_expanse_category.category_name','tb_employee.emp_first_name','tb_employee.employeeId')
        ->whereBetween('tb_expanse.expanse_date', [ $from, $to])
        ->where('tb_employee.branch_id', $branch_id->id)
        ->where('tb_expanse.created_by','=',auth()->user()->emp_id)
       
        ->get();

        if(request()->ajax())
        {
            return datatables()->of($expanse_list)
                    ->addColumn('action', function($data){
                        $button = '<button type="button" name="edit" id="'.$data->id.'" class="edit btn btn-blue btn-xs" data-toggle="modal" data-target="#editExpanse" data-placement="top" title="Edit"><i class="fa fa-edit"></i></button>';
                        $button .= '&nbsp;&nbsp;';
                        
                        if( Auth::user()->hasPermission('expense_edit')){
                        return $button;
                        }
                    })
                      ->editColumn('expanse_date', function ($expanse_list) {
                        return date("d/m/Y", strtotime($expanse_list->expanse_date));
                    })
                    ->rawColumns(['action'])
                    ->addIndexColumn()
                    ->make(true);
        }

        return view('backend.expanse.expense_list_emplooy_date',compact('expanse_category','branch_list'));
        }else{
            return '404';
        }
    }




}
