<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Auth; 
use Carbon\Carbon;
use Validator;

class ProcessStatus extends Controller
{
       // ===================================== Week Leave List  ============================================
   
    public function Process_status_list()
    {   
          $this->checkuserRole(['admin','super-admin','branch-manager'],'');

        $Process_status_list = DB::table('process_status')->orderBy('id', 'desc')
        // ->leftJoin('users','tb_severance_package.created_by','=','users.id')
        ->select('process_status.id','process_status.p_satatus_salary_month_year','process_status.process_salary_status')
        ->get();
        if(request()->ajax())
        {
            return datatables()->of($Process_status_list)
                    ->addColumn('action', function($data){
                        $button = '<button type="button" name="edit" id="'.$data->id.'" class="edit btn btn-blue btn-xs" data-toggle="modal" data-target="#editProcessStatus" data-placement="top" title="Edit"><i class="fa fa-edit"></i></button>';
                        $button .= '&nbsp;&nbsp;';
                        
                        return $button;
                    })
                     ->editColumn('p_satatus_salary_month_year', function ($Process_status_list) {
                    return date('d/m/Y', strtotime($Process_status_list->p_satatus_salary_month_year));
                })
                    ->rawColumns(['action'])
                    ->addIndexColumn()
                    ->make(true);
        }

        return view('backend.process_status.process_status_list'); 
      
    } 
    // ===================================== End Week Leave List  ============================================

    // ===================================== Week Leave Edit  ============================================ 

    public function Process_status_edit($id)
    {
        $Process_status_edit = DB::table('process_status')->where('id',$id)->first(['id','p_satatus_salary_month_year','process_salary_status']);
        return response()->json($Process_status_edit);
    }  
    // ===================================== End Week Leave Edit  ============================================ 

    // ===================================== Week Leave Update  ============================================ 

        public function Process_status_update(Request $request)
    { 

         

        $Process_status_update =  DB::table('process_status')
            ->where('id',$request->id)
            ->update(
                [
                 'process_salary_status'=>$request->edit_status,
                ]
            );
            

            
            if ($Process_status_update) {
                return response()->json(['success' =>'Process status Update only!!!']);
            }
            else {
                return response()->json(['falied' => 'Update Nothing.']);
            }
           
    }

    // ===================================== End Week Leave Update  ============================================ 
}
