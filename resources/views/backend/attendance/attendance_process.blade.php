@extends('layout.master')
@section('title', 'Process File')

<style>
    #pageloader
    {
        background: rgba( 255, 255, 255, 0.8 );
        display: none;
        height: 100%;
        position: fixed;
        width: 100%;
        z-index: 9999;
    }

    #pageloader img
    {
        left: 40%;
        margin-left: -32px;
        margin-top: -32px;
        position: absolute;
        top: 50%;
        transform: translate(-50%,-50%);
    }

    .content_body{
        padding: 15px;
        box-shadow: 0 0 10px 0 rgba(0, 0, 0, 0.1);
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
</style>
@section('content')
    <div id="pageloader">
        <img src="https://ui-ex.com/images/transparent-background-loading-3.gif" alt="processing..." />
    </div>
    <!--BEGIN TITLE & BREADCRUMB PAGE-->
    <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
        <div class="page-header pull-left">
            <div class="page-title">Attendance Files</div>
        </div>
        <ol class="breadcrumb page-breadcrumb pull-right">
            <li><i class="fa fa-home"></i>&nbsp;<a href="{{url('/')}}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
            <li><a href="#">Attendance</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
            <li class="active">Upload Files</li>
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
                                Attendance File Details
                            </div>
                        </div>
                    </div>
                    {!! Form::open(['method'=>'post','action'=>'AttendanceController@store','files'=>true,'id'=>'file_form']) !!}
                    <div class="panel-body">
                        <div class="row">

                            <div class="col-md-6 col-md-offset-3 ">
                                <div class="content_body">
                                    <div class="form-group">
                                        <div class="row first_r">
                                            <div class="col-md-6 col-sm-6 col-xs-6"><label><h5>Title:</h5></label></div>
                                            <div class="col-md-6 col-sm-6 col-xs-6"> <p>{{$file->title}}</p> </div>

                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 col-sm-6 col-xs-6"><label><h5>File Name:</h5></label></div>
                                            <div class="col-md-6 col-sm-6 col-xs-6"><p>{{$file->attendance_file}}</p></div>

                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 col-sm-6 col-xs-6"><label><h5>Description:</h5></label></div>
                                            <div class="col-md-6 col-sm-6 col-xs-6"><p>{{$file->description }}</p></div>

                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 col-sm-6  col-xs-6"><label><h5>Process Status:</h5></label></div>
                                            <div class="col-md-6 col-sm-6 col-xs-6" >
                                                <div id="process_status">
                                                    @if($file->process_status==0)
                                                        <p style="color: #f0ad4e">Pending</p>
                                                    @else
                                                        <p style="color: green">Processed</p>
                                                    @endif
                                                </div>
                                                <p></p>
                                            </div>

                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 col-sm-6 col-xs-6"><label><h5>Upload Date:</h5></label></div>
                                            <div class="col-md-6 col-sm-6 col-xs-6"><p>{{\Carbon\Carbon::parse($file->upload_date)->format('j M Y')}}</p></div>

                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 col-sm-6 col-xs-6"><label><h5>Upload Time:</h5></label></div>
                                            <div class="col-md-6 col-sm-6 col-xs-6"><p>{{\Carbon\Carbon::parse($file->upload_date)->format('g:i A')}}</p></div>

                                        </div>
                                        <div class="row">
                                            <div class="col-md-8 col-sm-8 col-xs-6"></div>
                                            <div class="col-md-4 col-sm-4 col-xs-4">
                                                <button id="process_btn" type="button" class="btn btn-primary btn-sm">Confirm Process</button>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
<<<<<<< HEAD
=======


>>>>>>> c1b537bf501023ac06dbb3a464e9d3c0011d631c
@endsection

@section('extra_js')
    <script>
        $(document).ready(function () {
            $("#process_btn").click(function (event) {
                event.preventDefault();
                var url="{{route('ajax.process_file','')}}";
                url+="/{{base64_encode($file->id)}}";
                $(document).ajaxStop(function(){
                    $("#pageloader").fadeOut();


                });
                $(document).ajaxStart(function(){
                    $("#pageloader").fadeIn();
                });
                $.ajax({
                    url:url,
                    method:"get",
                    success:function (response) {
                        if(response==="Job Done"){
                            $("#process_status").replaceWith("<p style='color: green'>Processed</p>");
                            swal(" Process Completed!", "Attendance processed successfully!", "success");

                        }
                        else if(response==="Invalid Excel Content"){
                            swal(" Error!", "The uploaded file is not in correct format.", "error");

                        }
                        else if(response==="File Not Found"){
                            swal(" Error!", "File not found. Try again.", "error");

                        }
                        else if(response==="Empty"){
                            swal(" Error!", "No data found to process.", "error");

                        }
                        else {
                            swal(" Error!", "Something went wrong. Try again later.", "error");

                        }

                    },
                    error:function () {
                        console.log("error");

                    }
                });

            });


            var form = $('#file_form');
            form.on('submit', function(event) {
                event.preventDefault();
                var url="{{route('attendance_file.store')}}";
                $.ajax({
                    url:url,
                    method:"post",
                    data:new FormData(this),
                    processData: false,
                    contentType: false,
                    success:function (response) {
                        if(response.errors){
                            html = '<div class="alert alert-danger">';
                            for(var count = 0; count < response.errors.length; count++)
                            {
                                html += '<p>' + response.errors[count] + '</p>';
                            }
                            html += '</div>';
                            $('#form_error').html(html);
                        }
                        else {
                            swal("Attendance file uploaded and ready for processing.");
                            $("#title").val("");
                            $("#description").val("");
                            $("#file").val("");
                            // $('#form_error').style.display="none";
                            $("#form_error").css('display', 'none');
                            $("#table_body").html(response);


                        }

                    }

                });
                // return false;
            });

            $('#submit_file').click(function (event) {
                event.preventDefault();
                $('#real_submit').click();
            });

        })
    </script>
@endsection

{{--        <!doctype html>--}}
{{--<html lang="en">--}}
{{--<head>--}}
{{--    <meta charset="UTF-8">--}}
{{--    <meta name="viewport"--}}
{{--          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">--}}
{{--    <meta http-equiv="X-UA-Compatible" content="ie=edge">--}}
{{--    <title>Document</title>--}}
{{--    <style>--}}
{{--        #pageloader--}}
{{--        {--}}
{{--            background: rgba( 255, 255, 255, 0.8 );--}}
{{--            display: none;--}}
{{--            height: 100%;--}}
{{--            position: fixed;--}}
{{--            width: 100%;--}}
{{--            z-index: 9999;--}}
{{--        }--}}

{{--        #pageloader img--}}
{{--        {--}}
{{--            left: 50%;--}}
{{--            margin-left: -32px;--}}
{{--            margin-top: -32px;--}}
{{--            position: absolute;--}}
{{--            top: 50%;--}}
{{--        }--}}
{{--    </style>--}}
{{--    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>--}}
{{--</head>--}}
{{--<body>--}}
{{--<div id="pageloader">--}}
{{--    <img src="{{asset('aa.gif')}}" alt="processing..." />--}}
{{--</div>--}}

{{--<form id="myform">--}}
{{--    <input type="text" name="fname" id="fname" value="" />--}}
{{--    <input type="submit" value="Submit" />--}}
{{--</form>--}}

{{--<script>--}}
{{--    $(document).ready(function(){--}}
{{--        $("#myform").on("submit", function(){--}}
{{--            $("#pageloader").fadeIn();--}}
{{--        });//submit--}}
{{--    });//document ready--}}
{{--</script>--}}

{{--</body>--}}
{{--</html>--}}
