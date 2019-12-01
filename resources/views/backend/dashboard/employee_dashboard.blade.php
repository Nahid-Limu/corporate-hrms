@extends('layout.master')
@section('title', 'Dashboard')
@section('extra_css')
<style type="text/css">
    .myAnimation .animated {
        -webkit-animation-duration: 4s !important;
        animation-duration: 4s !important;
        -webkit-animation-fill-mode: both;
        animation-fill-mode: both;
    }
   #tab-general .portlet {
        border: 1px solid #e5e5e5;
   }
    #footer{
        position: static;
    }
    #footer .copyright {
        width: 95%;
    }
    .employee_details_data .panel-body{
        padding-top: 0px;
        padding-bottom: 5px;
    }
    .panel_body_employee_data_heading{
        background: rgba(50,95,110,1);
        background: -moz-linear-gradient(left, rgba(50,95,110,1) 0%, rgba(94,176,204,1) 100%);
        background: -webkit-linear-gradient(left, rgba(50,95,110,1) 0%, rgba(94,176,204,1) 100%);
        background: -o-linear-gradient(left, rgba(50,95,110,1) 0%, rgba(94,176,204,1) 100%);
        background: -ms-linear-gradient(left, rgba(50,95,110,1) 0%, rgba(94,176,204,1) 100%);
        background: linear-gradient(to right, rgba(50,95,110,1) 0%, rgba(94,176,204,1) 100%);
        box-shadow: 0 3px 8px 0 rgba(50,95,110,.5)!important;
        text-align: center;
        margin-bottom: 20px;
    }
    .panel_body_employee_data_heading h1{
        color: #fff;
        font-size: 22px;
        margin-top: 12px;
        margin-bottom: 12px;
    }
    .panel_body_employee_data_value p{
        padding-left: 10%;
        padding-right: 10%;
        padding-bottom: 17px;
    }
    .panel_body_employee_data_value p span{
        display: block;
        width: 35%;
        float: left;
        text-align: left;
        margin-right: 5%;

    }
    .panel_body_employee_data_value p b{
        display: block;
        width:50%;
        float: left;
    }

</style>
@endsection
@section('content')
    <!--BEGIN TITLE & BREADCRUMB PAGE-->
    <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
        <div class="page-header pull-left">
            <div class="page-title">Dashboard</div>
        </div>
        <ol class="breadcrumb page-breadcrumb pull-right">
            <li><i class="fa fa-home"></i>&nbsp;<a href="{{url('/')}}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
            <li class="hidden"><a href="#">Dashboard</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
            <li class="active">Dashboard</li>
        </ol>
        <div class="clearfix"></div>
    </div>
    <!--END TITLE & BREADCRUMB PAGE-->
    <div class="page-content">
        <div id="tab-general">
            <div id="sum_box" class="row mbl myAnimation">
                
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-sm-6 animated bounceInDown">
                            <div class="panel  db mbm my_panel my_panel_1">
                                <div class="panel-body ">
                                    <div class="col-sm-4 col-xs-4">
                                        <div class="icon_body">
                                            <i class="my_icon fa fa-list"></i>
                                        </div>
                                    </div>
                                    <div class="col-sm-8 col-xs-8">
                                        <div class="my_panel_right">
                                            <h5>{{sprintf('%03d',$dashboard['task'])}}</h5>
                                            <p>Pending Task</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 animated bounceInRight">
                            <div class="panel  db mbm my_panel my_panel_10">
                                <div class="panel-body ">
                                    <div class="col-sm-4 col-xs-4">
                                        <div class="icon_body">
                                            <i class="my_icon fa fa-briefcase"></i>
                                        </div>

                                    </div>
                                    <div class="col-sm-8 col-xs-8">
                                        <div class="my_panel_right">
                                            <h5>{{sprintf('%03d',$dashboard['projects'])}}</h5>
                                            <p>Project</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6 animated bounceInDown">
                            <div class="panel  db mbm my_panel my_panel_9">
                                <div class="panel-body ">
                                    <div class="col-sm-4 col-xs-4">
                                        <div class="icon_body">
                                            <i class="my_icon fa fa-bullhorn"></i>
                                        </div>

                                    </div>
                                    <div class="col-sm-8 col-xs-8">
                                        <div class="my_panel_right">
                                            <h5>{{sprintf('%03d',$dashboard['training'])}}</h5>
                                            <p>Training</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    
                        <div class="col-sm-6 animated bounceInDown">
                            <div class="panel  db mbm my_panel my_panel_6">
                                <div class="panel-body ">
                                    <div class="col-sm-4 col-xs-4">
                                        <div class="icon_body">
                                            <i class="my_icon fa fa-clock-o"></i>
                                        </div>
                                    </div>
                                    <div class="col-sm-8 col-xs-8">
                                        <div class="my_panel_right">
                                            <h5>{{sprintf('%03d',$dashboard['meeting'])}}</h5>
                                            <p>Upcoming Meetings</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="row">

                        <div class="col-sm-6 animated bounceInDown">
                            <div class="panel  db mbm my_panel my_panel_7_r">
                                <div class="panel-body ">
                                    <div class="col-sm-4 col-xs-4">
                                        <div class="icon_body">
                                            <i class="my_icon fa fa-gears"></i>
                                        </div>
                                    </div>
                                    <div class="col-sm-8 col-xs-8">
                                        <div class="my_panel_right">
                                            <h5>{{$attendace['working_days']}} </h5>
                                            <p>Working <?php if($attendace['present']>1){ echo "days";}else{ echo "day";} ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 animated bounceInDown">
                            <div class="panel  db mbm my_panel my_panel_4_r">
                                <div class="panel-body ">
                                    <div class="col-sm-4 col-xs-4">
                                        <div class="icon_body">
                                            <i class="my_icon fa fa-check"></i>
                                        </div>
                                    </div>
                                    <div class="col-sm-8 col-xs-8">
                                        <div class="my_panel_right">
                                            <h5>{{$attendace['present']}} <?php if($attendace['present']>1){ echo "days";}else{ echo "day";} ?></h5>
                                            <p>Present</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 animated bounceInDown">
                            <div class="panel  db mbm my_panel my_panel_3_r">
                                <div class="panel-body ">
                                    <div class="col-sm-4 col-xs-4">
                                        <div class="icon_body">
                                            <i class="my_icon fa fa-clock-o"></i>
                                        </div>
                                    </div>
                                    <div class="col-sm-8 col-xs-8">
                                        <div class="my_panel_right">
                                            <h5>0 <?php if(0>1){ echo "days";}else{ echo "day";} ?></h5>
                                            <p>Late</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 animated bounceInDown">
                            <div class="panel  db mbm my_panel my_panel_2_r">
                                <div class="panel-body ">
                                    <div class="col-sm-4 col-xs-4">
                                        <div class="icon_body">
                                            <i class="my_icon fa fa-ban"></i>
                                        </div>
                                    </div>
                                    <div class="col-sm-8 col-xs-8">
                                        <div class="my_panel_right">
                                            <h5>{{$attendace['working_days']-($attendace['present']+$attendace['leave'])}} <?php if($attendace['working_days']-($attendace['present']+$attendace['leave'])>1){ echo "days";}else{ echo "day";} ?></h5>
                                            <p>Absent</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="row mbl myAnimation">
                <div class="col-lg-3 col-md-3 animated bounceIn">
                    <div class="portlet box">
                        <div class="portlet-body">
                            <canvas id="presentAbsentStatistics" width="200px" height="205px"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 animated bounceIn">
                    <div class="portlet box">
                        <div class="portlet-body">
                            <canvas id="presentLateStatistics" width="200px" height="205px"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                        <div class="animated bounceInLeft">
                            <div class="employee_details_data panel">
                                <div class="row panel-body ">
                                    <div class="col-md-12 panel_body_employee_data_heading my_panel_16">
                                        <h1>Employee Details</h1>
                                    </div>
                                    <div class="col-md-12 panel_body_employee_data_value">
                                       <p> <span>Employee ID  </span> <b>:  {{$user->employeeId}}</b> </p>
                                        <p> <span>Full Name  </span> <b> : {{$user->emp_first_name}} {{$user->emp_lastName}}</b> </p>
                                        <p> <span>Branch  </span> <b> : {{$user->branch_name}}</b> </p>
                                        <p> <span>Email  </span> <b> :  {{$user->emp_email}}</b> </p>
                                        <p> <span>Department  </span> <b> :   {{$user->department_name}}  </b> </p>
                                        <p> <span>Designation  </span> <b> : {{$user->designation_name}} </b> </p>
                                        <p> <span>Current Address  </span> <b> :  {{$user->emp_current_address}}  </b> </p>
                                        <p> <span>Joining Date  </span> <b> :  {{date('d-M-Y', strtotime($user->emp_joining_date))}}  </b> </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
            </div>

        </div>
    </div>

@endsection
@section('extra_js')
{{ Html::script('corporate/js/Chart.js') }}
<script>
     var ctx1 = document.getElementById("presentAbsentStatistics").getContext('2d');
     var myChart1 = new Chart(ctx1, {
         type: 'doughnut',
         data: {
             labels: ["Present", "Leave", "Absent"],
                      legend: {
                          labels: {
                              fontColor: "white",
                              fontSize: 18
                          }
                    },
             datasets: [{
                 label: '# ',
                 data: [{{$attendace['present']}},{{$attendace['leave']}},{{$attendace['working_days']-($attendace['present']+$attendace['leave'])}} ],
                 backgroundColor: [
                     'rgb(46, 204, 113)',
                     'rgb(52, 152, 219)',
                     'rgb(211, 84, 0)'
                 ],
                 borderColor: [
                     'rgb(46, 204, 113)',
                     'rgb(52, 152, 219)',
                     'rgb(211, 84, 0)'

                 ],
                 borderWidth: 1
              }]
         },
         options: {
         }
     });


     var ctx2 = document.getElementById("presentLateStatistics").getContext('2d');
     var myChart2 = new Chart(ctx2, {
         type: 'doughnut',
         data: {
             labels: ["Present", "Late"],
                legend: {
                    labels: {
                        fontColor: "white",
                        fontSize: 18
                    }
                },
             datasets: [{
                 label: '# ',
                 data: [{{$attendace['present']}}, 0],
                 backgroundColor: [
                     'rgb(46, 204, 113)',
                     'rgb(243, 156, 18)'
                 ],
                 borderColor: [
                     'rgb(46, 204, 113)',
                     'rgb(243, 156, 18)'
                 ],
                 borderWidth: 1
              }]
         },
         options: {
         }
     });
</script>
@endsection
