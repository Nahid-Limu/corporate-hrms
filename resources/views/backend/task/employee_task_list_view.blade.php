<?php
$total_leave=0;
$total_present=0;
$total_absent=0;
$total_late=0;
?>

@extends('layout.master')
@section('title', 'Individual Attendance Report')
<style>
    #pageloader
    {
        background: rgba( 255, 255, 255, 0.8 );
        display: none;
        height: 100%;
        position: fixed;
        width: 100%;
        z-index: 9999;
    }

    #pageloader img
    {
        left: 40%;
        margin-left: -32px;
        margin-top: -32px;
        position: absolute;
        top: 50%;
        transform: translate(-50%,-50%);
    }

    .content_body{
        padding: 15px;
        box-shadow: 0 0 10px 0 rgba(0, 0, 0, 0.1);
    }
    .content_body p{
        margin-top:7px;
    }
    .first_r{
        background: #40516f;
        color: #fff;
        font-weight: 700;
    }
    .first_r h5{
        font-weight: 700;
    }
    .table-body-1 tr{
        font-size: 14px;
    }
    .isDisabled {
        color: currentColor;
        cursor: not-allowed;
        opacity: 0.5;
        text-decoration: none;
    }
    thead tr th{
        font-size:13px;
    }
</style>

@section('content')
    <!--BEGIN TITLE & BREADCRUMB PAGE-->
    <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
        <div class="page-header pull-left">
            <div class="page-title">Employee Task Report</div>
        </div>
        <ol class="breadcrumb page-breadcrumb pull-right">
            <li><i class="fa fa-home"></i>&nbsp;<a href="{{url('/')}}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
            <li><a href="#">Report</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
            <li class="active">Employee Task Report</li>
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
{{--                                Attendance report from {{\Carbon\Carbon::parse($request->date)->format('j M Y')}} to--}}
{{--                                {{\Carbon\Carbon::parse($request->end_date)->format('j M Y')}}--}}
                                Employee Task Report
                            </div>
{{--                            {!! Form::open(['target'=>'_blank','method'=>'post','action'=>'AttendanceReportController@individual_attendance_report_export']) !!}--}}
{{--                            {!! Form::hidden('date',$request->date) !!}--}}
{{--                            {!! Form::hidden('end_date',$request->end_date) !!}--}}
{{--                            {!! Form::hidden('branch_id',$request->branch_id) !!}--}}
{{--                            {!! Form::hidden('emp_id',$request->emp_id) !!}--}}
{{--                            <div class="col-md-6">--}}
{{--                                <div class="dropdown report_dropdown" style="float:right;">--}}
{{--                                    <button class="btn  dropdown-toggle btn-sm" type="button" data-toggle="dropdown">Download/Export--}}
{{--                                        <span class="caret"></span></button>--}}
{{--                                    <ul class="dropdown-menu">--}}
{{--                                        <li><button name="submit" value="pdf" type="submit">PDF</button> </li>--}}
{{--                                        <li><button name="submit" value="excel" type="submit">Excel</button> </li>--}}
{{--                                        <li><button name="submit" value="csv" type="submit">CSV</button> </li>--}}

{{--                                    </ul>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            {!! Form::close() !!}--}}
                        </div>
                    </div>




                    <div class="panel-body table-responsive">
                        <table id="" class="table table-striped table-bordered" style="border: 1px solid #efefef">
                            <thead style="background: #e6e5e5cc;">
                            <tr>
                                <th width="5%">SN</th>
                                <th width="10%">Task Title</th>
                                <th width="15%">Employee Name</th>
                                <th width="10%">Branch</th>
                                <th width="10%">Department</th>
                                <th width="10%">Designation</th>
                                <th width="15%">Assign Date</th>
                                <th width="10%">Start Time</th>
                                <th width="10%">End Date</th>
                                <th width="15%">Attachment</th>
                                <th width="10%">Assign Status</th>


                            </tr>
                            </thead>
                            <tbody class="table-body-1">
                                @foreach($all_task as $key => $task)
                                <tr>
                                    <td>{{$key+1}}</td>
                                    <td>{{$task->title}}</td>
                                    <td>{{$task->emp_first_name}} {{$task->emp_lastName}}</td>
                                    <td>{{$task->branch_name}}</td>
                                    <td>{{$task->department_name}}</td>
                                    <td>{{$task->designation_name}}</td>
                                    <td>{{$task->assign_date}}</td>
                                    <td>{{$task->start_time}}</td>
                                    <td>{{$task->end_time}}</td>
                                    <td>{{$task->attachment}}</td>
                                    <td>

                                        @if($task->assign_status==1)
                                            Pending
                                        @elseif($project->status==1)
                                            On Going
                                        @elseif($project->status==2)
                                            Completed
                                        @elseif($project->status==3)
                                            Rejected

                                        @endif
                                    </td>
                                </tr>
                                @endforeach

                            </tbody>
                        </table>
                        <br>

                        <div class="col-md-offset-6 col-md-6" style="text-align: center; font-weight: bold">

                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@section('extra_js')
    <script>
    </script>
@endsection
