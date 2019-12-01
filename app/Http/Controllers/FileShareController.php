<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use Carbon\Carbon;
use Validator;
use App\Repositories\Settings;

class FileShareController extends Controller
{
    protected $fileShare;
    public function __construct()
    {
        // create object of settings class
        $this->fileShare = new Settings();
    }

    /**
     * file share view.
     */
    public function index(){

        $haserole = $this->checksuperadmin(['employee']);
       if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('super-admin')){
            $employee=$this->fileShare->all_employee();
            $branch=$this->fileShare->all_branch();
            $department=$this->fileShare->all_department();
            $designation=$this->fileShare->all_designation();
       }
        if($haserole){
            $branch=$this->fileShare->employeeBranch();
            $employee=$this->fileShare->all_employee();
            $department=$this->fileShare->employeeDepartment();
            $designation=$this->fileShare->employeeDesignation();
        }if(auth()->user()->hasRole('branch-manager')){
            $employee=$this->fileShare->branchall_employee();
            $branch=$this->fileShare->branchname_loginemployee();
            $department=$this->fileShare->employeeDepartmentBranch();
            $designation=$this->fileShare->all_designation();
        }
        return view('backend.file_share.index',compact('employee','branch','department','designation','haserole'));
    }




    /**
     * file store to database.
     */
    public function fileStore(Request $request){

        if($request->type_id==1){
          if($request->hasfile('share_file_one'))
          {
                foreach($request->file('share_file_one') as $image)
                {
                    $name=$image->getClientOriginalName();
                    $image->move(public_path().'/share_file/', $name);
                    $data[] = $name;
                    $insert=DB::table('tb_file_sharing')->insert([
                    'shared_group_type' =>$request->type_id,
                    'referenceId' =>$request->emp_id,
                    'shared_date' =>date('Y-m-d'),
                    'attachment' =>$name,
                    'emp_id' =>$request->emp_id,
                    'shared_by' =>auth()->user()->id,
                    'created_at'=>Carbon::now()->toDateTimeString(),
                    'updated_at'=>Carbon::now()->toDateTimeString()
                ]);

                }
               return response()->json(['success' => 'File has been share successfully']);
           }

        }


        if($request->type_id==2){
            if($request->hasfile('share_file_two')) {
                foreach ($request->file('share_file_two') as $image) {
                    $name = $image->getClientOriginalName();
                    $image->move(public_path() . '/share_file/', $name);
                    $data[] = $name;
                    foreach ($request->emp_id_multiple as $employee) {
                        $insert = DB::table('tb_file_sharing')->insert([
                            'shared_group_type' => $request->type_id,
                            'referenceId' => $employee,
                            'shared_date' => date('Y-m-d'),
                            'attachment' => $name,
                            'emp_id' => $employee,
                            'shared_by' =>auth()->user()->id,
                            'created_at' => Carbon::now()->toDateTimeString(),
                            'updated_at' => Carbon::now()->toDateTimeString()
                        ]);
                    }
                }
                return response()->json(['success' => 'File has been share successfully']);
            }
        }


        if($request->type_id==3){
            if($request->hasfile('share_file_three'))
            {
                foreach($request->file('share_file_three') as $image)
                {
                    $name=$image->getClientOriginalName();
                    $image->move(public_path().'/share_file/', $name);
                    $data[] = $name;
                    $insert=DB::table('tb_file_sharing')->insert([
                        'shared_group_type' =>$request->type_id,
                        'referenceId' =>$request->branch_id,
                        'shared_date' =>date('Y-m-d'),
                        'attachment' =>$name,
                        'branch_id' =>$request->branch_id,
                        'shared_by' =>auth()->user()->id,
                        'created_at'=>Carbon::now()->toDateTimeString(),
                        'updated_at'=>Carbon::now()->toDateTimeString()
                    ]);

                }
                return response()->json(['success' => 'File has been share successfully']);
            }
        }

        if($request->type_id==4){
            if($request->hasfile('share_file_four'))
            {
                foreach($request->file('share_file_four') as $image)
                {
                    $name=$image->getClientOriginalName();
                    $image->move(public_path().'/share_file/', $name);
                    $data[] = $name;
                    $insert=DB::table('tb_file_sharing')->insert([
                        'shared_group_type' =>$request->type_id,
                        'referenceId' =>$request->dept_id,
                        'shared_date' =>date('Y-m-d'),
                        'attachment' =>$name,
                        'department_id' =>$request->dept_id,
                        'shared_by' =>auth()->user()->id,
                        'created_at'=>Carbon::now()->toDateTimeString(),
                        'updated_at'=>Carbon::now()->toDateTimeString()
                    ]);

                }
                return response()->json(['success' => 'File has been share successfully']);
            }
        }


        if($request->type_id==5){
            if($request->hasfile('share_file_five'))
            {
                foreach($request->file('share_file_five') as $image)
                {
                    $name=$image->getClientOriginalName();
                    $image->move(public_path().'/share_file/', $name);
                    $data[] = $name;
                    $insert=DB::table('tb_file_sharing')->insert([
                        'shared_group_type' =>$request->type_id,
                        'referenceId' =>$request->designation_id,
                        'shared_date' =>date('Y-m-d'),
                        'attachment' =>$name,
                        'designation_id' =>$request->designation_id,
                        'shared_by' =>auth()->user()->id,
                        'created_at'=>Carbon::now()->toDateTimeString(),
                        'updated_at'=>Carbon::now()->toDateTimeString()
                    ]);

                }
                return response()->json(['success' => 'File has been share successfully']);
            }
        }
    }
}
