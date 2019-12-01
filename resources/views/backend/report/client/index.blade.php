@extends('layout.master')
@section('title', 'Employee Report')
@section('content')
    <div class="page-content ">
        <div class="row panel manual_attendance_panel"  style="border:1px solid #dcdcdc;">

            <div class="col-xlg-12 col-lg-12  col-sm-12">
                <div class="text-center" >
                    <h2><b>Client Report</b></h2>
                    <hr>
                </div>
            </div>

            <a href="{{url('report/client/list')}}">
                <div class=" col-md-3">
                    <div class="panel db mbm my_panel my_panel_1">
                        <div class="panel-body ">
                            <div class="col-sm-12 col-xs-12">
                                <div class="icon_body">
                                    <i class="my_icon fa fa-search"></i>
                                </div>
                            </div>
                            <div class="col-sm-12 col-xs-12">
                                <div class="my_panel_right">
                                    <b>Client List</b>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </a>


            <a href="{{url('report/client/project')}}">
                <div class=" col-md-3">
                    <div class="panel db mbm my_panel my_panel_7">
                        <div class="panel-body ">
                            <div class="col-sm-12 col-xs-12">
                                <div class="icon_body">
                                    <i class="my_icon fa fa-users"></i>
                                </div>
                            </div>
                            <div class="col-sm-12 col-xs-12">
                                <div class="my_panel_right">
                                    <b>Client Project</b>
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
