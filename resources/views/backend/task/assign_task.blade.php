@extends('layout.master')
@section('title', 'Assign Task')
@section('extra_css')
<style>
    .form-group {
        padding: 20px;
    }

    #assign_date {
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
        <div class="page-title">Assign Task</div>
    </div>
    <ol class="breadcrumb page-breadcrumb pull-right">
        <li><i class="fa fa-home"></i>&nbsp;<a href="{{url('/')}}">Home</a>&nbsp;&nbsp;<i
                class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
        <li><a href="#">Task</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
        <li class="active">Assign Task</li>
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
@if(Session::has('delete'))
<p id="alert_message" class="alert alert-danger">{{ Session::get('delete') }}</p>
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
                    <form id="assign_task_form">
                        @csrf
                        <div class="form-group">
                            <div class="col-md-3">
                                <label for="branch_id" class="pull-left">
                                    <h5>Select Branch<span class='require'>*</span></h5>
                                </label>
                                <div>
                                    <select id="branch_id" name="branch_id" class="form-control">
                                        <option value="">Select Branch</option>
                                    </select>
                                    <b class="form-text text-danger pull-left" id="studentError"></b>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label for="employee_id" class="pull-left">
                                    <h5>Select Employee<span class='require'>*</span></h5>
                                </label>
                                <div>
                                    <select id="employee_id" name="employee_id" class="form-control">
                                        <option value="">Select Employee</option>

                                    </select>
                                    <b class="form-text text-danger pull-left" id="studentError"></b>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label for="task_id" class="pull-left">
                                    <h5>Select Task<span class='require'>*</span></h5>
                                </label>
                                <div>
                                    <select id="task_id" name="task_id" class="form-control" multiple>
                                        <option value="">Select Employee First</option>

                                    </select>
                                    <b class="form-text text-danger pull-left" id="classError"></b>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label for="task_assign_date" class="pull-left">
                                    <h5>Select Date<span class='require'>*</span></h5>
                                </label>
                                <div class='input-group datetimepicker-disable-date date' id='task_assign_date'>
                                    <input type='text' class="form-control" id="assign_date" name="assign_date"
                                        readonly />
                                    <span class="input-group-addon">
                                        <span class="fa fa-clock-o"></span>
                                    </span>

                                </div>
                                <b class="form-text text-danger pull-left" id="dateError"></b>
                            </div>

                        </div>

                        <div class="form-group" style="margin-top: 50px;">
                            <div class="col-md-12">
                                <button id="assign_btn" class="btn btn-md btn-round btn-success pull-left" style=""><i
                                        class="fa fa-check"></i> Assign Task</button>
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
                            Assigned Task List
                        </div>
                    </div>
                </div>
                <div class="panel-body table-responsive">
                    <table id="assigned_task" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>SN</th>
                                <th>Task Title</th>
                                <th>Task Assign Date</th>
                                <th>Status</th>
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
        //get branch
        $.ajax({
            url:"{{route('ajax.get_branch')}}",
            method:"get",
            success:function (response) {
                console.log(response);
                $('#branch_id').html(response);
            }
        });
    
        //get employee
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
                },
                error:function(xhr){

                }
            });
        });

        //get task
        $('#employee_id').on('change',function () {
            //lode assigned task list
            var id = $("#employee_id").val();
            $.ajax({
                method:"get",
                url:"{{url('/task/assigned/list')}}"+"/"+id,
                success:function (response) {
                    if(response.error)
                    {
                        let ctp = $('#assigned_task').DataTable();
                        ctp.clear().draw();
                        $('#errorMssg').show();
                        $('#errorMssg').html(response.error);
                    }
                    if(response.success)
                    {
                        $('#errorMssg').hide();

                        let ctp = $('#assigned_task').DataTable();
                        ctp.clear();

                        let no = 1;
                        $.each(response.success,function(i, data){
                            //console.log(data);
                            if(data.status == 1){
                                ctp.row.add([
                                    no++,
                                    data.title,
                                    data.assign_date,
                                    '<span class="text-success">Active</span>'
                                ]).draw(true);
                            }else{
                                ctp.row.add([
                                    no++,
                                    data.title,
                                    data.assign_date,
                                    '<span class="text-danger">InActive</span>'
                                ]).draw(true);
                            }
                            
                            
                        })
                    }
                    
                }
            });
            //lode task list
            $.ajax({
                url:"{{route('ajax.get_task')}}",
                method:"get",
                success:function (response) {
                    //console.log(response);
                    $('#task_id').html(response);
                    
                    $("#task_id").select2({
                        placeholder: "Select Task"
                    });
                }
            });
        });


        //assign task
        $( "#assign_btn" ).click(function() {
            var _token = '{{ csrf_token() }}';
            var employee_id = $("#employee_id").val();
            var task_id = $("#task_id").val();
            //alert(task_id);

            var assign_date = $("#assign_date").val();
            $("#dateError").html('');
            
            if( assign_date == '' ){
                $("#assign_date").css('border-color', '#a94442');
                $("#dateError").html('* Assign Date Is required');
                return false;
            }else{
                //alert(assign_date);
                $.ajax({
                    url:"{{route('task_assigned')}}",
                    method:"post",
                    data: {_token : _token, employee_id : employee_id, task_id : task_id, assign_date : assign_date},
                    success:function (response) {
                        //console.log(response);
                        if(response.success)
                        {
                            swal(response.success, "", "success");
                            $("#employee_id").select2('val', '');
                            $("#employee_id").html('');
                            $("#task_id").select2('val', '');
                            $("#task_id").html('');
                            $("#assign_date").select2('val', '');
                            $("#assign_date").html('');
                            $('#assign_task_form')[0].reset();
                        }
                        if(response.error)
                        {
                            swal(response.error, "", "warning");
                        }
                        
                    }
                });
            }
                
            });

        
            
         
    
        $("#branch_id").select2({
            placeholder: "Select Branch"
        });
        $("#employee_id").select2({
            placeholder: "Select Branch First"
        });
        $("#task_id").select2({
            placeholder: "Select Employee First"
        });
        $('#task_assign_date').datetimepicker({
            pickTime: false
        });
            
    
    });
</script>
@endsection