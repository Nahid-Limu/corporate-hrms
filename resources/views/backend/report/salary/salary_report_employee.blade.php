@extends('layout.master')
@section('content')
    <!--BEGIN TITLE & BREADCRUMB PAGE-->
    <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
        <div class="page-header pull-left">
            <div class="page-title"> Month Wise Selary Payslip</div>
        </div>
        <ol class="breadcrumb page-breadcrumb pull-right">
            <li><i class="fa fa-home"></i>&nbsp;<a href="{{url('/')}}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
            <li><a href="#"> Month Wise Selary Payslip</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
            <li class="active"> Month Wise Selary Payslip</li>
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
                                            Month Wise Selary Payslip
                                    </div>
                                </div>
                            </div>
                            <div class="panel-body">
                          {!! Form::open(['method'=>'post','url'=>'report/pay_slip']) !!}
                              

                                  <div class="col-md-10 col-md-offset-1 ex-form">
                                        <div class="form-group">
                                            
                                                
                                            <div class="form-group">
                                                <label for="datepicker" >Select Month</label>
                                                <input type="text" class="form-control "  id="salary_month" name="salary_month" autocomplete="off" readonly >
                                                <b class="form-text text-danger pull-left" id="monthError"></b>
                                            </div>
                            
                                                </div>
                                            </div>
                                                <div class="col-md-10 col-md-offset-1 ex-form">
                                            <div class="form-group">
                                            <div class="input-form-gap"></div>
                                            <label for="branch_id" class="">Select Branch<span class="clon"></span></label>
                                            <div class="">
                                                <select name="all_branch" id="all_branch"  class="select2-container form-control" required>
                                                    <option value="">Select Branch</option>
                                                    @foreach($branch as  $branchs)
                                                    <option value="{{ $branchs->id}}">{{$branchs->branch_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                                <br>
                                            <div class="form-group">
                                                <label for="department_name">Select Department</label>
                                                <select class="form-control" id="all_department" name="all_department" required>
                                                    <option value="">Select Branch First</option>
                                                </select>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label for="employee_name">Select Employee</label>
                                                <select class="form-control" id="all_employee" name="all_employee_id" required>
                                                    <option value="">Select Department First</option>
                                                </select>
                                            </div>
                                       </div>
                                  </div>

                                         


                                      
                                     
                                    <div class="col-md-12 ex-form">
                                    <div class="form-group" style="text-align:center">
                                            
                                            <br>
                                            <button type="submit" name="pdf" value="pdf" class="btn btn-success">
                                                <i class="fa fa-download"></i> Generate PDF</button>
                                       
                                    </div>
                                </div>
                              {!! Form::close() !!}
                          </div>
                      </div>
                </div>
            </div>
    </div>
@endsection
@section('extra_js')
    <script>
        $("#branch_id").select2({
            placeholder: "Select Branch"
        });
        $("#project_priorityhigh_id").select2({
            placeholder: "Select Project"
        });
        $('#start_date').datetimepicker({
            pickTime: false
            
        });
            $('#month_date').datetimepicker({
            pickTime: false
                 //$( "#datepicker" ).datepicker({dateFormat: 'yy'});
        });


         $("#all_branch").change(function(){
            var id = $("#all_branch").val();
            $.ajax({
                type: "GET",
                url:"{{url('/branch/department')}}"+"/"+id,
                dataType:"json",
                success:function(response){
                      var designation = '';
                     designation+='<option value="">Select Designation</option>'
                    $.each(response, function (i, item) {
                        designation += '<option value="'+item.department_id+'">'+item.department_name+'</option>';
                    });
                    $('#all_department').html(designation);
                    $("#all_department").select2({
                        placeholder: "Select Department"
                    });
                },
                error:function(response){
                    console.log(response);
                }
            })
        });


         $("#all_department").change(function(){
            var id = $("#all_department").val();
            $.ajax({
                type: "GET",
                url:"{{url('/department/employee')}}"+"/"+id,
                dataType:"json",
                success:function(response){
                      var designation = '';
                     designation+='<option value="">Select Designation</option>'
                    $.each(response, function (i, item) {
                        designation += '<option value="'+item.emp_id+'">'+item.emp_first_name+'</option>';
                    });
                    $('#all_employee').html(designation);
                    $("#all_employee").select2({
                        placeholder: "Select Employee"
                    });
                },
                error:function(response){
                    console.log(response);
                }
            })
        });


        
         $("#salary_month").datepicker( {
            format: "yyyy-mm",
            viewMode: "months", 
            minViewMode: "months"
        });
    </script>
@endsection

