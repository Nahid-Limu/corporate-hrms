<?php

namespace App\Http\Controllers;

use App\AttendanceMachineData;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use App\Repositories\Settings;

use App\Imports\AttendanceMachineDataImport;

class AttendanceController extends Controller
{   
     protected $settings;
    public function __construct()
    {
         $this->settings = new Settings();
    } 



    public function create(){
         $this->checkuserRole(['admin','super-admin','branch-manager'],''); 

        $files=DB::table('tb_attendance_file')->orderBy('upload_date','desc')
            ->take(5)
            ->get();
        return view('backend.attendance.create',compact('files'));
    }

    public function store(Request $request){
        $rule=[
            'title'=>'required',
            'file'=>'required|mimes:xlsx,xlsm,xls',
        ];

        $check = Validator::make($request->all(), $rule);

        if($check->fails())
        {
            return response()->json(['errors' => $check->errors()->all()]);
        }

        if($file=$request->file('file')){
            if($file->getSize()>1000000){
                return response()->json(['errors'=> ["File size limit exceeded. Max size limit is 10 MB"]]);
            }
            $name=time().".".$file->getClientOriginalExtension();
            $file->move(base_path('attendance_file/'),$name);
            DB::table('tb_attendance_file')->insert([
                'title'=>$request->title,
                'description'=>$request->description,
                'attendance_file'=>$name,
                'process_status'=>0,
                'upload_date'=>Carbon::now()->toDateTimeString(),
            ]);
        }

        $recent_files=DB::table('tb_attendance_file')
            ->orderBy('upload_date','desc')
            ->take(5)
            ->get();

        return view('backend.attendance.ajax.recent_files',compact('recent_files'));
    }

    public function file_process($id){
        $id=base64_decode($id);
        $file=DB::table('tb_attendance_file')->where('id','=',$id)->first();
        return view('backend.attendance.attendance_process',compact('file'));
    }

    public function ajax_process_file($id){
        $id=base64_decode($id);
        $file_name=DB::table('tb_attendance_file')->where(['id'=>$id])->first()->attendance_file;
        $path=base_path()."/attendance_file/$file_name";
        try {
            $array = (new AttendanceMachineDataImport)->toArray($path);
        }
        catch (\Exception $e){
            return "File Not Found";

        }
        if(!empty($array)){
            foreach ($array[0] as $key => $value) {
                if($key==0){
                    if($value[0]=="Device Name" && $value[6]=="Time"){
                        continue;
                    }
                    else{
                        return "Invalid Excel Content";
                    }
                }

                $insert[] = [
                    'device_name' => $value[0],
                    'door' => $value[1],
                    'emp_no' => $value[4],
                    'card_no' => $value[5],
                    'time' => $value[6],
                    'event_explanation' => $value[7],
                    'attendance_file_id' => $id,
                ];
            }

            DB::table('attendance_machine_data')->insert($insert);

            $att=DB::select("SELECT attendance_machine_data.card_no, tb_employee.id AS emp_id, 
                MIN(TIME(attendance_machine_data.time)) as in_time, MAX(TIME(attendance_machine_data.time)) 
                as out_time, DATE(attendance_machine_data.time) as date FROM attendance_machine_data 
                JOIN tb_employee ON tb_employee.emp_card_number =attendance_machine_data.card_no 
                GROUP BY attendance_machine_data.card_no, DATE(attendance_machine_data.time) 
                HAVING attendance_machine_data.card_no is not null");

            $ids=[];
            foreach ($att as $key => $value) {
                $emp_id=$value->emp_id;
                if($emp_id!=null){
                    $checkEmp = DB::table('tb_attendance')->where(['emp_id' => $emp_id, 'attendance_date' => $value->date])->get();
                    if(count($checkEmp)){
                        $id = $checkEmp[0]->id;
                        $ids[]=$id;
                        $ddate=$value->date;
                        $otime=$value->out_time;
                        if($checkEmp[0]->in_time>$otime)
                        {
                            $temp=$checkEmp[0]->in_time;
                            $checkEmp[0]->in_time=$otime;
                            $otime=$temp;
                        }
                        $updateInsert[]=[
                            'id'=>$id,
                            'emp_id'=>$emp_id,
                            'in_time'=>$checkEmp[0]->in_time,
                            'out_time'=>$otime,
                            'attendance_date'=>$ddate,

                        ];
                    }
                    else{
                        $secondInsert[] = [
                            'emp_id' => $emp_id,
                            'in_time' => $value->in_time,
                            'out_time' => $value->out_time,
                            'attendance_date' => $value->date,
                        ];
                    }
                }
            }
            if(!empty($ids))
            {
                DB::table('tb_attendance')->whereIn('id',$ids)->delete();
                DB::table('tb_attendance')->insert($updateInsert);
            }
            if (!empty($secondInsert)) {
                DB::table('tb_attendance')->insert($secondInsert);
            }
            DB::table('attendance_machine_data')->truncate();
            DB::table('tb_attendance_file')->where('id','=',$id)->update([
                'process_status'=>1,
                'process_date'=>Carbon::now()->toDateTimeString(),
            ]);
            return "Job Done";

        }
        else{
            return "Empty";
        }
    }

    public function index(){
         $this->checkuserRole(['admin','super-admin','branch-manager'],''); 
        $files=DB::table('tb_attendance_file')->orderBy('upload_date','desc')
            ->get(['tb_attendance_file.id','title','description','attendance_file','upload_date','process_status','process_date']);
        if(request()->ajax())
        {
            return datatables()->of($files)
                ->addIndexColumn()
                ->make(true);
        }

        return view('backend.attendance.index');
    }

    public function manual_attendance(){
          $this->checkuserRole(['admin','super-admin','branch-manager'],'');
        return view('backend.attendance.manual_attendance');
    }

    public function create_attendance(){
       
        if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('super-admin')){
             $branch_list2=$this->settings->branchname_loginemployee();
             $branch=DB::table('tb_branch')->get();
             return view('backend.attendance.create_attendance',compact('branch','branch_list2'));
        }else{
              $branch_list2=$this->settings->branchname_loginemployee();
              $branch=DB::table('tb_branch')->get();
             return view('backend.attendance.create_attendance',compact('branch','branch_list2'));
        }
        
    }

    public function store_attendance(Request $request){
        $rule=[
            'emp_id'=>'required',
            'attendance_date'=>'required',
            'in_time'=>'required',
        ];

        $check = Validator::make($request->all(), $rule);

        if($check->fails())
        {
            return response()->json(['errors' => $check->errors()->all()]);
        }

        if(strtotime($request->in_time)>strtotime($request->out_time)){
            return "Greater";

        }
        $check=DB::table('tb_attendance')
            ->where('attendance_date','=',$request->attendance_date)
            ->where('emp_id','=',$request->emp_id)
            ->count();
        if ($check==0) {
            DB::table('tb_attendance')->insert([
                'emp_id' => $request->emp_id,
                'in_time' => Carbon::parse($request->in_time)->toTimeString(),
                'out_time' => Carbon::parse($request->out_time)->toTimeString(),
                'attendance_date' => Carbon::parse($request->attendance_date)->toDateString(),
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
            ]);
            return "success";
        }
        else{
            return "exist";
        }
    }

    public function edit_attendance(){

        if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('super-admin')){
            $branch_list2=$this->settings->branchname_loginemployee();
            $branch=DB::table('tb_branch')->get();
            return view('backend.attendance.edit_attendance',compact('branch','branch_list2'));
        }else{
             $branch_list2=$this->settings->branchname_loginemployee();
            $branch=DB::table('tb_branch')->get();
            return view('backend.attendance.edit_attendance',compact('branch','branch_list2'));
        }
        

    }

    public function get_attendance_data($emp_id,$date){
        $check=DB::table('tb_attendance')
            ->where('attendance_date','=',$date)
            ->where('emp_id','=',$emp_id)->first();

        if(!empty($check)){
            return response()->json([
                'in_time'=>Carbon::parse($check->in_time)->format('g:i A'),
                'out_time'=>Carbon::parse($check->out_time)->format('g:i A'),
            ]);
        }
        else{
            return "Not Found";

        }

    }

    public function update_attendance(Request $request, $emp_id, $date){
        $rule=[
            'emp_id'=>'required',
            'attendance_date'=>'required',
            'in_time'=>'required',
        ];

        $check = Validator::make($request->all(), $rule);

        if($check->fails())
        {
            return response()->json(['errors' => $check->errors()->all()]);
        }

        if(strtotime($request->in_time)>strtotime($request->out_time)){
            return "Greater";

        }
        $check=DB::table('tb_attendance')
            ->where('attendance_date','=',$date)
            ->where('emp_id','=',$emp_id)
            ->first();
        if(!empty($check)){
            DB::table('tb_attendance')
                ->where('attendance_date','=',$date)
                ->where('emp_id','=',$emp_id)
                ->update([
                    'in_time' => Carbon::parse($request->in_time)->toTimeString(),
                    'out_time' => Carbon::parse($request->out_time)->toTimeString(),
                    'updated_at' => Carbon::now()->toDateTimeString(),

                ]);
            return "success";

        }
        else{
            return "Not Found";
        }

    }

    public function delete_attendance(){

        if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('super-admin')){
            $branch_list2=$this->settings->branchname_loginemployee();
            $branch=DB::table('tb_branch')->get();
            return view('backend.attendance.delete_attendance',compact('branch','branch_list2'));
        }else{
            $branch_list2=$this->settings->branchname_loginemployee();
            $branch=DB::table('tb_branch')->get();
            return view('backend.attendance.delete_attendance',compact('branch','branch_list2'));
        }
        

    }

    public function destroy_attendance($emp_id,$date){
        $check=DB::table('tb_attendance')
            ->where('attendance_date','=',$date)
            ->where('emp_id','=',$emp_id)
            ->first();
        if(empty($check)){
            return "Not Found";
        }
        DB::table('tb_attendance')->where('id','=',$check->id)->delete();

        return "success";

    }

    public function create_attendance_date(){
         $this->checkuserRole(['admin','super-admin','branch-manager'],''); 
        if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('super-admin')){
             $branch_list2=$this->settings->branchname_loginemployee();
            $branch=DB::table('tb_branch')->get();
            return view('backend.attendance.create_attendance_date', compact('branch','branch_list2'));
        }
        else{
             $branch_list2=$this->settings->branchname_loginemployee();
            $branch=DB::table('tb_branch')->get();
        return view('backend.attendance.create_attendance_date', compact('branch','branch_list2'));
        }
    }

    public function manual_attendance_date_wise_data(Request $request){
//        return $request->all();
        $start_date=Carbon::parse($request->start_date)->toDateString();
        $end_date=Carbon::parse($request->end_date)->toDateString();
        if($start_date<=$end_date){
            $employee=DB::table('tb_employee')
                ->where('tb_employee.id','=',$request->emp_id)
                ->first();
            return view('backend.attendance.manual_attendance_date_wise_date',compact('employee','start_date','end_date'));

        }
        else{
            Session::flash('error','Start Date Can Not Be Greater Than End Date');
            return \redirect()->back();
        }

    }

    public function manual_attendance_data_store(Request $request){
        $data_count=count($request->date);
        $data=[];
        $update=0;
        for($i=0;$i<$data_count;$i++){
            if ($request->out_time[$i] == null) {
                $out_time = $request->in_time[$i];

            }
            elseif ($request->out_time[$i]<$request->in_time[$i]){
                $out_time = $request->in_time[$i];

            }
            else {
                $out_time = $request->out_time[$i];

            }
            if($request->update[$i]==0) {
                if ($request->in_time[$i] != null) {
                    $data[] = [
                        'emp_id' => $request->emp_id,
                        'attendance_date' => $request->date[$i],
                        'in_time' => $request->in_time[$i],
                        'out_time' => $out_time,
                    ];
                }
            }
            if ($request->update[$i]==1){
                $update=1;
                DB::table('tb_attendance')->where('emp_id','=',$request->emp_id)
                    ->where('attendance_date','=',$request->date[$i])->update([
                        'in_time'=>$request->in_time[$i],
                        'out_time'=>$out_time,
                        'emp_id' => $request->emp_id,
                    ]);
            }

        }
        if(!empty($data)){
            DB::table('tb_attendance')->insert($data);

            Session::flash('success','Attendance Data Inserted/Updated Successfully');
            return redirect(route('attendance.create_attendance_date'));
        }
        elseif(empty($data) && $update==0){
            Session::flash('error','Data Insertion Failed No Data Found');
            return redirect(route('attendance.create_attendance_date'));
        }

        Session::flash('success','Attendance Data Inserted/Updated Successfully');
        return redirect(route('attendance.create_attendance_date'));
    }

}
