@extends('layout.master')
@section('title', 'Employee Wise Expense List')
@section('content')
    <!--BEGIN TITLE & BREADCRUMB PAGE-->
    <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
        <div class="page-header pull-left">
            <div class="page-title">Employee Wise Expense List</div>
        </div>
        <ol class="breadcrumb page-breadcrumb pull-right">
            <li><i class="fa fa-home"></i>&nbsp;<a href="{{url('/')}}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
            <li><a href="#">Employee Wise Expense List</a>&nbsp;&nbsp;</li>
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
                               Employee Wise Expense List
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <table id="Expanse_table" class="table table-striped table-bordered" >
                            <thead>
                            <tr>    
                                <th>SN</th>
                                <th>Employee Name</th>
                                <th>Employee ID</th>
                                <th>Branch</th>
                                <th>Expense Month</th>
                                <th>Amount</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                                @php $i=0; $totAmount=0; @endphp
                                @foreach($expanse_list as $el)
                                @php $totAmount+=$el->totAmount; @endphp
                                  <tr>
                                    <td>{{++$i}}</td>
                                    <td>{{$el->name}}</td>
                                    <td>{{$el->employeeId}}</td>
                                    <td>{{$el->branch_name}}</td>
                                    <td>{{date('F-Y', strtotime($el->expanse_date))}}</td>
                                    <td>@money($el->totAmount)</td>
                                    <td>
                                      <a href="{{route('expense.employee_wise_expanse_history_monthly_details',['created_by' =>base64_encode($el->created_by), 'expanse_date' => base64_encode($el->expanse_date)])}}"   title="View Expense Details" class="btn btn-primary btn-sm animated fadeIn"><i class="fa fa-eye"></i></a>
                                    </td>
                                  </tr>
                                  @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="4"></th>
                                    <th>Total</th>
                                    <th>@money($totAmount)</th>
                                    <th></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('extra_js')
@endsection





 
