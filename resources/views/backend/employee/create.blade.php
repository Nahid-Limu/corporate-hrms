@extends('layout.master')
 @if (Lang::locale()=='bn') 
        @section('title', 'নতুন কর্মচারী যুক্ত করুন')
        @else 
        @section('title', 'Add New Employee')                                        
    @endif
@section('content')
    <!--BEGIN TITLE & BREADCRUMB PAGE-->
    <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
        <div class="page-header pull-left">
            <div class="page-title"><?php if(Lang::has('add_new_employee.employee')){ echo Lang::get('add_new_employee.employee'); }else{ echo "Employee"; } ?></div>
        </div>
        <ol class="breadcrumb page-breadcrumb pull-right">
            <li><i class="fa fa-home"></i>&nbsp;<a href="{{url('/')}}"><?php if(Lang::has('add_new_employee.home')){ echo Lang::get('add_new_employee.home'); }else{ echo "Home"; } ?></a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
            <li><a href="#"><?php if(Lang::has('add_new_employee.employee')){ echo Lang::get('add_new_employee.employee'); }else{ echo "Employee"; } ?></a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
            <li class="active"><?php if(Lang::has('add_new_employee.add_new_employee')){ echo Lang::get('add_new_employee.add_new_employee'); }else{ echo "Add New Employee"; } ?></li>
        </ol>
        <div class="clearfix"></div>
    </div>
    <!--END TITLE & BREADCRUMB PAGE-->
    <div class="page-content">
        <!--Flash Message Start-->
            {{ Html::script('corporate/js/sweetalert.min.js') }}
            @if(Session::has('success'))
            <script>
                var msg =' <?php echo Session::get('success');?>'
                swal(msg, "", "success");
            </script>
            @endif
        <!--Flash Message End-->
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-blue">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-md-6">
                                <i class="fa fa-plus"></i> <?php if(Lang::has('add_new_employee.add_new_employee')){ echo Lang::get('add_new_employee.add_new_employee'); }else{ echo "Add New Employee"; } ?>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                                <div class="row">
                                    {!! Form::open(['method'=>'POST','route'=>'employee.store','files'=>true]) !!}
                                    <div class="col-md-12">
                                        <h5>
                                            <b><?php if(Lang::has('add_new_employee.personal_information')){ echo Lang::get('add_new_employee.personal_information'); }else{ echo "Personal Information"; } ?></b>
                                        </h5>
                                        <hr>
                                    </div>

                                
                                    <div class="col-md-6">
                                        <div class="col-md-3">
                                           <?php if(Lang::has('add_new_employee.employee_id')){ echo Lang::get('add_new_employee.employee_id'); }else{ echo "Employee ID"; } ?> <span style="color:red">*</span>
                                        </div>
                                        <div class="col-md-9">
                                            <div class="form-group  {{ $errors->has('employeeId') ? 'has-error' : ''}}">
                                                <input type="text" class="form-control" id="employeeId" name="employeeId" value="{{old('employeeId')}}"  autocomplete="off" placeholder="<?php if(Lang::has('add_new_employee.please_enter_employee_id_here')){ echo Lang::get('add_new_employee.please_enter_employee_id_here'); }else{ echo "Please enter employee id here "; } ?>" required="">
                                                {!! $errors->first('employeeId', '<p class="help-block">:message</p>') !!}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="col-md-3">
                                            <?php if(Lang::has('add_new_employee.Joining_date')){ echo Lang::get('add_new_employee.Joining_date'); }else{ echo "Joining date"; } ?><span style="color:red">*</span>
                                        </div>
                                        <div class="col-md-9">
                                            <div class="form-group {{ $errors->has('joining_date') ? 'has-error' : ''}}">
                                                <input type="text" name="joining_date" id="joining_date" class="form-control" autocomplete="off" value="{{old('joining_date')}}"  placeholder="<?php if(Lang::has('add_new_employee.click_Joining_date')){ echo Lang::get('add_new_employee.click_Joining_date'); }else{ echo "Click here to select joining date"; } ?>" required="">
                                                {!! $errors->first('joining_date', '<p class="help-block">:message</p>') !!}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="col-md-3">
                                            <?php if(Lang::has('add_new_employee.first_name')){ echo Lang::get('add_new_employee.first_name'); }else{ echo "First Name"; } ?> <span style="color:red">*</span>
                                        </div>
                                        <div class="col-md-9">
                                            <div class="form-group  {{ $errors->has('first_name') ? 'has-error' : ''}}">
                                                <input type="text" class="form-control" id="emp_first_name" name="first_name" value="{{old('first_name')}}" autocomplete="off" placeholder="<?php if(Lang::has('add_new_employee.please_enter_first_name')){ echo Lang::get('add_new_employee.please_enter_first_name'); }else{ echo "Please enter first name here"; } ?>" required="">
                                                {!! $errors->first('first_name', '<p class="help-block">:message</p>') !!}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="col-md-3">
                                         <?php if(Lang::has('add_new_employee.last_name')){ echo Lang::get('add_new_employee.last_name'); }else{ echo "Last Name"; } ?> <span style="color:red">*</span>
                                        </div>
                                        <div class="col-md-9">
                                            <div class="form-group {{ $errors->has('last_name') ? 'has-error' : ''}}">
                                                <input type="text" class="form-control" id="emp_lastName" name="last_name" value="{{old('last_name')}}" autocomplete="off" placeholder="<?php if(Lang::has('add_new_employee.please_enter_last_name_here')){ echo Lang::get('add_new_employee.please_enter_last_name_here'); }else{ echo "Please enter last name here"; } ?>" required="">
                                                {!! $errors->first('last_name', '<p class="help-block">:message</p>') !!}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="col-md-3">
                                            <?php if(Lang::has('add_new_employee.branch')){ echo Lang::get('add_new_employee.branch'); }else{ echo "Branch"; } ?> <span style="color:red">*</span>
                                        </div>
                                        <div class="col-md-9">
                                            <div class="form-group {{ $errors->has('branch') ? 'has-error' : ''}}">
                                               
                                                <select class="form-control" id="branch" name="branch" required="">
                                                    <option value=""> <?php if(Lang::has('add_new_employee.select_branch')){ echo Lang::get('add_new_employee.select_branch'); }else{ echo "Select Branch"; } ?></option>
                                                    @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('super-admin'))
                                                    @foreach($branch as $branchs)
                                                        <option value="{{ $branchs->id }}" {{ (old("branch") == $branchs->id ? "selected":"") }}>{{ $branchs->branch_name }}</option>
                                                    @endforeach
                                                    @else  

                               
                                                     <option value="{{$branch->id}}"  >{{$branch->branch_name}}</option>
                                                    @endif
                                                </select>
                                                {!! $errors->first('branch', '<p class="help-block">:message</p>') !!}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="col-md-3">
                                            <?php if(Lang::has('add_new_employee.department')){ echo Lang::get('add_new_employee.department'); }else{ echo "Department"; } ?> <span style="color:red">*</span>
                                        </div>
                                        <div class="col-md-9">
                                            <div class="form-group {{ $errors->has('department') ? 'has-error' : ''}}">
                                                <select class="form-control" id="department" name="department" required="">
                                                    <option value=""><?php if(Lang::has('add_new_employee.select_department')){ echo Lang::get('add_new_employee.select_department'); }else{ echo "Select Department "; } ?></option>
                                                    @foreach($department as $departments)
                                                        <option value="{{ $departments->id }}" {{ (old("department") == $departments->id ? "selected":"") }}>{{ $departments->department_name }}</option>
                                                    @endforeach
                                                </select>
                                                {!! $errors->first('department', '<p class="help-block">:message</p>') !!}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="col-md-3">
                                            <?php if(Lang::has('add_new_employee.designation')){ echo Lang::get('add_new_employee.designation'); }else{ echo "Designation"; } ?> <span style="color:red">*</span>
                                        </div>
                                        <div class="col-md-9">
                                            <div class="form-group {{ $errors->has('designation') ? 'has-error' : ''}}">
                                                <select class="form-control" id="designation" name="designation"  required="">
                                                    <option value=""> <?php if(Lang::has('add_new_employee.select_designation')){ echo Lang::get('add_new_employee.select_designation'); }else{ echo "Select Designation"; } ?></option>
                                                    @foreach($designation as $designations)
                                                        <option value="{{ $designations->id }}" {{ (old("designation") == $designations->id ? "selected":"") }}>{{ $designations->designation_name }}</option>
                                                    @endforeach
                                                </select>
                                                {!! $errors->first('designation', '<p class="help-block">:message</p>') !!}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="col-md-3">
                                            <?php if(Lang::has('add_new_employee.gender')){ echo Lang::get('add_new_employee.gender'); }else{ echo "Gender"; } ?> <span style="color:red">*</span>
                                        </div>
                                        <div class="col-md-9">
                                            <div class="form-group {{ $errors->has('gender') ? 'has-error' : ''}}">
                                                <select class="form-control" id="emp_gender_id" name="gender"  required="">
                                                    <option value=""> <?php if(Lang::has('add_new_employee.select_gender')){ echo Lang::get('add_new_employee.select_gender'); }else{ echo "Select Gender"; } ?></option>
                                                    <option value="1">Male</option>
                                                    <option value="2">Female</option>
                                                </select>
                                                {!! $errors->first('gender', '<p class="help-block">:message</p>') !!}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="col-md-3">
                                            <?php if(Lang::has('add_new_employee.shift')){ echo Lang::get('add_new_employee.shift'); }else{ echo "Shift"; } ?><span style="color:red">*</span>
                                        </div>
                                        <div class="col-md-9">
                                            <div class="form-group {{ $errors->has('shift') ? 'has-error' : ''}}">
                                                <select class="form-control" id="shift" name="shift"  required="">
                                                    <option value=""> <?php if(Lang::has('add_new_employee.select_shift')){ echo Lang::get('add_new_employee.select_shift'); }else{ echo "Select Shift"; } ?></option>
                                                    @foreach($shift as $shifts)
                                                        <option value="{{$shifts->id}}">{{$shifts->shift_name}}</option>
                                                    @endforeach
                                                </select>
                                                {!! $errors->first('shift', '<p class="help-block">:message</p>') !!}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="col-md-3">
                                           <?php if(Lang::has('add_new_employee.date_of_birth')){ echo Lang::get('add_new_employee.date_of_birth'); }else{ echo "Date Of Birth"; } ?> <span style="color:red">*</span>
                                        </div>
                                        <div class="col-md-9">
                                            <div class="form-group {{ $errors->has('date_of_birth') ? 'has-error' : ''}}">
                                                <input type="text" name="date_of_birth" id="date_of_birth" class="form-control" autocomplete="off" value="{{old('date_of_birth')}}"   placeholder="<?php if(Lang::has('add_new_employee.click_date_of_birth')){ echo Lang::get('add_new_employee.click_date_of_birth'); }else{ echo "Click here to select  date of birth"; } ?>"  required="">
                                                {!! $errors->first('date_of_birth', '<p class="help-block">:message</p>') !!}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="col-md-3">
                                            <?php if(Lang::has('add_new_employee.religion')){ echo Lang::get('add_new_employee.religion'); }else{ echo "Religion"; } ?> <span style="color:red">*</span>
                                        </div>
                                        <div class="col-md-9">
                                            <div class="form-group {{ $errors->has('religion') ? 'has-error' : ''}}">
                                                <select class="form-control" id="emp_religion" name="religion" autocomplete="off">
                                                    <option value=""><?php if(Lang::has('add_new_employee.select_religion')){ echo Lang::get('add_new_employee.select_religion'); }else{ echo "Select Religion"; } ?></option>
                                                    <option value="Islam">Islam</option>
                                                    <option value="Hinduism">Hinduism</option>
                                                    <option value="Buddhists">Buddhists</option>
                                                    <option value="Christians">Christians</option>
                                                    <option value="Animists">Animists</option>
                                                    <option value="Others">Others</option>
                                                </select>
                                                {!! $errors->first('religion', '<p class="help-block">:message</p>') !!}
                                            
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="col-md-3">
                                          <?php if(Lang::has('add_new_employee.Mmarital_status')){ echo Lang::get('add_new_employee.Mmarital_status'); }else{ echo "Marital Status"; } ?>  <span style="color:red">*</span>
                                        </div>
                                        <div class="col-md-9">
                                            <div class="form-group {{ $errors->has('marital_status') ? 'has-error' : ''}}">
                                                <select class="form-control" id="emp_marital_status" name="marital_status" autocomplete="off" required="">
                                                    <option value=""><?php if(Lang::has('add_new_employee.select_marital_status')){ echo Lang::get('add_new_employee.select_marital_status'); }else{ echo "Select Marital Status"; } ?></option>
                                                    <option value="1">Single</option>
                                                    <option value="2">Married</option>
                                                    <option value="3">Divorced</option>
                                                </select>
                                                {!! $errors->first('marital_status', '<p class="help-block">:message</p>') !!}
                                            </div>
                                        </div>
                                    </div>



                                    <div class="col-md-6">
                                        <div class="col-md-3">
                                             <?php if(Lang::has('add_new_employee.blood_group')){ echo Lang::get('add_new_employee.blood_group'); }else{ echo "Blood Group"; } ?>
                                        </div>
                                        <div class="col-md-9">
                                            <div class="form-group {{ $errors->has('blood_group') ? 'has-error' : ''}}">
                                                <select class="form-control" id="emp_blood_group" name="blood_group" autocomplete="off">
                                                    <option value=""><?php if(Lang::has('add_new_employee.select_blood_group')){ echo Lang::get('add_new_employee.select_blood_group'); }else{ echo "Select Blood Group"; } ?></option>
                                                    <option value="1">A+</option>
                                                    <option value="5">A-</option>
                                                    <option value="2">B+</option>
                                                    <option value="6">B-</option>
                                                    <option value="3">AB+</option>
                                                    <option value="7">AB-</option>
                                                    <option value="4">O+</option>
                                                    <option value="8">O-</option>
                                                </select>
                                                {!! $errors->first('blood_group', '<p class="help-block">:message</p>') !!}
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-md-6">
                                        <div class="col-md-3">
                                          <?php if(Lang::has('add_new_employee.rfid_card_no')){ echo Lang::get('add_new_employee.rfid_card_no'); }else{ echo "RFID Card No"; } ?>   
                                        </div>

                                        <div class="col-md-9">
                                            <div class="form-group {{ $errors->has('emp_card_number') ? 'has-error' : ''}}">
                                                <input type="text" name="emp_card_number" id="emp_card_number" class="form-control" autocomplete="off" value="{{old('emp_card_number')}}" placeholder="<?php if(Lang::has('add_new_employee.p_rfid_card_no')){ echo Lang::get('add_new_employee.p_rfid_card_no'); }else{ echo "Please enter RFID card number here"; } ?>" >
                                                {!! $errors->first('emp_card_number', '<p class="help-block">:message</p>') !!}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="col-md-3">
                                           <?php if(Lang::has('add_new_employee.ot_status')){ echo Lang::get('add_new_employee.ot_status'); }else{ echo "OT Status"; } ?>
                                        </div>
                                        <div class="col-md-9">
                                            <div class="form-group">
                                                <select class="form-control" name="emp_ot_status">
                                                    <option value="1">On</option>
                                                    <option value="2">Off</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-md-12">
                                        <h5>
                                            <b><?php if(Lang::has('add_new_employee.login')){ echo Lang::get('add_new_employee.login'); }else{ echo "Login"; } ?></b>
                                        </h5>
                                        <hr>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="col-md-3">
                                             <?php if(Lang::has('add_new_employee.email')){ echo Lang::get('add_new_employee.email'); }else{ echo "Email"; } ?> <span style="color:red">*</span>
                                        </div>
                                        <div class="col-md-9">
                                            <div class="form-group {{ $errors->has('email') ? 'has-error' : ''}}">
                                                <input type="email" name="email" id="emp_email" class="form-control" value="{{old('email')}}" autocomplete="off" placeholder="<?php if(Lang::has('add_new_employee.p_email')){ echo Lang::get('add_new_employee.p_email'); }else{ echo "Please enter email address here"; } ?>" required="">
                                                {!! $errors->first('email', '<p class="help-block">:message</p>') !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="col-md-3">
                                             <?php if(Lang::has('add_new_employee.password')){ echo Lang::get('add_new_employee.password'); }else{ echo " Password"; } ?> <span style="color:red">*</span>
                                        </div>
                                        <div class="col-md-9">
                                            <div class="form-group {{ $errors->has('password') ? 'has-error' : ''}}">
                                                <input type="password" name="password" id="password" class="form-control" autocomplete="off" value="{{old('password')}}" required="">
                                                {!! $errors->first('password', '<p class="help-block">:message</p>') !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <h5>
                                            <b><?php if(Lang::has('add_new_employee.address')){ echo Lang::get('add_new_employee.address'); }else{ echo " Address"; } ?></b>
                                        </h5>
                                        <hr>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="col-md-3">
                                            <?php if(Lang::has('add_new_employee.current_address')){ echo Lang::get('add_new_employee.current_address'); }else{ echo "Current Address"; } ?> <span style="color:red">*</span>
                                        </div>
                                        <div class="col-md-9">
                                            <div class="form-group {{ $errors->has('current_address') ? 'has-error' : ''}}">
                                                <textarea class="form-control" id="emp_current_address" name="current_address" cols="2" rows="2" autocomplete="off" placeholder="<?php if(Lang::has('add_new_employee.p_current_address')){ echo Lang::get('add_new_employee.p_current_address'); }else{ echo "Please enter  current address here"; } ?>" >{{old('current_address')}}</textarea>
                                                {!! $errors->first('current_address', '<p class="help-block">:message</p>') !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="col-md-3">
                                             <?php if(Lang::has('add_new_employee.permanent_address')){ echo Lang::get('add_new_employee.permanent_address'); }else{ echo " Permanent Address"; } ?> <span style="color:red">*</span>
                                        </div>

                                        <div class="col-md-9">
                                            <div class="form-group {{ $errors->has('permanent_address') ? 'has-error' : ''}}">
                                                <textarea class="form-control" id="emp_parmanent_address" name="permanent_address" cols="2" rows="2" autocomplete="off" placeholder="<?php if(Lang::has('add_new_employee.p_permanent_address')){ echo Lang::get('add_new_employee.p_permanent_address'); }else{ echo "Please enter  permanent address here"; } ?>" >{{old('permanent_address')}}</textarea>
                                                {!! $errors->first('permanent_address', '<p class="help-block">:message</p>') !!}
                                            </div>
                                        </div>
                                    </div>
                                  </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <button id="add_vendor_btn" type="Submit" class="btn btn-primary pull-right"><i class="fa fa-save"></i> <?php if(Lang::has('add_new_employee.save_information')){ echo Lang::get('add_new_employee.save_information'); }else{ echo "Save Information"; } ?></button>
                                    </div>
                                </div>
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
               </div>
           </div>
@endsection

@section('extra_js')
    <script>
        $('#date_of_birth').datetimepicker({
            format: 'L',
            minDate: new Date()
        });
        $('#joining_date').datetimepicker({
            format: 'L',
            minDate: new Date()
        });
        $('#date_off_discontinue').datetimepicker({
            format: 'L',
            minDate: new Date()
        });
        $("#branch").select2();
        $("#department").select2();
        $("#designation").select2();
        $("#shift").select2();
    </script>
@endsection