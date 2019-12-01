<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use Carbon\Carbon;
use Validator;
use App\Repositories\Settings;

class MeetingController extends Controller
{
    protected $branch;
    public function __construct()
    {
        // create object of settings class
        $this->branch = new Settings();
    }

       /**
     * All Project List.
     */
    public function meeting_list(){ 

 $this->checkuserRole(['admin','super-admin','branch-manager'],'');
        if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('super-admin')){
        $branch_list=$this->branch->all_branch();
        $branch_list2=$this->branch->branchname_loginemployee();
        $meeting_list = DB::table('tb_meetings')
            ->leftJoin('users','tb_meetings.created_by','=','users.id')
            ->leftJoin('tb_branch','tb_meetings.branch_id','=','tb_branch.id')
            ->select('tb_meetings.*','users.name','tb_branch.branch_name')
            ->get();
        if(request()->ajax())
        {
            return datatables()->of($meeting_list)
                ->addColumn('action', function($data){
                    $button = '<button type="button" name="edit" id="'.$data->id.'" class="edit btn btn-blue btn-xs" data-toggle="modal" data-target="#editMeeting" data-placement="top" title="Edit"><i class="fa fa-edit"></i></button>';
                    $button .= '&nbsp;&nbsp;';
                    $button1 = '<button type="button" name="delete" id="'.$data->id.'" class="delete btn btn-danger btn-xs" data-toggle="modal" data-target="#deleteMeeting" data-placement="top" title="Delete"><i class="fa fa-trash-o"></i></button>';
                    $button1 .= '&nbsp;&nbsp;';
                    $button .= $button1;


                    return $button;
                })
                // ->addColumn('action', function($data){
                //     $button1 = '<button type="button" name="delete" id="'.$data->id.'" class="delete btn btn-blue btn-xs" data-toggle="modal" data-target="#deleteMeeting" data-placement="top" title="Delete"><i class="fa fa-trash"></i></button>';
                //     $button1 .= '&nbsp;&nbsp;';
                //     return $button1;
                // })
                ->editColumn('start_time', function ($meeting_list) {
                    return date('H:i:a', strtotime($meeting_list->start_time));
                })
                ->editColumn('end_time', function ($meeting_list) {
                    return date('H:i:a', strtotime($meeting_list->end_time));
                })
                ->rawColumns(['action'])
				->addIndexColumn()
                ->make(true);
        }
        return view('backend.meeting.meeting_list',compact('branch_list','branch_list2'));
        }else{
             $branch_list=$this->branch->all_branch();
            $branch_list2=$this->branch->branchname_loginemployee();
            $branch_emp_id=$this->branch->branchname_loginemployee();        
        $meeting_list = DB::table('tb_meetings')
            ->leftJoin('users','tb_meetings.created_by','=','users.id')
            ->leftJoin('tb_branch','tb_meetings.branch_id','=','tb_branch.id')
            ->select('tb_meetings.*','users.name','tb_branch.branch_name')
            ->where('tb_meetings.branch_id', $branch_emp_id->id)
            ->get();
        if(request()->ajax())
        {
            return datatables()->of($meeting_list)
                ->addColumn('action', function($data){
                    $button = '<button type="button" name="edit" id="'.$data->id.'" class="edit btn btn-blue btn-xs" data-toggle="modal" data-target="#editMeeting" data-placement="top" title="Edit"><i class="fa fa-edit"></i></button>';
                    $button .= '&nbsp;&nbsp;';
                    $button1 = '<button type="button" name="delete" id="'.$data->id.'" class="delete btn btn-danger btn-xs" data-toggle="modal" data-target="#deleteMeeting" data-placement="top" title="Delete"><i class="fa fa-trash-o"></i></button>';
                    $button1 .= '&nbsp;&nbsp;';
                    $button .= $button1;


                    return $button;
                })
                // ->addColumn('action', function($data){
                //     $button1 = '<button type="button" name="delete" id="'.$data->id.'" class="delete btn btn-blue btn-xs" data-toggle="modal" data-target="#deleteMeeting" data-placement="top" title="Delete"><i class="fa fa-trash"></i></button>';
                //     $button1 .= '&nbsp;&nbsp;';
                //     return $button1;
                // })
                ->editColumn('start_time', function ($meeting_list) {
                    return date('H:i:a', strtotime($meeting_list->start_time));
                })
                ->editColumn('end_time', function ($meeting_list) {
                    return date('H:i:a', strtotime($meeting_list->end_time));
                })
                ->rawColumns(['action'])
				->addIndexColumn()
                ->make(true);
        }
        return view('backend.meeting.meeting_list',compact('branch_list','branch_list2'));
        }

       
    }

    public function meeting_add(Request $request){

        // return response()->json('ok coming');
        $rules = array(
            'branch_id'=>'required',
            'meeting_subject'=>'required',
            'venue'=>'required',
            'meeting_date'=>'required',
            'start_time'=>'required',
            'end_time'=>'required',
            'description'=>'required',

        );
        $error = Validator::make($request->all(), $rules);
        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }
        $tb_metting= DB::table('tb_meetings')->insert([
            'branch_id'=>$request->branch_id,
            'meeting_subject'=>$request->meeting_subject,
            'venue'=>$request->venue,
            'meeting_date'=>$request->meeting_date,
            'start_time'=>$request->start_time,
            'end_time'=>$request->end_time,
            'description'=>$request->description,
            'created_by' =>auth()->user()->id
        ]);
        if ($tb_metting) {
            return response()->json(['success' => 'Meeting Added successfully.']);
            //return "Department added Successfully";
        } else {
            return 0;
        }

    }

    public function meeting_edit($id){
        $meeting=DB::table('tb_meetings')
            ->where('id','=',$id)
            //->leftJoin('branch_id','tb_meetings.branch_id','=','tb_branch.branch_id')
            ->first();

        return response()->json($meeting);
    }


    public function meeting_update(Request $request){
        $rules = array(
            'edit_meeting_subject'=>'required',
            'edit_venue'=>'required',
            'edit_meeting_date'=>'required',
            'edit_start_time'=>'required',
            'edit_end_time'=>'required',
            'edit_description'=>'required',
            'edit_status'=>'required',
            'edit_branch'=>'required',
        );
        $error = Validator::make($request->all(), $rules);
        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }
        $tb_metting_up=DB::table('tb_meetings')->where('id',$request->id)->update([
            'meeting_subject'=>$request->edit_meeting_subject,
            'venue'=>$request->edit_venue,
            'meeting_date'=>$request->edit_meeting_date,
            'start_time'=>$request->edit_start_time,
            'end_time'=>$request->edit_end_time,
            'description'=>$request->edit_description,
            'status'=>$request->edit_status,
            'branch_id'=>$request->edit_branch,
        ]);
        return response()->json(['success' => 'Meeting Update successfully']);
    }

    public function meeting_delete($id){
        $tb_metting_del=DB::table('tb_meetings')->where('tb_meetings.id',$id)->delete();
        if ($tb_metting_del) {
            return response()->json(['success' => 'Meeting has successfully  Deleted!']);

        } else {
            return 0;
        }
    }




}
