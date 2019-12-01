<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use Carbon\Carbon;
use Validator;
use App\Repositories\Settings;

class ClientController extends Controller
{

    protected $settings;

    public function __construct()
    {
        // create object of settings class
        $this->settings = new Settings();
    }
    /**
     * Client List.
     */
    public function index(){
       if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('super-admin')){
         $branch_list2=$this->settings->branchname_loginemployee();
         $branch=$this->settings->all_branch();
        $client_list = DB::table('tb_clients')->orderBy('id', 'desc')
            ->leftJoin('users','tb_clients.created_by','=','users.id')
            ->leftJoin('tb_branch','tb_clients.branch_id','=','tb_branch.id')
            ->select('tb_clients.id','tb_clients.client_name','tb_clients.client_email','tb_clients.client_phone','tb_clients.status','users.name as created_by','tb_branch.branch_name','tb_clients.branch_id')
            ->get();
        if(request()->ajax())
        {
            return datatables()->of($client_list)
                ->addColumn('action', function($data){
                    $button = '<button type="button" name="edit" id="'.$data->id.'" class="edit btn btn-blue btn-xs" data-toggle="modal" data-target="#editClient" data-placement="top" title="Edit"><i class="fa fa-edit"></i></button><a style="margin-left: 5px;" target="_blank" class="profile btn btn-blue btn-xs" title="View Profile" href="'.route('client_profile',base64_encode($data->id)).'"><i class="fa fa-eye"></i></a>';
                    $button .= '&nbsp;&nbsp;';
                    return $button;
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }
        return view('backend.project.client.client_list',compact('branch'));

        return view('backend.project.client.client_list',compact('branch','branch_list2'));
       }else{

         $branch_list2=$this->settings->branchname_loginemployee();
         $branch=$this->settings->all_branch();
        $client_list = DB::table('tb_clients')->orderBy('id', 'desc')
            ->leftJoin('users','tb_clients.created_by','=','users.id')
            ->leftJoin('tb_branch','tb_clients.branch_id','=','tb_branch.id')
            ->select('tb_clients.id','tb_clients.client_name','tb_clients.client_email','tb_clients.client_phone','tb_clients.status','users.name as created_by','tb_branch.branch_name','tb_clients.branch_id')
            ->where('tb_clients.branch_id', $branch_list2->id)
            ->get();
        if(request()->ajax())
        {
            return datatables()->of($client_list)
                ->addColumn('action', function($data){
                    $button = '<button type="button" name="edit" id="'.$data->id.'" class="edit btn btn-blue btn-xs" data-toggle="modal" data-target="#editClient" data-placement="top" title="Edit"><i class="fa fa-edit"></i></button>      <a target="_blank" class="profile btn btn-blue btn-xs" title="View Profile" href="'.route('client_profile',base64_encode($data->id)).'"><i class="fa fa-eye"></i></a>       ';
                    $button .= '&nbsp;&nbsp;';
                    return $button;
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }


        return view('backend.project.client.client_list',compact('branch','branch_list2'));
       }
    }


    /**
     * Client add after some validation.
     */
    public function client_add(Request $request){
        $rules = array(
            'branch_id'=>'required',
            'client_email'=>'required',
            'client_name'=>'required',
            'client_phone'=>'required',
            'client_address'=>'required',
        );
        $error = Validator::make($request->all(), $rules);
        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }
        $client_create = DB::table('tb_clients')->insert([
            'client_name'=>$request->client_name,
            'branch_id'=>$request->branch_id,
            'client_phone'=>$request->client_phone,
            'client_email'=>$request->client_email,
            'client_address'=>$request->client_address,
            'created_by'=>Auth::user()->id,
            'created_at'=>Carbon::now()->toDateTimeString(),
            'updated_at'=>Carbon::now()->toDateTimeString()
        ]);
        if ($client_create) {
            return response()->json(['success' => 'Client Added successfully.']);
        } else {
            return 0;
        }
    }

    /**
     * Client edit form.
     */
    public function client_edit($id){
        $client = DB::table('tb_clients')->where('id',$id)->first(['id','client_name','client_phone','client_email','client_address','status','branch_id']);
        return response()->json($client);
    }


    /**
     * Client update.
     */
    public function client_update(Request $request){

        $rules = array(
            'edit_branch_id'=>'required',
            'client_name'=>'required',
            'client_phone'=>'required',
            'client_address'=>'required',
        );
        $error = Validator::make($request->all(), $rules);
        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }
        $client_update=DB::table('tb_clients')->where('id',$request->id)->update([
            'client_name'=>$request->client_name,
            'branch_id'=>$request->edit_branch_id,
            'client_phone'=>$request->client_phone,
            'client_email'=>$request->client_email,
            'client_address'=>$request->client_address,
            'status'=>$request->c_status,
            'created_by'=>Auth::user()->id,
            'created_at'=>Carbon::now()->toDateTimeString(),
            'updated_at'=>Carbon::now()->toDateTimeString()
        ]);
        if ($client_update) {
            return response()->json(['success' => 'Client Update Successfully !!!']);
        }
    }

   /**
     * Client profile with project list.
     */
    public function clientProfile($id){
     $id=base64_decode($id);
     $client_details=DB::table('tb_clients')->where('tb_clients.id',$id)
     ->leftjoin('tb_branch','tb_clients.branch_id','=','tb_branch.id')
     ->first();
     $client_project_list=DB::table('tb_project')->where('client_id',$id)
     ->select('tb_project.*',DB::raw('abs(DATEDIFF(tb_project.start_date,tb_project.end_date)) as days'))
     ->get();
     return view('backend.project.client.client_wise_project',compact('client_details','client_project_list'));
    }

}
