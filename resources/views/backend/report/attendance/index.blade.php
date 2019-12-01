@extends('layout.master')
@section('title', 'Attendance File')
@section('content')
    <div class="page-content ">
        <div class="row panel manual_attendance_panel"  style="border:1px solid #dcdcdc;">

            <div class="col-xlg-12 col-lg-12  col-sm-12">
                <div class="text-center" >
                    <h2><b>Attendance Report</b></h2>
                    <hr>
                </div>
            </div>

            <a target="_blank" href="{{route('attendance.individual_attendance_report')}}">
                <div class="col-sm-6 col-md-3">
                    <div class="panel db mbm my_panel my_panel_4">
                        <div class="panel-body ">
                            <div class="col-sm-12 col-xs-12">
                                <div class="icon_body">
                                    <i class="my_icon fa fa-search"></i>
                                </div>

                            </div>
                            <div class="col-sm-12 col-xs-12">
                                <div class="my_panel_right">

                                    <b>Individual Attendance Report</b>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
            </a>

            <a target="_blank" href="{{route('attendance.attendance_report')}}">
                <div class="col-sm-6 col-md-3">
                    <div class="panel db mbm my_panel my_panel_7">
                        <div class="panel-body ">
                            <div class="col-sm-12 col-xs-12">
                                <div class="icon_body">
                                    <i class="my_icon fa fa-search"></i>
                                </div>

                            </div>
                            <div class="col-sm-12 col-xs-12">
                                <div class="my_panel_right">

                                    <b>Daily Attendance Report</b>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
            </a>

            <a target="_blank" href="{{route('attendance.daily_absent_report')}}">
                <div class="col-sm-6 col-md-3">
                    <div class="panel db mbm my_panel my_panel_1">
                        <div class="panel-body ">
                            <div class="col-sm-12 col-xs-12">
                                <div class="icon_body">
                                    <i class="my_icon fa fa-ban"></i>
                                </div>

                            </div>
                            <div class="col-sm-12 col-xs-12">
                                <div class="my_panel_right">
                                    <b>Daily Absent Report</b>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </a>

            <a target="_blank" href="{{route('attendance.present_report')}}">
                <div class="col-sm-6 col-md-3">
                    <div class="panel db mbm my_panel my_panel_8">
                        <div class="panel-body ">
                            <div class="col-sm-12 col-xs-12">
                                <div class="icon_body">
                                    <i class="my_icon fa fa-users"></i>
                                </div>

                            </div>
                            <div class="col-sm-12 col-xs-12">
                                <div class="my_panel_right">
                                    <b>Present Report</b>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
            </a>

            <a target="_blank" href="{{route('attendance.late_report')}}">
                <div class="col-sm-6 col-md-3">
                    <div class="panel db mbm my_panel my_panel_3">
                        <div class="panel-body ">
                            <div class="col-sm-12 col-xs-12">
                                <div class="icon_body">
                                    <i class="my_icon fa fa-exclamation-circle"></i>
                                </div>

                            </div>
                            <div class="col-sm-12 col-xs-12">
                                <div class="my_panel_right">
                                    <b>Late Attendance Report</b>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </a>

            <a target="_blank" href="{{route('attendance.overtime_report')}}">
                <div class="col-sm-6 col-md-3">
                    <div class="panel db mbm my_panel my_panel_10">
                        <div class="panel-body ">
                            <div class="col-sm-12 col-xs-12">
                                <div class="icon_body">
                                    <i class="my_icon fa fa-search"></i>
                                </div>

                            </div>
                            <div class="col-sm-12 col-xs-12">
                                <div class="my_panel_right">

                                    <b>Overtime Report</b>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
            </a>

            <a target="_blank" href="{{route('attendance.attendance_exception_report')}}">
                <div class="col-sm-6 col-md-3">
                    <div class="panel db mbm my_panel my_panel_14">
                        <div class="panel-body">
                            <div class="col-sm-12 col-xs-12">
                                <div class="icon_body">
                                    <i class="my_icon fa fa-search"></i>
                                </div>

                            </div>
                            <div class="col-sm-12 col-xs-12">
                                <div class="my_panel_right">

                                    <b>Attendance Exception Report</b>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
            </a>

            <div class="col-md-12">
                <hr>
            </div>
        </div>
    </div>

@endsection

@section('extra_js')

@endsection