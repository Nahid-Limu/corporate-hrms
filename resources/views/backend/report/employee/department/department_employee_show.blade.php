@extends('layout.master')
@section('content')
    <!--BEGIN TITLE & BREADCRUMB PAGE-->
    <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
        <div class="page-header pull-left">
            <div class="page-title">Department Wise Employee</div>
        </div>
        <ol class="breadcrumb page-breadcrumb pull-right">
            <li><i class="fa fa-home"></i>&nbsp;<a href="{{url('/')}}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
            <li><a href="#">Department Wise Employee</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
            <li class="active">Department Wise Employee</li>
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
                               Department Wise Employee
                            </div>
                        </div>
                    </div>
                    {{--  <div class="panel-body">
                        <div class="col-md-12">

                        </div>
                    </div>  --}}
                </div>
            </div>
        </div>
        <table id="designation_employee" class="table table-striped table-bordered">
            <thead>
            <tr>
                <th>Employee Id</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Department</th>
                <th>Designation</th>
                <th>Action</th>
            </tr>
            </thead>
            @foreach($employee as $employees)
                <tr>
                    <td>{{$employees->employeeId}}</td>
                    <td>{{$employees->emp_first_name}}</td>
                    <td>{{$employees->emp_lastName}}</td>
                    <td>{{$employees->department_name}}</td>
                    <td>{{$employees->designation_name}}</td>
                    <td><a href="{{url('/employee/profile/'.base64_encode($employees->id))}}">View profile</a></td>
                </tr>
            @endforeach
        </table>

    </div>
@endsection

@section('extra_js')
    <script>
        $('#designation_employee').DataTable();
    </script>
@endsection








