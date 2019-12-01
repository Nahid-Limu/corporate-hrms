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
</style>

@section('content')
    <!--BEGIN TITLE & BREADCRUMB PAGE-->
    <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
        <div class="page-header pull-left">
            <div class="page-title">Individual Attendance Report</div>
        </div>
        <ol class="breadcrumb page-breadcrumb pull-right">
            <li><i class="fa fa-home"></i>&nbsp;<a href="{{url('/')}}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
            <li><a href="#">Report</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
            <li class="active">Individual Attendance Report</li>
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
                                Attendance report from {{\Carbon\Carbon::parse($request->date)->format('j M Y')}} to
                                {{\Carbon\Carbon::parse($request->end_date)->format('j M Y')}}
                            </div>
                            {!! Form::open(['target'=>'_blank','method'=>'post','action'=>'AttendanceReportController@individual_attendance_report_export']) !!}
                            {!! Form::hidden('date',$request->date) !!}
                            {!! Form::hidden('end_date',$request->end_date) !!}
                            {!! Form::hidden('branch_id',$request->branch_id) !!}
                            {!! Form::hidden('emp_id',$request->emp_id) !!}
                            <div class="col-md-6">
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

                    <div class="panel-body">
                        <div class="row">

                            <div class="col-md-6 col-md-offset-3 ">
                                <div class="content_body">
                                    <div class="form-group">
                                        <div class="row first_r">
                                            <div class="col-md-12 col-sm-12 col-xs-12"><label><h5>Employee Details</h5></label></div>

                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 col-sm-6 col-xs-6"><label><h5>Full Name:</h5></label></div>
                                            <div class="col-md-6 col-sm-6 col-xs-6"><p>{{$employee->full_name}}</p></div>

                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 col-sm-6 col-xs-6"><label><h5>Employee ID:</h5></label></div>
                                            <div class="col-md-6 col-sm-6 col-xs-6"><p>{{$employee->employeeId}}</p></div>

                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 col-sm-6  col-xs-6"><label><h5>Branch:</h5></label></div>
                                            <div class="col-md-6 col-sm-6 col-xs-6"><p>{{$employee->branch_name}}</p></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 col-sm-6 col-xs-6"><label><h5>Designation:</h5></label></div>
                                            <div class="col-md-6 col-sm-6 col-xs-6"><p>{{$employee->designation_name}}</p></div>

                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>

                    </div>


                    <div class="panel-body table-responsive">
                        <table id="daily_attendance_report_table" class="table table-striped table-bordered" style="border: 1px solid #efefef">
                            <thead>
                            <tr>
                                <th width="15%">Date</th>
                                <th width="15%">Day</th>
                                <th width="15%">Entry Time</th>
                                <th width="15%">Exit Time</th>
                                <th width="10%">Status</th>

                            </tr>
                            </thead>
                            <tbody class="table-body-1">

                            @for($i=$request->date;$i<=$request->end_date;$i=\Carbon\Carbon::parse($i)->addDay())
                                <?php
                                $check_leave=0;
                                $check_weekend=0;
                                $check_holiday=0;
                                $check_present=0;

                                $day=\Carbon\Carbon::parse($i)->format('l');
                                $leave=\Illuminate\Support\Facades\DB::table('tb_employee')
                                    ->join('tb_leave_application', 'tb_employee.id', '=', 'tb_leave_application.emp_id')
                                    ->where('tb_employee.emp_account_status','=',1)
                                    ->where('tb_leave_application.status','=',1)
                                    ->where("tb_leave_application.leave_starting_date",'<=',$i)
                                    ->where("tb_leave_application.leave_ending_date",'>=',$i)
                                    ->where('tb_employee.id','=',$request->emp_id)->first();

                                if(isset($leave->id)){
                                    $check_leave=1;
                                }
                                if($check_leave!=1){
                                    $week_leave=\Illuminate\Support\Facades\DB::table('tb_week_leave')->where('day','=',\Illuminate\Support\Facades\DB::raw("'$day'"))->where('status','=',1)->first();
                                    if(isset($week_leave->id)){
                                        $check_weekend=1;
                                    }

                                }

                                if($check_leave!=1 && $check_weekend!=1){
                                    $holiday=\Illuminate\Support\Facades\DB::table('tb_festival_leave')->where('start_date','>=',$i)
                                        ->where('end_date','<=',$i)->first();
                                    if(isset($holiday->id)){
                                        $check_holiday=1;

                                    }
                                }


                                $att=\Illuminate\Support\Facades\DB::table('tb_employee')
                                    ->leftJoin('tb_shift','tb_employee.emp_shift_id','=','tb_shift.id')
                                    ->join('tb_attendance','tb_employee.id','=','tb_attendance.emp_id')
                                    ->where('emp_id','=',$request->emp_id)
                                    ->where('attendance_date','=',$i)
                                    ->select('tb_attendance.id','tb_attendance.in_time','tb_attendance.out_time',
                                        'tb_shift.entry_time','tb_shift.exit_time')
                                    ->first();
                                if(isset($att->id)){
                                    $check_present=1;
                                }



                                ?>
                                <tr>
                                    <td>{{\Carbon\Carbon::parse($i)->format('d M Y')}}</td>
                                    <td>{{$day}}</td>
                                    <td>
                                        @if(isset($att->in_time))
                                            {{$att->in_time}}
                                        @endif
                                    </td>
                                    <td>
                                        @if(isset($att->out_time))
                                            {{$att->out_time}}
                                        @endif
                                    </td>
                                    <td>
                                        @if($check_leave==1)
                                            <span style="color: blue">On Leave</span>
                                            <?php $total_leave++; ?>
                                        @elseif($check_holiday==1)
                                            <span style="color: #0b97c4">Holiday</span>

                                        @elseif($check_present==1)
                                            @if($att->in_time>$att->entry_time)
                                                <span style="color: ">Late</span>
                                                <?php $total_late++; ?>
                                                
                                            @else
                                                <span style="color: green">Present</span>
                                                <?php $total_present++; ?>
                                            @endif
                                        @elseif($check_weekend==1)
                                            <span style="color: #0c5460">Weekend</span>
                                        @else
                                            <span style="color: red">Absent</span>
                                            <?php $total_absent++; ?>
                                        @endif
                                    </td>

                                </tr>
                            @endfor
                            </tbody>
                        </table>
                        <br>

                        <div class="col-md-offset-6 col-md-6" style="text-align: center; font-weight: bold">
                            <p>Total Present: <span>{{$total_present+$total_late}}</span> </p>
                            <p>Total Late: <span>{{$total_late}}</span> </p>
                            <p>Total Leave: <span>{{$total_leave}}</span> </p>
                            <p>Total Absent: <span>{{$total_absent}}</span> </p>
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