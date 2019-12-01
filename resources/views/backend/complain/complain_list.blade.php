@extends('layout.master')
@section('title', 'Complain List')
@section('content')
    <!--BEGIN TITLE & BREADCRUMB PAGE-->
    <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
        <div class="page-header pull-left">
            <div class="page-title">Complain</div>
        </div>
        <ol class="breadcrumb page-breadcrumb pull-right">
            <li><i class="fa fa-home"></i>&nbsp;<a href="{{url('/')}}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
            <li><a href="#">Complain</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
            <li class="active">Complain List</li>
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
                                        Pending Complain List
                                    </div>
                                    <div class="col-md-6" style="text-align: right;">
                                    </div>
                                </div>
                            </div>
                            <div class="panel-body table-responsive">
                                <table id="complain_list" class="table table-striped table-bordered" >
                                    <thead>
                                    <tr>
                                        <th>SN</th>
                                        <th>Token Number</th>
                                        <th>Complain By</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                        <th>Action</th>
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
    
        $('#complain_list').DataTable({
        processing: true,
        serverSide: true,
        "order": [[ 1, "desc" ]],
        ajax:{
        url: "{{ route('complain.complain_list') }}",
        },
        columns:[
        { 
            data: 'DT_RowIndex', 
            name: 'DT_RowIndex' 
        },
        {
            data: 'com_token',
            name: 'com_token'
        },
        {
            data: 'employeeName',
            name: 'employeeName'
        },
        {
            data: 'status',
            name: 'status',
            render: function(data, type, full, meta){
                if(data=='0'){
                    return "<span style='color: blue;'>Pending</span>";
                }else if(data=='1'){
                    return "<span style='color: green;'>Solved</span>";
                }else if(data=='1'){
                    return "<span style='color: red;'>Rejected</span>";
                }
            },
        },
        {
            data: 'complain_date',
            name: 'complain_date',
        },        
        {
            data: 'action',
            name: 'action',
            orderable: false
        }
        ]
        });
    
    });
    </script>
@endsection