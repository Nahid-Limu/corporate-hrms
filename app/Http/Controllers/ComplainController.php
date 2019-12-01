<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class ComplainController extends Controller
{
    public function index(){
        $this->checkuserRole(['admin','super-admin','branch-manager'],'');
        $users=DB::table('role_user')
        ->leftjoin('users','role_user.user_id','=','users.id')
        ->select('users.name', 'users.id')
        ->where('role_user.role_id', '=', 1)
        ->orWhere('role_user.role_id', '=', 2)
        ->orWhere('role_user.role_id', '=', 3)
        ->orderBy('users.name', 'ASC')
        ->get();
        return view('backend.complain.index', compact('users'));
    }

    public function complain_submit(Request $request){
        $pre = DB::table('tb_complains')->orderBy('id', 'desc')->take(1)->first();
        if(!empty($pre->com_token) && substr($pre->com_token, 0, 6)==date('dmy')){
            $tok1 = substr($pre->com_token, 0, 6);
            $tok2 = substr($pre->com_token, 6);
            $tok2=$tok2+1;
            $tmpToken = $tok1."".$tok2;
        }else{
            $mdate= date('dmy');
            $tok = substr($mdate, 0, 6);
            $tmpToken = $tok."1";
        }
        $get_complain=DB::table('tb_complains')->insert([
            'complain'=>$request->complain_text,
            'complain_to'=>$request->complain_to,
            'emp_id' => Auth::user()->id,
            'com_token' => $tmpToken,
            'com_date'=> date('Y-m-d'),
            'created_at'=>Carbon::now()->toDateTimeString(),
            'updated_at'=>Carbon::now()->toDateTimeString(),
        ]);
        return $tmpToken;
    }

    public function complain_list(){

        $complain_list = DB::table('tb_complains')
        ->leftjoin('users','tb_complains.emp_id','=','users.id')
        ->select('tb_complains.*' ,'users.name as employeeName')
        // ->where('tb_complains.complain_to', '=', Auth::user()->id)
        ->orderBy('id', 'desc')
        ->get();
        
        if(request()->ajax())
        {
            return datatables()->of($complain_list)
                ->addColumn('action', function($data){
                    $button = '<button type="button" name="edit" id="'.$data->id.'" class="edit btn btn-blue btn-xs" data-toggle="modal" data-target="#editComplain" data-placement="top" title="Edit"><i class="fa fa-eye"></i></button>';
                    $button .= '&nbsp;&nbsp;';
                    return $button;
                })
                ->addColumn('complain_date', function($data1){
                    return date('d-m-Y', strtotime($data1->com_date));
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }
        // dd($complain_list);
        return view('backend.complain.complain_list');
    }
}
