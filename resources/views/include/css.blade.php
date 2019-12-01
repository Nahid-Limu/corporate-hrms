<?php
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AccessController;
if(AccessController::ipAccess()==false){
    redirect('/AccessDenied')->send();
} 
?>
<link type="text/css" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:400italic,400,300,700">
<link type="text/css" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Oswald:400,700,300">
{{ Html::style('corporate/vendors/jquery-ui-1.10.4.custom/css/ui-lightness/jquery-ui-1.10.4.custom.min.css') }}
{{ Html::style('corporate/vendors/font-awesome/css/font-awesome.min.css') }}
{{ Html::style('corporate/vendors/bootstrap/css/bootstrap.min.css') }}
{{ Html::style('corporate/vendors/bootstrap-toggle/css/bootstrap-toggle.css') }}
{{ Html::style('corporate/vendors/bootstrap-datepicker/css/datepicker.css') }}
{{ Html::style('corporate/vendors/calendar/zabuto_calendar.min.css') }}
{{ Html::style('corporate/vendors/animate.css/animate.css') }}
{{ Html::style('corporate/vendors/jquery-pace/pace.css') }}
{{ Html::style('corporate/vendors/iCheck/skins/all.css') }}
{{ Html::style('corporate/vendors/jquery-news-ticker/jquery.news-ticker.css') }}
{{ Html::style('corporate/css/themes/style3/pink-blue.css') }}
{{ Html::style('corporate/css/style-responsive.css') }}
{{ Html::style('corporate/css/datatable.css') }}
{{ Html::style('corporate/css/select2.css') }}
{{ Html::style('corporate/vendors/bootstrap-datepicker/css/datepicker.css') }}
{{ Html::style('corporate/vendors/bootstrap-daterangepicker/daterangepicker-bs3.css') }}
{{ Html::style('corporate/vendors/bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css') }}
{{ Html::style('corporate/vendors/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}
{{ Html::style('corporate/vendors/animate.css/animate.css') }}

{{ Html::style('corporate/css/custom-style.css')}}


<?php if(Auth::user()->theme_style==1){ ?>
{{ Html::style('corporate/css/custom-style.css')}}
<?php }elseif(Auth::user()->theme_style==2) { ?>
{{ Html::style('corporate/css/dark-style.css')}}
<?php } ?>

{{--  extra css  --}}
    <style>
        /* side nav scroll bar */
        #sidebar {
            /*height: 100%;*/
            /*overflow: auto;*/
        }
        /* side nav li style */
        .nav-third-level li .fa-angle-double-right{
            margin-left: 15px;
        }

        /* select2 responsive */
        .select2 {
            width:100%!important;
            }

        /* select2 height adjust with template */
        .select2-selection {
            height: 38px !important;
            }
        
        /* datepicker style */
        .bootstrap-datetimepicker-widget td span{
            height:30px!important;
            line-height: 30px!important;
        }
        /* slelect2 style */
        .form-control.select2Style{
            background-color: white;
            border: 1px solid #aaa;
            border-radius: 4px !important;
            cursor: text;
         }
    </style>
