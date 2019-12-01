<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use Carbon\Carbon;
use Validator;
class DepartmentController extends Controller
{
    /**
     * Retive department from table and show in blade
     */
    public function department_list()
    {   
         $this->checkuserRole(['admin','super-admin','branch-manager'],'');
        $departments_list = DB::table('tb_departments')->orderBy('id', 'desc')
        ->leftJoin('users','tb_departments.created_by','=','users.id')
        ->select('tb_departments.id','tb_departments.department_name','tb_departments.status','users.name')
        ->orderBy('tb_departments.department_name', 'ASC')
        ->get();
        if(request()->ajax())
        {
            return datatables()->of($departments_list)
                    ->addColumn('action', function($data){
                        $button = '<button type="button" name="edit" id="'.$data->id.'" class="edit btn btn-blue btn-xs" data-toggle="modal" data-target="#editDepartment" data-placement="top" title="Edit"><i class="fa fa-edit"></i></button>';
                        $button .= '&nbsp;&nbsp;';
                        
                        return $button;
                    })
                    ->rawColumns(['action'])
                    ->addIndexColumn()
                    ->make(true);
        }

        return view('backend.department.department_list');
    }

    /**
     * add new department
     */
    public function department_add(Request $request)
    {
       $rules = array(
            'department_name'=>'required|unique:tb_departments', 
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $departments_create = DB::table('tb_departments')->insert([
            'department_name'=>$request->department_name,
            'remarks'=>$request->remarks,
            'status'=>1,
            'created_by'=>Auth::user()->id,
            'created_at'=>Carbon::now()->toDateTimeString(),
            'updated_at'=>Carbon::now()->toDateTimeString()
        ]);

        if ($departments_create) {
            return response()->json(['success' => 'Department has been successfully added.']);
            //return "Department added Successfully";
         } else {
            return 0;
         }
    }


    /**
     * Edit department modal
     */
    public function department_edit($id)
    {
        $department = DB::table('tb_departments')->where('id',$id)->first(['id','department_name','remarks','status']);
        return response()->json($department);
    }

    /**
     * Update department
     */
    public function department_update(Request $request)
    {
        $rules = array(
            'department_name'=>'required', 
        );
        $error = Validator::make($request->all(), $rules);
        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $department =  DB::table('tb_departments')
            ->where('department_name',$request->department_name)
            ->orWhereNull ('department_name')
            ->first();
        
        if ($department) {
            $department_update =  DB::table('tb_departments')
            ->where('id',$request->id)
            ->update(
                [
                    
                    'remarks' =>$request->remarks,
                    'status' =>$request->status
                    
                ]
            );
            if ($department->remarks != $request->remarks) {
                return response()->json(['success' => 'Department has been successfully updated.']);
                //return "Department added Successfully";
            }elseif ($department->status != $request->status) {
                return response()->json(['success' => 'Department has been successfully updated.']);
            }else {
                return response()->json(['falied' => 'Update Nothing.']);
            }
        }else {
            $department_update =  DB::table('tb_departments')
            ->where('id',$request->id)
            ->update(
                [
                    'department_name' =>$request->department_name,
                    'remarks' =>$request->remarks,
                    'status' =>$request->status
                    
                ]
            );
            if ($department_update) {
                return response()->json(['success' => 'Department has been successfully updated.']);
                //return "Department added Successfully";
            } else {
                return response()->json(['falied' => 'Update Nothing.']);
            }
        }
          
    }
}
