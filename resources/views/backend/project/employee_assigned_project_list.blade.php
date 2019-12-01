@extends('layout.master')
@section('content')
    <!--BEGIN TITLE & BREADCRUMB PAGE-->
    <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
        <div class="page-header pull-left">
            <div class="page-title">Project</div>
        </div>
        <ol class="breadcrumb page-breadcrumb pull-right">
            <li><i class="fa fa-home"></i>&nbsp;<a href="{{url('/')}}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
            <li><a href="#">Project</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
            <li class="active">Assign Project List</li>
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
    <!--Flash Message End-->
    <div class="page-content">

        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-blue">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-md-6">
                                    Assign Project List
                            </div>
                        </div>
                    </div>
                    <div class="panel-body table-responsive">
                        <table id="project_table" class="table table-striped table-bordered" >
                            <thead>
                            <tr>
                                <th>SN</th>
                                <th>Project</th>
                                <th>Attachment</th>
                                <th>Price</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Deadline</th>
                                <th>Priority</th>
                                <th>Status</th>
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
            //Clients List
            $('#project_table').DataTable({
                processing: true,
                serverSide: true,
                "order": [[ 5, "desc" ]],
                ajax:{
                    url: "{{ url('employee/assign/project/list') }}",
                },
                columns:[
                    {
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                    },
                    {
                        data: 'project_name',
                        name: 'project_name'
                    },
                    {
                        data: 'attachment',
                        name: 'attachment'
                    },
                    {
                        data: 'price',
                        name: 'price'
                    },
                    {
                        data: 'start_date',
                        name: 'start_date'
                    },
                    {
                        data: 'end_date',
                        name: 'end_date'
                    },

                    {
                        data: 'days',
                        name: 'days'
                    },

                    {
                        data: 'priority',
                        name: 'priority',
                        render: function(data, type, full, meta){
                            return data == '1' ? '<span style="color:red">High</span>' : '<span style="color:orange">Low</span>'
                        },
                    },
                    {
                        data: 'project_status',
                        name: 'project_status',
                        render: function(data, type, full, meta){
                            if(data==0){
                                return '<span style="color:green">Pending</span>'
                            }else if(data==1){
                                return '<span style="color:green">Approved</span>'
                            }
                            else if(data==2){
                                return '<span style="color:green">Running</span>'
                            }
                            else if(data==3){
                                return '<span style="color:green">Completed</span>'
                            }
                            else if(data==4){
                                return '<span style="color:green">Delivered</span>'
                            }
                            else if(data==5){
                                return '<span style="color:green">Rejected</span>'
                            }
                            else{
                                return '<span style="color:green">Cancel</span>'
                            }
                        },
                    },

                    {
                    data: 'action_btn',
                    name: 'action_btn',
                    orderable: false
                   }
                ]
            });
        });
    </script>
@endsection
