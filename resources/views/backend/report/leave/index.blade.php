@extends('layout.master')
@section('title', 'Employee Report')
@section('content')
    <div class="page-content ">
        <div class="row panel manual_attendance_panel"  style="border:1px solid #dcdcdc;">

            <div class="col-xlg-12 col-lg-12  col-sm-12">
                <div class="" >
                    <h2><b>Leave Report</b></h2>
                    <hr>
                </div>
            </div>

            <a href="{{route('report.current.month.leave')}}">
                <div class="col-sm-6 col-md-3">
                    <div class="panel db mbm my_panel my_panel_16">
                        <div class="panel-body ">
                            <div class="col-sm-12 col-xs-12">
                                <div class="icon_body">
                                    <i class="my_icon fa fa-search"></i>
                                </div>
                            </div>
                            <div class="col-sm-12 col-xs-12">
                                <div class="my_panel_right">
                                    <b>On leave Employee (Current Month)</b>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </a>

            <a href="{{route('report.date.wise.leave')}}">
                <div class="col-sm-6 col-md-3">
                    <div class="panel db mbm my_panel my_panel_6">
                        <div class="panel-body ">
                            <div class="col-sm-12 col-xs-12">
                                <div class="icon_body">
                                    <i class="my_icon fa fa-users"></i>
                                </div>

                            </div>
                            <div class="col-sm-12 col-xs-12">
                                <div class="my_panel_right">
                                    <b>Datewise Leave Report</b>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
            </a>


                <a href="{{route('leave_report_type_datewise')}}">
                <div class="col-sm-6 col-md-3">
                    <div class="panel db mbm my_panel my_panel_12">

                        <div class="panel-body ">
                            <div class="col-sm-12 col-xs-12">
                                <div class="icon_body">
                                    <i class="my_icon fa fa-users"></i>
                                </div>

                            </div>
                            <div class="col-sm-12 col-xs-12">
                                <div class="my_panel_right">
                                    <b>Report Leave Type</b>
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
