@extends('layout.master')
@section('title', 'Client Details')
@section('extra_css')
<style>
    .team_profile{
        box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
        transition: 0.3s;
        border-radius: 3px;
        cursor: pointer;
        margin-bottom: 20px;
    }
    .team_profile:hover {
        box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2);
    }
    .team_profile:hover .team_profile_img_overlay{
        opacity: 1;
        cursor: pointer;
    }
    .team_profile_img{
        height:200px;
        width: 100%;
        position: relative;
    }
    .team_profile_img_overlay{
        position: absolute;
        width: 100%;
        height: 100%;

        top: 0;
        left: 0;
        opacity:0;
        webkit-transition: all 0.3s ease-in-out;
        -moz-transition: all 0.3s ease-in-out;
        -ms-transition: all 0.3s ease-in-out;
        -o-transition: all 0.3s ease-in-out;
        transition: all 0.3s ease-in-out;
        background: -webkit-linear-gradient(left, rgba(56,107,12,.6) 0%, rgba(133,153,115,.6) 100%);
        background: linear-gradient(to right, rgba(56,107,12,.6) 0%, rgba(133,153,115,.6) 100%);
        box-shadow: 0 5px 10px 0 rgba(56,107,12, 0.5)!important;
    }
    .team_profile_img_overlay i{
        color:#fff;
        position: relative;
        top:50%;
        left:50%;
        transform: translate(-50%,-50%);
        font-size: 20px;
    }

    .team_profile img {
        border-radius: 3px 3px 0 0;
        height: 100%;
        width: 100%;
    }

    .team_profile .profile_container {
        padding: 2px 16px;
        text-align: center;
        padding-top: 20px;
        padding-bottom: 20px;
    }
    .profile_container h4{
        margin-top: 5px;
        margin-bottom: 5px;
    }
    .profile_container p{
        margin-bottom: 5px;
        font-size: 13px;
    }
    .client_project_details .profile_container{
        text-align: left;
        padding-bottom: 10px;
    }
    .client_project_details{
        padding-bottom: 10px;
    }
    .client_project_btn{
        margin-left: 10px;
    }

</style>
@endsection


@section('content')
<!--BEGIN TITLE & BREADCRUMB PAGE-->
<div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
    <div class="page-header pull-left">
        <div class="page-title">Client Project</div>
    </div>
    <ol class="breadcrumb page-breadcrumb pull-right">
        <li><i class="fa fa-home"></i>&nbsp;<a href="{{url('/')}}">Home</a>&nbsp;&nbsp;<i
                class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
        <li><a href="#">Client</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
        <li class="active">Client Project</li>
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
                            <i class="fa fa-tasks" style="font-size: 20px;"></i>
                            Client Details
                        </div>
                        <div class="col-md-6" style="text-align: right;">
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    <table class="table table-bordered table-hover table-striped" style="margin-top:20px;">
                        <thead >
                          <tr>
                            <th>Branch</th>
                            <th>Client</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Address</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                           <td>{{$client_details->branch_name}}</td>
                            <td>{{$client_details->client_name}}</td>
                            <td>{{$client_details->client_email}}</td>
                            <td>{{$client_details->client_phone}}</td>
                            <td>{{$client_details->client_address}}</td>
                          </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>





    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-blue">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-md-12">
                            <i class="fa fa-tasks" style="font-size: 20px;"></i>
                            Project List
                        </div>

                    </div>
                </div>
                <div class="panel-body">
                  @foreach($client_project_list as  $project_list)
                    <div class="col-md-3">
                        <div class="team_profile client_project_details">

                            <div class="profile_container">
                            <h4><b>{{$project_list->project_name}}</b></h4>
                                <p>Start Date:<b>{{date('F-d-Y',strtotime($project_list->start_date))}}</b></p>
                                <p>End Date:<b>{{date('F-d-Y',strtotime($project_list->end_date))}}</b></p>
                                <p>Price:<b>{{$project_list->price}}</b></p>
                                <p>Priority:<b>@if($project_list->priority==1) <span style="color:red">High</span> @else <span style="color:orange">Low</span>  @endif</b></p>
                                <p>Deadline:<b>{{$project_list->days}} Days</b></p>
                                <p>Status:<b>@if($project_list->status==0)
                                    Pending
                                    @elseif($project_list->status==1)
                                    Approve
                                    @elseif($project_list->status==2)
                                    Running
                                    @elseif($project_list->status==3)
                                    Completed
                                    @elseif($project_list->status==4)
                                    Delivered
                                    @elseif($project_list->status==5)
                                    Rejected
                                    @else
                                    Cancel
                                  @endif
                                </b>
                            </p>
                            </div>

                            @if($project_list->attachment=='')
                                <h1 style="color:red">No Attachment</h1>
                            @else
                                <a target="_blank" href="{{asset('project_attachment/'.$project_list->attachment)}}"  class="btn btn-success btn-sm client_project_btn"><i class="fa fa-download"> </i> Attachment</a>
                            @endif
                        </div>
                    </div>
                  @endforeach
                </div>
            </div>
        </div>
    </div>













</div>
@endsection
