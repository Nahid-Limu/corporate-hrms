<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Settings;
use DB;

class MeetingReportController extends Controller
{

    protected $settings;

    public function __construct()
    {
        // create object of settings class
        $this->settings = new Settings();
    }

     /**
     *  meeting report view.
     */
    public function index(){
          $this->checkuserRole(['admin','super-admin','branch-manager'],'');
      if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('super-admin')){
          $branch_list2=$this->settings->branchname_loginemployee();
        $branch=$this->settings->all_branch();
        return view('backend.report.meeting.meeting_report_view',compact('branch','branch_list2'));
      }else{
          $branch_list2=$this->settings->branchname_loginemployee();
        $branch=$this->settings->all_branch();
        return view('backend.report.meeting.meeting_report_view',compact('branch','branch_list2'));
      }
        
    }

    /**
     *  meeting branch wise view ajax.
     */
    public function ajax_branch_meeting($id){
       $branch_meeting=DB::table('tb_meetings')->where('branch_id',$id)->get();
       return response()->json($branch_meeting);
    }


    /**
     *  meeting report preview or download.
     */
    public function meeting_report_preview_download(Request $request){
      $meeting=DB::table('tb_meetings')->where('id',$request->meeting_id)->first();

      $assign_member=DB::table('tb_meeting_employee')->where('meeting_id',$meeting->id)
      ->leftjoin('tb_employee','tb_meeting_employee.emp_id','=','tb_employee.id')
      ->select('tb_employee.employeeId','tb_employee.emp_first_name','tb_employee.emp_lastName','tb_employee.emp_photo')
      ->get();
      $company=$this->settings->companyInformation();
      if($request->preview){
         return view('backend.report.meeting.preview.meeting_report_preview',compact('meeting','assign_member'));
      }else{
        $pdf = \PDF::loadView('backend.report.meeting.pdf.meeting_report_download',compact('meeting','assign_member','company'));
        return $pdf->download('meeting_list.pdf');
      }
    }





}
