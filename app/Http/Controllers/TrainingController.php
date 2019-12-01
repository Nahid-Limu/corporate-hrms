<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use Carbon\Carbon;
use Validator;
use App\Repositories\Settings;

class TrainingController extends Controller
{

    protected $training;
    public function __construct()
    {
        // create object of settings class
        $this->training = new Settings();
    }

    /**
     * Training View page.
     */
    public function index(){
          $this->checkuserRole(['admin','super-admin','branch-manager'],'');

        if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('super-admin')){
             $training_list = DB::table('tb_training')
            ->leftJoin('users','tb_training.created_by','=','users.id')
            ->leftJoin('tb_branch','tb_training.branch_id','=','tb_branch.id')
            ->select('tb_training.id','tb_training.training_name','tb_training.training_start','tb_training.training_end','tb_training.duration','users.name as created_by','tb_training.training_month','tb_training.status as training_status','tb_training.training_institution','tb_training.training_month','tb_branch.branch_name')
            ->orderBy('tb_training.id','DESC')
            ->get();
            $branch=$this->training->all_branch();
            $branch_list2=$this->training->branchname_loginemployee();

        if(request()->ajax())
        {
            return datatables()->of($training_list)
                ->addColumn('action', function($data){
                    $button = '<button type="button" name="edit" id="'.$data->id.'" class="edit btn btn-blue btn-xs" data-toggle="modal" data-target="#editTraining" data-placement="top" title="Edit"><i class="fa fa-edit"></i></button>';
                    $button .= '&nbsp;&nbsp;';
                    return $button;
                })
                ->editColumn('training_start', function ($training_list) {
                    return date('F-d-Y', strtotime($training_list->training_start));
                })
                ->editColumn('training_start', function ($training_list) {
                    return date('F-d-Y', strtotime($training_list->training_start));
                })
                ->editColumn('training_month', function ($training_list) {
                    return date('F-Y', strtotime($training_list->training_month));
                })
                ->rawColumns(['action'])
				->addIndexColumn()
                ->make(true);
        }
        return view('backend.training.training_list',compact('training_list','branch','branch_list2'));
        }else{
             $branch_emp_id=$this->training->branchname_loginemployee();
             $training_list = DB::table('tb_training')
            ->leftJoin('users','tb_training.created_by','=','users.id')
            ->leftJoin('tb_branch','tb_training.branch_id','=','tb_branch.id')
            ->select('tb_training.id','tb_training.training_name','tb_training.training_start','tb_training.training_end','tb_training.duration','users.name as created_by','tb_training.training_month','tb_training.status as training_status','tb_training.training_institution','tb_training.training_month','tb_branch.branch_name')
            ->orderBy('tb_training.id','DESC')
            ->where('tb_training.branch_id', $branch_emp_id->id)
            ->get();
            $branch=$this->training->all_branch();
            $branch_list2=$this->training->branchname_loginemployee();

        if(request()->ajax())
        {
            return datatables()->of($training_list)
                ->addColumn('action', function($data){
                    $button = '<button type="button" name="edit" id="'.$data->id.'" class="edit btn btn-blue btn-xs" data-toggle="modal" data-target="#editTraining" data-placement="top" title="Edit"><i class="fa fa-edit"></i></button>';
                    $button .= '&nbsp;&nbsp;';
                    return $button;
                })
                ->editColumn('training_start', function ($training_list) {
                    return date('F-d-Y', strtotime($training_list->training_start));
                })
                ->editColumn('training_start', function ($training_list) {
                    return date('F-d-Y', strtotime($training_list->training_start));
                })
                ->editColumn('training_month', function ($training_list) {
                    return date('F-Y', strtotime($training_list->training_month));
                })
                ->rawColumns(['action'])
				->addIndexColumn()
                ->make(true);
        }
        return view('backend.training.training_list',compact('training_list','branch','branch_list2'));
        }
       
    }




    /**
     * Create new training after some validation.
     */

    public function trainingStore(Request $request){
        $rules = array(
            'branch_id'=>'required',
            'training_name'=>'required',
            'duration'=>'required',
            'training_start'=>'required',
            'training_end'=>'required',
            'training_institution'=>'required',
            'training_month'=>'required',
            'description'=>'required',
            'training_attachment'=>'required',

        );
        $error = Validator::make($request->all(), $rules);
        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        if($request->hasFile('training_attachment')) {
            $attachment = $request->file('training_attachment');
            $new_file = 'training_attachment' . '-' . time() . '.' . $attachment->getClientOriginalExtension();
            $attachment->move(('training_attachment'), $new_file);
            $training_create = DB::table('tb_training')->insert([
                'branch_id'=>$request->branch_id,
                'training_name'=>$request->training_name,
                'duration'=>$request->duration,
                'training_start'=>$request->training_start,
                'training_end'=>$request->training_end,
                'training_institution'=>$request->training_institution,
                'training_month'=>$request->training_month,
                'description'=>$request->description,
                'training_attachment'=>$new_file,
                'status'=>1,
                'created_by'=>Auth::user()->id,
                'created_at'=>Carbon::now()->toDateTimeString(),
                'updated_at'=>Carbon::now()->toDateTimeString()
            ]);
            return response()->json(['success' => 'Training has been Created successfully.']);
        }

    }

    /**
     * Training Edit.
     */
    public function trainingEdit($id){
      $trainingEdit=DB::table('tb_training')->where('id',$id)->first();
      return response()->json($trainingEdit);
    }

    /**
     * Training update.
     */

    public function trainingUpdate(Request $request){

        $rules = array(
            'training_name'=>'required',
            'duration'=>'required',
            'training_start'=>'required',
            'training_end'=>'required',
            'training_institution'=>'required',
            'training_month'=>'required',
            'description'=>'required',
        );
        $error = Validator::make($request->all(), $rules);
        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }
        if($request->hasFile('training_attachment')) {
            $attachment = $request->file('training_attachment');
            $new_file = 'training_attachment' . '-' . time() . '.' . $attachment->getClientOriginalExtension();
            $attachment->move(('training_attachment'), $new_file);
            $trainingUpdate = DB::table('tb_training')->where('id',$request->id)->update([
                'branch_id' =>$request->edit_branch,
                'training_name'=>$request->training_name,
                'duration'=>$request->duration,
                'training_start'=>$request->training_start,
                'training_end'=>$request->training_end,
                'training_institution'=>$request->training_institution,
                'training_month'=>$request->training_month,
                'description'=>$request->description,
                'training_attachment'=>$new_file,
                'status'=>$request->training_status,
                'created_by'=>Auth::user()->id,
                'created_at'=>Carbon::now()->toDateTimeString(),
                'updated_at'=>Carbon::now()->toDateTimeString()
            ]);
            return response()->json(['success' => 'Training has been update successfully.']);
        }else{
            $trainingUpdate=DB::table('tb_training')->where('id',$request->id)->update([
                'branch_id' =>$request->edit_branch,
                'training_name'=>$request->training_name,
                'duration'=>$request->duration,
                'training_start'=>$request->training_start,
                'training_end'=>$request->training_end,
                'training_institution'=>$request->training_institution,
                'training_month'=>$request->training_month,
                'description'=>$request->description,
                'training_attachment'=>$request->attachment_default,
                'status'=>$request->training_status,
                'created_by'=>Auth::user()->id,
                'created_at'=>Carbon::now()->toDateTimeString(),
                'updated_at'=>Carbon::now()->toDateTimeString()

            ]);
            return response()->json(['success' => 'Training has been update successfully.']);
        }

    }

    /**
     * Training details.
     */

    public function trainingDetails($id){
        $training_details=DB::table('tb_training')->where('tb_training.id',$id)
        ->leftjoin('users','tb_training.created_by','=','users.id')
        ->leftjoin('tb_branch','tb_training.branch_id','=','tb_branch.id')
        ->get();
        return response()->json($training_details);
    }

    /**
     * Training details.
     */
    public function assignMember($id){
       $assign_member=DB::table('tb_assign_training')->where('training_id',$id)
       ->leftjoin('tb_employee','tb_assign_training.emp_id','=','tb_employee.id')
       ->leftjoin('tb_branch','tb_assign_training.branch_id','=','tb_branch.id')
       ->select('tb_employee.employeeId','tb_employee.emp_first_name','tb_branch.branch_name')
       ->get();
        return response()->json($assign_member);
    }


    /**
     * Training assign.
     */
    public function assignTraining(){
          $this->checkuserRole(['admin','super-admin','branch-manager'],'');
        if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('super-admin')){
              $training=$this->training->all_training();
              $branch=$this->training->all_branch();
              $branch_list2=$this->training->branchname_loginemployee();
          return view('backend.training.assign_training',compact('training','branch','branch_list2'));
        }else{
            $training=$this->training->all_training();
            $branch=$this->training->all_branch();
            $branch_list2=$this->training->branchname_loginemployee();
        return view('backend.training.assign_training',compact('training','branch','branch_list2'));
        }
        
    }

    /**
     * assign member store.
     */
    public function assignMemberStore(Request $request){
            foreach ($request->member_id as $key => $member) {
                $assign_training[] = [
                    'branch_id' =>$request->branch_id,
                    'training_id' =>$request->project_id,
                    'emp_id' =>$member,
                    'assigned_by' =>auth()->user()->id,
                    'created_at'=>Carbon::now()->toDateTimeString(),
                    'updated_at'=>Carbon::now()->toDateTimeString(),
                ];
            }
            DB::table('tb_assign_training')->insert($assign_training);
            return response()->json(['success' => 'Training Assign successfully']);
    }

    /**
     * Training Request.
     */
    public function trainingRequest(){
        $training_request = DB::table('tb_request_training')
            ->leftJoin('tb_employee','tb_request_training.emp_id','=','tb_employee.id')
            ->leftJoin('tb_training','tb_request_training.training_id','=','tb_training.id')
            ->select('tb_training.id','tb_training.training_name','tb_training.training_start','tb_training.training_end','tb_training.duration','tb_training.training_month','tb_training.status as training_status','tb_training.training_institution','tb_training.training_month','tb_request_training.status as request_status','tb_employee.employeeId','tb_employee.emp_first_name','tb_request_training.id as request_id')
            ->orderBy('tb_request_training.id','DESC')
            ->get();
        if(request()->ajax())
        {
            return datatables()->of($training_request)
                ->addColumn('action', function($data){
                    if($data->request_status==0){
                        $button = '<button type="button" name="edit" id="'.$data->request_id.'" class="approve btn btn-success btn-xs" data-toggle="modal" data-target="#editTraining" data-placement="top" title="Approve"><i class="fa fa-check"></i></button>';
                        $button .= '&nbsp;&nbsp;';
                        return $button;
                    }else{
                        $button = '<button type="button" name="edit" id="'.$data->request_id.'" class="rejected btn btn-danger btn-xs" data-toggle="modal" data-target="#editTraining" data-placement="top" title="Rejected"><i class="fa fa-times"></i></button>';
                        $button .= '&nbsp;&nbsp;';
                        return $button;
                    }
                })
                ->editColumn('training_start', function ($training_request) {
                    return date('F-d-Y', strtotime($training_request->training_start));
                })
                ->editColumn('training_start', function ($training_request) {
                    return date('F-d-Y', strtotime($training_request->training_start));
                })
                ->editColumn('training_month', function ($training_request) {
                    return date('F-Y', strtotime($training_request->training_month));
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }
       return view('backend.training.employee_training_request');
    }


    /**
     * Training status approve or rejected.
     */
    public function trainingStatus($id){
        $status=DB::table('tb_request_training')->where('id',$id)->update([
           'status' =>$_GET['status_value']
        ]);
        if($_GET['status_value']==0){
            return response()->json(['error' => 'Training Request has been rejected']);
        }
        else{
            return response()->json(['success' => 'Training Request has been approved']);
        }
    }


}
