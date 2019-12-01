@extends('layout.master')
@section('title', 'File List')
@section('content')
    <!--BEGIN TITLE & BREADCRUMB PAGE-->
    <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
        <div class="page-header pull-left">
            <div class="page-title">File List</div>
        </div>
        <ol class="breadcrumb page-breadcrumb pull-right">
            <li><i class="fa fa-home"></i>&nbsp;<a href="{{url('/')}}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
            <li><a href="#">File</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
            <li class="active">File List</li>
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
                                        File List
                                    </div>
                                </div>
                            </div>
                            <div class="panel-body table-responsive">
                                <table id="task" class="table table-striped table-bordered" >
                                    <thead>
                                    <tr>
                                        <th>SN</th>
                                        <th>Attachment</th>
                                        <th>Shared By</th>
                                        <th>Shared To</th>
                                        <th>Shared Date</th>
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
        "order": [[ 4, "desc" ]],
        ajax:{
        url: "{{ url('employee/panel/file/share/list') }}",
        },
        columns:[
        {
            data: 'DT_RowIndex',
            name: 'DT_RowIndex'
        },
        {
            data: 'attachment',
            name: 'attachment'
        },
        {
            data: 'shared_by',
            name: 'shared_by'
        },
        {
            data: 'file_share_to',
            name: 'file_share_to'
        },
        {
            data: 'shared_date',
            name: 'shared_date'
        },
        ]
        });
    });
    </script>
@endsection
