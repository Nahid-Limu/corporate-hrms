@extends('layout.master')
@section('title', 'Assign Leave')
@section('extra_css')
    <style>
        .form-group{
            padding: 30px;
            margin-bottom: 30px;
         }
         #actual_days{
            background-color: white;
            border: 1px solid #aaa;
            border-radius: 4px !important;
            cursor: text;
         }
         #leave_starting_date{
            background-color: white;
            border: 1px solid #aaa;
            border-radius: 4px !important;
            cursor: text;
         }
         #leave_ending_date{
            background-color: white;
            border: 1px solid #aaa;
            border-radius: 4px !important;
            cursor: text;
         }
         #attachment{
            background-color: white;
            border: 1px solid #aaa;
            border-radius: 4px !important;
            cursor: text;
         }
    </style>
@endsection
@section('content')
    <!--BEGIN TITLE & BREADCRUMB PAGE-->
    <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
        <div class="page-header pull-left">
            <div class="page-title">Assign Leave</div>
        </div>
        <ol class="breadcrumb page-breadcrumb pull-right">
            <li><i class="fa fa-home"></i>&nbsp;<a href="{{url('/')}}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
            <li><a href="#">Leave</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
            <li class="active">Assign Leave</li>
        </ol>
        <div class="clearfix"></div>
    </div>
    <!--END TITLE & BREADCRUMB PAGE-->

    <!--Flash Message Start-->
    @if(Session::has('success'))
            <p id="alert_message" class="alert alert-success">{{ Session::get('success') }}</p>
    @endif
    @if(Session::has('error'))
        <p id="alert_message" class="alert alert-error">{{ Session::get('error') }}</p>
    @endif
    @if(Session::has('devare'))
        <p id="alert_message" class="alert alert-danger">{{ Session::get('devare') }}</p>
    @endif
    <!--Flash Message End-->
    <div class="page-content">
            <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-blue">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-md-6">
                                        <i class="fa fa-tasks" style="font-size: 20px;"></i>
                                        Assign Task
                                    </div>
                                    <div class="col-md-6" style="text-align: right;">
                                        {{--  <a href="" class="add-new-modal btn btn-success btn-square btn-xs" data-toggle="modal" data-target="#createTask"> <i class="fa fa-plus"></i> Add New</a>  --}}
                                    </div>
                                </div>
                            </div>
                            <div class="panel-body">
                                <form method="post" id="assign_leave_form" enctype="multipart/form-data">
                                    @csrf
                                <div class="form-group">
                                    <div class="col-md-4">
                                        <label for="branch_id" class="pull-left"><h5>Select Branch<span class='require'>*</span></h5></label>
                                        <div>
                                            <select id="branch_id" name="branch_id"  class="form-control">
                                                <option value="">Select Branch</option>


                                            </select>
                                            <b class="form-text text-danger pull-left" id="studentError"></b>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="employee_id" class="pull-left"><h5>Select Employee<span class='require'>*</span></h5></label>
                                        <div>
                                            <select id="employee_id" name="employee_id"  class="form-control">
                                                <option value="">Select Employee</option>

                                            </select>
                                            <b class="form-text text-danger pull-left" id="studentError"></b>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="leave_type_id" class="pull-left"><h5>Select Leave Type<span class='require'>*</span></h5></label>
                                        <div>
                                            <select id="leave_type_id" name="leave_type_id"  class="form-control">
                                                <option value="">Select Employee First</option>

                                            </select>
                                            <b class="form-text text-danger pull-left" id="classError"></b>
                                        </div>
                                    </div>


                                </div>
                                <div class="form-group leave_info">
                                    <div class="col-md-3">
                                        <label for="task_assign_date" class="pull-left"><h5>Leave Start Date<span class='require'>*</span></h5></label>
                                        <div class='input-group datetimepicker-disable-date date'  id='leave_start_date' >
                                            <input type='date' class="form-control" id="leave_starting_date" name="leave_starting_date"/>
                                            <span class="input-group-addon">
                                                <span class="fa fa-clock-o"></span>
                                            </span>

                                        </div>
                                        <b class="form-text text-danger pull-left" id="startdateError"></b>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="task_assign_date" class="pull-left"><h5>Leave End Date<span class='require'>*</span></h5></label>
                                        <div class='input-group datetimepicker-disable-date date'  id='leave_end_date' >
                                            <input type='date' class="form-control" id="leave_ending_date" name="leave_ending_date"/>
                                            <span class="input-group-addon">
                                                <span class="fa fa-clock-o"></span>
                                            </span>

                                        </div>
                                        <b class="form-text text-danger pull-left" id="enddateError"></b>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="actual_days" class="pull-left"><h5>Total Days</h5></label>
                                        <div>
                                            <input class="form-control" type="text" name="actual_days" id="actual_days" readonly>
                                            <b class="form-text text-danger pull-left" id="totalDaysError"></b>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="attachment" class="pull-left"><h5>Attachment</h5></label>
                                        <div>
                                            <input class="form-control" type="file" name="attachment" id="attachment">
                                            <b class="form-text text-danger pull-left" id="studentError"></b>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group leave_info">
                                    <div class="col-md-12">
                                        <label for=""><h5>Description In Short</h5></label>
                                        <div>
                                            <textarea name="description" id="description" cols="9" rows="3" style="width:100%;" placeholder=" Add Description"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12"  style="margin-top: 10px;">
                                        <button type="submit" id="assign_btn" class="btn btn-md btn-round btn-success pull-left" style=""><i class="fa fa-check"></i> Assign Leave</button>
                                    </div>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                        <div class="col-lg-12">
                            <div class="panel panel-blue">
                                <div class="panel-heading">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <i class="fa fa-list" style="font-size: 20px;"></i>
                                            Assigned Leave List
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-body table-responsive">
                                    <table id="assigned_leave" class="table table-striped table-bordered" >
                                        <thead>
                                        <tr>
                                            <th>#No</th>
                                            <th>Employee Name</th>
                                            <th>Leave Type</th>
                                            <th>From</th>
                                            <th>To</th>
                                            <th>Total</th>
                                            <th>Approved By</th>
                                        </tr>
                                        </thead>
                                    </table>

                                    <h3 class="text-center text-danger" id="errorMssg"></h3>
                                </div>
                            </div>
                        </div>
                    </div>

    <!-- Modal Start -->
    @include('backend.task.modal.create')
    @include('backend.task.modal.edit')
    <!-- Modal End -->
    </div>
@endsection

@section('extra_js')

<script>
    $(document).ready(function(){
        //get branch start
        $.ajax({
            url:"{{route('ajax.get_branch')}}",
            method:"get",
            success:function (response) {
                //console.log(response);
                $('#branch_id').html(response);
                $('.leave_info').hide();
                $("#assign_btn").prop('disabled', true);

            }
        });
        //get branch end

        //get employee start
        $('#branch_id').on('change',function () {
            var id = $("#branch_id").val();
            //alert(id);
            $.ajax({
                type: "GET",
                url:"{{url('/ajax/get_employee')}}"+"/"+id,
                success:function (response) {
                    //console.log(response);
                    $('#employee_id').html(response);
                    $("#employee_id").select2({
                        placeholder: "Select Employee"
                    });
                }
            });
        });
        //get employee end

        //get leave type start
        $('#employee_id').on('change',function () {
            var id = $("#employee_id").val();
            //alert(id);
            $.ajax({
                type: "GET",
                url:"{{url('/ajax/get_leave_type')}}"+"/"+id,
                success:function (response) {
                    //console.log(response);
                    $('#leave_type_id').html(response);
                    $("#leave_type_id").select2({
                        placeholder: "Select Leave Type"
                    });
                }
            });

            //lode assigned task list
            //var id = $("#employee_id").val();
            $.ajax({
                method:"get",
                url:"{{url('/leave/assigned/list')}}"+"/"+id,
                success:function (response) {
                    if(response.error)
                    {
                        var assigned_leave = $('#assigned_leave').DataTable();
                        assigned_leave.clear().draw();
                        $('#errorMssg').show();
                        $('#errorMssg').html(response.error);
                    }
                    if(response.success)
                    {
                        $('#errorMssg').hide();
                        var assigned_leave = $('#assigned_leave').DataTable();
                        assigned_leave.clear();
                        var no = 1;
                        $.each(response.success,function(i, data){
                            //console.log(data);
                                assigned_leave.row.add([
                                    no++,
                                    data.emp_name,
                                    data.leave_type,
                                    data.leave_starting_date,
                                    data.leave_ending_date,
                                    data.actual_days,
                                    data.approve_by,
                                ]).draw(true);
                        })
                    }
                }
            });
            //lode assigned task list end

        });
        //get leave type end

        //calculate days on change date start
        $('#leave_type_id').on('change',function () {
            $("#totalDaysError").html('');
            $('.leave_info').show();
            $("#assign_btn").prop('disabled', false);
            var leave_type = $('#leave_type_id').val();
            if(leave_type == 1){
                $("#leave_ending_date").prop("readonly", true);
                //start datepicker and day calculate function
                    $('#leave_starting_date').change(function() {
                        $.ajax({
                        type: "GET",
                        url:"{{url('maternity_leave')}}"+"/"+leave_type,
                        dataType:"json",
                        success:function(response){
                            console.log(response.total_days);
                        var startDate = $("#leave_starting_date").val();
                        var nextDate = new Date(startDate);
                        nextDate.setDate(nextDate.getDate() + response.total_days - 1);
                        var dd = ("0" + nextDate.getDate()).slice(-2);
                        var mm = ("0" + (nextDate.getMonth() + 1)).slice(-2);
                        var y = nextDate.getFullYear();
                        var result = y+"-"+(mm)+"-"+(dd) ;
                        $("#leave_ending_date").val(result);
                        //set actual_days
                        var diff = new Date(result) - new Date(startDate);
                        var days = (diff / 1000 / 60 / 60 / 24) + 1;
                        //check available leave
                        var e_id = $("#employee_id").val();
                        $.ajax({
                            type: "GET",
                            url:"{{url('/leave/available/leave')}}"+"/"+leave_type+"/"+e_id,
                            success:function (response) {
                                //console.log(response.maternity);
                                //$('#leave_type_id').html(response);
                                if(response.maternity){
                                    $("#actual_days").val('');
                                    $("#actual_days").css('border-color', '#a94442');
                                    $("#totalDaysError").html('* '+response.maternity);
                                    swal(response.maternity, "", "warning");
                                    $("#leave_ending_date").val('');
                                    $("#assign_btn").prop('disabled', true);
                                }else{
                                    $("#totalDaysError").html('');
                                    $("#actual_days").val(days);
                                    $("#actual_days").css('border-color', '#32CD32');
                                    $("#assign_btn").prop('disabled', false);
                                }

                            }
                        });

                        //$("#actual_days").val(days);
                        //alert(result);
                        }
                    });
                });
                //end datepicker and day calculate function
            }else{
                $("#leave_ending_date").val('');
                $("#leave_ending_date").prop("readonly", false);

                $('#leave_ending_date').change(function() {

                    var start = $("#leave_starting_date").val();
                    var end = $("#leave_ending_date").val();

                    var end_date = new Date(end);
                    end_date.setDate(end_date.getDate() + 1);

                    var diff = end_date - new Date(start);
                    var days = diff / 1000 / 60 / 60 / 24;

                    //check available leave
                    var e_id = $("#employee_id").val();
                    $.ajax({
                        type: "GET",
                        url:"{{url('/leave/available/leave')}}"+"/"+leave_type+"/"+e_id,
                        success:function (response) {
                            //console.log(response.maternity);
                            //$('#leave_type_id').html(response);
                            if(response.maternity){
                                $("#actual_days").val('');
                                $("#actual_days").css('border-color', '#a94442');
                                $("#totalDaysError").html('* '+response.maternity);
                                swal(response.maternity, "", "warning");
                                $("#leave_ending_date").val('');
                                $("#assign_btn").prop('disabled', true);
                            }
                            if(response.error){
                                $("#actual_days").val('');
                                $("#actual_days").css('border-color', '#a94442');
                                $("#totalDaysError").html('* '+response.error);
                                swal(response.error, "", "warning");
                                $("#leave_ending_date").val('');
                                $("#assign_btn").prop('disabled', true);
                            }
                            if(response.leave){
                                if(days > response.leave){
                                    $("#actual_days").val('');
                                    $("#actual_days").css('border-color', '#a94442');
                                    $("#totalDaysError").html('* Enough Leave Is not available');
                                    swal('Available Leave is '+response.leave+ ' days', "", "warning");
                                    $("#leave_ending_date").val('');
                                    $("#assign_btn").prop('disabled', true);
                                }
                                else{
                                    $("#totalDaysError").html('');
                                    $("#actual_days").val(days);
                                    $("#actual_days").css('border-color', '#32CD32');
                                    $("#assign_btn").prop('disabled', false);
                                }
                            }

                        }
                    });


                    //$("#actual_days").val(days);
                    //alert(days + " days");
                });
            }

        });
        //calculate days on change date end

        //start assign leave
        {{--  $( "#assign_btn" ).click(function() {
            var _token = '{{ csrf_token() }}';
            var employee_id = $("#employee_id").val();
            var task_id = $("#task_id").val();
            var assign_date = $("#assign_date").val();

            $("#attachment").val('');
            //alert();

        });  --}}

        //add task
        $('#assign_leave_form').on('submit', function(event){
            event.preventDefault();
                $("#startdateError").html('');
                $("#enddateError").html('');
                var leave_start_date = $("#leave_starting_date").val();
                var leave_ending_date = $("#leave_ending_date").val();
                if( leave_start_date == '' ){
                    //alert(leave_start_date);
                    $("#leave_start_date").css('border-color', '#a94442');
                    $("#startdateError").html('* Leave Start Date Is required');
                    return false;
                }else if( leave_ending_date == '' ){
                    //alert(leave_start_date);
                    $("#leave_ending_date").css('border-color', '#a94442');
                    $("#enddateError").html('* Leave End Date Is required');
                    return false;
                }
                else{
                    $.ajax({
                        url:"{{ route('leave_assign') }}",
                        method:"POST",
                        data:new FormData(this),
                        dataType:'JSON',
                        contentType: false,
                        cache: false,
                        processData: false,
                        success:function(response)
                        {
                           if(response.success){
                               $("#employee_id").select2('val', '');
                               $("#employee_id").html('');
                               $("#leave_type_id").select2('val', '');
                               $("#leave_type_id").html('');
                               swal(response.success, "", "success");
                               $("#assign_leave_form")[0].reset();
                               $('.leave_info').hide();
                               $("#assign_btn").prop('disabled', true);
                           }
                           if(response.failed){
                               swal(response.warning, "", "warning");
                           }
                        },
                        error: function(jqXHR, exception) {
                            if (jqXHR.status === 0) {
                                console.log('Not connect.\n Verify Network.');
                            } else if (jqXHR.status == 404) {
                                console.log('Requested page not found. [404]');
                            } else if (jqXHR.status == 500) {
                                console.log('Internal Server Error [500].');
                            } else if (exception === 'parsererror') {
                                console.log('Requested JSON parse failed.');
                            } else if (exception === 'timeout') {
                                console.log('Time out error.');
                            } else if (exception === 'abort') {
                                console.log('Ajax request aborted.');
                            } else {
                                console.log('Uncaught Error.\n' + jqXHR.responseText);
                            }
                        }

                       })
                }

           });
        //end assign leave

        $("#branch_id").select2({
            placeholder: "Select Branch"
        });
        $("#employee_id").select2({
            placeholder: "Select Branch First"
        });
        $("#leave_type_id").select2({
            placeholder: "Select Employee First"
        });

    });
    </script>
@endsection
