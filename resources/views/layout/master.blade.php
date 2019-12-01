<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head><title>
        @if(View::hasSection('title'))
            @yield('title')
        @else
            One HRMS
        @endif
    </title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{--<link rel="shortcut icon" href="images/icons/favicon.ico">--}}
    {{--<link rel="apple-touch-icon" href="images/icons/favicon.png">--}}
    {{--<link rel="apple-touch-icon" sizes="72x72" href="images/icons/favicon-72x72.png">--}}
    {{--<link rel="apple-touch-icon" sizes="114x114" href="images/icons/favicon-114x114.png">--}}
  
    {{--  <link rel="shortcut icon" href="images/icons/favicon.ico">  --}}
    <link rel="shortcut icon" href="{{asset('corporate/images/favicon_2.png')}}">
    <link rel="apple-touch-icon" href="{{asset('corporate/images/favicon_2.png')}}">
    <link rel="apple-touch-icon" sizes="72x72" href="{{asset('corporate/images/favicon_2.png')}}">
    <link rel="apple-touch-icon" sizes="114x114" href="{{asset('corporate/images/favicon_2.png')}}"> 
    <!--Loading bootstrap css-->
    @include('include.css')
    @yield('extra_css')
    <style>
        body{
            padding: 0px !important;
        }

        .panel {
            -webkit-box-shadow: none !important;
            box-shadow: none !important;
            -webkit-border-radius: 0 !important;
            -moz-border-radius: 0 !important;
            border-radius: 0 !important;
             border: 0px solid #e5e5e5 !important;
        }
        .form-control {
            -webkit-box-shadow: none !important;
            box-shadow: none !important;
            border: 1px solid #e5e5e5;
            height: 38px;
            -webkit-border-radius: 0 !important;
            -moz-border-radius: 0 !important;
            border-radius: 0 !important;
        }
        select[multiple], select[size] {
            height: 38px !important;
        }
    </style>
</head>
<body>
<div>
    <!--BEGIN THEME SETTING-->
      {{--@include('include.theme_style')--}}
    <!--END THEME SETTING-->
    <!--BEGIN BACK TO TOP-->
    <a id="totop" href="#"><i class="fa fa-angle-up"></i></a><!--END BACK TO TOP--><!--BEGIN TOPBAR-->
    <div id="header-topbar-option-demo" class="page-header-topbar">
       @include('include.top_header')
    </div>
    <!--END TOPBAR-->
    <div id="wrapper">
        <!--BEGIN SIDEBAR MENU-->
          @include('include.sidebar')
        <!--END SIDEBAR MENU-->
        <!--BEGIN PAGE WRAPPER-->
        <div id="page-wrapper">
            <!--BEGIN CONTENT-->
            @yield('content')
            <!--END CONTENT-->
            <!--BEGIN FOOTER-->
            <div id="footer">
                @include('include.copyright')
            </div>
            <!--END FOOTER-->
        </div>
        <!--END PAGE WRAPPER-->
    </div>
</div>
@include('include.js')
@yield('extra_js')
</body>
</html>