<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use Carbon\Carbon;
use Validator;
class ShiftController extends Controller
{
    /**
     * Retive shift from table and show in blade
     */
    public function shift_list()
    {   

         $this->checkuserRole(['admin','super-admin','branch-manager'],'');
        $shift_list = DB::table('tb_shift')->orderBy('id', 'desc')
            ->get(['id','shift_name','entry_time','exit_time']);
        if(request()->ajax())
        {
            return datatables()->of($shift_list)
                    ->addColumn('action', function($data){
                        $button = '<button type="button" name="edit" id="'.$data->id.'" class="edit btn btn-blue btn-xs" data-toggle="modal" data-target="#editShift" data-placement="top" title="Edit"><i class="fa fa-edit"></i></button>';
                        $button .= '&nbsp;&nbsp;';
                        if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('super-admin')){
                        return $button;
                        }
                    })
                    ->editColumn('entry_time', function ($shift_list) {
                        return date('h:i A', strtotime($shift_list->entry_time));
                    })
                    ->editColumn('exit_time', function ($shift_list) {
                        return date('h:i A', strtotime($shift_list->exit_time));
                    })
                    ->rawColumns(['action'])
                    ->addIndexColumn()
                    ->make(true);
        }

        return view('backend.shift.shift_list');
    }

    /**
     * add new shift
     */
    public function shift_add(Request $request)
    {
       $rules = array(
            'shift_name'=>'required|unique:tb_shift', 
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $shift_create = DB::table('tb_shift')->insert([
            'shift_name'=>$request->shift_name,
            'entry_time'=>date("G:i", strtotime($request->entry_time)),
            'exit_time'=>date("G:i", strtotime($request->exit_time)),
            'created_at'=>Carbon::now()->toDateTimeString(),
            'updated_at'=>Carbon::now()->toDateTimeString()
        ]);

        if ($shift_create) {
            return response()->json(['success' => 'Shift has been successfully added.']);
            //return "Department added Successfully";
         } else {
            return 0;
         }
    }

    /**
     * Edit shift modal
     */
    public function shift_edit($id)
    {
        $shift = DB::table('tb_shift')->where('id',$id)->first(['id','shift_name','entry_time','exit_time']);
        return response()->json($shift);
    }

    /**
     * Update shift
     */
    public function shift_update(Request $request)
    {
        $rules = array(
            'edit_shift_name'=>'required', 
        );
        $error = Validator::make($request->all(), $rules);
        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $shift =  DB::table('tb_shift')
            ->where('shift_name',$request->edit_shift_name)
            ->first();
        
        if ($shift) {
            $shift_update =  DB::table('tb_shift')
            ->where('id',$request->id)
            ->update(
                [  
                    'entry_time'=>date("G:i", strtotime($request->edit_entry_time)),
                    'exit_time'=>date("G:i", strtotime($request->edit_exit_time))  
                ]
            );
            if ($shift_update) {
                return response()->json(['success' => 'Information has been successfully updated.']);
                //return "Department added Successfully";
            }else {
                return response()->json(['falied' => 'Update Nothing.']);
            }
        }else {
            $shift_update =  DB::table('tb_shift')
            ->where('id',$request->id)
            ->update(
                [
                    'shift_name'=>$request->edit_shift_name,
                    'entry_time'=>date("G:i", strtotime($request->edit_entry_time)),
                    'exit_time'=>date("G:i", strtotime($request->edit_exit_time))
                ]
            );
            if ($shift_update) {
                return response()->json(['success' => 'Information has been successfully updated.']);
                //return "Department added Successfully";
            } else {
                return response()->json(['falied' => 'Update Nothing.']);
            }
        }
          
    }
}
