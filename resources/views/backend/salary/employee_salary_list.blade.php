@extends('layout.master')
@section('title', 'Employee Salaray List')
@section('content')
    <!--BEGIN TITLE & BREADCRUMB PAGE-->
    <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
        <div class="page-header pull-left">
            <div class="page-title">Salary List</div>
        </div>
        <ol class="breadcrumb page-breadcrumb pull-right">
            <li><i class="fa fa-home"></i>&nbsp;<a href="{{url('/')}}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
            <li><a href="#">Salaray</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
            <li class="active">Employee Total Gross</li>
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
                                        <i class="fa fa-list" style="font-size: 20px;"></i>
                                        EMPLOYEE TOTAL GROSS
                                    </div>
                                    <div class="col-md-6" style="text-align: right;">
                                        <a href="{{route('salary_assign_view')}}" class=" btn btn-success btn-round btn-sm"> <i class="fa fa-plus"></i>Assigin Salary</a>
                                    </div>
                                </div>
                            </div>
                            <div class="panel-body table-responsive">
                                <table id="emp_salary_table" class="table table-responsive table-striped" >
                                    <thead>
                                    <tr>
                                        <th>EMPID</th>
                                        <th>EMPLOYEE</th>
                                        <th>GRADE</th>
                                        <th>BASIC</th>
                                        <th>TOTAL</th>
                                        <th>PROVIDENT PERCENT</th>
                                        <th>PROVIDENT AMOUNT</th>
                                        <th>GROSS</th>
                                        <th>ACTION</th>
                                    </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
    <!-- Modal Start -->
    @include('backend.salary.modal.view')
    @include('backend.salary.modal.edit')
    <!-- Modal End -->
    </div>
@endsection

@section('extra_js')
<script>
    $(document).ready(function(){
    
        $('#emp_salary_table').DataTable({
        processing: true,
        serverSide: true,
        "order": [[ 0, "desc" ]],
        ajax:{
        url: "{{ route('emp_salary_list') }}",
        },
        columns:[
        {
            data: 'employeeId',
            name: 'employeeId'
        },
        {
            data: 'emp_name',
            name: 'emp_name'
        },
        
        {
            data: 'grade_name',
            name: 'grade_name'
        },
        {
            data: 'basic_salary',
            name: 'basic_salary'
        },
        {
            data: 'total_salary',
            name: 'total_salary'
        },
        {
            data: 'provident_fund_percent',
            name: 'provident_fund_percent'
        },
        {
            data: 'provident_fund_amount',
            name: 'provident_fund_amount'
        },
        {
            data: 'net_salary',
            name: 'net_salary'
        },
        {
            data: 'action',
            name: 'action',
            orderable: false
        }
        ]
        });


        //view Salary
        $(document).on('click', '.view', function(){
            var id = $(this).attr('id');
            //alert(id);
            //$('#form_result').html('');
            $.ajax({
             type: "GET",
             url:"{{url('/employee/salary/details')}}"+"/"+id,
             dataType:"json",
             success:function(response){
                 console.log(response);
                 $('#emp_name').html(response.emp_name);
                 $('#employeeId').val(response.employeeId);
                 $('#grade_name').val(response.grade_name);
                 $('#basic_salary').val(response.basic_salary);
                 $('#house_rant').val(response.house_rant);
                 $('#medical').val(response.medical);
                 $('#transport').val(response.transport);
                 $('#food').val(response.food);
                 $('#other').val(response.other);
                 $('#total_salary').val(response.total_salary);
                 $('#provident_fund_amount').val(response.provident_fund_amount);
                 $('#net_salary').html(response.net_salary);
                }
            })
            
        });


        //Edit departments
        $(document).on('click', '.edit', function(){
            
            var id = $(this).attr('id');
            //alert(id);
            //$('#form_result').html('');
            $.ajax({
             type: "GET",
             url:"{{url('/employee/salary/details')}}"+"/"+id,
             dataType:"json",
             success:function(response){
                    //console.log(response);
                    $('#name').html(response.emp_name);
                    $('#edit_employeeId').val(response.employeeId);
                    //slelect2 value selected
                    $('#edit_basic_salary').val(response.basic_salary);
                    $('#edit_house_rant').val(response.house_rant);
                    $('#edit_medical').val(response.medical);
                    $('#edit_transport').val(response.transport);
                    $('#edit_food').val(response.food);
                    $('#edit_other').val(response.other);
                    $('#id').val(response.id);

                    //lode grades
                    $.ajax({
                        type: "GET",
                        url:"{{route('ajax.get_grade')}}",
                        success:function (grade) {
                            //console.log(response.id);
                            $('#salary_grade_id').html(grade);
                            $('#salary_grade_id').val(response.grade_id);
                            $('#salary_grade_id').select2().trigger('change');
                        }
                    });
                }
            })

            
        });


        //update branch
        $( "#updae" ).click(function() {

            if( $("#edit_basic_salary").val() <= 0 ){
                $("#edit_basic_salary").css('border-color', '#a94442');
                alert('Negative value cannot be accepted');
                //$("#basicError").html('* Remove Negative Value');
                return false;
            }
            else if( $("#edit_house_rant").val() < 0 ){
                $("#edit_house_rant").css('border-color', '#a94442');
                alert('Negative value cannot be accepted');
                //$("#houseError").html('* Remove Negative Value');
                return false;
            }
            else if( $("#edit_medical").val() < 0 ){
                $("#edit_medical").css('border-color', '#a94442');
                alert('Negative value cannot be accepted');
                //$("#medicalError").html('* Remove Negative Value');
                return false;
            }
            else if( $("#edit_transport").val() < 0 ){
                $("#edit_transport").css('border-color', '#a94442');
                alert('Negative value cannot be accepted');
                //$("#transportationError").html('* Remove Negative Value');
                return false;
            }
            else if( $("#edit_food").val() < 0 ){
                $("#edit_food").css('border-color', '#a94442');
                alert('Negative value cannot be accepted');
                //$("#foodError").html('* Remove Negative Value');
                return false;
            }
            else if( $("#edit_other").val() < 0 ){
                $("#edit_other").css('border-color', '#a94442');
                alert('Negative value cannot be accepted');
                //$("#otherError").html('* Remove Negative Value');
                return false;
            }else{
                $("#edit_basic_salary").css('border-color', '#32CD32');
                $("#edit_house_rant").css('border-color', '#32CD32');
                $("#edit_medical").css('border-color', '#32CD32');
                $("#edit_transport").css('border-color', '#32CD32');
                $("#edit_food").css('border-color', '#32CD32');
                $("#edit_other").css('border-color', '#32CD32')

                var _token = '{{ csrf_token() }}';
                var editSalary = $('#edit_salary_modal_form').serialize();
                //alert(_token);
                    $.ajax({
                        url:"{{route('employee_salary_update')}}",
                        method:"post",
                        data: editSalary,
                        success:function (response) {
                            //console.log(response);
                            
                            if(response.falied)
                            {
                                swal(response.falied, "", "warning");
                            }
                            if(response.success)
                            {
                                swal(response.success, "", "success");
                                $('#emp_salary_table').DataTable().ajax.reload();
                                $('#edit_salary_modal_form').modal('hide');
                            }
                        }
                    });
            }

        
        });


        $("#salary_grade_id").select2({
            placeholder: "Select Gread"
        });
    
    });
    </script>
@endsection