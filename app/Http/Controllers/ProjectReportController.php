<?php

namespace App\Http\Controllers;

use DB;
use PDF;
use Auth;
use Session;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Repositories\Settings;

class ProjectReportController extends Controller
{
    public function index(){
        $this->checkuserRole(['admin','super-admin','branch-manager'],'');
        return view('backend.report.project.index');
    }

    public function projectSearch(){
        $this->checkuserRole(['admin','super-admin','branch-manager'],'');
        $branches=DB::table('tb_branch')->where('status',1)->select('id','branch_name')->get();
        return view('backend.report.project.projectsearch',compact('branches'));
    }

    public function projectList_getajax($id){
        $project=DB::table('tb_project')
        ->where('branch_id',$id)
        ->select('id','project_name')
        ->get();
        return response()->json($project);

    }

    public function projectHigh(){
        $this->checkuserRole(['admin','super-admin','branch-manager'],'');
        $branch=DB::table('tb_branch')->where('status',1)->select('id','branch_name')->get();
        return view('backend.report.project.highpriority_project',compact('branch'));
    }

    public function project_date_wise(){
        $this->checkuserRole(['admin','super-admin','branch-manager'],'');
        $branch=DB::table('tb_branch')->where('status',1)->select('id','branch_name')->get();
        return view('backend.report.project.datewise_project',compact('branch'));
    }

    public function projectList_high($id){
        $prority=DB::table('tb_project')
        ->where('branch_id',$id)
        ->where('priority',1)
        ->select('id','project_name','priority')
        ->get();
        return response()->json($prority);
    }


    public function projectLow(){
          $this->checkuserRole(['admin','super-admin','branch-manager'],'');
        $branch=DB::table('tb_branch')->where('status',1)->select('id','branch_name')->get();
        return view('backend.report.project.lowpriority_project',compact('branch'));
    }

    public function projectList_low($id){
        $prority=DB::table('tb_project')
        ->where('branch_id',$id)
        ->where('priority',0)
        ->select('id','project_name','priority')
        ->get();
        return response()->json($prority);
        // return view('backend.ajax.get_project',compact('prority'));
    }

    //branch wise project show or download
    public function projectPreviewDownload(Request $request){
        $project=DB::table('tb_project')->where('tb_project.id',$request->project_id)
        ->leftjoin('tb_clients','tb_project.client_id','=','tb_clients.id')
        ->leftjoin('tb_employee','tb_project.team_leader','=','tb_employee.id')
        ->select('tb_project.*','tb_clients.client_name','tb_project.id as project_id','tb_employee.employeeId','tb_employee.emp_first_name','tb_employee.emp_lastName','tb_project.branch_id as project_branch_id',DB::raw('abs(DATEDIFF(tb_project.start_date,tb_project.end_date)) as days'))
        ->first();

        $assign_member=DB::table('tb_assign_project')->where('tb_assign_project.project_id',$project->project_id)
        ->leftjoin('tb_employee','tb_assign_project.member_id','=','tb_employee.id')
        ->select('tb_employee.emp_first_name','tb_employee.employeeId','tb_employee.emp_lastName','tb_employee.emp_photo')
        ->groupBy('tb_assign_project.member_id')
        ->get();

        $project_manager=DB::table('tb_assign_project')->where('tb_assign_project.project_id',$project->project_id)
        ->leftjoin('users','tb_assign_project.assign_by','=','users.id')
        ->leftjoin('tb_employee','users.emp_id','=','tb_employee.id')
        ->select('users.name','tb_employee.emp_first_name','tb_employee.employeeId','tb_employee.emp_lastName','tb_employee.emp_photo')
        ->first();

        if($request->preview){
         return view('backend.report.project.preview.branch_wise_project',compact('project','assign_member','project_manager'));
        }
        else{
        echo "Coming Soon";
        }

    }


    //hign priority project show or download
    public function projectHighPreviewDownload(Request $request){
        $project=DB::table('tb_project')->where('tb_project.id',$request->project_id)
        ->leftjoin('tb_clients','tb_project.client_id','=','tb_clients.id')
        ->leftjoin('tb_employee','tb_project.team_leader','=','tb_employee.id')
        ->select('tb_project.*','tb_clients.client_name','tb_project.id as project_id','tb_employee.employeeId','tb_employee.emp_first_name','tb_employee.emp_lastName','tb_project.branch_id as project_branch_id',DB::raw('abs(DATEDIFF(tb_project.start_date,tb_project.end_date)) as days'))
        ->first();

        $assign_member=DB::table('tb_assign_project')->where('tb_assign_project.project_id',$project->project_id)
        ->leftjoin('tb_employee','tb_assign_project.member_id','=','tb_employee.id')
        ->select('tb_employee.emp_first_name','tb_employee.employeeId','tb_employee.emp_lastName','tb_employee.emp_photo')
        ->groupBy('tb_assign_project.member_id')
        ->get();

        $project_manager=DB::table('tb_assign_project')->where('tb_assign_project.project_id',$project->project_id)
        ->leftjoin('users','tb_assign_project.assign_by','=','users.id')
        ->leftjoin('tb_employee','users.emp_id','=','tb_employee.id')
        ->select('users.name','tb_employee.emp_first_name','tb_employee.employeeId','tb_employee.emp_lastName','tb_employee.emp_photo')
        ->first();

        if($request->preview){
         return view('backend.report.project.preview.high_priority_project',compact('project','assign_member','project_manager'));
        }
        else{
        echo "Coming Soon";
        }
    }


     //low priority project show or download
     public function projectLowPreviewDownload(Request $request){
        $project=DB::table('tb_project')->where('tb_project.id',$request->project_id)
        ->leftjoin('tb_clients','tb_project.client_id','=','tb_clients.id')
        ->leftjoin('tb_employee','tb_project.team_leader','=','tb_employee.id')
        ->select('tb_project.*','tb_clients.client_name','tb_project.id as project_id','tb_employee.employeeId','tb_employee.emp_first_name','tb_employee.emp_lastName','tb_project.branch_id as project_branch_id',DB::raw('abs(DATEDIFF(tb_project.start_date,tb_project.end_date)) as days'))
        ->first();

        $assign_member=DB::table('tb_assign_project')->where('tb_assign_project.project_id',$project->project_id)
        ->leftjoin('tb_employee','tb_assign_project.member_id','=','tb_employee.id')
        ->select('tb_employee.emp_first_name','tb_employee.employeeId','tb_employee.emp_lastName','tb_employee.emp_photo')
        ->groupBy('tb_assign_project.member_id')
        ->get();

        $project_manager=DB::table('tb_assign_project')->where('tb_assign_project.project_id',$project->project_id)
        ->leftjoin('users','tb_assign_project.assign_by','=','users.id')
        ->leftjoin('tb_employee','users.emp_id','=','tb_employee.id')
        ->select('users.name','tb_employee.emp_first_name','tb_employee.employeeId','tb_employee.emp_lastName','tb_employee.emp_photo')
        ->first();

        if($request->preview){
         return view('backend.report.project.preview.low_priority_project',compact('project','assign_member','project_manager'));
        }
        else{
        echo "Coming Soon";
        }
     }


   //date wise project preview
     public function project_date_wise_preview_download(Request $request){
        $start=date('Y-m-d',strtotime($request->start_date));
        $end=date('Y-m-d',strtotime($request->end_date));
        $project=DB::table('tb_project')->where('branch_id',$request->branch_id)
        ->select('tb_project.*','tb_project.id as project_id',DB::raw('abs(DATEDIFF(tb_project.start_date,tb_project.end_date)) as days'))
        ->whereBetween('created_at', [$start,$end])
        ->get();
        if($request->preview){
            return view('backend.report.project.preview.date_wise_project_preview',compact('project'));
           }
           else{
           echo "Coming Soon";
           }
     }


     //project report details profile
     public function project_report_details_profile($id){
        $project=DB::table('tb_project')->where('tb_project.id',$id)
        ->leftjoin('tb_clients','tb_project.client_id','=','tb_clients.id')
        ->leftjoin('tb_employee','tb_project.team_leader','=','tb_employee.id')
        ->select('tb_project.*','tb_clients.client_name','tb_project.id as project_id','tb_employee.employeeId','tb_employee.emp_first_name','tb_employee.emp_lastName','tb_project.branch_id as project_branch_id',DB::raw('abs(DATEDIFF(tb_project.start_date,tb_project.end_date)) as days'))
        ->first();


        $assign_member=DB::table('tb_assign_project')->where('tb_assign_project.project_id',$id)
        ->leftjoin('tb_employee','tb_assign_project.member_id','=','tb_employee.id')
        ->select('tb_employee.emp_first_name','tb_employee.employeeId','tb_employee.emp_lastName','tb_employee.emp_photo')
        ->groupBy('tb_assign_project.member_id')
        ->get();
   

        $project_manager=DB::table('tb_assign_project')->where('tb_assign_project.project_id',$id)
        ->leftjoin('users','tb_assign_project.assign_by','=','users.id')
        ->leftjoin('tb_employee','users.emp_id','=','tb_employee.id')
        ->select('users.name','tb_employee.emp_first_name','tb_employee.employeeId','tb_employee.emp_lastName','tb_employee.emp_photo')
        ->first();

        return view('backend.report.project.preview.date_wise_project_profile',compact('project','assign_member','project_manager'));
     }


}
