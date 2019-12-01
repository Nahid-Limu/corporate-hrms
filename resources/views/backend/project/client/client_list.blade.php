@extends('layout.master')
@section('content')
    <!--BEGIN TITLE & BREADCRUMB PAGE-->
    <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
        <div class="page-header pull-left">
            <div class="page-title">Clients</div>
        </div>
        <ol class="breadcrumb page-breadcrumb pull-right">
            <li><i class="fa fa-home"></i>&nbsp;<a href="{{url('/')}}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
            <li><a href="#">Clients</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
            <li class="active">Clients List</li>
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
                                Clients List
                            </div>
                            <div class="col-md-6" style="text-align: right;">
                                <a href="" class="add-new-modal btn btn-success btn-round btn-sm" data-toggle="modal" data-target="#createClient"> <i class="fa fa-plus"></i> Add New</a>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body table-responsive">
                        <table id="client_table" class="table table-striped table-bordered" >
                            <thead>
                            <tr>
                                <th>SN</th>
                                <th>Branch</th>
                                <th>Client Name</th>
                                <th>Client Phone</th>
                                <th>Client Email</th>
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
    @include('backend.project.client.modal.create')
    @include('backend.project.client.modal.edit')
    <!-- Modal End -->
    </div>
@endsection

@section('extra_js')
    <script>
        $(document).ready(function(){
            //Clients List
            $('#client_table').DataTable({
                processing: true,
                serverSide: true,
                "order": [[ 1, "desc" ]],
                ajax:{
                    url: "{{ route('clients_list') }}",
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
                        data: 'client_name',
                        name: 'client_name'
                    },
                    {
                        data: 'client_phone',
                        name: 'client_phone'
                    },
                    {
                        data: 'client_email',
                        name: 'client_email'
                    },
                    {
                        data: 'created_by',
                        name: 'created_by'
                    },
                    {
                        data: 'status',
                        name: 'status',
                        render: function(data, type, full, meta){
                            return data == '1' ? '<span style="color:green">Active</span>' : '<span style="color:red">InActive</span>'
                        },
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false
                    }
                ]
            });


            //Client Add
            $( "#client_add" ).click(function() {
                var _token = '{{ csrf_token() }}';
                var branch_id = $("#branch_id").val();
                var client_name = $("#client_name").val();
                var client_phone = $("#client_phone").val();
                var client_email = $("#client_email").val();
                var client_address = $("#client_address").val();
                //alert(_token);
                $.ajax({
                    url:"{{route('clients_add')}}",
                    method:"post",
                    data: {_token : _token, client_name : client_name, client_phone : client_phone,client_email:client_email,client_address:client_address,branch_id:branch_id},
                    success:function (response) {
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
                            $('#modal_form')[0].reset();
                            $('#client_table').DataTable().ajax.reload();
                            $('#createClient').modal('hide');
                        }

                    }
                });
            });

            //Edit Client
            $(document).on('click', '.edit', function(){
                var id = $(this).attr('id');
                $.ajax({
                    type: "GET",
                    url:"{{url('clients/edit')}}"+"/"+id,
                    dataType:"json",
                    success:function(response){
                        $('#id').val(response.id);
                        $('#edit_clients_name').val(response.client_name);
                        $('#edit_clients_phone').val(response.client_phone);
                        $('#edit_clients_email').val(response.client_email);
                        $('#edit_clients_address').val(response.client_address);
                        $("#c_status option[value=" + response.status + "]").prop('selected', true);
                       $("#edit_branch_id option[value="+response.branch_id+"]").attr("selected","selected")
                       $("#edit_branch_id").select2().select2('+response.branch_id+','+response.branch_name+');
                    }
                })
            });


            //update client
            $( "#client_update" ).click(function() {
                var _token = '{{ csrf_token() }}';
                var id = $("#id").val();
                var edit_branch_id = $("#edit_branch_id").val();
                var client_name = $("#edit_clients_name").val();
                var client_phone = $("#edit_clients_phone").val();
                var client_email = $("#edit_clients_email").val();
                var client_address = $("#edit_clients_address").val();
                var c_status = $("#c_status").val();

                $.ajax({
                    url:"{{route('clients_update')}}",
                    method:"post",
                    data: {_token : _token, id : id, client_name : client_name, client_phone : client_phone,client_email:client_email,client_address:client_address,c_status:c_status,edit_branch_id:edit_branch_id},
                    success:function (response) {
                        var html = '';
                        if(response.errors)
                        {
                            html = '<div class="alert alert-danger">';

                            html += '<p>' + response.errors + '</p>';

                            html += '</div>';
                            $('#form_results').html(html);
                        }
                        if(response.success)
                        {
                            swal(response.success, "", "success");
                            $('#edit_form_result').hide();
                            $('#modal_form')[0].reset();
                            $('#client_table').DataTable().ajax.reload();
                            $('#editClient').modal('hide');
                        }
                    }
                });
            });

         $("#branch_id").select2();
        });
    </script>
@endsection
