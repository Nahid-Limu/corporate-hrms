@extends('layout.master')
@section('title', 'Assigin Salary')
@section('extra_css')
    <style>
        .form-group{
            padding: 30px;
            margin-bottom: 30px;
         }
         .form-control.select2Style{
            background-color: white;
            border: 1px solid #aaa;
            border-radius: 4px !important;
            cursor: text;
         }
         
         #leave_starting_date{
            background-color: white;
            border: 1px solid #aaa;
            border-radius: 4px !important;
            cursor: text;
         }
         #leave_ending_date{
            background-color: white;
            border: 1px solid #aaa;
            border-radius: 4px !important;
            cursor: text;
         }
         #attachment{
            background-color: white;
            border: 1px solid #aaa;
            border-radius: 4px !important;
            cursor: text;
         }
    </style>
@endsection
@section('content')
    <!--BEGIN TITLE & BREADCRUMB PAGE-->
    <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
        <div class="page-header pull-left">
            <div class="page-title">Salary</div>
        </div>
        <ol class="breadcrumb page-breadcrumb pull-right">
            <li><i class="fa fa-home"></i>&nbsp;<a href="{{url('/')}}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
            <li><a href="#">Salary</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
            <li class="active">Assign Salary</li>
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
    @if(Session::has('devare'))
        <p id="alert_message" class="alert alert-danger">{{ Session::get('devare') }}</p>
    @endif
    <!--Flash Message End-->
    <div class="page-content">
            <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-blue">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-md-6">
                                        <i class="fa fa-money" style="font-size: 20px;"></i> 
                                        Assign Salary
                                    </div>
                                    <div class="col-md-6" style="text-align: right;">
                                        {{--  <a href="" class="add-new-modal btn btn-success btn-square btn-xs" data-toggle="modal" data-target="#createTask"> <i class="fa fa-plus"></i> Add New</a>  --}}
                                    </div>
                                </div>
                            </div>
                            <div class="panel-body">
                                <form id="assign_salary_form">
                                    @csrf
                                <div class="form-group">
                                    <div class="col-md-4">
                                        <label for="branch_id" class="pull-left"><h5>Select Branch<span class='require'>*</span></h5></label>
                                        <div>
                                            <select id="branch_id" name="branch_id"  class="form-control">
                                                <option value="">Select Branch</option>

                                                
                                            </select>
                                            <b class="form-text text-danger pull-left" id="studentError"></b>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="employee_id" class="pull-left"><h5>Select Employee<span class='require'>*</span></h5></label>
                                        <div>
                                            <select id="employee_id" name="employee_id"  class="form-control">
                                                <option value="">Select Employee</option>
                                                
                                            </select>
                                            <b class="form-text text-danger pull-left" id="studentError"></b>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="salary_grade_id" class="pull-left"><h5>Select Salary Grade<span class='require'>*</span></h5></label>
                                        <div>
                                            <select id="salary_grade_id" name="salary_grade_id"  class="form-control">
                                                <option value="">Select Employee First</option>
                                                
                                            </select>
                                            <b class="form-text text-danger pull-left" id="classError"></b>
                                        </div>
                                    </div>
                                    
                                    
                                </div>
                                <div class="form-group grade_info">
                                    <div class="raw">
                                        <div class="col-md-4">
                                            <label for="basic" class="pull-left"><h5>Basic</h5></label>
                                            <div>
                                                <input class="form-control select2Style" type="number" name="basic" id="basic" >
                                                
                                            </div>
                                            <b class="form-text text-danger pull-left" id="basicError"></b>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="house" class="pull-left"><h5>House</h5></label>
                                            <div>
                                                <input class="form-control select2Style" type="number" name="house" id="house" >
                                                <b class="form-text text-danger pull-left" id="houseError"></b>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="medical" class="pull-left"><h5>Medical</h5></label>
                                            <div>
                                                <input class="form-control select2Style" type="number" name="medical" id="medical" >
                                                <b class="form-text text-danger pull-left" id="medicalError"></b>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="raw">
                                        <div class="col-md-4">
                                            <label for="transportation" class="pull-left"><h5>Transportation</h5></label>
                                            <div>
                                                <input class="form-control select2Style" type="number" name="transportation" id="transportation" >
                                                <b class="form-text text-danger pull-left" id="transportationError"></b>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="food" class="pull-left"><h5>Food</h5></label>
                                            <div>
                                                <input class="form-control select2Style" type="number" name="food" id="food" >
                                                <b class="form-text text-danger pull-left" id="foodError"></b>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="other" class="pull-left"><h5>Other</h5></label>
                                            <div>
                                                <input class="form-control select2Style" type="number" name="other" id="other" >
                                                <b class="form-text text-danger pull-left" id="otherError"></b>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="raw">
                                        <div class="col-md-4">
                                            <label for="provident_fund_percent" class="pull-left"><h5>Provident Fund Percent</h5></label>
                                            <div>
                                                <input class="form-control select2Style" type="number" name="provident_fund_percent" id="provident_fund_percent" value="10">
                                                <b class="form-text text-danger pull-left" id="otherError"></b>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <div class="col-md-12"  style="margin-top: 10px;">
                                        <button type="button" id="assign_btn" class="btn btn-md btn-round btn-success pull-left" style=""><i class="fa fa-check"></i> Assign Salary</button>
                                    </div>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                        <div class="col-lg-12">
                            <div class="panel panel-blue">
                                <div class="panel-heading">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <i class="fa fa-list" style="font-size: 20px;"></i>
                                            Assigned Salary List
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-body table-responsive">
                                    <table id="assigned_salary" class="table table-striped table-bordered" >
                                        <thead>
                                        <tr>
                                            {{--  <th>#No</th>  --}}
                                            <th>Name</th>
                                            <th>Grade</th>
                                            <th>Basic</th>
                                            <th>House</th>
                                            <th>Medical</th>
                                            <th>Transport</th>
                                            <th>Food</th>
                                            <th>Other</th>
                                            <th>Total</th>
                                            <th>Provident Percent</th>
                                            <th>Provident Amount</th>
                                            <th>Net Salary</th>
                                        </tr>
                                        </thead>
                                    </table>
                                    
                                    <h3 class="text-center text-danger" id="errorMssg"></h3>
                                </div>
                            </div>
                        </div>
                    </div>
                
    <!-- Modal Start -->
    @include('backend.task.modal.create')
    @include('backend.task.modal.edit')
    <!-- Modal End -->
    </div>
@endsection

@section('extra_js')

<script>
    $(document).ready(function(){
        //get branch start
        $.ajax({
            url:"{{route('ajax.get_branch')}}",
            method:"get",
            success:function (response) {
                //console.log(response);
                $('#branch_id').html(response);
                $('.grade_info').hide();
                $("#assign_btn").prop('disabled', true);
                
            }
        });
        //get branch end
    
        //get employee start
        $('#branch_id').on('change',function () {
            var id = $("#branch_id").val();
            //alert(id);
            $.ajax({
                type: "GET",
                url:"{{url('/ajax/get_employee')}}"+"/"+id,
                success:function (response) {
                    //console.log(response);
                    $('#employee_id').html(response);
                    $("#employee_id").select2({
                        placeholder: "Select Employee"
                    });
                }
            });
        });
        //get employee end

        //get salary grade start
        $('#employee_id').on('change',function () {
            //var id = $("#employee_id").val();
            //alert(id);
            $.ajax({
                type: "GET",
                url:"{{route('ajax.get_grade')}}",
                success:function (response) {
                    //console.log(response);
                    $('#salary_grade_id').html(response);
                    $("#salary_grade_id").select2({
                        placeholder: "Select Grade"
                    });
                }
            });

            //lode employee salary details
            var id = $("#employee_id").val();
            $.ajax({
                method:"get",
                url:"{{url('/salary/assigned/details/')}}"+"/"+id,
                success:function (response) {
                    if(response.error)
                    {
                        var assigned_salary = $('#assigned_salary').DataTable();
                        assigned_salary.clear().draw();
                        $('#errorMssg').show();
                        $('#errorMssg').html(response.error);
                    }
                    if(response.success)
                    {
                        $('#errorMssg').hide();

                        var assigned_salary = $('#assigned_salary').DataTable();
                        assigned_salary.clear();

                        //var no = 1;
                        $.each(response.success,function(i, data){
                            //console.log(data);
                                assigned_salary.row.add([
                                    //no++,
                                    data.emp_name,
                                    data.grade_name,
                                    data.basic_salary,
                                    data.house_rant,
                                    data.medical,
                                    data.transport,
                                    data.food,
                                    data.other,
                                    data.total_salary,
                                    data.provident_fund_percent + ' %',
                                    data.provident_fund_amount,
                                    data.net_salary,
                                ]).draw(true);
                        })
                    }
                    
                }
            });
            //lode assigned task list end
            
        });
        //get salary grade end


        //lode grade details on change grade start
        $('#salary_grade_id').on('change',function () {
            var g_id = $("#salary_grade_id").val();
            $('.grade_info').show();
            $("#assign_btn").prop('disabled', false);
            $.ajax({
                type: "GET",
                url:"{{url('/salary_grade')}}"+"/"+g_id,
                success:function (response) {
                    //console.log(response);
                    $('#basic').val(response.basic);
                    $('#house').val(response.house);
                    $('#medical').val(response.medical);
                    $('#transportation').val(response.transportation);
                    $('#food').val(response.food);
                    $('#other').val(response.other);
                }
            });
            
        });
        //lode grade details on change grade end


        //start assign salary
         $( "#assign_btn" ).click(function() {
           
            if( $("#basic").val() <= 0 ){
                $("#basic").css('border-color', '#a94442');
                alert('Negative value cannot be accepted');
                //$("#basicError").html('* Remove Negative Value');
                return false;
            }
            else if( $("#house").val() < 0 ){
                $("#house").css('border-color', '#a94442');
                alert('Negative value cannot be accepted');
                //$("#houseError").html('* Remove Negative Value');
                return false;
            }
            else if( $("#medical").val() < 0 ){
                $("#medical").css('border-color', '#a94442');
                alert('Negative value cannot be accepted');
                //$("#medicalError").html('* Remove Negative Value');
                return false;
            }
            else if( $("#transportation").val() < 0 ){
                $("#transportation").css('border-color', '#a94442');
                alert('Negative value cannot be accepted');
                //$("#transportationError").html('* Remove Negative Value');
                return false;
            }
            else if( $("#food").val() < 0 ){
                $("#food").css('border-color', '#a94442');
                alert('Negative value cannot be accepted');
                //$("#foodError").html('* Remove Negative Value');
                return false;
            }
            else if( $("#other").val() < 0 ){
                $("#other").css('border-color', '#a94442');
                alert('Negative value cannot be accepted');
                //$("#otherError").html('* Remove Negative Value');
                return false;
            }
            else{
                $("#basic").css('border-color', '#32CD32');
                $("#house").css('border-color', '#32CD32');
                $("#medical").css('border-color', '#32CD32');
                $("#transportation").css('border-color', '#32CD32');
                $("#food").css('border-color', '#32CD32');
                $("#other").css('border-color', '#32CD32')

                var _token = '{{ csrf_token() }}';
                var salaryFormData = $('#assign_salary_form').serialize();
                //alert(_token);
                    $.ajax({
                        url:"{{route('salary_assign')}}",
                        method:"post",
                        data: salaryFormData,
                        success:function (response) {
                            //console.log(response);
                            if(response.success){
                                swal(response.success, "", "success");
                                $('.grade_info').hide();
                                $("#assign_btn").prop('disabled', true);
                                $("#employee_id").select2('val', '');
                                $("#employee_id").html('');
                                $("#salary_grade_id").select2('val', '');
                                $("#salary_grade_id").html('');
                                $('#assign_salary_form')[0].reset();
                            }
                            
                        }
                    });
            }
            
        }); 
        //end assign salary
        
        $("#branch_id").select2({
            placeholder: "Select Branch"
        });
        $("#employee_id").select2({
            placeholder: "Select Branch First"
        });
        $("#salary_grade_id").select2({
            placeholder: "Select Employee First"
        });

    });
    </script>
@endsection