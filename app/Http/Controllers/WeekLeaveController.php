<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth; 
use Carbon\Carbon;
use Validator;

class WeekLeaveController extends Controller
{
    // ===================================== Week Leave List  ============================================
   
    public function weekleave_list()
    { 

        
        $weekleave_list = DB::table('tb_week_leave')->orderBy('id', 'desc')
        // ->leftJoin('users','tb_severance_package.created_by','=','users.id')
        ->select('tb_week_leave.id','tb_week_leave.day','tb_week_leave.status')
        ->get();
        if(request()->ajax())
        {
            return datatables()->of($weekleave_list)
                    ->addColumn('action', function($data){
                        $button = '<button type="button" name="edit" id="'.$data->id.'" class="edit btn btn-blue btn-xs" data-toggle="modal" data-target="#editweekLeave" data-placement="top" title="Edit"><i class="fa fa-edit"></i></button>';
                        $button .= '&nbsp;&nbsp;';
                         if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('super-admin')){
                        return $button;
                        }
                    })
                    ->rawColumns(['action'])
                    ->addIndexColumn()
                    ->make(true);
        }

        return view('backend.week_leave.week_leave_list'); 
      
    } 
    // ===================================== End Week Leave List  ============================================

    // ===================================== Week Leave Add  ============================================ 

     public function weekleave_add(Request $request)
    {
      
        //  return response()->joson([$request]); 


        // TODO:satatus update not workong

       $rules = array(
            'day'=>'required|unique:tb_week_leave', 
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $weekleave_create = DB::table('tb_week_leave')->insert([
            'day'=>$request->day,
            'status'=>1,
            'created_at'=>Carbon::now()->toDateTimeString(),
            'updated_at'=>Carbon::now()->toDateTimeString()
        ]);

        if ($weekleave_create) {
            return response()->json(['success' => 'Week leave Added successfully.']);
         } else {
            return 0;
         } 

    
    }  

    // ===================================== end Week Leave Add  ============================================



    // ===================================== Week Leave Edit  ============================================ 

    public function weekleave_edit($id)
    {
        $weekleave = DB::table('tb_week_leave')->where('id',$id)->first(['id','day','status']);
        return response()->json($weekleave);
    }  
    // ===================================== End Week Leave Edit  ============================================ 

    // ===================================== Week Leave Update  ============================================ 

        public function weekleave_update(Request $request)
    { 

         

        $weekleave_update =  DB::table('tb_week_leave')
            ->where('id',$request->id)
            ->update(
                [
                 'status'=>$request->status,
                ]
            );
            

            
            if ($weekleave_update) {
                return response()->json(['success' =>'Status Update only!!!']);
            }
            else {
                return response()->json(['falied' => 'Update Nothing.']);
            }
           
    }

    // ===================================== End Week Leave Update  ============================================ 

}
