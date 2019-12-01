@extends('layout.master')
@section('title', $groupName)
@section('content')
    <!--BEGIN TITLE & BREADCRUMB PAGE-->
    <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
        <div class="page-header pull-left">
            <div class="page-title"> {{$groupName}}</div>
        </div>
        <ol class="breadcrumb page-breadcrumb pull-right">
            <li><i class="fa fa-home"></i>&nbsp;<a href="{{url('/')}}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
            <li><a href="#">Employee</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
            <li class="active"> {{$groupName}}</li>
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
                                {{$groupName}}
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                        <table id="employee" class="table table-striped table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>SN</th>
                                <th>Employee ID</th>
                                <th>Employee Name</th>
                                <th>Branch</th>
                                <th>Department</th>
                                <th>Designation</th>
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
    </div>
@endsection
@section('extra_js')
    <script>
       var t = $('#employee').DataTable({
            processing: true,
            serverSide: true,
            "order": [[ 0, "asc" ]],
            ajax:{
                url: "{{ url('/dashboard/employee_list/'.$group) }}",
            },
            columns:[
                {
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
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
                    data: 'branch_name',
                    name: 'branch_name'
                },
                {
                    data: 'department_name',
                    name: 'department_name'
                },
                {
                    data: 'designation_name',
                    name: 'designation_name'
                },
                {
                    data: 'emp_account_status',
                    name: 'emp_account_status',
                    render: function(data){
                        return data == '1' ? '<span style="color:Green">Active</span>' : '<span style="color:red">Inactive</span>'
                    }
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false
                }
            ]
        });
    </script>
@endsection
