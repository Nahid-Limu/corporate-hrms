@extends('layout.master')
    @if (Lang::locale()=='bn') 
        @section('title', 'কর্মচারী')
        @else 
        @section('title', 'Employee List')                                        
    @endif
@section('content')


    <!--BEGIN TITLE & BREADCRUMB PAGE-->
    <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
        <div class="page-header pull-left">
            <div class="page-title"> <?php if(Lang::has('employee_list.employee_list')){ echo Lang::get('employee_list.employee_list'); }else{ echo "Employee List"; } ?></div>
        </div>
        <ol class="breadcrumb page-breadcrumb pull-right">
            <li><i class="fa fa-home"></i>&nbsp;<a href="{{url('/')}}"><?php if(Lang::has('employee_list.home')){ echo Lang::get('employee_list.home'); }else{ echo "Home"; } ?></a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
            <li class="active"><?php if(Lang::has('employee_list.employee_list')){ echo Lang::get('employee_list.employee_list'); }else{ echo "List"; } ?></li>
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
                               <?php if(Lang::has('employee_list.employee_list')){ echo Lang::get('employee_list.employee_list'); }else{ echo "Employee List"; } ?>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                        <table id="employee" class="table table-striped table-bordered table-hover">
                            <thead>
                            <tr>
                                <th><?php if(Lang::has('employee_list.sn')){ echo Lang::get('employee_list.sn'); }else{ echo "SN"; } ?></th>
                                <th><?php if(Lang::has('employee_list.employee_id')){ echo Lang::get('employee_list.employee_id'); }else{ echo "Employee ID"; } ?></th>
                               
                                <th><?php if(Lang::has('employee_list.employee_name')){ echo Lang::get('employee_list.employee_name'); }else{ echo "Employee Name"; } ?></th>
                                <th><?php if(Lang::has('employee_list.branch')){ echo Lang::get('employee_list.branch'); }else{ echo "Branch"; } ?></th>
                                <th><?php if(Lang::has('employee_list.department')){ echo Lang::get('employee_list.department'); }else{ echo "Department"; } ?></th>
                                <th><?php if(Lang::has('employee_list.designation')){ echo Lang::get('employee_list.designation'); }else{ echo "Designation"; } ?></th>
                                <th><?php if(Lang::has('employee_list.status')){ echo Lang::get('employee_list.status'); }else{ echo "Status"; } ?></th>
                                <th><?php if(Lang::has('employee_list.action')){ echo Lang::get('employee_list.action'); }else{ echo "Action"; } ?></th>
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
            "order": [[ 1, "asc" ]],
            ajax:{
                url: "{{ url('employee/list') }}",
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
