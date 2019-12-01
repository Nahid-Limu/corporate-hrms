<?php

namespace App\Http\Controllers;

use DB;
use Auth; 
use Carbon\Carbon;
use Validator;
use Illuminate\Http\Request;
use App\Repositories\Settings;

class SalaryGradeController extends Controller
{
    protected $settings;

    public function __construct()
    {
        // create object of settings class
        $this->settings = new Settings();
    }
   
    // ===================================== Salarygrade List  ============================================

    public function salarygrade_list()
    
    {
          $this->checkuserRole(['admin','super-admin','branch-manager'],'');

        $salarygrade_list = DB::table('tb_salary_grade')->orderBy('id', 'desc')
        ->select('tb_salary_grade.id','tb_salary_grade.grade_name','tb_salary_grade.basic','tb_salary_grade.house','tb_salary_grade.medical','tb_salary_grade.transportation','tb_salary_grade.food','tb_salary_grade.other','tb_salary_grade.status')
        ->get();
        if(request()->ajax())
        {
            return datatables()->of($salarygrade_list)
                    ->addColumn('action', function($data){
                        $button = '<button type="button" name="edit" id="'.$data->id.'" class="edit btn btn-blue btn-xs" data-toggle="modal" data-target="#editsalary_grade" data-placement="top" title="Edit"><i class="fa fa-edit"></i></button>';
                        $button .= '&nbsp;&nbsp;';
                        
                        return $button;
                    })
                    ->rawColumns(['action'])
                    ->addIndexColumn()
                    ->make(true);
        }

        return view('backend.salary_grade.salary_grade_list');
    }
    // ===================================== End Salarygrade List  ============================================


    // ===================================== Salarygrade Add  ============================================

    public function salarygrade_add(Request $request)
    {
       $rules = array(
            'grade_name'=>'required|unique:tb_salary_grade', 
            'basic'=>'required', 
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $salarygrade_create = DB::table('tb_salary_grade')->insert([
            'grade_name'=>$request->grade_name,
            'basic'=>$request->basic,
            'house'=>$request->house,
            'medical'=>$request->medical,
            'transportation'=>$request->transportation,
            'food'=>$request->food,
            'other'=>$request->other,
            'status'=>1,
            'created_at'=>Carbon::now()->toDateTimeString(),
            'updated_at'=>Carbon::now()->toDateTimeString()
        ]);

        if ($salarygrade_create) {
            return response()->json(['success' => 'Grade Added successfully.']);
         } else {
            return 0;
         }
    } 
 
    // ===================================== End Salarygrade Add  ============================================


    // =====================================  Salarygrade Edit  ============================================
    
    public function salarygrade_edit($id)
    {
        $salarygrade = DB::table('tb_salary_grade')->where('id',$id)->first(['id','grade_name','basic','house','medical','transportation','food','other','status']);
        return response()->json($salarygrade);
    } 

    // ===================================== End Salarygrade Edit  ============================================
    
    // =====================================  Salarygrade Update  ============================================
    
    public function salarygrade_update(Request $request)
    {  

        //    TO DO ADD some value in data base 

        // TODO: some value in data base 

        $salary_grade =  DB::table('tb_salary_grade')
            ->where('grade_name',$request->edit_grade_name)
            ->first();
        
             
        if ($salary_grade) {
            $salary_grade_update =  DB::table('tb_salary_grade')
            ->where('id',$request->id)
            ->update(
                [
                    'grade_name'=>$request->edit_grade_name,
                    'basic'=>$request->edit_basic,
                    'house'=>$request->edit_house,
                    'medical'=>$request->edit_medical,
                    'transportation'=>$request->edit_transportation,
                    'food'=>$request->edit_food,
                    'other'=>$request->edit_other,
                    'status' =>$request->status,
                    'updated_at'=>Carbon::now()->toDateTimeString()
                    
                ]
            );
            if ($salary_grade_update) {
                return response()->json(['success' => 'Grade Name Already Exist !!! Update Successfully']);
            }
            else {
                return response()->json(['falied' => 'Update Nothing.']);
            }
        }else {
            $salary_grade_update =  DB::table('tb_salary_grade')
            ->where('id',$request->id)
            ->update(
                [
                    'basic'=>$request->edit_basic,
                    'house'=>$request->edit_house,
                    'medical'=>$request->edit_medical,
                    'transportation'=>$request->edit_transportation,
                    'food'=>$request->edit_food,
                    'other'=>$request->edit_other,
                    'status' =>$request->status,
                    'updated_at'=>Carbon::now()->toDateTimeString()
                    
                ]
            );
            if ($salary_grade_update) {
                return response()->json(['success' => 'Update successfully !!!']);
            } else {
                return response()->json(['falied' => 'Update Nothing.']);
            }
        }
          
    }

    // ===================================== End Salarygrade Update  ============================================
    
    /**
    * Get all active grade.
    */
    public function get_grade()
    {  
        $grade = $this->settings->all_grade();
        return view('backend.ajax.get_salary_grade',compact('grade'));
    }

    /**
    * Get salary grade details.
    */
    public function salary_grade($id)
    {
        $salary_grade =  DB::table('tb_salary_grade')
            ->where('id',$id)
            ->select('tb_salary_grade.basic','tb_salary_grade.house','tb_salary_grade.medical','tb_salary_grade.transportation','tb_salary_grade.food','tb_salary_grade.other')
            ->first();
            return response()->json($salary_grade);
    }
}
