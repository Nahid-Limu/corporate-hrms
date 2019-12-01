@extends('layout.master')
@section('title', 'Expense')
@section('content')
    <!--BEGIN TITLE & BREADCRUMB PAGE-->
    <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
        <div class="page-header pull-left">
            <div class="page-title">Expense</div>
        </div>
        <ol class="breadcrumb page-breadcrumb pull-right">
            <li><i class="fa fa-home"></i>&nbsp;<a href="{{url('/')}}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
            <li><a href="#">Expense</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
            <li class="active">Expense List</li>
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
                               Employee Wise Expense List
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <table id="Expanse_table" class="table table-striped table-bordered" >
                            <thead>
                            <tr>    
                                <th>SN</th>
                                <th>Employee Name</th>
                                <th>Employee ID</th>
                                <th>Branch</th>
                                <th>Department</th>
                                <th>Designation</th>
                                <th>Amount</th>
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

   // =============== Index List ============= --> 

    $(document).ready(function(){
    
        $('#Expanse_table').DataTable({
        processing: true,
        serverSide: true,
        "order": [[ 1, "asc" ]],
        ajax:{
        url: "{{ route('employee_wise_expanse_summary') }}",
        },
        columns:[
        { 
            data: 'DT_RowIndex', 
            name: 'DT_RowIndex' 
        },
        {
            data: 'emp_first_name',
            name: 'emp_first_name'
        },
        {
            data: 'employeeId',
            name: 'employeeId'
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
            data: 'totAmount',
            name: 'totAmount'
        },
        {
            data: 'action',
            name: 'action',
            orderable: false
        }
        ]
        });
           
    }); 

   // =============== End Update group ============= --> 

    </script>
@endsection





 
