@extends('layout.master')
@section('content')
    <!--BEGIN TITLE & BREADCRUMB PAGE-->
    <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
        <div class="page-header pull-left">
            <div class="page-title">Training</div>
        </div>
        <ol class="breadcrumb page-breadcrumb pull-right">
            <li><i class="fa fa-home"></i>&nbsp;<a href="{{url('/')}}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
            <li><a href="#">Training</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
            <li class="active">Training List</li>
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
                                Training List
                            </div>
                            <div class="col-md-6" style="text-align: right;">
                                <a href="" class="add-new-modal btn btn-success btn-round btn-sm" data-toggle="modal" data-target="#createTraining"> <i class="fa fa-plus"></i> Add New</a>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body table-responsive">
                        <table id="training_table" class="table table-striped table-bordered" >
                            <thead>
                            <tr>
                                <th>SN</th>
                                <th>Branch</th>
                                <th>Training</th>
                                <th>Duration</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Institution</th>
                                <th>Month</th>
                                <th>Created By</th>
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
        @include('backend.training.modal.training_create')
        @include('backend.training.modal.training_edit')
        <!-- Modal End -->
    </div>
@endsection



@section('extra_js')
    <script>
        $(document).ready(function(){
            //Clients List
            $('#training_table').DataTable({
                processing: true,
                serverSide: true,
                "order": [[ 2, "desc" ]],
                ajax:{
                    url: "{{ route('training_view') }}",
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
                        data: 'training_name',
                        name: 'training_name'
                    },
                    {
                        data: 'duration',
                        name: 'duration'
                    },
                    {
                        data: 'training_start',
                        name: 'training_start'
                    },
                    {
                        data: 'training_end',
                        name: 'training_end'
                    },
                    {
                        data: 'training_institution',
                        name: 'training_institution'
                    },
                    {
                        data: 'training_month',
                        name: 'training_month'
                    },
                    {
                        data: 'created_by',
                        name: 'created_by'
                    },

                    {
                        data: 'training_status',
                        name: 'training_status',
                        render: function(data, type, full, meta){
                            return data == '1' ? '<span style="color:green">Active</span>' : '<span style="color:orange">Inactive</span>'
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
            $('#training_modal_form').on('submit', function(event){

                event.preventDefault();
                $.ajax({
                    url:"{{ route('training_store') }}",
                    method:"POST",
                    data:new FormData(this),
                    dataType:'JSON',
                    contentType: false,
                    cache: false,
                    processData: false,
                    success:function(response)
                    {
                        console.log(response);
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
                            $('#training_modal_form')[0].reset();
                            $('#training_table').DataTable().ajax.reload();
                            $('#createTraining').modal('hide');
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
                    url:"{{url('training/edit')}}"+"/"+id,
                    dataType:"json",
                    success:function(response){
                        console.log(response);
                        $('#id').val(response.id);
                        $('#attachment_default').val(response.training_attachment);
                        $('#edit_duration').val(response.duration);
                        $('#edit_training_name').val(response.training_name);
                        $('#edit_training_start').val(response.training_start);
                        $('#edit_training_end').val(response.training_end);
                        $('#edit_training_institution').val(response.training_institution);
                        $('#edit_description').val(response.description);
                        $('#edit_training_month').val(response.training_month);
                        $("#edit_training_status option[value=" + response.status+"]").prop('selected', true);
						$("#edit_branch option[value="+response.branch_id+"]").attr("selected","selected")
                        $("#edit_branch").select2().select2('+response.branch_id+','+response.branch_name+');
                    }
                })
            });


            //update project
            $('#edit_training_modal_form').on('submit', function(event){
                event.preventDefault();
                $.ajax({
                    url:"{{ route('training_update') }}",
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
                            $('#edit_training_modal_form')[0].reset();
                            $('#training_table').DataTable().ajax.reload();
                            $('#editTraining').modal('hide');
                        }
                    },
                    error: function(response) {
                        console.log(response);
                    }
                })
            });
            $("#branch_id").select2();
        });
    </script>
@endsection
