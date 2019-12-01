<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Support\Facades\DB;
use Validator;
use Carbon\Carbon;
use App\Repositories\Settings;

class SettingsController extends Controller
{

      protected $settings;

    public function __construct()
    {
        // create object of settings class
        $this->settings = new Settings();
    }

    public $successStatus = 200;

    // ===================================== allBranch ============================================

   public function allBranch(){

        $all_branch=$this->settings->all_branch();
         return response()->json([
             'all_branch' => $all_branch,
            ], $this->successStatus);

    }
    // ===================================== End allBranch ============================================

    // ===================================== allBranch ============================================

    public function manager_branch(){
//       return auth()->user()->id;
//        $branch=DB::table('tb_branch')->where('status',1)->->select('id','branch_name')->get();
        $branch=DB::table('tb_employee')
            ->leftJoin('tb_branch','tb_employee.branch_id','=','tb_branch.id')
            ->where('tb_employee.id','=',auth()->user()->emp_id)
            ->select('tb_branch.id','tb_branch.branch_name')
            ->get();
        return $branch;
        return response()->json([
            'all_branch' => $all_branch,
        ], $this->successStatus);

    }
    // ===================================== End allBranch ============================================



    // ===================================== allDepartment ============================================

   public function allDepartment(){

        $all_department=$this->settings->all_departmentasc();
         return response()->json([
             'all_department' => $all_department,
            ], $this->successStatus);

    }
    // ===================================== End allDepartment ============================================

    // ===================================== allDepartment ============================================

   public function allDesignation(){

        $all_designation=$this->settings->all_designation();
         return response()->json([
             'all_designation' => $all_designation,
            ], $this->successStatus);

    }
    // ===================================== End allDepartment ============================================

}
