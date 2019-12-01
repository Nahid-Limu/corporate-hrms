@extends('layout.master')
@section('title', 'Travel')
@section('content')

    <!--BEGIN TITLE & BREADCRUMB PAGE-->
    <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
        <div class="page-header pull-left">
            <div class="page-title">Travel</div>
        </div>
         
     
        <ol class="breadcrumb page-breadcrumb pull-right">
            <li><i class="fa fa-home"></i>&nbsp;<a href="{{url('/')}}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
            <li><a href="#">Travel</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
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
                <span id="form_error">
                    @if ($errors->any())
                        <div id="alert_message" class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </span>
            <div class="col-lg-12">
                <div class="panel panel-blue">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-md-6">
                              Travel
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <form class="form-group" method="post" action="{{route('save_festival_bonus')}}" novalidate>
                            @csrf
                            <div class="col-md-12" style="margin-bottom: 30px;">
                                <label for="title" class="pull-left"><h5>Title <span class='require'>*</span></h5></label>
                                <div>
                                    <input type="text" id="title" required class="form-control" name="title" placeholder="Enter Title" />
                                </div>
                            </div>
                            <br>
                            <div class="col-md-6" style="margin-bottom: 30px;">
                                <label for="start_date" class="pull-left"><h5>Start Date <span class='require'>*</span></h5></label>
                                <div>
                                    <input type="text" id="start_date"  required class="form-control" name="start_date" />
                                </div>
                            </div>
                            <div class="col-md-6" style="margin-bottom: 30px;">
                                <label for="end_date" class="pull-left"><h5>End Date <span class='require'>*</span></h5></label>
                                <div>
                                    <input type="text" id="end_date"  required class="form-control" name="month" />
                                </div>
                            </div>
                            <br>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="department_name">Select Branch</label>
                                    <select class="form-control" id="all_branch" name="all_branch">
                                        <option value="">Select</option>
                                        @foreach($branch_list as $branchs)
                                            <option value="{{$branchs->id}}">{{$branchs->branch_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="department_name">Select Designation</label>
                                    <select class="form-control" id="all_designation" name="all_designation">
                                        <option value="">Select Branch First</option>
                                    </select>
                                </div>
                            </div>
                              <div class="col-md-12">
                                  <table id="employee_tbl" class="table table-hover table-bordered table-responsive">
                                  </table>
                              </div>

                            <div class="col-md-12">
                             <button type="submit"  style="display: none" class="btn btn-success" id="festival_bonus_btn">Save Information</button>
                            </div>
                          </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('extra_js')
    <script>
        //branch wise designation ajax
        $("#all_branch").change(function(){
            var id = $("#all_branch").val();
            $.ajax({
                type: "GET",
                // url:"{{url('branch/designation')}}"+"/"+id,
                url:"{{url('branch/department_id')}}"+"/"+id,
                dataType:"json",
                success:function(response){
                      var designation = '';
                     designation+='<option value="">Select Designation</option>'
                    $.each(response, function (i, item) {
                        designation += '<option value="'+item.departments_id+'">'+item.department_name+'</option>';
                    });
                    $('#all_designation').html(designation);
                    $("#all_designation").select2({
                        placeholder: "Select Designation"
                    });
                },
                error:function(response){
                    console.log(response);
                }
            })
        });

        //designation wise employee ajax
        $("#all_designation").change(function(){
            $("#amount_div").show();
            $("#percent_div").show();
            $("#festival_bonus_btn").show();
            var id = $("#all_designation").val();
            $.ajax({
                type: "GET",
                url:"{{url('designation/employee')}}"+"/"+id,
                dataType:"json",
                success:function(response){
                    var employee = '';
                    employee+='<thead><tr><th>Employee Id</th><th>Employee</th><th>Check</th> </thead>'
                    $.each(response, function (i, item) {
                        employee += '<tbody><tr><td>'+item.employeeId+'</td><td>'+item.emp_first_name+'</td><td><input type="text" class="form-control amount"  name="emp_amount[]" placeholder="amount"></td><td><input type="text" class="form-control percent"  name="emp_percent[]" placeholder="percent"></td></tr><input type="hidden" name="emp_id[]" value="4"><input type="hidden" class="form-control" name="emp_gross[]" value=""></tbody>';
                    });
                    $('#employee_tbl').html(employee);
                },
                error:function(response){
                    console.log(response);
                }
            })
        });

        //amount field onchange
        $('#amount_value').keyup(function () {
            $("#production_button").show();
            $("#percent_div").hide();
            $(".percent").hide();
            $("#p_title").hide();
            $("#title_id").show();
            var input = document.getElementsByClassName("amount");
            for (var i = 0; i < input.length; i++){
                input[i].value = document.getElementById('amount_value').value;
            }
        });

        //percent field onchange
        $('#percent_val').keyup(function () {
            $("#percent_button").show();
            $("#amount_div").hide();
            $(".amount").hide();
            $("#amount_title").hide();
            $("#title_id").show();
            var input = document.getElementsByClassName("percent");
            for (var i = 0; i < input.length; i++){
                input[i].value = document.getElementById('percent_val').value;
            }
        });

      // Month select picker
        $("#all_branch").select2();
        $("#start_date").datepicker( {
            format: "dd-yyyy-mm",
          
        });
        $("#end_date").datepicker( {
            format: "dd-yyyy-mm",
         
        });
    </script>
@endsection
