@extends('layout.master')
@section('title')
    Company Info
@endsection
    <style>
        .content_body{
            padding: 15px;
            box-shadow: 0 0 10px 0 rgba(0, 0, 0, 0.1);
            padding-top: 0px;
        }
        .content_body p{
            margin-top:7px;
        }
        .first_r{
            background: #40516f;
            color: #fff;
            font-weight: 700;
        }
        .first_r h5{
            font-weight: 700;
        }
        .isDisabled {
            color: currentColor;
            cursor: not-allowed;
            opacity: 0.5;
            text-decoration: none;
        }
        .company-image{
            width: 40%;
            margin: 0 auto;
            margin-top: 20px;
            margin-bottom: 20px;

        }
        .company-image img{
            width:100%;
        }
        .content_body .row div label{
            width: 70%;
            margin-left: 25%;
        }
    </style>
@section('content')
    <!--BEGIN TITLE & BREADCRUMB PAGE-->
    <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
        <div class="page-header pull-left">
            <div class="page-title">Company Information</div>
        </div>
        <ol class="breadcrumb page-breadcrumb pull-right">
            <li><i class="fa fa-home"></i>&nbsp;<a href="{{url('/')}}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
            <li><a href="#">Company</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
            <li class="active">Company Information</li>
        </ol>
        <div class="clearfix"></div>
    </div>
    <!--END TITLE & BREADCRUMB PAGE-->
    <div class="page-content">
         <!--Flash Message Start-->
         {{ Html::script('corporate/js/sweetalert.min.js') }}
         @if(Session::has('success'))
         <script>
             var msg =' <?php echo Session::get('success');?>'
             swal(msg, "", "success");
         </script>
         @endif
     <!--Flash Message End-->
            <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-blue" style="padding-bottom: 50px;">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-md-6">
                                        Company Information
                                    </div>
                                </div>
                            </div>
                            <div class="panel-body table-responsive" style="margin-top: 30px;">
                                <div class="row">
                                   @if($company_info->isEmpty())
                                   {!! Form::open(['method'=>'POST','route'=>'companyInfo_add','files'=>true]) !!}
                                  <div class="col-md-8 col-md-offset-2 ">
                                        <div class="form-group">
                                            <label for="edit_company_name">Company Name</label>
                                            <input type="text" class="form-control"  name="company_name" placeholder="Company Name" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="edit_company_phone">Company Phone</label>
                                            <input type="tel" class="form-control"  name="company_phone" pattern="[0-9]{11}" maxlength="11" placeholder="Ex: 017xxxxxxxx" title="Type Eleven digits Number" required autocomplete="off" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="edit_company_email">Company Email</label>
                                            <input type="email" class="form-control"  name="company_email" placeholder="Company Email" required>
                                        </div>
                                        <div class="form-group">
                                                <label for="edit_company_email">Company Logo</label>
                                                <input type="file" class="form-control"  name="company_logo">
                                        </div>
                                        <div class="form-group">
                                            <label for="edit_company_address">Address</label>
                                            <textarea  name="company_address" cols="5" rows="5" class="form-control" autocomplete="off" required>Company Address</textarea>
                                        </div>
                                        <br>
                                        <button type="submit" class="btn btn-info pull-right"><i class="fa fa-save"></i> Save Information</button>
                                  </div>
                                  {!! Form::close() !!}
                                      @else
                                    @foreach($company_info as $company)
                                    <div class="col-md-6 col-md-offset-3 ">
                                        <div class="content_body">
                                            <div class="form-group">
                                                <div class="row ">
                                                    <div class="company-image">
                                                          <img class="img-responsive" src="{{asset('company_info/'.$company->company_logo)}}" alt="">
                                                    </div>
                                                </div>

                                                <div class="row ">
                                                    <div class="col-md-6 col-sm-6 col-xs-6"><label><h5>Company Name:</h5></label></div>
                                                    <div class="col-md-6 col-sm-6 col-xs-6"> <p>{{$company->company_name}}</p> </div>

                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6 col-sm-6 col-xs-6"><label><h5>Company Phone:</h5></label></div>
                                                    <div class="col-md-6 col-sm-6 col-xs-6"><p>{{$company->company_phone}}</p></div>

                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6 col-sm-6 col-xs-6"><label><h5>Company Email:</h5></label></div>
                                                    <div class="col-md-6 col-sm-6 col-xs-6"><p>{{$company->company_email}}</p></div>

                                                </div>

                                                <div class="row">
                                                    <div class="col-md-6 col-sm-6 col-xs-6"><label><h5>Company Address:</h5></label></div>
                                                    <div class="col-md-6 col-sm-6 col-xs-6"><p>{{$company->company_address}}</p></div>

                                                </div>

                                                <div class="row">
                                                    <div class="col-md-6" style="text-align: right;">
                                                        <button type="button" value="{{$company->id}}"  id="com_edit" class="edit btn btn-blue btn-sm" title="Edit">Edit</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
    <!-- Modal Start -->
    @include('backend.company_info.modal.edit')
    <!-- Modal End -->
    </div>
@endsection
@section('extra_js')
<script>
    $(document).ready(function(){
        //Edit Company
        $("#com_edit").click(function(){
            var id = $("#com_edit").val();
            $.ajax({
             type: "GET",
             url:"{{url('company_edit')}}"+"/"+id,
             dataType:"json",
             success:function(response){
                 console.log(response);
                 $("#editCompany").modal('show');
                 $('#id').val(response.id);
                 $('#default_logo').val(response.company_logo);
                 $('#edit_company_name').val(response.company_name);
                 $('#edit_company_phone').val(response.company_phone);
                 $('#edit_company_email').val(response.company_email);
                 $('#edit_company_address').val(response.company_address);
             },
                error:function(response){
                    console.log(response);
                },
            })
           });
    });
    </script>
@endsection
