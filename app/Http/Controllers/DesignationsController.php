<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use Carbon\Carbon;
use Validator;
class DesignationsController extends Controller
{
    /**
     * Retive designations from table and show in blade
     */
    public function designations_list()
    {   
         $this->checkuserRole(['admin','super-admin','branch-manager'],'');
        $designations_list = DB::table('tb_designations')->orderBy('id', 'desc')
        ->leftJoin('users','tb_designations.created_by','=','users.id')
        ->select('tb_designations.id','tb_designations.designation_name','tb_designations.status','users.name')
        ->orderBy('tb_designations.designation_name', 'ASC')
        ->get();
        if(request()->ajax())
        {
            return datatables()->of($designations_list)
                    ->addColumn('action', function($data){
                        $button = '<button type="button" name="edit" id="'.$data->id.'" class="edit btn btn-blue btn-xs" data-toggle="modal" data-target="#editDesignation" data-placement="top" title="Edit"><i class="fa fa-edit"></i></button>';
                        $button .= '&nbsp;&nbsp;';
                        
                        return $button;
                    })
                    ->rawColumns(['action'])
                    ->addIndexColumn()
                    ->make(true);
        }
        return view('backend.designation.designations_list');
        
    }

    /**
     * add new designation
     */
    public function designation_add(Request $request)
    {
       $rules = array(
            'designation_name'=>'required|unique:tb_designations', 
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $designation_create = DB::table('tb_designations')->insert([
            'designation_name'=>$request->designation_name,
            'remarks'=>$request->remarks,
            'status'=>1,
            'created_by'=>Auth::user()->id,
            'created_at'=>Carbon::now()->toDateTimeString(),
            'updated_at'=>Carbon::now()->toDateTimeString()
        ]);

        if ($designation_create) {
            return response()->json(['success' => 'Designation has been successfully added.']);
            //return "Department added Successfully";
         } else {
            return 0;
         }
    }

    /**
     * Edit designation modal
     */
    public function designation_edit($id)
    {
        $designation = DB::table('tb_designations')->where('id',$id)->first(['id','designation_name','remarks','status']);
        return response()->json($designation);
    }

    /**
     * Update designation
     */
    public function designation_update(Request $request)
    {
        $rules = array(
            'designation_name'=>'required', 
        );
        $error = Validator::make($request->all(), $rules);
        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $designation =  DB::table('tb_designations')
            ->where('designation_name',$request->designation_name)
            ->first();
        
        if ($designation) {
            $designation_update =  DB::table('tb_designations')
            ->where('id',$request->id)
            ->update(
                [
                    'remarks' =>$request->remarks,
                    'status' =>$request->status
                    
                ]
            );
            if ($designation->remarks != $request->remarks) {
                return response()->json(['success' => 'Designation has been successfully updated.']);
                //return "Department added Successfully";
            }elseif ($designation->status != $request->status) {
                return response()->json(['success' => 'Designation has been successfully updated.']);
            }else {
                return response()->json(['falied' => 'Update Nothing.']);
            }
        }else {
            $designation_update =  DB::table('tb_designations')
            ->where('id',$request->id)
            ->update(
                [
                    'designation_name' =>$request->designation_name,
                    'remarks' =>$request->remarks,
                    'status' =>$request->status
                    
                ]
            );
            if ($designation_update) {
                return response()->json(['success' => 'Designation has been successfully updated.']);
                //return "Department added Successfully";
            } else {
                return response()->json(['falied' => 'Update Nothing.']);
            }
        }
    }


}
