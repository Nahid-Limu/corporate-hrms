<div id="{{$employee_profile->emp_id}}" class="modal fade " role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Update Employee Information</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    {!! Form::open(['method'=>'POST','route'=>'employee.update','files'=>true]) !!}

                    <div class="col-md-12">
                        <h5>
                            <b>Personal Information</b>
                        </h5>
                        <hr>
                    </div>
                    <div class="col-md-6">
                        <div class="col-md-5">
                            Employee Id <span style="color:red">*</span>
                        </div>
                        <div class="col-md-7">
                            <div class="form-group">
                                <input type="text" class="form-control" id="employeeId" name="employeeId" value="{{$employee_profile->employeeId}}"  autocomplete="off" placeholder="Employee Id" required>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="col-md-5">
                            <label for="department_name">First Name <span style="color:red">*</span></label>
                        </div>
                        <div class="col-md-7">
                            <div class="form-group">
                                <input type="text" class="form-control" id="emp_first_name" name="first_name" value="{{$employee_profile->emp_first_name}}" autocomplete="off" placeholder="First Name" required>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="col-md-5">
                            Last Name <span style="color:red">*</span>
                        </div>
                        <div class="col-md-7">
                            <div class="form-group">
                                <input type="text" class="form-control" id="emp_lastName" name="last_name" value="{{$employee_profile->emp_lastName}}" autocomplete="off" placeholder="Last Name" required>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="col-md-5">
                            Branch <span style="color:red">*</span>
                        </div>
                        <div class="col-md-7">
                            <div class="form-group">
                                <select class="form-control" id="branch" name="branch" required>
                                    @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('super-admin'))
                                    <option value="">Select</option>
                                    @foreach($branch as $branchs)
                                        @php
                                            $selected = '';
                                            if($branchs->id == $employee_profile->branch_id)    // Any Id
                                            {
                                            $selected = 'selected="selected"';
                                            }
                                        @endphp
                                        <option value='{{ $branchs->id }}' {{$selected}} >{{ $branchs->branch_name }}</option>
                                    @endforeach
                                    @else 
                                            <option value="{{$branch_list2->id}}">{{$branch_list2->branch_name}}</option>
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="col-md-5">
                            Department <span style="color:red">*</span>
                        </div>
                        <div class="col-md-7">
                            <div class="form-group">
                                <select class="form-control" id="department" name="department" required>
                                    <option value="">Select</option>
                                    @foreach($department as $departments)
                                        @php
                                            $selected = '';
                                            if($departments->id == $employee_profile->emp_department_id)    // Any Id
                                            {
                                            $selected = 'selected="selected"';
                                            }
                                        @endphp
                                        <option value='{{ $departments->id }}' {{$selected}} >{{ $departments->department_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>



                    <div class="col-md-6">
                        <div class="col-md-5">
                            Designation <span style="color:red">*</span>
                        </div>
                        <div class="col-md-7">
                            <div class="form-group">
                                <select class="form-control" id="designation" name="designation" required>
                                    <option value="">Select</option>
                                    @foreach($designation as $designations)
                                        @php
                                            $selected = '';
                                            if($designations->id == $employee_profile->emp_designation_id)    // Any Id
                                            {
                                            $selected = 'selected="selected"';
                                            }
                                        @endphp
                                        <option value='{{ $designations->id }}' {{$selected}}>{{ $designations->designation_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>



                    <div class="col-md-6">
                        <div class="col-md-5">
                            Gender <span style="color:red">*</span>
                        </div>
                        <div class="col-md-7">
                            <div class="form-group">
                                <select class="form-control" id="emp_gender_id" name="gender" required>
                                    <option value="">Select</option>
                                    @if($employee_profile->emp_gender_id==1)
                                        <option value="1" selected>Male</option>
                                        <option value="2">Female</option>
                                        @else
                                        <option value="1">Male</option>
                                        <option value="2" selected>Female</option>
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="col-md-5">
                            Shift<span style="color:red">*</span>
                        </div>
                        <div class="col-md-7">
                            <div class="form-group">
                                <select class="form-control" id="shift" name="shift" required>
                                    <option value="">Select</option>
                                    @foreach($shift as $shifts)
                                        @php
                                            $selected = '';
                                            if($shifts->id == $employee_profile->emp_shift_id)    // Any Id
                                            {
                                            $selected = 'selected="selected"';
                                            }
                                        @endphp
                                        <option value='{{$shifts->id}}' {{$selected}}>{{$shifts->shift_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="col-md-5">
                            <label for="department_name">Father Name</label>
                        </div>
                        <div class="col-md-7">
                            <div class="form-group">
                                <input type="text" class="form-control" name="emp_father_name" id="emp_father_name" value="{{$employee_profile->emp_father_name}}" autocomplete="off">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="col-md-5">
                            <label for="department_name">Mother Name</label>
                        </div>
                        <div class="col-md-7">
                            <div class="form-group">
                                <input type="text" class="form-control" name="emp_mother_name" id="emp_mother_name" value="{{$employee_profile->emp_mother_name}}" autocomplete="off">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="col-md-5">
                            Email <span style="color:red">*</span>
                        </div>
                        <div class="col-md-7">
                            <div class="form-group">
                                <input type="email" name="email" id="emp_email" class="form-control" value="{{$employee_profile->emp_email}}" autocomplete="off" required>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="col-md-5">
                            <label for="department_name">Phone</label>
                        </div>
                        <div class="col-md-7">
                            <div class="form-group">
                                <input type="text" name="emp_phone" id="emp_phone" class="form-control" autocomplete="off" value="{{$employee_profile->emp_phone}}" placeholder="Phone">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="col-md-5">
                            Date Of Birth <span style="color:red">*</span>
                        </div>
                        <div class="col-md-7">
                            <div class="form-group">
                                <input type="date" name="date_of_birth" class="form-control" autocomplete="off" value="{{$employee_profile->emp_dob}}" required>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="col-md-5">
                            Joining date <span style="color:red">*</span>
                        </div>
                        <div class="col-md-7">
                            <div class="form-group">
                                <input type="date" name="joining_date"  class="form-control" autocomplete="off" value="{{$employee_profile->emp_joining_date}}" required>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="col-md-5">
                            <label for="department_name">Probation Period</label>
                        </div>
                        <div class="col-md-7">
                            <div class="form-group">
                                <input type="number" name="emp_probation_period" id="emp_probation_period" class="form-control" value="{{$employee_profile->emp_probation_period}}">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="col-md-5">
                            Religion <span style="color:red">*</span>
                        </div>
                        <div class="col-md-7">
                            <div class="form-group">
                                <select class="form-control" id="emp_religion" name="religion" autocomplete="off">
                                    <option value="">Select Religion</option>
                                    <option <?php if($employee_profile->emp_religion=="Islam"){ echo "selected";} ?> value="Islam">Islam</option>
                                    <option <?php if($employee_profile->emp_religion=="Hinduism"){ echo "selected";} ?>  value="Hinduism">Hinduism</option>
                                    <option <?php if($employee_profile->emp_religion=="Buddhists"){ echo "selected";} ?>  value="Buddhists">Buddhists</option>
                                    <option <?php if($employee_profile->emp_religion=="Christians"){ echo "selected";} ?>  value="Christians">Christians</option>
                                    <option <?php if($employee_profile->emp_religion=="Animists"){ echo "selected";} ?>  value="Animists">Animists</option>
                                    <option <?php if($employee_profile->emp_religion=="Others"){ echo "selected";} ?>  value="Others">Others</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="col-md-5">
                            Marital Status <span style="color:red">*</span>
                        </div>
                        <div class="col-md-7">
                            <div class="form-group">
                                <select class="form-control" id="emp_marital_status" name="marital_status" autocomplete="off">
                                    <option value="">Select Marital Status</option>
                                    @if($employee_profile->emp_marital_status==1)
                                        <option value="1" selected>Single</option>
                                        <option value="2">Married</option>
                                        <option value="3">Divorced</option>
                                        @elseif($employee_profile->emp_marital_status==2)
                                        <option value="1">Single</option>
                                        <option value="2" selected>Married</option>
                                        <option value="3">Divorced</option>
                                        @else
                                        <option value="1">Single</option>
                                        <option value="2">Married</option>
                                        <option value="3" selected>Divorced</option>
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="col-md-5">
                            Blood Group 
                        </div>
                        <div class="col-md-7">
                            <div class="form-group">
                                <select class="form-control" id="emp_blood_group" name="blood_group" autocomplete="off">
                                    <option value="">Select</option>
                                    @if($employee_profile->emp_blood_group==1)
                                        <option value="1" selected>A+</option>
                                        <option value="2">B+</option>
                                        <option value="3">AB+</option>
                                        <option value="4">O+</option>
                                        <option value="5">A-</option>
                                        <option value="6">B-</option>
                                        <option value="7">AB-</option>
                                        <option value="8">O-</option>
                                    @elseif($employee_profile->emp_blood_group==2)
                                        <option value="1">A+</option>
                                        <option value="2" selected>B+</option>
                                        <option value="3">AB+</option>
                                        <option value="4">O+</option>
                                        <option value="5">A-</option>
                                        <option value="6">B-</option>
                                        <option value="7">AB-</option>
                                        <option value="8">O-</option>
                                    @elseif($employee_profile->emp_blood_group==3)
                                        <option value="1">A+</option>
                                        <option value="2">B+</option>
                                        <option value="3" selected>AB+</option>
                                        <option value="4">O+</option>
                                        <option value="5">A-</option>
                                        <option value="6">B-</option>
                                        <option value="7">AB-</option>
                                        <option value="8">O-</option>
                                    @elseif($employee_profile->emp_blood_group==4)
                                        <option value="1">A+</option>
                                        <option value="2">B+</option>
                                        <option value="3">AB+</option>
                                        <option value="4" selected>O+</option>
                                        <option value="5">A-</option>
                                        <option value="6">B-</option>
                                        <option value="7">AB-</option>
                                        <option value="8">O-</option>
                                    @elseif($employee_profile->emp_blood_group==5)
                                        <option value="1">A+</option>
                                        <option value="2">B+</option>
                                        <option value="3">AB+</option>
                                        <option value="4">O+</option>
                                        <option value="5" selected>A-</option>
                                        <option value="6">B-</option>
                                        <option value="7">AB-</option>
                                        <option value="8">O-</option>
                                    @elseif($employee_profile->emp_blood_group==6)
                                        <option value="1">A+</option>
                                        <option value="2">B+</option>
                                        <option value="3">AB+</option>
                                        <option value="4">O+</option>
                                        <option value="5">A-</option>
                                        <option value="6" selected>B-</option>
                                        <option value="7">AB-</option>
                                        <option value="8">O-</option>
                                    @elseif($employee_profile->emp_blood_group==7)
                                        <option value="1">A+</option>
                                        <option value="2">B+</option>
                                        <option value="3">AB+</option>
                                        <option value="4">O+</option>
                                        <option value="5">A-</option>
                                        <option value="6">B-</option>
                                        <option value="7" selected>AB-</option>
                                        <option value="8">O-</option>
                                    @elseif($employee_profile->emp_blood_group==8)
                                        <option value="1">A+</option>
                                        <option value="2">B+</option>
                                        <option value="3">AB+</option>
                                        <option value="4">O+</option>
                                        <option value="5">A-</option>
                                        <option value="6">B-</option>
                                        <option value="7">AB-</option>
                                        <option value="8" selected>O-</option>
                                    @else
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="col-md-5">
                            <label for="department_name">Card No <span style="color:red">*</span></label>
                        </div>
                        <div class="col-md-7">
                            <div class="form-group">
                                <input type="text" name="emp_card_number" id="emp_card_number" class="form-control" autocomplete="off" value="{{$employee_profile->emp_card_number}}">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="col-md-5">
                            <label for="department_name">Employee Nid</label>
                        </div>
                        <div class="col-md-7">
                            <div class="form-group">
                                <input type="text" id="emp_nid" name="emp_nid" class="form-control" value="{{$employee_profile->emp_nid}}">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="col-md-5">
                            <label for="department_name">Nationality</label>
                        </div>
                        <div class="col-md-7">
                            <div class="form-group">
                                <input type="text" id="emp_nationality" name="emp_nationality" class="form-control" value="{{$employee_profile->emp_nationality}}">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="col-md-5">
                            <label for="department_name">OT Status</label>
                        </div>
                        <div class="col-md-7">
                            <div class="form-group">
                                <select class="form-control" id="emp_ot_status" name="emp_ot_status" required>
                                    <option value="">Select</option>
                                    @if($employee_profile->emp_ot_status==1)
                                        <option value="1" selected>On</option>
                                        <option value="2">Off</option>
                                        @else
                                        <option value="1">On</option>
                                        <option value="2" selected>Off</option>
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="col-md-5">
                            <label for="department_name">Date of Discontinuation</label>
                        </div>
                        <div class="col-md-7">
                            <div class="form-group">
                                <input type="date" name="date_of_discontinuation"  class="form-control" value="{{$employee_profile->date_of_discontinuation}}">
                            </div>
                        </div>
                    </div>


                    <div class="col-md-6">
                        <div class="col-md-5">
                            <label for="department_name">Reason of Discontinuation</label>
                        </div>
                        <div class="col-md-7">
                            <div class="form-group">
                                <textarea class="form-control" id="reason_of_discontinuation" name="reason_of_discontinuation" cols="2" rows="2" autocomplete="off">{{$employee_profile->reason_of_discontinuation}}</textarea>
                            </div>
                        </div>
                    </div>


                    <div class="col-md-6">
                        <div class="col-md-5">
                            <label for="department_name">Account Status</label>
                        </div>
                        <div class="col-md-7">
                            <div class="form-group">
                                <select class="form-control"  name="emp_account_status" required>
                                    <option value="">Select</option>
                                    @if($employee_profile->emp_account_status==1)
                                        <option value="1" selected>Active</option>
                                        <option value="2">Inactive</option>
                                    @else
                                        <option value="1">Active</option>
                                        <option value="2" selected>Inactive</option>
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div>



                    <div class="col-md-12">
                        <h5>
                            <b>Bank Account Information</b>
                        </h5>
                        <hr>
                    </div>

                    <div class="col-md-6">
                        <div class="col-md-5">
                            <label for="department_name">Bank Account</label>
                        </div>
                        <div class="col-md-7">
                            <div class="form-group">
                                <input type="text" name="emp_bank_account" id="emp_bank_account" class="form-control" value="{{$employee_profile->emp_bank_account}}">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="col-md-5">
                            <label for="department_name">Bank Info</label>
                        </div>
                        <div class="col-md-7">
                            <div class="form-group">
                                <input type="text" name="emp_bank_info" id="emp_bank_info" class="form-control" value="{{$employee_profile->emp_bank_info}}">
                            </div>
                        </div>
                    </div>


                    <div class="col-md-12">
                        <h5>
                            <b>Address</b>
                        </h5>
                        <hr>
                    </div>

                    <div class="col-md-6">
                        <div class="col-md-5">
                            <label for="department_name">Current Address <span style="color:red">*</span></label>
                        </div>
                        <div class="col-md-7">
                            <div class="form-group">
                                <textarea class="form-control" id="emp_current_address" name="current_address" cols="2" rows="2" autocomplete="off">{{$employee_profile->emp_current_address}}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="col-md-5">
                            <label for="department_name">Permanent Address <span style="color:red">*</span></label>
                        </div>
                        <div class="col-md-7">
                            <div class="form-group">
                                <textarea class="form-control" id="emp_parmanent_address" name="permanent_address" cols="2" rows="2" autocomplete="off">{{$employee_profile->emp_parmanent_address}}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="col-md-5">
                            <label for="department_name">Emergency Phone</label>
                        </div>
                        <div class="col-md-7">
                            <div class="form-group">
                                <input type="text" class="form-control" name="emp_emergency_phone" id="emp_emergency_phone" value="{{$employee_profile->emp_emergency_phone}}" autocomplete="off">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="col-md-5">
                            <label for="department_name">Emergency Address</label>
                        </div>
                        <div class="col-md-7">
                            <div class="form-group">
                                <textarea class="form-control" id="emp_emergency_address" name="emp_emergency_address" cols="2" rows="2" autocomplete="off">{{$employee_profile->emp_emergency_address}}</textarea>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="emp_id" value="{{$employee_profile->emp_id}}">
                     <div class="col-md-12">
                           <div class="form-group">
                               <button id="add_vendor_btn" type="Submit" class="btn btn-primary pull-right"><i class="fa fa-save"></i> Update Information</button>
                           </div>
                     </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>