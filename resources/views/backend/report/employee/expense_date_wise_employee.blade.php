@extends('layout.master')
@section('content')
    <!--BEGIN TITLE & BREADCRUMB PAGE-->
    <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
        <div class="page-header pull-left">
            <div class="page-title"> Date Wise ExpenseReport</div>
        </div>
        <ol class="breadcrumb page-breadcrumb pull-right">
            <li><i class="fa fa-home"></i>&nbsp;<a href="{{url('/')}}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
            <li><a href="#"> Date Wise ExpenseReport</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
            <li class="active"> Date Wise ExpenseReport</li>
        </ol>
        <div class="clearfix"></div>
    </div>
    <!--END TITLE & BREADCRUMB PAGE-->
    <div class="page-content">
            <div class="row">
                <div class="col-lg-10 col-lg-offset-1">
                        <div class="panel panel-blue">
                            <div class="panel-heading ex-panel">
                                <div class="row">
                                    <div class="col-md-12">
                                            Date Wise ExpenseReport
                                    </div>
                                </div>
                            </div>
                            <div class="panel-body">
                          {!! Form::open(['method'=>'post','url'=>'employee_wise_expanse/report/date']) !!}
                                


                                <div class="col-md-10 col-md-offset-1 ex-form">
    
                                    <div class="form-group">
                                        <label for="datepicker" >Select Start Date</label>
                                        <input type="date" class="form-control "   name="startdate"  autocomplete="off" required >
                                        <b class="form-text text-danger pull-left" id="monthError"></b>
                                    </div>

                                </div>
                                <div class="col-md-10 col-md-offset-1 ex-form">
    
                                    <div class="form-group">
                                        <label for="datepicker" >Select End Date</label>
                                        <input type="date" class="form-control "    name="enddate" autocomplete="off"  required>
                                        <b class="form-text text-danger pull-left" id="monthError"></b>
                                    </div>

                                </div>
                                    
                                <div class="col-md-12 ex-form">
                                    <div class="form-group" style="text-align:center">
                                        <br> 
                                        <button id="add_vendor_btn" type="Submit" class="btn btn-success"><i class="fa fa-search"></i> Search</button>
                                        
                                    </div>
                                </div>
                              {!! Form::close() !!}
                          </div>
                      </div>
              
    </div>
@endsection
@section('extra_js')
    <script>
        
         $("#enddate").datepicker( {
            
           
        });
         $("#startdate").datepicker( {
            
           
        });
    </script>
@endsection

