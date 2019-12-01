@extends('layout.master')
@section('title', 'Employee Task Report ')
@section('content')

    <div class="page-content">
        @if(Session::has('success'))
            <p id="alert_message" class="alert alert-success">{{ Session::get('success') }}</p>

        @elseif(Session::has('error'))
            <p id="alert_message" class="alert alert-warning">{{ Session::get('error') }}</p>

        @endif
        <div class="row">
            <div class="col-lg-10 col-lg-offset-1">
                <div class="panel panel-blue">
                    <div class="panel-heading ex-panel">
                        <div class="row">
                            <div style="text-align: center" class="col-md-12">
                                Employee Task List
                            </div>

                        </div>
                    </div>
                    <div class="panel-body">

                        {!! Form::open(['method'=>'post','route'=>'employee_task_list_show']) !!}

                        <div class="col-md-10 col-md-offset-1 ex-form">

                            <div class="form-group">
                            <select class="form-control" name="search_type" id="search_type" required>
                                <option value="">Select Type</option>
                                <option value="1">Branch Wise</option>
                                <option value="2">Department Wise</option>
                                <option value="3">Designation Wise</option>
                            </select>
                            </div>

                            <div id="div_four" >
                                <div class="form-group">
                                    <div class="input-form-gap"></div>
                                    <label class="col-md-4">Start Date <span class='require'>*</span> <span class="clon">:</span></label>
                                    <div class="col-md-8">
                                        <input type="date" name="start_date" class="date-picker form-control hasDatepicker" value="{{date('Y-m-01')}}"  placeholder="Select a date..." id="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-form-gap"></div>
                                    <label class="col-md-4">End Date <span class='require'>*</span> <span class="clon">:</span></label>
                                    <div class="col-md-8">
                                        <input type="date" name="end_date" class="date-picker form-control hasDatepicker" value="{{\Carbon\Carbon::now()->toDateString()}}"  placeholder="Select a date..." id="">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="input-form-gap"></div>
                                    <label for="emp_task_status" class="col-md-4">Select Status <span class='require'>*</span> <span class="clon">:</span></label>
                                    <div class="col-md-8">
                                        <select name="emp_task_status"  id="emp_task_status"  class="select2-container form-control" required title="Select Status:">
                                            <option value="">Select Status</option>
                                            <option value="1">Pending</option>
                                            <option value="2">On Going</option>
                                            <option value="3">Completed</option>
                                            <option value="4">Rejected</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                                <div class="form-group" id="div_one">
                                    <div class="input-form-gap"></div>
                                    <label for="emp_id" class="col-md-4">Select Branch <span class='require'>*</span> <span class="clon">:</span></label>
                                    <div class="col-md-8">
                                        <select id="branch_id"  name="branch_id"  class="form-control select2-container">
                                            <option value="all">All Branch</option>
                                            @foreach($branchList as $branch)
                                                <option value="{{$branch->id}}">{{$branch->branch_name}}</option>
                                            @endforeach
                                        </select>
                                        <b class="form-text text-danger pull-left" id="studentError"></b>
                                    </div>
                                </div>

                                <div class="form-group" id="div_two">
                                    <div class="input-form-gap"></div>
                                    <label for="emp_id" class="col-md-4">Select Department <span class='require'>*</span> <span class="clon">:</span></label>
                                    <div class="col-md-8">
                                        <select name="dept_id"  id="dept_id"  class="select2-container form-control"  title="Select Department:">
                                            <option value="all">All Department</option>
                                            @foreach($departmentList as $dept)
                                                <option value="{{$dept->id}}">{{$dept->department_name}}</option>
                                            @endforeach

                                        </select>
                                    </div>
                                </div>
                            <div class="form-group" id="div_three">
                                <div class="input-form-gap"></div>
                                <label for="emp_id" class="col-md-4">Select Designation <span class='require'>*</span> <span class="clon">:</span></label>
                                <div class="col-md-8">
                                    <select name="desig_id"  id="desig_id"  class="select2-container form-control"  title="Select Employee:">
                                        <option value="all">All Designation</option>
                                        @foreach($designation as $desig)
                                            <option value="{{$desig->id}}">{{$desig->designation_name}}</option>
                                        @endforeach


                                    </select>
                                </div>
                            </div>
                            <div class="form-group" id="div_five">
                                <div class="input-form-gap"></div>
                                <label for="emp_id" class="col-md-4">Select Employee <span class='require'>*</span> <span class="clon">:</span></label>
                                <div class="col-md-8">
                                    <select name="emp_id"  id="emp_id"  class="select2-container form-control"  title="Select Employee:">
                                        <option value="all">All Employee</option>
                                        <option value="">Select Employee</option>

                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-form-gap"></div>
                                <br>
                                <div class="col-md-4">

                                </div>
                                <div class="col-md-8">
                                    <button id="real-submit" type="submit" class="btn btn-success">
                                        <i class="fa fa-eye-slash"></i> Preview</button>
                                </div>
                            </div>
                            {!! Form::close() !!}
                        </div>

                    </div>

                </div>
            </div>

        </div>
    </div>
@endsection
@section('extra_js')
    <script>
        $(function () {

            $("#search_type").select2({
                placeholder: "Select Search Type"
            });
            $("#branch_id").select2({
                placeholder: "Select Branch"
            });
            $("#dept_id").select2({
                placeholder: "Select Department"
            });
            $("#emp_id").select2({
                placeholder: "Select Employee"
            });
            $("#emp_task_status").select2({
                placeholder: "Select Status"
            });
            $("#desig_id").select2({
                placeholder: "Select Designation"
            });

            $('#div_four').hide();
            $('#div_one').hide();
            $('#div_two').hide();
            $('#div_three').hide();
            $('#div_five').hide();

            $("#search_type").change(function(){
                var select_type=$("#search_type").val();
                if(select_type==1){
                    $('#div_four').show();
                    $('#div_one').show();
                    $('#div_two').hide();
                    $('#div_three').hide();
                    $('#div_five').hide();
                }
                else if(select_type==2){
                    $('#div_four').show();
                    $('#div_one').hide();
                    $('#div_two').show();
                    $('#div_three').hide();
                    $('#div_five').hide();
                }
                else{
                    $('#div_four').show();
                    $('#div_one').hide();
                    $('#div_two').hide();
                    $('#div_three').show();
                    $('#div_five').hide();
                }
            });
            //Branch Wise
            $("#branch_id").on('change',function () {
                var b_id=$('#branch_id').val();
                if(b_id=='all'){
                }else{
                    $.ajax({
                        url:"{{url('/task/branch/employee')}}"+"/"+b_id,
                        type:"GET",
                        success:function (response) {
                            $('#emp_id').html(response);
                            $('#div_five').show();
                        }
                    })
                }
            })

            //department Wise
            $("#dept_id").on('change',function () {
                var dept_id=$('#dept_id').val();
                $('#div_two').show();
                if(dept_id=='all'){

                }else{
                    $.ajax({
                        url:"{{url('/task/department/employee')}}"+"/"+dept_id,
                        type:"GET",
                        success:function (response) {
                            //console.log(response)
                            $('#emp_id').html(response);
                            $('#div_five').show();
                        }
                    })
                }
            })
            //Designation Wise
            $("#desig_id").on('change',function () {
                var desig_id=$('#desig_id').val();
                $('#div_three').show();
                if(desig_id=='all'){

                }else{
                    $.ajax({
                        url:"{{url('/task/department/employee')}}"+"/"+desig_id,
                        type:"GET",
                        success:function (response) {
                            //console.log(response)
                            $('#emp_id').html(response);
                            $('#div_five').show();
                        }
                    })
                }
            })
        });
    </script>
@endsection


