@extends('layout.master')
@section('title', 'Attendance Exception Report')
@section('content')
    <!--BEGIN TITLE & BREADCRUMB PAGE-->
    <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
        <div class="page-header pull-left">
            <div class="page-title">Attendance Exception Report</div>
        </div>
        <ol class="breadcrumb page-breadcrumb pull-right">
            <li><i class="fa fa-home"></i>&nbsp;<a href="{{url('/')}}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
            <li><a href="#">Report</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
            <li class="active">Attendance Exception Report</li>
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
                            <div class="col-md-8">
                                Attendance Exception Report From {{\Carbon\Carbon::parse($request->date)->format('j M Y')}} to {{\Carbon\Carbon::parse($request->end_date)->format('j M Y')}}
                            </div>
                            {!! Form::open(['target'=>'_blank','method'=>'post','action'=>'AttendanceReportController@attendance_exception_export']) !!}
                            {!! Form::hidden('date',$request->date) !!}
                            {!! Form::hidden('end_date',$request->end_date) !!}
                            {!! Form::hidden('branch_id',$request->branch_id) !!}
                            {!! Form::hidden('emp_id',$request->emp_id) !!}
                            {!! Form::hidden('department_id',$request->department_id) !!}
                            {!! Form::hidden('designation_id',$request->designation_id) !!}
                            {!! Form::hidden('gender_id',$request->gender_id) !!}
                            <div class="col-md-4">
                                <div class="dropdown report_dropdown" style="float:right;">
                                    <button class="btn  dropdown-toggle btn-sm" type="button" data-toggle="dropdown">Download/Export
                                        <span class="caret"></span></button>
                                    <ul class="dropdown-menu">
                                        <li><button name="submit" value="pdf" type="submit">PDF</button> </li>
                                        <li><button name="submit" value="excel" type="submit">Excel</button> </li>
                                        <li><button name="submit" value="csv" type="submit">CSV</button> </li>

                                    </ul>
                                </div>
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                    <div class="panel-body table-responsive">
                        <table id="attendance_exception_table" class="table table-striped table-bordered" >
                            <thead>
                            <tr>
                                <th width="5%">No.</th>
                                <th width="15%">Name</th>
                                <th width="15%">Employee ID</th>
                                <th width="10%">Branch</th>
                                <th width="15%">Department</th>
                                <th width="15%">Date</th>
                                <th width="15%">Entry Time</th>
                                <th width="15%">Out Time</th>
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
            $('#attendance_exception_table').DataTable({
                processing: true,
                serverSide: true,
                "order": [[ 0, "desc" ]],
                ajax:{
                    url: "{{ route('attendance.attendance_exception_data') }}",
                    type:"post",
                    data:{
                        "_token": "{{ csrf_token() }}",
                        'date':"{{$request->date}}",
                        'end_date':"{{$request->end_date}}",
                        'branch_id':"{{$request->branch_id}}",
                        'emp_id':"{{$request->emp_id}}",
                        'department_id':"{{$request->department_id}}",
                        'designation_id':"{{$request->designation_id}}",
                        'gender_id':"{{$request->gender_id}}"
                    }
                },
                columns:[
                    {
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'full_name',
                        name: 'full_name'
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
                        data: 'attendance_date',
                        name: 'attendance_date'
                    },
                    {
                        data: 'in_time',
                        name: 'in_time'


                    },
                    {
                        data: 'out_time',
                        name: 'out_time'

                    }
                ]
            });


        });
    </script>
@endsection