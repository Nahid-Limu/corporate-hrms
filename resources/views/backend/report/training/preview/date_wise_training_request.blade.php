@extends('layout.master')
@section('content')
    <!--BEGIN TITLE & BREADCRUMB PAGE-->
    <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
        <div class="page-header pull-left">
            <div class="page-title">    Employee Training Request</div>
        </div>
        <ol class="breadcrumb page-breadcrumb pull-right">
            <li><i class="fa fa-home"></i>&nbsp;<a href="{{url('/')}}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
            <li><a href="#">     Employee Training Request</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
            <li class="active">Employee Training Request</li>
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
                               Employee Training Request
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
                 <th>Employee Id</th>
                 <th>Employee</th>
                 <th>Training</th>
                 <th>Branch</th>
                 <th>Duration</th>
                 <th>Start Date</th>
                 <th>End Date</th>
                 <th>Institution</th>
                 <th>Month</th>
                 <th>Status</th>
            </tr>
            </thead>
            @foreach($training as $trainings)
                <tr>
                    <td>{{$trainings->employeeId}}</td>
                    <td>{{$trainings->emp_first_name}} {{$trainings->emp_lastName}}</td>
                    <td>{{$trainings->training_name}}</td>
                    <td>{{$trainings->branch_name}}</td>
                    <td>{{$trainings->duration}} days</td>
                    <td>{{date('F-d-Y',strtotime($trainings->training_start))}}</td>
                    <td>{{date('F-d-Y',strtotime($trainings->training_end))}}</td>
                    <td>{{$trainings->training_institution}}</td>
                    <td>{{date('F-d-Y',strtotime($trainings->training_month))}}</td>
                    <td>
                        @if($trainings->request_status==1) Approved
                         @else Calcel
                         @endif
                        </td>
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








