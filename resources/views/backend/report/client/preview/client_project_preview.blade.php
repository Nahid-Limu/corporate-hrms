@extends('layout.master')
@section('content')
    <!--BEGIN TITLE & BREADCRUMB PAGE-->
    <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
        <div class="page-header pull-left">
            <div class="page-title">Branch Wise Client Project List</div>
        </div>
        <ol class="breadcrumb page-breadcrumb pull-right">
            <li><i class="fa fa-home"></i>&nbsp;<a href="{{url('/')}}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
            <li><a href="#"> Branch Wise Client Project List</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
            <li class="active">Branch Wise Client Project List</li>
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
                               Branch Wise Client Project List
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
                <th>Client</th>
                <th>Phone</th>
                <th>Email</th>
                <th>Address</th>
            </tr>
            </thead>
            @foreach($client_project as $project)
                <tr>
                    <td>{{$project->project_name}}</td>
                    <td>{{date('F-d-Y',strtotime($project->start_date))}}</td>
                    <td>{{date('F-d-Y',strtotime($project->end_date))}}</td>
                    <td>
                        @if(date('Y-m-d')>$project->end_date)
                          Deadline Over
                          @else
                          {{$project->days}} Days
                        @endif
                    </td>
                    <td>{{$project->client_name}}</td>
                    <td>{{$project->client_phone}}</td>
                    <td>{{$project->client_email}}</td>
                    <td>{{$project->client_address}}</td>
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








