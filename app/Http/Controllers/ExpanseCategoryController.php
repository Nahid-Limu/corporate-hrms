<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth; 
use Carbon\Carbon;
use Validator;


class ExpanseCategoryController extends Controller
{
   /**
     * Retive expansecategory from table and show in blade
     */ 

    // ===================================== Expansecategory List  ============================================

    public function expansecategory_list()
    {   

       $this->checkPermission('manage_expense','You have not right to Access');  

      

        $expansecategory_list = DB::table('tb_expanse_category')->orderBy('id', 'desc')
        ->select('tb_expanse_category.id','tb_expanse_category.category_name','tb_expanse_category.description','tb_expanse_category.status')
        ->get();
        if(request()->ajax())
        {   
          
            return datatables()->of($expansecategory_list)
                    ->addColumn('action', function($data){
                        
                        $button = '<button type="button" name="edit" id="'.$data->id.'" class="edit btn btn-blue btn-xs" data-toggle="modal" data-target="#editexpansecategory" data-placement="top" title="Edit"> <i class="fa fa-edit"></i></button>';
                        $button .= '&nbsp;&nbsp;';
                       
                        // abort_if(!Auth::user()->hasPermission($permission), 403, $massge);
                        if(Auth::user()->hasPermission('manage_expense')){
                        return $button;
                        }
                    })
                    ->rawColumns(['action'])
                    ->addIndexColumn()
                    ->make(true);
        }

        return view('backend.expanse_category.expanse_category_list');
    }

    // ===================================== End Expansecategory List  ============================================

    /**
     * add new expansecategory
     */ 

    // =====================================  Expansecategory Add  ============================================

    public function expansecategory_add(Request $request)
    {
       $rules = array(
            'category_name'=>'required|unique:tb_expanse_category', 
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $expansecategory_create = DB::table('tb_expanse_category')->insert([
            'category_name'=>$request->category_name,
            'description'=>$request->description,
            'status'=>1,
            'created_at'=>Carbon::now()->toDateTimeString(),
            'updated_at'=>Carbon::now()->toDateTimeString()
        ]);

        if ($expansecategory_create) {
            return response()->json(['success' => ' Expense Category  has been successfully added.']);
         } else {
            return 0;
         }
    } 

    // ===================================== End Expansecategory Add  ============================================

       /**
     * Edit expansecategory modal
     */

    // ===================================== Expansecategory Edit  ============================================
    
    public function expansecategory_edit($id)
    {
        $expansecategory = DB::table('tb_expanse_category')->where('id',$id)->first(['id','category_name','description','status']);
        return response()->json($expansecategory);
    } 

    // ===================================== End Expansecategory Edit  ============================================


    /**
     * Update expansecategory
     */

    // ===================================== End Expansecategory Update  ============================================

    public function expansecategory_update(Request $request)
    {

        $expansecategory =  DB::table('tb_expanse_category')
            ->where('category_name',$request->edit_category_name)
            ->first();
        
        if ($expansecategory) {
            $expansecategory_update =  DB::table('tb_expanse_category')
            ->where('id',$request->id)
            ->update(
                [
                    'description' =>$request->edit_description,
                    'status' =>$request->status
                    
                ]
            );
            if ($expansecategory->description != $request->edit_description) {
                return response()->json(['success' => 'Description Update only!!!']);
            }elseif ($expansecategory->status != $request->status) {
                return response()->json(['success' => 'Status Update only!!!']);
            }else {
                return response()->json(['falied' => 'Update Nothing.']);
            }
        }else {
            $expansecategory_update =  DB::table('tb_expanse_category')
            ->where('id',$request->id)
            ->update(
                [
                    'category_name' =>$request->edit_category_name,
                    'description' =>$request->edit_description,
                    'status' =>$request->status
                    
                ]
            );
            if ($expansecategory_update) {
                return response()->json(['success' => 'Update successfully !!!']);
                //return "Department added Successfully";
            } else {
                return response()->json(['falied' => 'Update Nothing.']);
            }
        }
          
    }

    // ===================================== End Expansecategory Update  ============================================

}
