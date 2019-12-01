<?php

namespace App\Http\Controllers;
use DB;
use Auth;
use Carbon\Carbon;
use Validator;
use App\Repositories\Settings;

use Illuminate\Http\Request;

class ProvidentFundController extends Controller
{
    protected $settings;
    public function __construct()
    {
        // create object of settings class
        $this->settings = new Settings();
    }

    /**
     * Retive provident_fund_percent from table and show in blade
     */
    public function employee_provident_fund()
    {
        $list = DB::table('tb_payroll_salary')
        ->leftJoin('tb_employee','tb_payroll_salary.emp_id','=','tb_employee.id')
        ->select('tb_payroll_salary.id',DB::raw("CONCAT(tb_employee.emp_first_name,' ',tb_employee.emp_lastName) as emp_name"),
        'tb_payroll_salary.provident_fund_percent')
        ->get();
        //dd($list);
        if(request()->ajax())
        {
            return datatables()->of($list)
                    ->addColumn('action', function($data){
                        $button = '<button type="button" name="edit" id="'.$data->id.'" class="edit btn btn-blue btn-xs" data-toggle="modal" data-target="#editProvident" data-placement="top" title="Edit"><i class="fa fa-edit"></i></button>';
                        $button .= '&nbsp;&nbsp;';
                        
                        return $button;
                    })
                    ->editColumn('provident_fund_percent', function ($data) {
                        return $data->provident_fund_percent.' %';
                    })
                    ->rawColumns(['action'])
                    ->addIndexColumn()
                    ->make(true);
        }

        return view('backend.provident_fund.provident_fund_list');
    }

    /**
     * Edit provident fund percent modal
     */
    public function provident_percent_edit($id)
    {
        $provident_fund_percent = DB::table('tb_payroll_salary')
        ->leftJoin('tb_employee','tb_payroll_salary.emp_id','=','tb_employee.id')
        ->select('tb_payroll_salary.id',DB::raw("CONCAT(tb_employee.emp_first_name,' ',tb_employee.emp_lastName) as emp_name"),
        'tb_payroll_salary.provident_fund_percent')
        ->where('tb_payroll_salary.id',$id)
        ->first();
        //dd($provident_fund_percent);
        return response()->json($provident_fund_percent);
    }


    /**
     * update provident fund percent modal
     */
    public function provident_percent_update(Request $request)
    {
        $data =  DB::table('tb_payroll_salary')->where('id',$request->id)->first(['total_salary']);
        //dd($data->total_salary);
        $provident_amount = ($data->total_salary * $request->edit_provident_fund_percent) /100;
        
        $update =  DB::table('tb_payroll_salary')
        ->where('id',$request->id)
        ->update(
            [
                'provident_fund_percent' =>$request->edit_provident_fund_percent,
                'provident_fund_amount' =>$provident_amount,
            ]
        );
        if ($update) {
            return response()->json(['success' => 'Information has been successfully updated.']);
            //return "Department added Successfully";
        }else {
            return response()->json(['falied' => 'Update Nothing.']);
        }
      
    }
}
