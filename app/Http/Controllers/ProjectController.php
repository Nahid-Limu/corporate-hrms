<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use PDF;
use Auth;
use Carbon\Carbon;
use Validator;
use App\Repositories\Settings;
use Session;



class ProjectController extends Controller
{

    protected $project;
    public function __construct()
    {
        // create object of settings class
        $this->project = new Settings();
    }
    /**
     * All Project List.
     */
    public function index(){

        if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('super-admin')){
            $client_list=$this->project->all_client();
            $branch_list=$this->project->all_branch();
            $branch_list2=$this->project->branchname_loginemployee();
            $project_list = DB::table('tb_project')
                ->leftJoin('users','tb_project.created_by','=','users.id')
                ->leftJoin('tb_clients','tb_project.client_id','=','tb_clients.id')
                ->leftJoin('tb_employee','tb_project.team_leader','=','tb_employee.id')
                ->leftJoin('tb_branch','tb_project.branch_id','=','tb_branch.id')
                ->select('tb_project.id','tb_project.project_name','tb_project.start_date','tb_project.end_date','tb_project.price','users.name as created_by','tb_project.priority','tb_project.status as project_status','tb_clients.client_name','tb_employee.emp_first_name','tb_employee.emp_lastName','tb_branch.branch_name')
                ->get();
            if(request()->ajax())
        {
            return datatables()->of($project_list)
                ->addColumn('action', function($data){
                    $button = '<button type="button" name="edit" id="'.$data->id.'" class="edit btn btn-blue btn-xs" data-toggle="modal" data-target="#editProject" data-placement="top" title="Edit"><i class="fa fa-edit"></i></button> <a target="_blank" class="profile btn btn-blue btn-xs" title="View Profile" href="'.route('project_profile',base64_encode($data->id)).'"><i class="fa fa-eye"></i></a>';
                    $button .= '&nbsp;&nbsp;';
                    return $button;
                })
                ->editColumn('start_date', function ($project_list) {
                    return date('d/m/Y', strtotime($project_list->start_date));
                })
                ->editColumn('end_date', function ($project_list) {
                    return date('d/m/Y', strtotime($project_list->end_date));
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }
        return view('backend.project.project_list',compact('client_list','branch_list','branch_list2'));
        }else{

        $client_list=$this->project->all_client();
        $branch_list=$this->project->all_branch();
        $branch_list2=$this->project->branchname_loginemployee();
        $branch_emp_id=$this->project->branchname_loginemployee();
        $project_list = DB::table('tb_project')
            ->leftJoin('users','tb_project.created_by','=','users.id')
            ->leftJoin('tb_clients','tb_project.client_id','=','tb_clients.id')
            ->leftJoin('tb_employee','tb_project.team_leader','=','tb_employee.id')
            ->leftJoin('tb_branch','tb_project.branch_id','=','tb_branch.id')
            ->select('tb_project.id','tb_project.project_name','tb_project.start_date','tb_project.end_date','tb_project.price','users.name as created_by','tb_project.priority','tb_project.status as project_status','tb_clients.client_name','tb_employee.emp_first_name','tb_employee.emp_lastName','tb_branch.branch_name')
            ->where('tb_employee.branch_id', $branch_emp_id->id)
            ->get();
        if(request()->ajax())
        {
            return datatables()->of($project_list)
                ->addColumn('action', function($data){
                    $button = '<button type="button" name="edit" id="'.$data->id.'" class="edit btn btn-blue btn-xs" data-toggle="modal" data-target="#editProject" data-placement="top" title="Edit"><i class="fa fa-edit"></i></button>';
                    $button .= '&nbsp;&nbsp;';
                    return $button;
                })
                ->editColumn('start_date', function ($project_list) {
                    return date('d/m/Y', strtotime($project_list->start_date));
                })
                ->editColumn('end_date', function ($project_list) {
                    return date('d/m/Y', strtotime($project_list->end_date));
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }
        return view('backend.project.project_list',compact('client_list','branch_list','branch_list2'));
        }

    }


    /**
     * Create new project after some validation.
     */

    public function projectStore(Request $request){
        $rules = array(
            'project_name'=>'required',
            'client_name'=>'required',
            'team_leader'=>'required',
            'start_date'=>'required',
            'end_date'=>'required',
            'price'=>'required',
            'priority'=>'required',
            'attachment'=>'required',
            'description'=>'required',
        );
        $error = Validator::make($request->all(), $rules);
        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        if($request->hasFile('attachment')) {
            $attachment = $request->file('attachment');
            $new_file = 'project_attachment' . '-' . time() . '.' . $attachment->getClientOriginalExtension();
            $attachment->move(('project_attachment'), $new_file);
            $project_create = DB::table('tb_project')->insert([
                'project_name'=>$request->project_name,
                'client_id'=>$request->client_name,
                'team_leader'=>$request->team_leader,
                'branch_id'=>$request->all_branch,
                'start_date'=>$request->start_date,
                'end_date'=>$request->end_date,
                'price'=>$request->price,
                'priority'=>$request->priority,
                'attachment'=>$new_file,
                'description'=>$request->description,
                'status'=>1,
                'created_by'=>Auth::user()->id,
                'created_at'=>Carbon::now()->toDateTimeString(),
                'updated_at'=>Carbon::now()->toDateTimeString()
            ]);
            return response()->json(['success' => 'Project Created successfully.']);
        }

    }


    /**
     * branch wise employee or team leader ajax request.
     */
     public function teamLeader($id){
       $teamLeader=DB::table('tb_employee')->where('branch_id',$id)->select('tb_employee.id as emp_id','emp_first_name','emp_lastName','tb_employee.employeeId')->get();
       return response()->json($teamLeader);
     }


     //branch client
     public function branchClient($id){
       $client=DB::table('tb_clients')->where('branch_id',$id)->get();
       return response()->json($client);
     }



    /**
     * project edit id wise.
     */
     public function projectEdit($id){
         $project = DB::table('tb_project')
             ->leftJoin('users','tb_project.created_by','=','users.id')
             ->leftJoin('tb_clients','tb_project.client_id','=','tb_clients.id')
             ->leftJoin('tb_employee','tb_project.team_leader','=','tb_employee.id')
             ->select('tb_project.id','tb_project.project_name','tb_project.start_date','tb_project.end_date','tb_project.price','users.name as created_by','tb_project.priority','tb_project.status as project_status','tb_clients.client_name','tb_employee.emp_first_name','tb_employee.emp_lastName','tb_project.description','tb_clients.id as c_id','tb_project.client_id as cli_id','tb_employee.id as emp_id','tb_project.team_leader as team_id','tb_project.status as project_status','tb_project.attachment')
             ->where('tb_project.id',$id)
             ->first();
         return response()->json($project);
     }

    /**
     * project update id wise.
     */
    public function projectUpdate(Request $request){
        $rules = array(
            'project_name'=>'required',
            'client_name'=>'required',
            'team_leader'=>'required',
            'start_date'=>'required',
            'end_date'=>'required',
            'price'=>'required',
            'priority'=>'required',
            'description'=>'required',
        );
        $error = Validator::make($request->all(), $rules);
        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        if($request->hasFile('attachment')) {
            $attachment = $request->file('attachment');
            $new_file = 'project_attachment' . '-' . time() . '.' . $attachment->getClientOriginalExtension();
            $attachment->move(('project_attachment'), $new_file);
            $project_update = DB::table('tb_project')->where('id',$request->id)->update([
                'project_name'=>$request->project_name,
                'client_id'=>$request->client_name,
                'team_leader'=>$request->team_leader,
                'branch_id'=>$request->all_branch,
                'start_date'=>$request->start_date,
                'end_date'=>$request->end_date,
                'price'=>$request->price,
                'priority'=>$request->priority,
                'attachment'=>$new_file,
                'description'=>$request->description,
                'status'=>$request->project_status,
                'created_by'=>Auth::user()->id,
                'created_at'=>Carbon::now()->toDateTimeString(),
                'updated_at'=>Carbon::now()->toDateTimeString()
            ]);
            return response()->json(['success' => 'Project Update successfully.']);
        }else{
            $project_update = DB::table('tb_project')->where('id',$request->id)->update([
                'project_name'=>$request->project_name,
                'client_id'=>$request->client_name,
                'team_leader'=>$request->team_leader,
                'branch_id'=>$request->all_branch,
                'start_date'=>$request->start_date,
                'end_date'=>$request->end_date,
                'price'=>$request->price,
                'priority'=>$request->priority,
                'attachment'=>$request->attachment_default,
                'description'=>$request->description,
                'status'=>$request->project_status,
                'created_by'=>Auth::user()->id,
                'created_at'=>Carbon::now()->toDateTimeString(),
                'updated_at'=>Carbon::now()->toDateTimeString()
            ]);
            return response()->json(['success' => 'Project Update successfully.']);
        }

    }


    /**
     * Assign Project.
     */
    public function assignProject(){
        if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('super-admin')){
            $branch_list2=$this->project->branchname_loginemployee();
            $project_list=$this->project->active_project();
            $branch=$this->project->all_branch();
            return view('backend.project.assign_project',compact('project_list','branch','branch_list2'));
        }else{
            $branch_list2=$this->project->branchname_loginemployee();

             $project_list=$this->project->active_project();
            $branch=$this->project->all_branch();
            return view('backend.project.assign_project',compact('project_list','branch','branch_list2'));
        }

    }

    /**
     * id wise project details.
     */
    public function projectDetails($id){
        $project = DB::table('tb_project')
            ->leftJoin('users','tb_project.created_by','=','users.id')
            ->leftJoin('tb_clients','tb_project.client_id','=','tb_clients.id')
            ->leftJoin('tb_branch','tb_project.branch_id','=','tb_branch.id')
            ->leftJoin('tb_employee','tb_project.team_leader','=','tb_employee.id')
            ->select('tb_project.id','tb_project.project_name','tb_project.start_date','tb_project.end_date','tb_project.price','users.name as created_by','tb_project.priority','tb_project.status as project_status','tb_clients.client_name','tb_employee.emp_first_name','tb_employee.emp_lastName','tb_project.description','tb_clients.id as c_id','tb_project.client_id as cli_id','tb_employee.id as emp_id','tb_project.team_leader as team_id','tb_project.status as project_status','tb_project.attachment','tb_branch.branch_name','tb_project.status as project_status',DB::raw('abs(DATEDIFF(tb_project.start_date,tb_project.end_date)) as days'))
            ->where('tb_project.id',$id)
            ->get();
        return response()->json($project);
    }


    /**
     * already exists assign project member.
     */

    public function assignMember($id){
        $assign_member=DB::table('tb_assign_project')->where('project_id',$id)
        ->leftjoin('tb_employee','tb_assign_project.member_id','=','tb_employee.id')
        ->leftjoin('tb_branch','tb_employee.branch_id','=','tb_branch.id')
        ->select('tb_employee.employeeId','tb_employee.emp_first_name','tb_branch.branch_name')
        ->groupBy('tb_assign_project.member_id')
        ->get();
        return response()->json($assign_member);
    }


    /**
     * project assign data store.
     */
    public function projectAssignStore(Request $request){
               foreach ($request->member_id as $key => $member) {
                   $assign_project[] = [
                       'branch_id' =>$request->branch_id,
                       'project_id' =>$request->project_id,
                       'member_id' =>$member,
                       'assign_by' =>auth()->user()->id,
                       'created_at'=>Carbon::now()->toDateTimeString(),
                       'updated_at'=>Carbon::now()->toDateTimeString(),
                   ];
               }
               DB::table('tb_assign_project')->insert($assign_project);
               return response()->json(['success' => 'Project has been successfully Assigned']);
        }


      //assign project list login employee wise

      public function assignMemberProject(){
        $assign_member=DB::table('tb_assign_project')->where('tb_assign_project.member_id',auth()->user()->emp_id)
        ->leftjoin('tb_project','tb_assign_project.project_id','=','tb_project.id')
        ->leftjoin('tb_employee','tb_project.team_leader','=','tb_employee.id')
        ->leftjoin('users','tb_assign_project.assign_by','=','users.id')
        ->select('tb_project.*','tb_project.id as pro_id','tb_employee.emp_first_name','tb_employee.emp_lastName','tb_employee.employeeId','users.name as assigned_by','tb_project.status as project_status',DB::raw('abs(DATEDIFF(tb_project.start_date,tb_project.end_date)) as days'))
        ->groupBy('tb_assign_project.project_id')
        ->get();
        if(request()->ajax())
        {
            return datatables()->of($assign_member)
                ->editColumn('start_date', function ($assign_member) {
                    return date('F-d-Y', strtotime($assign_member->start_date));
                })
                ->addColumn('attachment', function($data){
                    if ($data->attachment != null) {
                        $asset = asset('project_attachment').'/'.$data->attachment ;
                        $button = '<a href="'.$asset.'" target="_blank"><span style="color:green">Open</span><i class="fa fa-download pull-right" aria-hidden="true"></i></a>';
                        $button .= '&nbsp;&nbsp;';
                    return $button;
                    }else {
                        return '<span style="color:red">No Attachment</span>';
                    }

                })
                ->editColumn('end_date', function ($assign_member) {
                    return date('F-d-Y', strtotime($assign_member->end_date));
                })

                ->addColumn('action_btn', function($assign_member){
                    return '<a target="_blank" class="profile btn btn-blue btn-xs" title="View Project Details" href="'.url('project/profile', base64_encode($assign_member->pro_id)).'"><i class="fa fa-eye"></i></a> <a target="_blank" class="profile btn btn-blue btn-xs" title="View All Task" href="'.url('project/employee/task/list', base64_encode($assign_member->pro_id)).'"><i class="fa fa-tasks"></i> Show Task</a>';
                })
                ->rawColumns(['action','attachment','action_btn'])
                ->addIndexColumn()
                ->make(true);
        }
        return view('backend.project.employee_assigned_project_list');
      }

  //assign project list login employee wise
  public function projectProfile($id){
    $id=base64_decode($id);
    $project=DB::table('tb_project')->where('tb_project.id',$id)
    ->leftjoin('tb_clients','tb_project.client_id','=','tb_clients.id')
    ->leftjoin('tb_employee','tb_project.team_leader','=','tb_employee.id')
    ->select('tb_project.*','tb_clients.client_name','tb_project.id as project_id','tb_employee.employeeId','tb_employee.emp_first_name','tb_employee.emp_lastName','tb_project.branch_id as project_branch_id',DB::raw('abs(DATEDIFF(tb_project.start_date,tb_project.end_date)) as days'))
    ->first();

    $assign_member=DB::table('tb_assign_project')->where('tb_assign_project.project_id',$id)
    ->leftjoin('tb_employee','tb_assign_project.member_id','=','tb_employee.id')
    ->select('tb_employee.emp_first_name','tb_employee.employeeId','tb_employee.emp_lastName','tb_employee.emp_photo','tb_assign_project.member_id')
    ->groupBy('tb_assign_project.member_id')
    ->get();
    $project_manager=DB::table('tb_project')->where('tb_project.id',$id)
    ->leftjoin('users','tb_project.created_by','=','users.id')
    ->leftjoin('tb_employee','users.emp_id','=','tb_employee.id')
    ->select('users.name','tb_employee.emp_first_name','tb_employee.employeeId','tb_employee.emp_lastName','tb_employee.emp_photo')
    ->first();
    return view('backend.project.profile.project_profile',compact('project','assign_member','project_manager','id'));
  }

  //assign task project wise view
  public function projectTask($projectid,$memberid){
    $projectid=base64_decode($projectid);
    $memberid=base64_decode($memberid);

    $employee=DB::table('tb_assign_project')->where('project_id',$projectid)->where('member_id',$memberid)
    ->leftjoin('tb_employee','tb_employee.id','=','tb_assign_project.member_id')
    ->select('tb_employee.id as emp_id','tb_employee.employeeId','tb_employee.emp_first_name','tb_employee.emp_lastName')
    ->first();

    $employee_task=DB::table('tb_project_assign_task')->where('project_id',$projectid)->where('emp_id',$memberid)
    ->leftjoin('tb_employee','tb_employee.id','=','tb_project_assign_task.emp_id')
    ->leftjoin('tb_project','tb_project_assign_task.project_id','=','tb_project.id')
    ->select('tb_project.project_name','tb_employee.id as emp_id','tb_employee.employeeId','tb_employee.emp_first_name','tb_employee.emp_lastName','tb_project_assign_task.task_title','tb_project_assign_task.task_description','tb_project_assign_task.due_date','tb_project_assign_task.status as task_status','tb_project_assign_task.id as main_id')
    ->orderBy('tb_project_assign_task.id','DESC')
    ->get();

    return view('backend.project.assign_task.task_create',compact('employee','employee_task','projectid'));
  }

  //project task store
  public function projectTaskStore(Request $request){
      $check_data=DB::table('tb_project_assign_task')->where('project_id',$request->project_id)->where('emp_id',$request->emp_id)->where('due_date',$request->task_due_date)->count();
      if($check_data>0){
        $delete=DB::table('tb_project_assign_task')->where('project_id',$request->project_id)->where('emp_id',$request->emp_id)->where('due_date',$request->task_due_date)->delete();
      }
      for($i=0;$i<count($request->task_title);$i++){
        $insert=DB::table('tb_project_assign_task')->insert([
          'project_id'        =>  $request->project_id,
          'emp_id'            =>  $request->emp_id,
          'task_title'        =>  $request->task_title[$i],
          'task_description'  =>  $request->task_description[$i],
          'due_date'          =>  $request->task_due_date[$i],
          'status'            =>  0,
          'created_at'=>Carbon::now()->toDateTimeString(),
          'updated_at'=>Carbon::now()->toDateTimeString()
        ]);
      }
      Session::flash('success','Task has been assigned successfully');
      return redirect()->back();
  }

  //project assign task update
  public function project_assign_task_update(Request $request){
    $update=DB::table('tb_project_assign_task')->where('id',$request->task_edit_id)->update([
        'task_title'        =>  $request->task_title,
        'task_description'  =>  $request->task_description,
        'due_date'          =>  $request->task_due_date,
        'created_at'=>Carbon::now()->toDateTimeString(),
        'updated_at'=>Carbon::now()->toDateTimeString()
    ]);
    Session::flash('success','Task has been update successfully');
    return redirect()->back();
  }


  //project assign task delete
  public function project_assign_task_delete(Request $request){
    $delete=DB::table('tb_project_assign_task')->where('id',$request->task_delete_id)->delete();
    Session::flash('error','Task has been deleted successfully');
    return redirect()->back();
  }

  //project wise group chat conversation
  public function projectGroupChat(Request $request){
    $insert=DB::table('tb_project_group_chat')->insert([
        'project_id'           =>  $request->project_id,
        'emp_id'               =>  auth()->user()->emp_id,
        'conversation'         =>  $request->conversation,
        'created_at'=>Carbon::now()->toDateTimeString(),
        'updated_at'=>Carbon::now()->toDateTimeString()
      ]);
   }


  //group chat conversation latest message load
  public function latestChatMessage($id){
    $conversation=DB::table('tb_project_group_chat')->where('project_id',$id)
    ->leftjoin('tb_employee','tb_employee.id','=','tb_project_group_chat.emp_id')
    ->select('tb_employee.employeeId','tb_employee.emp_first_name','tb_employee.emp_lastName','tb_project_group_chat.conversation','tb_project_group_chat.created_at','tb_project_group_chat.emp_id as chat_id')
    ->orderBy('tb_project_group_chat.id','ASC')
    ->get();
    return response()->json($conversation);
  }


  //employee project wise assign task list
  public function assignTaskListProject($id){
   $id=base64_decode($id);
   $date=date('Y-m-d');
   $task=DB::table('tb_project_assign_task')
   ->where('project_id',$id)->where('emp_id',auth()->user()->emp_id)->where('status',0)
   ->select('tb_project_assign_task.*','tb_project_assign_task.id as main_id')
   ->orderBy('tb_project_assign_task.id','DESC')
   ->get();
   return view('backend.project.assign_project_task_list',compact('task'));
  }

  //employee update task status project wise
  public function updateTaskStatus(Request $request){
      $update_task_status=DB::table('tb_project_assign_task')->where('id',$request->task_id)->update([
        'status' =>$request->task_status
      ]);
      Session::flash('success','Task has been update successfully');
      return redirect()->back();
  }


}
