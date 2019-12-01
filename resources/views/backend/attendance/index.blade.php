@extends('layout.master')
@section('title', 'Attendance Files')
@section('content')
    <!--BEGIN TITLE & BREADCRUMB PAGE-->
    <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
        <div class="page-header pull-left">
            <div class="page-title">Attendance</div>
        </div>
        <ol class="breadcrumb page-breadcrumb pull-right">
            <li><i class="fa fa-home"></i>&nbsp;<a href="{{url('/')}}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
            <li><a href="#">Attendance</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
            <li class="active">Attendance Files</li>
        </ol>
        <div class="clearfix"></div>
    </div>
    <!--END TITLE & BREADCRUMB PAGE-->

    <!--Flash Message Start-->
    @if(Session::has('success'))
        <p id="alert_message" class="alert alert-success">{{ Session::get('success') }}</p>
    @endif
    @if(Session::has('error'))
        <p id="alert_message" class="alert alert-error">{{ Session::get('error') }}</p>
    @endif
    @if(Session::has('delete'))
        <p id="alert_message" class="alert alert-danger">{{ Session::get('delete') }}</p>
    @endif
    <!--Flash Message End-->
    <div class="page-content">

        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-blue">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-md-6">
                                Attendance Files
                            </div>
{{--                            <div class="col-md-6" style="text-align: right;">--}}
{{--                                <a href="" class="add-new-modal btn btn-success btn-round btn-xs" data-toggle="modal" data-target="#createDepartment"> <i class="fa fa-plus"></i> Add New</a>--}}
{{--                            </div>--}}
                        </div>
                    </div>
                    <div class="panel-body table-responsive">
                        <table id="attendance_table" class="table table-striped table-bordered" >
                            <thead>
                            <tr>
                                <th width="5%">No.</th>
                                <th width="15%">Title</th>
                                <th width="15%">File Name</th>
                                <th width="10%">Description</th>
                                <th width="15%">Upload Time</th>
                                <th width="15%">Process Status</th>
                                <th width="15%">Process Time</th>
{{--                                <th width="12%">Actions</th>--}}
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
            $('#attendance_table').DataTable({
                processing: true,
                serverSide: true,
                "order": [[ 0, "desc" ]],
                ajax:{
                    url: "{{ route('attendance.index') }}",
                },
                columns:[
                    {
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'title',
                        name: 'title'
                    },
                    {
                        data: 'attendance_file',
                        name: 'attendance_file',
                        render: function (data, type, full, meta) {
                            return "<a href='../attendance_file/"+data+"'>"+data+"&nbsp;&nbsp;<i class='fa fa-download' aria-hidden='true'></i></a>"
                        }
                    },
                    // {
                    //     data: 'status',
                    //     name: 'status'
                    //     // render: function(data, type, full, meta){
                    //     //     return data == '1' ? '<span style="color:green">Active</span>' : '<span style="color:red">InActive</span>'
                    //     // },
                    // },

                    {
                        data: 'description',
                        name: 'description'
                    },
                    {
                        data: 'upload_date',
                        name: 'upload_date'
                    },
                    {
                        data: 'process_status',
                        name: 'process_status',
                        render: function(process_status, type, full, meta){
                            return process_status === '1' ? '<span style="color:green">Processed</span>' : '<span style="color:#f0ad4e">Pending</span>'
                        }
                    },
                    {
                        data: 'process_date',
                        name: 'process_date'

                    }
                    // {
                    //     data: 'action',
                    //     name: 'action',
                    //     orderable: false
                    // }
                ]
            });


        });
    </script>
@endsection