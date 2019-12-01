@extends('layout.master')
@section('title')
    Chat
@endsection

@section('extra_css')
{{--    {{ Html::style('corporate/vendors/chatSocketAchex/chatSocketAchex.css') }}--}}
    <style>
    .panel-body.chat_panel_main_body {
        height: 600px;
    }


    </style>
@endsection

@section('content')
    <!--BEGIN TITLE & BREADCRUMB PAGE-->
    <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
        <div class="page-header pull-left">
            <div class="page-title">Branch</div>
        </div>
        <ol class="breadcrumb page-breadcrumb pull-right">
            <li><i class="fa fa-home"></i>&nbsp;<a href="{{url('/')}}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
            <li><a href="#">Branch</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
            <li class="active">Branch List</li>
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
                                Online Chat
                            </div>

                        </div>
                    </div>
                    <div class="panel-body chat_panel_main_body">
                        <div id="Elchat"></div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal Start -->

    <!-- Modal End -->
    </div>
@endsection

@section('extra_js')
{{--    {{ Html::script('corporate/vendors/chatSocketAchex/chatSocketAchex.js') }}--}}
    <script>
        $('#Elchat').ChatSocket();
    </script>
@endsection
