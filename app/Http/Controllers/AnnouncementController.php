<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;
use Validator;
use App\Repositories\Settings;


class AnnouncementController extends Controller
{

    protected $settings;

    public function __construct()
    {
        // create object of settings class
        $this->settings = new Settings();
    }

   public function announcement_list(){

    if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('super-admin')){
         $all_branch=$this->settings->all_branch();
        $branch_list2=$this->settings->branchname_loginemployee();

       $announcement_list=DB::table('tb_announcement')
            ->leftJoin('tb_branch','tb_announcement.branch_id','=','tb_branch.id')
            ->select('tb_announcement.*','tb_branch.branch_name')
            ->get();


       if(request()->ajax()){
           return datatables()->of($announcement_list)
           ->addColumn('action', function($data){
            $button = '<button type="button" name="edit" id="'.$data->id.'" class="edit btn btn-blue btn-xs" data-toggle="modal" data-target="#editAnnouncement" data-placement="top" title="Edit"><i class="fa fa-edit"></i></button>';
            $button .= '&nbsp;&nbsp;';
            $button1 = '<button type="button" name="delete" id="'.$data->id.'" class="delete btn btn-danger btn-xs" data-toggle="modal" data-target="#deleteAnnouncement" data-placement="top" title="Delete"><i class="fa fa-trash-o"></i></button>';
            $button1 .= '&nbsp;&nbsp;';
            $button .= $button1;

            return $button;
            })
            ->editColumn('start_date', function ($announcement_list) {
                return date('Y-m-d',strtotime($announcement_list->start_date));
            })
            ->editColumn('ann_branch_id', function ($announcement_list) {
                if($announcement_list->branch_id===0){
                   return "All";
                }else{
                    return $announcement_list->branch_name;
                }
            })
            ->editColumn('end_date', function ($announcement_list) {
                return date('Y-m-d',strtotime($announcement_list->end_date));
            })
            ->rawColumns(['action'])
			->addIndexColumn()
            ->make(true);
        }

    return view('backend.announcement.announcement_list',compact('all_branch','branch_list2'));
    }else{
         $all_branch=$this->settings->all_branch();
         $branch_emp_id=$this->settings->branchname_loginemployee();
        $branch_list2=$this->settings->branchname_loginemployee();
       $announcement_list=DB::table('tb_announcement')
            ->leftJoin('tb_branch','tb_announcement.branch_id','=','tb_branch.id')
            ->select('tb_announcement.*','tb_branch.branch_name')
            ->where('tb_announcement.branch_id', $branch_emp_id->id)
            ->orWhere('tb_announcement.branch_id', 0)
            ->get();


       if(request()->ajax()){
           return datatables()->of($announcement_list)
           ->addColumn('action', function($data){
            $button = '<button type="button" name="edit" id="'.$data->id.'" class="edit btn btn-blue btn-xs" data-toggle="modal" data-target="#editAnnouncement" data-placement="top" title="Edit"><i class="fa fa-edit"></i></button>';
            $button .= '&nbsp;&nbsp;';
            $button1 = '<button type="button" name="delete" id="'.$data->id.'" class="delete btn btn-danger btn-xs" data-toggle="modal" data-target="#deleteAnnouncement" data-placement="top" title="Delete"><i class="fa fa-trash-o"></i></button>';
            $button1 .= '&nbsp;&nbsp;';
            $button .= $button1;

            return $button;
            })
            ->editColumn('start_date', function ($announcement_list) {
                return date('Y-m-d',strtotime($announcement_list->start_date));
            })
            ->editColumn('ann_branch_id', function ($announcement_list) {
                if($announcement_list->branch_id===0){
                   return "All";
                }else{
                    return $announcement_list->branch_name;
                }
            })
            ->editColumn('end_date', function ($announcement_list) {
                return date('Y-m-d',strtotime($announcement_list->end_date));
            })
            ->rawColumns(['action'])
			->addIndexColumn()
            ->make(true);
        }

    return view('backend.announcement.announcement_list',compact('all_branch','branch_list2'));
    }
      
   }

   //  add

   public function announcement_add(Request $request){


        // return response()->json($request->all());

        $rules = array(
            'announcement_title'=>'required',
            'start_date'=>'required',
            'end_date'=>'required',
            'description'=>'required',

        );
        $error = Validator::make($request->all(), $rules);
        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $tb_announcement= DB::table('tb_announcement')->insert([
            'announcement_title'=>$request->announcement_title,
            'start_date'=>$request->start_date,
            'end_date'=>$request->end_date,
            'branch_id'=>$request->ann_branch_id,
            'description'=>$request->description,
            'created_by'=>auth()->user()->id,
            'created_at'=>Carbon::now()->toDateTimeString(),
        ]);
        if ($tb_announcement) {
            return response()->json(['success' => 'Annoncement Added successfully.']);
        } else {
            return 0;
        }

   }

   //    edit

   public function announcement_edit($id){

        $editAnnouncement=DB::table('tb_announcement')
            ->where('tb_announcement.id','=',$id)
            ->leftjoin('tb_branch','tb_announcement.branch_id','=','tb_branch.id')
            ->select('tb_announcement.*','tb_branch.id as branch_id','tb_announcement.branch_id as ann_branch_id','tb_branch.branch_name')
            ->first();

        return response()->json($editAnnouncement);
   }

   public function announcement_update(Request $request){

    // return response()->json($request->all());



        $tb_announcement=DB::table('tb_announcement')->where('id',$request->id)->update([
            'announcement_title'=>$request->edit_announcement_title,
            'start_date'=>$request->edit_start_date,
            'end_date'=>$request->edit_end_date,
            'branch_id'=>$request->edit_ann_branch_id,
            'description'=>$request->edit_description,
            'status'=>$request->edit_status,
        ]);
        if ($tb_announcement) {
            return response()->json(['success' => 'Announcement Update successfully.']);

        } else {
            return 0;
        }
    }

    public function announcement_delete($id){
        $deleteAnnouncement=DB::table('tb_announcement')->where('tb_announcement.id',$id)->delete();
        if ($deleteAnnouncement) {
            return response()->json(['success' => 'Announcement has successfully  Deleted!']);

        } else {
            return 0;
        }
    }



  public function announcements_list($id){
    $announcement_details=DB::table('tb_announcement')->where('id',$id)->first();
    return view('backend.announcement.announcement_details',compact('announcement_details'));
  }


}
