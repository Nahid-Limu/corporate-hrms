@extends('layout.master')
@section('content')
    <!--BEGIN TITLE & BREADCRUMB PAGE-->
    <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
        <div class="page-header pull-left">
            <div class="page-title">Date Wise Project List</div>
        </div>
        <ol class="breadcrumb page-breadcrumb pull-right">
            <li><i class="fa fa-home"></i>&nbsp;<a href="{{url('/')}}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
            <li><a href="#"> Date Wise Project List</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
            <li class="active">Date Wise Project List</li>
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
                                    Date Wise Project List
                            </div>
                        </div>
                    </div>
                    {{--  <div class="panel-body">
                        <div class="col-md-12">

                        </div>
                    </div>  --}}
                </div>
            </div>
        </div>
        <table id="designation_employee" class="table table-striped table-bordered">
            <thead>
                    <tr>
                            <th>Project Name</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Deadline</th>
                            <th>Action</th>
                          </tr>
                </thead>
            @foreach($project as $projects)
                 <tr>
                          <td>{{$projects->project_name}}</td>
                            <td>{{date('F-d-Y',strtotime($projects->start_date))}}</td>
                            <td>{{date('F-d-Y',strtotime($projects->end_date))}}</td>
                            <td>{{$projects->days}} Days</td>
                            <td><a title="View Details" href="{{url('report/project/details/profile/'.$projects->project_id)}}"><button class="btn btn-success btn-xs"><i class="fa fa-eye"></i></button></a></td>
                          </tr>
            @endforeach
        </table>
    </div>
@endsection
@section('extra_js')
    <script>
        $('#designation_employee').DataTable({
            responsive: true,
        });
    </script>
@endsection








