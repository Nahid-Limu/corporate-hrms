@extends('layout.master')
@section('title', 'Task list')
@section('content')
    <!--BEGIN TITLE & BREADCRUMB PAGE-->
    <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
        <div class="page-header pull-left">
            <div class="page-title">Task List</div>
        </div>
        <ol class="breadcrumb page-breadcrumb pull-right">
            <li><i class="fa fa-home"></i>&nbsp;<a href="{{url('/')}}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
            <li><a href="#">Task</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
            <li class="active">Task List</li>
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
                                        Task List
                                    </div>
                                    <div class="col-md-6" style="text-align: right;">
                                        <a href="" class="add-new-modal btn btn-success btn-round btn-sm" data-toggle="modal" data-target="#createTask"> <i class="fa fa-plus"></i> Add New</a>
                                    </div>
                                </div>
                            </div>
                            <div class="panel-body table-responsive">
                                <table id="task" class="table table-striped table-bordered" >
                                    <thead>
                                    <tr>
                                        <th>SN</th>
                                        <th>Title</th>
{{--                                        <th>Description</th>--}}
                                        <th>Attachment</th>
                                        <th>Start Time</th>
                                        <th>End Time</th>
                                        <th>Status</th>
                                        <th>Created By</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                
                
    <!-- Modal Start -->
    @include('backend.task.modal.create')
    @include('backend.task.modal.edit')
    @include('backend.task.modal.view')

    <!-- Modal End -->
    </div>
@endsection

@section('extra_js')
<script>
    $(document).ready(function(){
    
        $('#task').DataTable({
        processing: true,
        serverSide: true,
        "order": [[ 1, "desc" ]],
        ajax:{
        url: "{{ route('task_list') }}",
        },
        columns:[
        { 
            data: 'DT_RowIndex', 
            name: 'DT_RowIndex' 
        },
        {
            data: 'title',
            name: 'title'
        },
        // {
        //     data: 'description',
        //     name: 'description'
        // },
        {
            data: 'attachment',
            name: 'attachment'
        },
        {
            data: 'start_time',
            name: 'start_time'
        },
        {
            data: 'end_time',
            name: 'end_time'
        },
        {
            data: 'status',
            name: 'status',
            render: function(data, type, full, meta){
                return data == '1' ? '<span style="color:green">Active</span>' : '<span style="color:red">InActive</span>'
            },
        },
        {
            data: 'name',
            name: 'name'
        },
        {
            data: 'action',
            name: 'action',
            orderable: false
        }
        ]
        });


        //add task
        $('#task_modal_form').on('submit', function(event){
            event.preventDefault();
            $.ajax({
             url:"{{ route('task_add') }}",
             method:"POST",
             data:new FormData(this),
             dataType:'JSON',
             contentType: false,
             cache: false,
             processData: false,
             success:function(response)
             {
                var html = '';
                if(response.errors)
                {
                html = '<div class="alert alert-danger">';
                for(var count = 0; count < response.errors.length; count++)
                {
                html += '<p>' + response.errors[count] + '</p>';
                }
                html += '</div>';
                $('#form_result').html(html);
                }
                if(response.warning)
                {
                swal(response.warning, "", "warning");
                $('#task_modal_form')[0].reset();
                $('#task').DataTable().ajax.reload();
                $('#createTask').modal('hide');
                }
                if(response.success)
                {
                swal(response.success, "", "success");
                $('#task_modal_form')[0].reset();
                $('#task').DataTable().ajax.reload();
                $('#createTask').modal('hide');
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
           });

        //Edit task
        $(document).on('click', '.edit', function(){
            var id = $(this).attr('id');
            $.ajax({
             type: "GET",
             url:"{{url('task_edit')}}"+"/"+id,
             dataType:"json",
             success:function(response){
                 $('#id').val(response.id);
                 $('#edit_title').val(response.title);
                 $('#edit_description').val(response.description);
                 $('#edit_start_time').val(convertTime24to12(response.start_time));
                 $('#edit_end_time').val(convertTime24to12(response.end_time));
                 $("#status option[value=" + response.status + "]").prop('selected', true);
                 //am pm time function
                function convertTime24to12(time24){
                    var tmpArr = time24.split(':'), time12;
                        if(+tmpArr[0] == 12) {
                            time12 = tmpArr[0] + ':' + tmpArr[1] + ' pm';
                        } else {
                            if(+tmpArr[0] == 00) {
                            time12 = '12:' + tmpArr[1] + ' am';
                            } else {
                                if(+tmpArr[0] > 12) {
                                time12 = (+tmpArr[0]-12) + ':' + tmpArr[1] + ' pm';
                                } else {
                                time12 = (+tmpArr[0]) + ':' + tmpArr[1] + ' am';
                                }
                            }
                        }
                        return time12;
                    }
             }
            })
           });

        
        //update task
        $('#edit_task_modal_form').on('submit', function(event){
            event.preventDefault();
            $.ajax({
             url:"{{ route('task_update') }}",
             method:"POST",
             data:new FormData(this),
             dataType:'JSON',
             contentType: false,
             cache: false,
             processData: false,
             success:function(response)
             {

                var html = '';
                if(response.errors)
                {
                html = '<div class="alert alert-danger">';
                
                html += '<p>' + response.errors + '</p>';
                
                html += '</div>';
                $('#edit_form_result').html(html);
                }
                if(response.falied)
                {
                    swal(response.falied, "", "warning");
                }
                if(response.success)
                {
                swal(response.success, "", "success");
                $('#edit_task_modal_form')[0].reset();
                $('#task').DataTable().ajax.reload();
                $('#editTask').modal('hide');
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
           });

        //Delete Task
        $(document).on('click','.delete',function () {

                var id=$(this).attr('id');
                var _token="{{csrf_token()}}";

                swal({
                    title: "Are you sure?",
                    text: "Once deleted, you will not be able to recover this imaginary file!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                    .then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
                            method:"post",
                            url:"{{url('/task/delete')}}"+"/"+id,
                            data:{id:id,_token:_token},
                            success:function (response) {


                                if(response.success){
                                    swal(response.success,"","success");

                                    $('#task').DataTable().ajax.reload();

                                }
                            }
                        })
                        swal("Poof! Your Task  has been deleted!", {
                            icon: "success",
                        });
                    } else {
                        swal("Your Task file is safe!");
            }
            })


            });

        //view task
        $(document).on('click','.view',function () {
            var id=$(this).attr('id');
            $.ajax({
                type:"GET",
                url:"{{url('/task/view/')}}"+"/"+id,
                dataype:"JSON",
                success:function (response) {

                    $("#viewTask").modal('show');
                    $("#view_task_title").text(response.title);
                    $("#view_task_description").text(response.description);
                    $("#view_task_attachment").text(response.attachment);
                    $("#view_task_start_time").text(response.start_time);
                    $("#view_task_end_time").text(response.end_time);
                    $("#view_task_created_by").text(response.userName);
                    if(response.status==1){

                        $("#view_task_status").html("<span style='color:green;'>Active</span>");
                    }else {

                        $("#view_task_status").html("<span style='color:red;'>Inactive</span>");
                    }

                }
            });
        })

            $('#entry').datetimepicker({
                pickDate: false
            });
            $('#exit').datetimepicker({
                pickDate: false
            });

            $('#edit_entry').datetimepicker({
                pickDate: false
            });
            $('#edit_exit').datetimepicker({
                pickDate: false
            });
            
    
    });
    </script>
@endsection
