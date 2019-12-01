<?php

namespace App\Http\Controllers; 

use DB;
use Auth;
use Carbon\Carbon;
use Validator;
use App\Repositories\Settings;

use Illuminate\Http\Request;

class FavouritesController extends Controller
{   

    protected $branche;
    public function __construct()
    {
        // create object of settings class
        $this->branche = new Settings();
    }

    // =====================================  Favourite List  ============================================

    public function favourites_list()
    {   

        if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('super-admin')){
        $employee_list = DB::table('tb_employee')->select('id','emp_first_name','emp_lastName','employeeId')->get();
        $branch_list=$this->branche->all_branch();
        $branch_list2=$this->branche->branchname_loginemployee();
        $favourites_list = DB::table('tb_favourites')->orderBy('id', 'desc')
        ->leftJoin('users','tb_favourites.created_by','=','users.id')
        ->leftJoin('tb_employee','tb_favourites.emp_id','=','tb_employee.id')
        ->leftJoin('tb_branch','tb_employee.branch_id','=','tb_branch.id')
        ->leftJoin('tb_designations','tb_employee.emp_designation_id','=','tb_designations.id')
        ->select('tb_favourites.id','tb_favourites.status','users.name','tb_employee.emp_first_name','tb_employee.employeeId','tb_branch.branch_name','tb_designations.designation_name')
        
        ->get();
        //dd($favourites_list);
        if(request()->ajax())
        {
            return datatables()->of($favourites_list)
                    ->addColumn('action', function($data){
                        $button = '<button type="button" name="edit" id="'.$data->id.'" class="edit btn btn-blue btn-xs" data-toggle="modal" data-target="#editFavourite" data-placement="top" title="Edit"><i class="fa fa-edit"></i></button>';
                        $button .= '&nbsp;&nbsp;';
                        
                        return $button;
                    })
                    // ->editColumn('group_name', function ($group_list) {
                    //     return ucwords($group_list->group_name);
                    // })
                    // ->editColumn('emp_first_name', function ($group_list) {
                    //     return ucwords($group_list->emp_first_name);
                    // })
                    ->rawColumns(['action'])
                    ->addIndexColumn()
                    ->make(true);
        }

        return view('backend.favourites.favourites_list',compact('employee_list','branch_list','branch_list2'));
        }else{
        $branch_id=$this->branche->branchname_loginemployee();
        $branch_list2=$this->branche->branchname_loginemployee();
        $employee_list = DB::table('tb_employee')->select('id','emp_first_name','emp_lastName','employeeId')->get();
        $branch_list=$this->branche->all_branch();
        $favourites_list = DB::table('tb_favourites')->orderBy('id', 'desc')
        ->leftJoin('users','tb_favourites.created_by','=','users.id')
        ->leftJoin('tb_employee','tb_favourites.emp_id','=','tb_employee.id')
        ->leftJoin('tb_branch','tb_employee.branch_id','=','tb_branch.id')
        ->leftJoin('tb_designations','tb_employee.emp_designation_id','=','tb_designations.id')
        ->select('tb_favourites.id','tb_favourites.status','users.name','tb_employee.emp_first_name','tb_employee.employeeId','tb_branch.branch_name','tb_designations.designation_name')
        ->where('tb_employee.branch_id', $branch_id->id)
        ->get();
        //dd($favourites_list);
        if(request()->ajax())
        {
            return datatables()->of($favourites_list)
                    ->addColumn('action', function($data){
                        $button = '<button type="button" name="edit" id="'.$data->id.'" class="edit btn btn-blue btn-xs" data-toggle="modal" data-target="#editFavourite" data-placement="top" title="Edit"><i class="fa fa-edit"></i></button>';
                        $button .= '&nbsp;&nbsp;';
                        
                        return $button;
                    })
                    // ->editColumn('group_name', function ($group_list) {
                    //     return ucwords($group_list->group_name);
                    // })
                    // ->editColumn('emp_first_name', function ($group_list) {
                    //     return ucwords($group_list->emp_first_name);
                    // })
                    ->rawColumns(['action'])
                    ->addIndexColumn()
                    ->make(true);
        }

        return view('backend.favourites.favourites_list',compact('employee_list','branch_list','branch_list2'));
        }
        
       
    }  

    // ===================================== End Favourite List  ============================================


    // ===================================== Favourite ADD  ============================================
    
    public function favourites_add(Request $request)
    {
       $rules = array(
            'emp_id'=>'required|unique:tb_favourites', 
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $favourites_create = DB::table('tb_favourites')->insert([
            'emp_id'=>$request->emp_id,
            'status'=>1,
            'created_by'=>Auth::user()->id,
            'created_at'=>Carbon::now()->toDateTimeString(),
            'updated_at'=>Carbon::now()->toDateTimeString()
        ]);

        if ($favourites_create) {
            return response()->json(['success' => 'Favourite has been successfully added.']);
         } else {
            return 0;
         }
    } 

    // ===================================== End Favourite ADD  ============================================


    // ===================================== Favourite Edit  ============================================
    
    public function favourites_edit($id)
    {   
        // $favourites_edit = DB::table('tb_favourites')->where('id',4)->first(['id','emp_id','status']);


         $favourites_edit = DB::table('tb_favourites')
             ->leftJoin('tb_employee','tb_favourites.emp_id','=','tb_employee.id')
             ->leftJoin('tb_branch','tb_employee.branch_id','=','tb_branch.id')
             ->select('tb_favourites.id','tb_favourites.status','tb_employee.emp_first_name',
           'tb_favourites.emp_id as fav_emp_id','tb_branch.id as branch_id') 
             ->where('tb_favourites.id',$id)
             ->first();
        return response()->json($favourites_edit);
    } 
    
    // ===================================== End Favourite Edit  ============================================

    // ===================================== Favourite Update  ============================================

    public function favourites_update(Request $request)
    {

        
            // return response()->json(['success' => $request->id]);
    //  TODO:employee edit page cannot show employee name 
    
    $favourite =  DB::table('tb_favourites')
    ->where('emp_id',$request->edit_emp_id)
    ->first();
      
                 
            if ($favourite) {
                $favourite_update =  DB::table('tb_favourites')
                ->where('id',$request->id)
                ->update(
                [
                    'status' =>$request->status
                ]
                
            );


      
            if ($favourite->status != $request->status) {
                return response()->json(['success' => ' Status Update !!!']);
               
            }else {
                return response()->json(['falied' => 'Update Nothing.']);
            }
        }else {
            $favourite_update =  DB::table('tb_favourites')
            ->where('id',$request->id)
            ->update(
                [
                    'emp_id' =>$request->edit_emp_id,
                    'status' =>$request->status
                    
                ]
            );
            if ($favourite_update) {
                return response()->json(['success' => 'Update successfully !!!']);
                //return "Department added Successfully";
            } else {
                return response()->json(['falied' => 'Update Nothing.']);
            }
        }
          
    }


     public function favouritesemployeeId($id){

       $employeeId=DB::table('tb_employee')->where('branch_id',$id)->select('tb_employee.id as emp_id','emp_first_name','emp_lastName','tb_employee.employeeId')->get();
       return response()->json($employeeId);
     }

    // ===================================== Favourite Update  ============================================


}
