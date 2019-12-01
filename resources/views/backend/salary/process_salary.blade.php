@extends('layout.master')
@section('title', 'Process Salary')
@section('content')
    <div id="salaryProcessloader">
        <img src="{{ asset('images/salaryProcess.svg') }}" alt="processing..." />
    </div>
    <!--BEGIN TITLE & BREADCRUMB PAGE-->
    <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
        <div class="page-header pull-left">
            <div class="page-title">Process Salary</div>
        </div>
        <ol class="breadcrumb page-breadcrumb pull-right">
            <li><i class="fa fa-home"></i>&nbsp;<a href="{{url('/')}}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
            <li><a href="#">Salary</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
            <li class="active">Process Salary</li>
        </ol>
        <div class="clearfix"></div>
    </div>
    <!--END TITLE & BREADCRUMB PAGE-->

   @section('extra_css')
       <style>
        #salaryProcessloader
        {
            background: rgba( 255, 255, 255, 0.8 );
            display: none;
            height: 100%;
            position: fixed;
            width: 100%;
            z-index: 9999;
        }

        #salaryProcessloader img
        {
            left: 40%;
            margin-left: -32px;
            margin-top: -32px;
            position: absolute;
            top: 50%;
            transform: translate(-50%,-50%);
        }
       </style>
   @endsection
    <div class="page-content">
            <!--Flash Message Start-->
                {{ Html::script('corporate/js/sweetalert.min.js') }}
                @if(Session::has('success'))
                <script>
                    var msg =' <?php echo Session::get('success');?>'
                    swal(msg, "", "success");
                </script>
                @elseif(Session::has('delete'))
                <script>
                    var msg =' <?php echo Session::get('delete');?>'
                    swal(msg, "", "warning");
                </script>
                @endif
            <!--Flash Message End-->
            <div class="row">
                    <div class="col-lg-6 col-xs-offset-3">
                        <div class="panel panel-blue">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-md-6"> 
                                        <i class="fa fa-cog" style="font-size: 20px;"></i>
                                        Process Salary
                                    </div>
                                    
                                </div>
                            </div>
                            <div class="panel-body">
                                <div class="form-group">
                                    <label for="datepicker">Select Month</label>
                                    <input type="text" class="form-control" id="salary_month" name="salary_month" autocomplete="off" readonly>
                                    <b class="form-text text-danger pull-left" id="monthError"></b>
                                </div>
                                <div class="form-group">
                                    <input type="checkbox" name="reduction_tax" class="messageCheckbox"  id="reduction_tax"  value="reduction_tax" > With Tax Deduction<br>
                                </div>
                                
                            </div>
                            <div class="panel-footer">
                                <button class="btn btn-danger center-block" id="process_btn">Process</button>
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
        //$( "#datepicker" ).datepicker({dateFormat: 'yy'});
        $( "#process_btn" ).click(function() {
            $("#monthError").html('');
            var year_month = $("#salary_month").val();
            // var reduction_tax = $("#reduction_tax").val(); 



            var reduction_tax = $('.messageCheckbox:checked').val();

  
           
            
            var date = new Date(year_month);
            input_month = date.getMonth()+ 1;

            var now = new Date();
            current_month = now.getMonth()+ 1;

            // alert(year_month +' '+checkedValue);
            
            
            if( year_month == '' ){
                $("#salary_month").css('border-color', '#a94442');
                $("#monthError").html('* Salary Month Is required');
                return false;
            }else{
                $("#salary_month").css('border-color', '#32CD32');
                if(input_month > current_month){
                    swal("Month is Greater then Current Month", "", "warning");
                    
                }else{
                    
                    $(document).ajaxStop(function(){
                        $("#salaryProcessloader").hide();
                    });
                    $(document).ajaxStart(function(){
                        $("#salaryProcessloader").show();
                    });
                    $.ajax({
                        type: "GET",
                        url:"{{url('/salary/process')}}"+"/"+year_month +"/" +reduction_tax,
                        success:function (response) {
                            // console.log(response);
                            if(response.success){
                                swal(response.success, "", "success");
                            }
                            if(response.error){
                                swal(response.error, "", "error");
                            }

                            if(response.falied)
                        {
                            swal(response.falied, "", "warning");
                        }
                        }
                    });
                }
                
            }
            
        });

        $("#salary_month").datepicker( {
            format: "yyyy-mm",
            viewMode: "months", 
            minViewMode: "months"
        });
    });

    
</script>
@endsection
