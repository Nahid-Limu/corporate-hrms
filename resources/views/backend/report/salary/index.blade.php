@extends('layout.master')
@section('title', 'Salary Report')
@section('content')
    <div class="page-content ">
        <div class="row panel manual_attendance_panel"  style="border:1px solid #dcdcdc;">

            <div class="col-xlg-12 col-lg-12  col-sm-12">
                <div class="text-center" >
                    <h2><b>Salary Report</b></h2>
                    <hr>
                </div>
            </div>

            {{-- <a target="_blank" href="{{route('salary_report.salary_sheet')}}"> --}}
            <a target="_blank" href="{{route('salary_report.salary_month')}}">
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

                                    <b>Salary Report</b>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
            </a>

            {{-- <a target="_blank" href="{{route('salary_report.pay_slip')}}"> --}}
            <a target="_blank" href="{{route('salary_report.salary_month_employee')}}">
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

                                    <b>Generate Payslip</b>
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