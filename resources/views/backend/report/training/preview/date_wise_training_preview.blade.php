@extends('layout.master')
@section('content')
    <!--BEGIN TITLE & BREADCRUMB PAGE-->
    <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
        <div class="page-header pull-left">
            <div class="page-title">Date Wise Training Report</div>
        </div>
        <ol class="breadcrumb page-breadcrumb pull-right">
            <li><i class="fa fa-home"></i>&nbsp;<a href="{{url('/')}}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
            <li><a href="#"> Date Wise Training Report</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
            <li class="active">Date Wise Training Report</li>
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
                               Date Wise Training Report
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
                 <th>Name</th>
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
                    <td>{{$trainings->training_name}}</td>
                    <td>{{$trainings->branch_name}}</td>
                    <td>{{$trainings->duration}} days</td>
                    <td>{{date('F-d-Y',strtotime($trainings->training_start))}}</td>
                    <td>{{date('F-d-Y',strtotime($trainings->training_end))}}</td>
                    <td>{{$trainings->training_institution}}</td>
                    <td>{{date('F-d-Y',strtotime($trainings->training_month))}}</td>
                    <td>
                        @if($trainings->status==1) Active
                         @else Inactive
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








