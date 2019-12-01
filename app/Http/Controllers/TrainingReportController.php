<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Settings;
use DB;
use PDF;

class TrainingReportController extends Controller
{
    protected $training;
    public function __construct()
    {
        // create object of settings class
        $this->training = new Settings();
    }
    //training view
    public function index(){
          $this->checkuserRole(['admin','super-admin','branch-manager'],'');

        return view('backend.report.training.index');
    }

    //date wise training view
    public function datewiseTraining(){
          $this->checkuserRole(['admin','super-admin','branch-manager'],'');

        if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('super-admin')){
          $branch_list2=$this->training->branchname_loginemployee();
            $branch=$this->training->all_branch();
        return view('backend.report.training.date_wise_training',compact('branch','branch_list2'));
        }else{
            $branch=$this->training->all_branch();
          $branch_list2=$this->training->branchname_loginemployee();
        return view('backend.report.training.date_wise_training',compact('branch','branch_list2'));
        }
        
    }

    //training request view
    public function trainingRequest(){
        $branch=$this->training->all_branch();
        return view('backend.report.training.training_request',compact('branch'));
    }

    //date wise training report download or preview
    public function date_wise_training_report(Request $request){
        $start=date('Y-m-d',strtotime($request->start_date));
        $end=date('Y-m-d',strtotime($request->end_date));
        $company=$this->training->companyInformation();
        $branch=DB::table('tb_branch')->where('id',$request->branch_id)->first();
        $training=DB::table('tb_training')->where('branch_id',$request->branch_id)
        ->leftjoin('tb_branch','tb_training.branch_id','=','tb_branch.id')
        ->select('tb_training.id as training_id','tb_training.*','tb_branch.branch_name')
        ->whereBetween('tb_training.created_at', [$start,$end])
        ->get();

        if($request->preview){
             return view('backend.report.training.preview.date_wise_training_preview',compact('training'));
           }
           else{
            foreach($training as $trainings){
                $assign_training=DB::table('tb_assign_training')->where('tb_assign_training.training_id',$trainings->training_id)
                ->leftjoin('tb_training','tb_assign_training.training_id','=','tb_training.id')
                ->leftjoin('tb_employee','tb_assign_training.emp_id','=','tb_employee.id')
                ->select('tb_employee.employeeId','tb_employee.emp_first_name','tb_employee.emp_lastName','tb_training.training_name')
                ->get();
             }
            $pdf = \PDF::loadView('backend.report.training.pdf.date_wise_training_pdf',compact('training','company','branch','assign_training'));
            return $pdf->download('training_list.pdf');
           }
    }



   //training request
   public function date_wise_training_request(Request $request){
    $start=date('Y-m-d',strtotime($request->start_date));
    $end=date('Y-m-d',strtotime($request->end_date));
    $training=DB::table('tb_request_training')->where('tb_request_training.branch_id',$request->branch_id)
    ->leftjoin('tb_branch','tb_request_training.branch_id','=','tb_branch.id')
    ->leftjoin('tb_training','tb_request_training.training_id','=','tb_training.id')
    ->leftjoin('tb_employee','tb_request_training.emp_id','=','tb_employee.id')
    ->select('tb_training.id as training_id','tb_training.*','tb_branch.branch_name','tb_request_training.status as request_status','tb_employee.*')
    ->whereBetween('tb_request_training.created_at', [$start,$end])
    ->get();
    $company=$this->training->companyInformation();
    $branch=DB::table('tb_branch')->where('id',$request->branch_id)->first();
    if($request->preview){
        return view('backend.report.training.preview.date_wise_training_request',compact('training'));
      }else{
        $pdf = \PDF::loadView('backend.report.training.pdf.date_wise_training_request_pdf',compact('training','company','branch'));
        return $pdf->download('training_list.pdf');
      }
   }




}
