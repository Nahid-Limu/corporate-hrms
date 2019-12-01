@extends('layout.master')
@section('title', 'Training List')
@section('content')
    <!--BEGIN TITLE & BREADCRUMB PAGE-->
    <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
        <div class="page-header pull-left">
            <div class="page-title">Training List</div>
        </div>
        <ol class="breadcrumb page-breadcrumb pull-right">
            <li><i class="fa fa-home"></i>&nbsp;<a href="{{url('/')}}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
            <li><a href="#">Training</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
            <li class="active">Training List</li>
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
                                        Training List
                                    </div>
                                </div>
                            </div>
                            <div class="panel-body table-responsive">
                                <table id="task" class="table table-striped table-bordered" >
                                    <thead>
                                    <tr>
                                        <th>SN</th>
                                        <th>Training</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th>Institution</th>
                                        <th>Attachment</th>
                                        <th>Duration</th>
                                        <th>Description</th>
                                        <th>Month</th>
                                        <th>Status</th>
                                        <th>Assigned By</th>
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

        $('#task').DataTable({
        processing: true,
        serverSide: true,
        "order": [[ 0, "desc" ]],
        ajax:{
        url: "{{ url('employee/panel/training/list') }}",
        },
        columns:[
        {
            data: 'DT_RowIndex',
            name: 'DT_RowIndex'
        },
        {
            data: 'training_name',
            name: 'training_name'
        },
        {
            data: 'training_start',
            name: 'training_start'
        },
        {
            data: 'training_end',
            name: 'training_end'
        },
        {
            data: 'training_institution',
            name: 'training_institution'
        },
        {
            data: 'training_attachment',
            name: 'training_attachment'
        },
        {
            data: 'duration',
            name: 'duration'
        },

        {
            data: 'description',
            name: 'description'
        },
        {
            data: 'training_month',
            name: 'training_month'
        },

        {
            data: 'assign_status',
            name: 'assign_status',
            render: function(data, type, full, meta){
                return data == '1' ? '<span style="color:green">Active</span>' : '<span style="color:red">InActive</span>'
            },
        },
        {
            data: 'assigned_by',
            name: 'assigned_by'
        },
        ]
        });

    });
    </script>
@endsection
