@extends('layout.master')
@section('title', 'Announcement')
@section('content')
    <!--BEGIN TITLE & BREADCRUMB PAGE-->
    <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
        <div class="page-header pull-left">
            <div class="page-title">Announcement</div>
        </div>
        <ol class="breadcrumb page-breadcrumb pull-right">
            <li><i class="fa fa-home"></i>&nbsp;<a href="{{url('/')}}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
            <li><a href="#">Announcement</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
            <li class="active">Announcement</li>
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
                                Announcement
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                        <table id="employee" class="table table-striped table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>Announcement</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Description</th>
                            </tr>
                            </thead>
                            <tbody>
                                        <tr>
                                           <td>{{$announcement_details->announcement_title}}</td>
                                            <td>{{date('F-d-Y',strtotime($announcement_details->start_date))}}</td>
                                            <td>{{date('F-d-Y',strtotime($announcement_details->end_date))}}</td>
                                            <td>{{$announcement_details->description}}</td>
                                        </tr>
                            </tbody>
                        </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
