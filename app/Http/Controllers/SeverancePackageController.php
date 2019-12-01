<?php

namespace App\Http\Controllers;


use DB;
use Auth; 
use Carbon\Carbon;
use Validator;
use Illuminate\Http\Request;

class SeverancePackageController extends Controller
{
    
    // =====================================  Severance Package List  ============================================
    
    public function severance_list()
    {   
          $this->checkuserRole(['admin','super-admin','branch-manager'],'');
        
        $severance_list = DB::table('tb_severance_package')->orderBy('id', 'desc')
        ->leftJoin('users','tb_severance_package.created_by','=','users.id')
        ->select('tb_severance_package.id','tb_severance_package.package_name','tb_severance_package.package_type','tb_severance_package.description','tb_severance_package.status','users.name')
        ->get();
        if(request()->ajax())
        {
            return datatables()->of($severance_list)
                    ->addColumn('action', function($data){
                        $button = '<button type="button" name="edit" id="'.$data->id.'" class="edit btn btn-blue btn-xs" data-toggle="modal" data-target="#editSeverance" data-placement="top" title="Edit"><i class="fa fa-edit"></i></button>';
                        $button .= '&nbsp;&nbsp;';
                        
                        return $button;
                    })
                    ->rawColumns(['action'])
                    ->addIndexColumn()
                    ->make(true);
        }

        return view('backend.severance_package.severance_list');
    }

    // ===================================== End Severance Package List  ============================================
    

    // =====================================  Severance Package Add  ============================================

    public function severance_add(Request $request)
    {
       $rules = array(
            'package_name'=>'required|unique:tb_severance_package', 
            'package_type'=>'required', 
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $severance_create = DB::table('tb_severance_package')->insert([
            'package_name'=>$request->package_name,
            'package_type'=>$request->package_type,
            'description'=>$request->description,
            'status'=>1,
            'created_by'=>Auth::user()->id,
            'created_at'=>Carbon::now()->toDateTimeString(),
            'updated_at'=>Carbon::now()->toDateTimeString()
        ]);

        if ($severance_create) {
            return response()->json(['success' => 'Severance package has been successfully added.']);
            //return "Department added Successfully";
         } else {
            return 0;
         }
    }
    // ===================================== End Severance Package Add  ============================================

    // ===================================== Severance Package Edit  ============================================

    public function severance_edit($id)
    {
        $severance = DB::table('tb_severance_package')->where('id',$id)->first(['id','package_name','package_type','description','status']);
        return response()->json($severance);
    }

    // ===================================== End Severance Package Edit  ============================================
    

    // =====================================  Severance Package Update  ============================================

    public function severance_update(Request $request)
    {
        $rules = array(
            'edit_package_name'=>'required', 
        );
        $error = Validator::make($request->all(), $rules);
        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }
        $severance =  DB::table('tb_severance_package')
            ->where('package_name',$request->edit_package_name)
            ->first();
        
        if ($severance) {
            $severance_update =  DB::table('tb_severance_package')
            ->where('id',$request->id)
            ->update(
                [
                    'package_type' =>$request->edit_package_type,
                    'description' =>$request->edit_description,
                    'status' =>$request->status
                    
                ]
            );
            if ($severance->package_type != $request->edit_package_type) {
                return response()->json(['success' => 'Package Name Exist !!! Package Type Update only!!!']);
                //return "Department added Successfully";
            }elseif ($severance->description != $request->edit_description) {
                return response()->json(['success' => 'Package Name Exist !!! Description Update only!!!']);
            }elseif ($severance->status != $request->status) {
                return response()->json(['success' => 'Package Name Exist !!! Status Update only!!!']);
            }else {
                return response()->json(['falied' => 'Update Nothing.']);
            }
        }else {
            $severance_update =  DB::table('tb_severance_package')
            ->where('id',$request->id)
            ->update(
                [
                    'package_name' =>$request->edit_package_name,
                    'package_type' =>$request->edit_package_type,
                    'description' =>$request->edit_description,
                    'status' =>$request->status
                    
                ]
            );
            if ($severance_update) {
                return response()->json(['success' => 'Update successfully !!!']);
                //return "Department added Successfully";
            } else {
                return response()->json(['falied' => 'Update Nothing.']);
            }
        }
          
    }
    // ===================================== End Severance Package Update  ============================================

}
