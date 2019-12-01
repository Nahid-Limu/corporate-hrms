<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use Carbon\Carbon;
use Session;
use Validator;
class CompanyInformationController extends Controller
{
    /**
     * Retive company info from table and show in blade
     */
    public function company_information_view()
    {   
        $this->checkuserRole(['admin','super-admin','branch-manager'],'');
        $company_info = DB::table('tb_company_information')->get();
        return view('backend.company_info.company_info_view',compact('company_info'));
    }

    /**
     * add new company information
     */
    public function companyInfo_add(Request $request)
    {
        if ($request->hasFile('company_logo')) {
            $logoName = time().'.'.$request->company_logo->getClientOriginalExtension();
            $request->company_logo->move(('company_info'),$logoName);
        }else{
            $logoName='company_logo.png';
        }
        $company_create = DB::table('tb_company_information')->insert([
            'company_name'=>$request->company_name,
            'company_logo'=>$logoName,
            'company_phone'=>$request->company_phone,
            'company_email'=>$request->company_email,
            'company_address'=>$request->company_address,
            'created_at'=>Carbon::now()->toDateTimeString(),
            'updated_at'=>Carbon::now()->toDateTimeString()
        ]);
        Session::flash('success','Company Information has been added successfully');
        return redirect()->back();
    }

    /**
     * Edit company modal
     */
    public function company_edit($id)
    {
        $company = DB::table('tb_company_information')->where('id',$id)->first(['id','company_name','company_phone','company_email','company_address','company_logo']);
        return response()->json($company);
    }

    /**
     * Update company information
     */
    public function company_update(Request $request)
    {
        if ($request->hasFile('company_logo')) {
            $logoName = time().'.'.$request->company_logo->getClientOriginalExtension();
            $request->company_logo->move(('company_info'),$logoName);
        }else{
            $logoName=$request->default_logo;
        }
         $companyUpdate=DB::table('tb_company_information')->where('id',$request->id)->update([
            'company_name'=>$request->company_name,
            'company_logo'=>$logoName,
            'company_phone'=>$request->company_phone,
            'company_email'=>$request->company_email,
            'company_address'=>$request->company_address,
            'created_at'=>Carbon::now()->toDateTimeString(),
            'updated_at'=>Carbon::now()->toDateTimeString()
         ]);
         Session::flash('success','Company Information has been update successfully');
         return redirect()->back();
    }
}
