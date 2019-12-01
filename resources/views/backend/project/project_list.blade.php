@extends('layout.master')
@section('title', 'Project List')
@section('content')
    <!--BEGIN TITLE & BREADCRUMB PAGE-->
    <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
        <div class="page-header pull-left">
            <div class="page-title">Project</div>
        </div>
        <ol class="breadcrumb page-breadcrumb pull-right">
            <li><i class="fa fa-home"></i>&nbsp;<a href="{{url('/')}}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
            <li><a href="#">Project</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
            <li class="active">Project List</li>
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
    <!--Flash Message End-->
    <div class="page-content">

        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-blue">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-md-6">
                                Project List
                            </div>
                            <div class="col-md-6" style="text-align: right;">
                                <a href="" class="add-new-modal btn btn-success btn-round btn-sm" data-toggle="modal" data-target="#createProject"> <i class="fa fa-plus"></i> Add New</a>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body table-responsive">
                        <table id="project_table" class="table table-striped table-bordered" >
                            <thead>
                            <tr>
                                <th>SN</th>
                                <th>Branch</th>
                                <th>Project Name</th>
                                <th>Client</th>
                                <th>Team Leader</th>
                                {{-- <th>Price</th> --}}
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Priority</th>
                                <th>Created_By</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal Start -->
    @include('backend.project.project_create')
    @include('backend.project.project_edit')
    <!-- Modal End -->
    </div>
@endsection

@section('extra_js')
    <script>
        $(document).ready(function(){
            //Clients List
            $('#project_table').DataTable({
                processing: true,
                serverSide: true,
                "order": [[ 2, "desc" ]],
                ajax:{
                    url: "{{ route('project_list') }}",
                },
                columns:[
                    {
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                    },
                    {
                        data: 'branch_name',
                        name: 'branch_name'
                    },
                    {
                        data: 'project_name',
                        name: 'project_name'
                    },
                    {
                        data: 'client_name',
                        name: 'client_name'
                    },
                    {
                        data: 'emp_first_name',
                        name: 'emp_first_name'
                    },
                    // {
                    //     data: 'price',
                    //     name: 'price'
                    // },
                    {
                        data: 'start_date',
                        name: 'start_date'
                    },
                    {
                        data: 'end_date',
                        name: 'end_date'
                    },
                    {
                        data: 'priority',
                        name: 'priority',
                        render: function(data, type, full, meta){
                            return data == '1' ? '<span style="color:red">High</span>' : '<span style="color:orange">Low</span>'
                        },
                    },
                    {
                        data: 'created_by',
                        name: 'created_by'
                    },
                    {
                        data: 'project_status',
                        name: 'project_status',
                        render: function(data, type, full, meta){
                            if(data==0){
                                return '<span style="color:green">Pending</span>'
                            }else if(data==1){
                                return '<span style="color:green">Approved</span>'
                            }
                            else if(data==2){
                                return '<span style="color:green">Running</span>'
                            }
                            else if(data==3){
                                return '<span style="color:green">Completed</span>'
                            }
                            else if(data==4){
                                return '<span style="color:green">Delivered</span>'
                            }
                            else if(data==5){
                                return '<span style="color:green">Rejected</span>'
                            }
                            else{
                                return '<span style="color:green">Cancel</span>'
                            }
                        },
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false
                    }
                ]
            });


            //project Add
            $('#project_modal_form').on('submit', function(event){
                event.preventDefault();
                $.ajax({
                    url:"{{ route('project_add') }}",
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
                        if(response.success)
                        {
                            swal(response.success, "", "success");
                            $('#project_modal_form')[0].reset();
                            $('#project_table').DataTable().ajax.reload();
                            $('#createProject').modal('hide');
                        }
                    },
                    error: function(response) {
                        console.log(response);
                    }

                })
            });

            //Edit project
            $(document).on('click', '.edit', function(){
                var id = $(this).attr('id');
                $.ajax({
                    type: "GET",
                    url:"{{url('project/edit')}}"+"/"+id,
                    dataType:"json",
                    success:function(response){
                         $('#id').val(response.id);
                         $('#attachment_default').val(response.attachment);
                         $('#edit_project_name').val(response.project_name);
                         $('#edit_start_date').val(response.start_date);
                         $('#edit_end_date').val(response.end_date);
                         $('#edit_price').val(response.price);
                         $('#edit_description').val(response.description);

                         if(response.c_id==response.cli_id){
                            $("#edit_client_id option[value=" + response.c_id + "]").prop('selected', true);
                         }

                        if(response.emp_id==response.team_id){
                            $("#edit_team_leader option[value=" + response.emp_id + "]").prop('selected', true);
                        }

                         $("#edit_all_branch").change(function(){
                            var id = $("#edit_all_branch").val();
                            $.ajax({
                                type: "GET",
                                url:"{{url('branch/team/leader')}}"+"/"+id,
                                dataType:"json",
                                success:function(response){
                                    var leader = '';
                                    leader+='<option value="">Select</option>'
                                    $.each(response, function (i, item) {
                                        leader += '<option value="'+item.emp_id+'">'+item.employeeId+' ('+ item.emp_first_name+')</option>';
                                    });
                                    $('#edit_team_leader').html(leader);
                                    $("#edit_team_leader").select2();
                                }
                            })



                     $.ajax({
                       type: "GET",
                       url:"{{url('branch/client')}}"+"/"+id,
                       dataType:"json",
                       success:function(response){
                        console.log(response);
                             var client = '';
                             client+='<option value="">Select</option>'
                           $.each(response, function (i, item) {
                            client += '<option value="'+item.id+'">'+item.client_name+'</option>';
                           });
                           $('#edit_client_id').html(client);
                           $("#edit_client_id").select2();
                       },seeror:function(response){
                           console.log(response);
                       }
                   })
                 });
                        $("#edit_priority option[value=" + response.priority+"]").prop('selected', true);
                        $("#project_status option[value="+response.project_status+"]").prop('selected', true);
                        $("#edit_client_id").select2();
                        $("#edit_all_branch").select2();
                    }
                })
            });


            //update project
            $('#edit_project_modal_form').on('submit', function(event){
                event.preventDefault();
                $.ajax({
                    url:"{{ route('project_update') }}",
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
                            $('#edit_form_result').html(html);
                        }
                        if(response.success)
                        {
                            swal(response.success, "", "success");
                            $('#edit_project_modal_form')[0].reset();
                            $('#project_table').DataTable().ajax.reload();
                            $('#editProject').modal('hide');
                        }
                    },
                    error: function(response) {
                        console.log(response);
                    }
                })
            });

            //branch wise employee or team leader ajax
               $("#all_branch").change(function(){
                   var id = $("#all_branch").val();
                   $.ajax({
                       type: "GET",
                       url:"{{url('branch/team/leader')}}"+"/"+id,
                       dataType:"json",
                       success:function(response){
                             var leader = '';
                             leader+='<option value="">Select</option>'
                           $.each(response, function (i, item) {
                            leader += '<option value="'+item.emp_id+'">'+item.employeeId+' ('+ item.emp_first_name+')</option>';
                           });
                           $('#team_leader').html(leader);
                           $("#team_leader").select2();
                       }
                   })

                   $.ajax({
                       type: "GET",
                       url:"{{url('branch/client')}}"+"/"+id,
                       dataType:"json",
                       success:function(response){
                        console.log(response);
                             var client = '';
                             client+='<option value="">Select</option>'
                           $.each(response, function (i, item) {
                            client += '<option value="'+item.id+'">'+item.client_name+'</option>';
                           });
                           $('#clients_id').html(client);
                           $("#clients_id").select2();
                       },seeror:function(response){
                           console.log(response);
                       }
                   })
               });

              $("#clients_id").select2();
              $("#all_branch").select2();
        });
    </script>
@endsection
