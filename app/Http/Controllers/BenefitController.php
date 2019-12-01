<?php

namespace App\Http\Controllers; 

use DB;
use Auth;
use Carbon\Carbon;
use Validator;
use App\Repositories\Settings;

use Illuminate\Http\Request;

class BenefitController extends Controller
{   

    protected $settings;
    public function __construct()
    {
        // create object of settings class
        $this->settings = new Settings();
    }
  
      
    // =====================================   Benefit List  ====================================

    public function benefit_list()
    {  

          $this->checkuserRole(['admin','super-admin','branch-manager'],'');
          


        if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('super-admin')){
        $employee_list = DB::table('tb_employee')->select('id','emp_first_name','emp_lastName','employeeId')->get();
        $branch_list=$this->settings->all_branch();
        $branch_list2=$this->settings->branchname_loginemployee();
        $benefit_list = DB::table('tb_benefit')->orderBy('id', 'desc')
        ->leftJoin('users','tb_benefit.created_by','=','users.id')
        ->leftJoin('tb_employee','tb_benefit.emp_id','=','tb_employee.id')
        ->select('tb_benefit.id','tb_benefit.benefit_name','tb_benefit.status','users.name','tb_employee.emp_first_name','tb_employee.employeeId')

        ->get();
       
        // data send to data table 
        if(request()->ajax())
        { 
            return datatables()->of($benefit_list)
                    ->addColumn('action', function($data){
                        $button = '<button type="button" name="edit" id="'.$data->id.'" class="edit btn btn-blue btn-xs" data-toggle="modal" data-target="#editBenefit" data-placement="top" title="Edit"><i class="fa fa-edit"></i></button>';
                        $button .= '&nbsp;&nbsp;';
                        
                        return $button;
                    })
                    // ->editColumn('benefit_name', function ($benefit_list) {
                    //     return ucwords($benefit_list->benefit_name);
                    // })
                    // ->editColumn('emp_first_name', function ($benefit_list) {
                    //     return ucwords($benefit_list->emp_first_name);
                    // })
                    ->rawColumns(['action'])
                    ->addIndexColumn()
                    ->make(true);
        }

        // end data send to data table 
     

        return view('backend.benefit.benefit_list',compact('employee_list','branch_list','branch_list2'));
        }else{

        $branch_emp_id=$this->settings->branchname_loginemployee();        
        $employee_list = DB::table('tb_employee')->select('id','emp_first_name','emp_lastName','employeeId')->get();
        $branch_list=$this->settings->all_branch();
        $branch_list2=$this->settings->branchname_loginemployee();
        $benefit_list = DB::table('tb_benefit')->orderBy('id', 'desc')
        ->leftJoin('users','tb_benefit.created_by','=','users.id')
        ->leftJoin('tb_employee','tb_benefit.emp_id','=','tb_employee.id')
        ->select('tb_benefit.id','tb_benefit.benefit_name','tb_benefit.status','users.name','tb_employee.emp_first_name','tb_employee.employeeId')
        ->where('tb_employee.branch_id', $branch_emp_id->id)
        ->get();
       
        // data send to data table 
        if(request()->ajax())
        { 
            return datatables()->of($benefit_list)
                    ->addColumn('action', function($data){
                        $button = '<button type="button" name="edit" id="'.$data->id.'" class="edit btn btn-blue btn-xs" data-toggle="modal" data-target="#editBenefit" data-placement="top" title="Edit"><i class="fa fa-edit"></i></button>';
                        $button .= '&nbsp;&nbsp;';
                        
                        return $button;
                    })
                    // ->editColumn('benefit_name', function ($benefit_list) {
                    //     return ucwords($benefit_list->benefit_name);
                    // })
                    // ->editColumn('emp_first_name', function ($benefit_list) {
                    //     return ucwords($benefit_list->emp_first_name);
                    // })
                    ->rawColumns(['action'])
                    ->addIndexColumn()
                    ->make(true);
        }

        // end data send to data table 
     

        return view('backend.benefit.benefit_list',compact('employee_list','branch_list','branch_list2'));
        }
        
        
    } 

    // =====================================  End Benefit List  ====================================


    // ===================================== Benefit Add  ============================================

    public function benefit_add(Request $request)
    {
       $rules = array(
            'benefit_name'=>'required|unique:tb_benefit', 
            'emp_id'=>'required', 
        );

        // TODO:required custom message

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $benefit_create = DB::table('tb_benefit')->insert([
            'benefit_name'=>$request->benefit_name,
            'emp_id'=>$request->emp_id,
            'remarks'=>$request->remarks,
            'status'=>1,
            'created_by'=>Auth::user()->id,
            'created_at'=>Carbon::now()->toDateTimeString(),
            'updated_at'=>Carbon::now()->toDateTimeString()
        ]);

        if ($benefit_create) {
            return response()->json(['success' => 'Benifit has been successfully added.']);
         } else {
            return 0;
         }
    } 

    // =====================================  End Benefit Add  ====================================


    


    // ===================================== Benefit Edit  ============================================    
    public function benefit_edit($id)
    {   
      
        // $benefit_edit = DB::table('tb_benefit')->where('id',$id)->first(['id','benefit_name','remarks','emp_id','status']);
        //  $branchid = DB::table('tb_employee')->where('tb_employee.id', $branchid)->select('branch_id')->first();
        //  $employee_list2 = DB::table('tb_employee')->where('tb_employee.id',1)->select('id as branempid','emp_first_name as branempname')->first();
         $benefit_edit = DB::table('tb_benefit')
             ->leftJoin('tb_employee','tb_benefit.emp_id','=','tb_employee.id')
             ->leftJoin('tb_branch','tb_employee.branch_id','=','tb_branch.id')
             ->select('tb_benefit.id','tb_benefit.benefit_name','tb_benefit.remarks','tb_benefit.status','tb_benefit.remarks','tb_employee.emp_first_name',
           'tb_benefit.emp_id as bfit_emp_id','tb_branch.id as branch_id') 
             ->where('tb_benefit.id',$id)
             ->first();
        return response()->json($benefit_edit);
    } 

    // ===================================== End Benefit Edit  ============================================


    // =====================================  Benefit Update  ============================================
    public function benefit_update(Request $request)
    {

         
         //  TODO:edit page cannot show employee name  


     

        $benefit =  DB::table('tb_benefit')
            ->where('benefit_name',$request->edit_benefit_name)
            ->first();
        
                 
            if ($benefit) {
                $benefit_update =  DB::table('tb_benefit')
                ->where('id',$request->id)
                ->update(
                [
                    'emp_id' =>$request->edit_emp_id,
                    'remarks' =>$request->edit_remarks,
                    'status' =>$request->status
                ]
                
            );


            // =====================satatus change===========================
            if ($benefit->emp_id != $request->edit_emp_id) {
                return response()->json(['success' => 'Benefit Name Exist !!! Benefit Type Update only!!!']);
              
                  // ====================remarks remarks==================
            }elseif ($benefit->remarks != $request->edit_remarks) {
                return response()->json(['success' => 'Benefit Name Exist !!! remarks Update only!!!']);
            }elseif ($benefit->status != $request->status) {
            // =====================satatus change===========================
                return response()->json(['success' => 'Benefit Name Exist !!! Status Update only!!!']);
            }else {
                return response()->json(['falied' => 'Update Nothing.']);
            }
        }else {
            $benefit_update =  DB::table('tb_benefit')
            ->where('id',$request->id)
            ->update(
                [
                    'benefit_name' =>$request->edit_benefit_name,
                    'emp_id' =>$request->edit_emp_id,
                    'remarks' =>$request->edit_remarks,
                    'status' =>$request->status
                    
                ]
            );
            if ($benefit_update) {
                return response()->json(['success' => 'Update successfully !!!']);
            } else {
                return response()->json(['falied' => 'Update Nothing.']);
            }
        }
        
    // ===================================== End Benefit Update  ============================================
    

    }  




     public function branchbenefit($id){
       $employeeId=DB::table('tb_employee')->where('branch_id',$id)->select('tb_employee.id as emp_id','emp_first_name','emp_lastName','tb_employee.employeeId')->get();
       return response()->json($employeeId);
     }



     
      /**
    * Get employee active grade.
    */
    public function get_employeebenefit()
    {  
        $employee = $this->settings->all_employee();
        return view('backend.ajax.get_employee',compact('employee'));
    }
}
