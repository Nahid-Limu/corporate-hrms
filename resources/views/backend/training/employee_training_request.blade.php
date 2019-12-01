@extends('layout.master')
@section('content')
    <!--BEGIN TITLE & BREADCRUMB PAGE-->
    <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
        <div class="page-header pull-left">
            <div class="page-title">Training Request</div>
        </div>
        <ol class="breadcrumb page-breadcrumb pull-right">
            <li><i class="fa fa-home"></i>&nbsp;<a href="{{url('/')}}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
            <li><a href="#">Training Request</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
            <li class="active">Training Request List</li>
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
                                Training Request List
                            </div>
                        </div>
                    </div>
                    <div class="panel-body table-responsive">
                        <table id="training_table" class="table table-striped table-bordered" >
                            <thead>
                            <tr>
							    <th>SN</th>
                                <th>Training</th>
                                <th>Duration</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Institution</th>
                                <th>Month</th>
                                <th>Employee Id</th>
                                <th>Employee</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection



@section('extra_js')
    <script>
        $(document).ready(function(){
            //Training request List
            $('#training_table').DataTable({
                processing: true,
                serverSide: true,
                "order": [[ 1, "desc" ]],
                ajax:{
                    url: "{{ route('training_request') }}",
                },
                columns:[
				  {
data: 'DT_RowIndex',

  name: 'DT_RowIndex'

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
                        data: 'employeeId',
                        name: 'employeeId'
                    },
                    {
                        data: 'emp_first_name',
                        name: 'emp_first_name'
                    },
                    {
                        data: 'request_status',
                        name: 'request_status',
                        render: function(data, type, full, meta){
                            return data == '1' ? '<span style="color:green">Approve</span>' : '<span style="color:red">Rejected</span>'
                        },
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false
                    }
                ]
            });


            //approve or reject training
            $(document).on('click', '.approve', function(){
                var id = $(this).attr('id');
                $.ajax({
                    type: "GET",
                    data: {status_value:1},
                    url:"{{url('training/approve/reject')}}"+"/"+id,
                    dataType:"json",
                    success:function(response){
                        if(response.success)
                        {
                            swal(response.success, "", "success");
                            $('#training_table').DataTable().ajax.reload();
                        }
                    }
                })
            });

            $(document).on('click', '.rejected', function(){
                var id = $(this).attr('id');
                $.ajax({
                    type: "GET",
                    data: {status_value:0},
                    url:"{{url('training/approve/reject')}}"+"/"+id,
                    dataType:"json",
                    success:function(response){
                        if(response.error)
                        {
                            swal(response.error, "", "error");
                            $('#training_table').DataTable().ajax.reload();
                        }
                    }
                })
            });

        });
    </script>
@endsection