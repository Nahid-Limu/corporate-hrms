@extends('layout.master')
@section('title', 'Meeting List')
@section('content')
    <!--BEGIN TITLE & BREADCRUMB PAGE-->
    <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
        <div class="page-header pull-left">
            <div class="page-title">Meeting List</div>
        </div>
        <ol class="breadcrumb page-breadcrumb pull-right">
            <li><i class="fa fa-home"></i>&nbsp;<a href="{{url('/')}}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
            <li><a href="#">Meeting</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
            <li class="active">Meeting List</li>
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
                                        Meeting List
                                    </div>
                                </div>
                            </div>
                            <div class="panel-body table-responsive">
                                <table id="meeting" class="table table-striped table-bordered" >
                                    <thead>
                                    <tr>
                                        <th>SN</th>
                                        <th>Meeting Subject</th>
                                        <th>Start Time</th>
                                        <th>End Time</th>
                                        <th>Venue</th>
                                        <th>Description</th>
                                        <th>Meeting Date</th>
                                    </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
    </div>
@endsection

@section('extra_js')
<script>
    $(document).ready(function(){

        $('#meeting').DataTable({
        processing: true,
        serverSide: true,
        "order": [[ 0, "desc" ]],
        ajax:{
        url: "{{ url('employee/panel/meeting/list') }}",
        },
        columns:[
        {
            data: 'DT_RowIndex',
            name: 'DT_RowIndex'
        },
        {
            data: 'meeting_subject',
            name: 'meeting_subject'
        },
        {
            data: 'start_time',
            name: 'start_time'
        },
        {
            data: 'end_time',
            name: 'end_time'
        },
        {
            data: 'venue',
            name: 'venue'
        },
        {
            data: 'description',
            name: 'description'
        },
        {
            data: 'meeting_date',
            name: 'meeting_date'
        },
        ]
        });

    });
    </script>
@endsection
