@extends('layout.master')
@section('title', 'Attendance File')
@section('content')
    <div class="page-content ">
        <div class="row panel manual_attendance_panel"  style="border:1px solid #dcdcdc;">

            <div class="col-xlg-12 col-lg-12  col-sm-12">
                <div class="text-center" >
                    <h2><b>Manual Attendance</b></h2>
                    <hr>
                </div>
            </div>

            <a target="_blank" href="{{route('attendance.create_attendance')}}">
                <div class="col-sm-6 col-md-3">
                    <div class="panel db mbm my_panel my_panel_1">
                        <div class="panel-body ">
                            <div class="col-sm-12 col-xs-12">
                                <div class="icon_body">
                                    <i class="my_icon fa fa-search"></i>
                                </div>

                            </div>
                            <div class="col-sm-12 col-xs-12">
                                <div class="my_panel_right">

                                    <b>Manual Attendance (Daily)</b>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
            </a>

            <a target="_blank" href="{{route('attendance.create_attendance_date')}}">
                <div class="col-sm-6 col-md-3">
                    <div class="panel db mbm my_panel my_panel_2">
                        <div class="panel-body ">
                            <div class="col-sm-12 col-xs-12">
                                <div class="icon_body">
                                    <i class="my_icon fa fa-users"></i>
                                </div>

                            </div>
                            <div class="col-sm-12 col-xs-12">
                                <div class="my_panel_right">
                                    <b>Manual Attendance (Date Wise)</b>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
            </a>

            <a target="_blank" href="{{route('attendance.edit_attendance')}}">
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
                                    <b>Edit Attendance</b>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </a>
            <a target="_blank" href="{{route('attendance.delete_attendance')}}">
                <div class="col-sm-6 col-md-3">
                    <div class="panel db mbm my_panel my_panel_6">
                        <div class="panel-body ">
                            <div class="col-sm-12 col-xs-12">
                                <div class="icon_body">
                                    <i class="my_icon fa fa-ban"></i>
                                </div>

                            </div>
                            <div class="col-sm-12 col-xs-12">
                                <div class="my_panel_right">
                                    <b>Delete Attendance Record</b>
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