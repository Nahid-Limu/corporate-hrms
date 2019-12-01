@extends('layout.master')
@section('title', 'Task List')
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
    <div class="page-content">

            <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-blue">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-md-6">
                                        Task List
                                    </div>
                                </div>
                            </div>
                            <div class="panel-body table-responsive">
                                <table id="task" class="table table-striped table-bordered" >
                                    <thead>
                                    <tr>
                                        <th>SN</th>
                                        <th>Task</th>
                                        <th>Date</th>
                                         <th>Start Time</th>
                                        <th>End Time</th>
                                        <th>Attachment</th>
                                        <th>Status</th>
                                        <th>Assigned By</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
    </div>

    @include('backend.employee.employee_panel.modal.edit')
@endsection

@section('extra_js')
<script>
    $(document).ready(function(){

        $('#task').DataTable({
        processing: true,
        serverSide: true,
        "order": [[ 0, "desc" ]],
        ajax:{
        url: "{{ url('employee/panel/task/list')}}",
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
        {
            data: 'assign_date',
            name: 'assign_date'
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
            data: 'attachment',
            name: 'attachment'
        },

        {
            data: 'assign_status',
            name: 'assign_status',
            render: function(data, type, full, meta){
                if(data==1){
                    return '<span style="color:blue">Pending</span>';
                }
                if(data==2){
                    return '<span style="color:aqua">On Going</span>';
                }
                if(data==3){
                    return '<span style="color:green">Completed</span>';
                }
                if(data==4){
                    return '<span style="color:red">Rejected</span>';
                }
            }
        },
        {
            data: 'assigned_by',
            name: 'assigned_by'
        },
        {
            data: 'action',
            name: 'action'
        },
        ]
        });


        // edit task view
        $(document).on('click','.edit_view',function () {
            var id=$(this).attr('id');
            $.ajax({
               type:"GET",
               url:"{{url('employee/panel/task/edit')}}"+"/"+id,
                dataType:"JSON",
                success:function (response) {

                    $("#edit_view_assign_Task").modal('show');

                    $("#edit_view_task_title").text(response.title);
                    $("#edit_view_task_assign_date").text(response.assign_date);
                    $("#edit_view_task_status").val(response.status);
                    $("#remarks_id").val(response.remarks);

                    $("#id").val(response.id);



                }
            });
        })
        //update task view
        $("#task_view_edit_btn").on('click',function () {
            var id=$("#id").val();
            var remarks=$("#remarks_id").val();
            var status=$("#edit_view_task_status").val();
            var _token="{{csrf_token()}}";

            $.ajax({
                type:"POST",
                url:"{{route('employee_panel_task_update_view')}}",
                data:{id:id,_token:_token,status:status,remarks:remarks},
                success:function (response) {
                    var html = '';
                    if (response.errors) {
                        html = '<div class="alert alert-danger">'
                        for (var count = 0; count < response.errors.length; count++) {
                            html += '<p>' + response.errors[count] + '</p>'
                        }

                        html += '</div>';
                        $('#form_result_edit').html(html);

                    }


                    if(response.success){
                        swal(response.success,"success");
                        $('#edit_announcement_modal_form')[0].reset();
                        $('#task').DataTable().ajax.reload();
                        $('#edit_view_assign_Task').modal('hide');
                    }
                    if(response.failed)
                    {
                        swal(response.failed, "", "warning");
                        $('#edit_view_assign_Task').modal('hide');
                    }
                }
            })

        })


    });
    </script>
@endsection
