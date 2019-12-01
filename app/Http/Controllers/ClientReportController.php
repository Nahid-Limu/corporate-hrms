<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Settings;
use PDF;
use DB;
use Auth;
use Session;


class ClientReportController extends Controller
{
    protected $settings;

    public function __construct()
    {
        // create object of settings class
        $this->settings = new Settings();
    }
    public function index(){
        return view('backend.report.client.index');
    }

  // client list view
    public function clientList(Request $request){
          $this->checkuserRole(['admin','super-admin','branch-manager'],'');

        if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('super-admin')){
               $branch=$this->settings->all_branch();
                $branch_list2=$this->settings->branchname_loginemployee();
                return view('backend.report.client.client_list',compact('branch','branch_list2'));
        }else{
                $branch=$this->settings->all_branch();
                $branch_list2=$this->settings->branchname_loginemployee();
                return view('backend.report.client.client_list',compact('branch','branch_list2'));
        }
     
    }

    //client List Preview or download branch wise
    public function clientListPreviewPdf(Request $request){
       $company=$this->settings->companyInformation();
       $client=DB::table('tb_clients')->where('branch_id',$request->branch_id)->get();
       if($request->preview){
        return view('backend.report.client.preview.client_preview',compact('client'));
       }else{
        $pdf = \PDF::loadView('backend.report.client.pdf.client_download', compact('client','company'));
        return $pdf->download('client_list.pdf');
       }
    }


     //client project view
     public function clientProject(){
          $this->checkuserRole(['admin','super-admin','branch-manager'],'');

        if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('super-admin')){
            $branch_list2=$this->settings->branchname_loginemployee();
            $branch=$this->settings->all_branch();
            return view('backend.report.client.client_project',compact('branch','branch_list2'));
        }else{

        }
            $branch=$this->settings->all_branch();
            $branch_list2=$this->settings->branchname_loginemployee();
            return view('backend.report.client.client_project',compact('branch','branch_list2'));
     }


      //client project list Preview or download branch wise
      public function clientProjectList(Request $request){
        $company=$this->settings->companyInformation();
        $branch=DB::table('tb_branch')->where('id',$request->branch_id)->first();
        $client_project=DB::table('tb_clients')->where('tb_clients.branch_id',$request->branch_id)
        ->leftjoin('tb_project','tb_project.client_id','=','tb_clients.id')
        ->select('tb_project.*','tb_clients.*',DB::raw('abs(DATEDIFF(tb_project.start_date,tb_project.end_date)) as days'))
        ->get();
        if($request->preview){
            return view('backend.report.client.preview.client_project_preview',compact('client_project','branch'));
           }else{
            $pdf = \PDF::loadView('backend.report.client.pdf.client_project_download',compact('client_project','company','branch'));
            return $pdf->download('client_project_list.pdf');
        }
    }

    public function Process_salary_report(){
        return view('backend.report.client.pdf.client_salary_report_download');
    }







}
