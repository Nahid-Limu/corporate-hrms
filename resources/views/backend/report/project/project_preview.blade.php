@extends('layout.master')
@section('title', 'Project Preview')

@section('extra_css')
<style>


    .team_profile{
        box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
        transition: 0.3s;
        border-radius: 3px;
        cursor: pointer;
        margin-bottom: 20px;
    }
    .team_profile:hover {
        box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2);
    }
    .team_profile:hover .team_profile_img_overlay{
        opacity: 1;
        cursor: pointer;
    }
    .team_profile_img{
        height:200px;
        width: 100%;
        position: relative;
    }
    .team_profile_img_overlay{
        position: absolute;
        width: 100%;
        height: 100%;
       
        top: 0;
        left: 0;
        opacity:0;
        webkit-transition: all 0.3s ease-in-out;
        -moz-transition: all 0.3s ease-in-out;
        -ms-transition: all 0.3s ease-in-out;
        -o-transition: all 0.3s ease-in-out;
        transition: all 0.3s ease-in-out;
        background: -webkit-linear-gradient(left, rgba(56,107,12,.6) 0%, rgba(133,153,115,.6) 100%);
        background: linear-gradient(to right, rgba(56,107,12,.6) 0%, rgba(133,153,115,.6) 100%);
        box-shadow: 0 5px 10px 0 rgba(56,107,12, 0.5)!important;
    }
    .team_profile_img_overlay i{
        color:#fff;
        position: relative;
        top:50%;
        left:50%;
        transform: translate(-50%,-50%);
        font-size: 20px;
    }
      
    .team_profile img {
        border-radius: 3px 3px 0 0;
        height: 100%;
        width: 100%;
    }
      
    .team_profile .profile_container {
        padding: 2px 16px;
        text-align: center;
        padding-top: 20px;
        padding-bottom: 20px;
    }
    .profile_container h4{
        margin-top: 5px;
        margin-bottom: 5px;
    }
    .profile_container p{
        margin-bottom: 5px;
        font-size: 13px;
    }

</style>    
@endsection


@section('content')
<!--BEGIN TITLE & BREADCRUMB PAGE-->
<div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
    <div class="page-header pull-left">
        <div class="page-title">Project Preview</div>
    </div>
    <ol class="breadcrumb page-breadcrumb pull-right">
        <li><i class="fa fa-home"></i>&nbsp;<a href="{{url('/')}}">Home</a>&nbsp;&nbsp;<i
                class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
        <li><a href="#">Project</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
        <li class="active">Project Preview</li>
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
                            <i class="fa fa-tasks" style="font-size: 20px;"></i>
                            Project Preview
                        </div>
                        <div class="col-md-6" style="text-align: right;">
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    <table class="table table-bordered table-hover table-striped" style="margin-top:20px;">
                        <thead >
                          <tr>
                            <th>Firstname</th>
                            <th>Lastname</th>
                            <th>Email</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td>John</td>
                            <td>Doe</td>
                            <td>john@example.com</td>
                          </tr>
                          <tr>
                            <td>Mary</td>
                            <td>Moe</td>
                            <td>mary@example.com</td>
                          </tr>
                          <tr>
                            <td>July</td>
                            <td>Dooley</td>
                            <td>july@example.com</td>
                          </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-blue">
                <div class="panel-heading ">
                    <div class="row">
                        <div class="col-md-12">
                            <i class="fa fa-tasks" style="font-size: 20px;"></i>
                            Project Manager
                        </div>
                        
                    </div>
                </div>
                <div class="panel-body">
                    <div class="col-md-3">
                        <div class="team_profile">
                            <div class="team_profile_img">
                                <img src="https://i0.wp.com/zblogged.com/wp-content/uploads/2019/02/FakeDP.jpeg?resize=567%2C580&ssl=1" alt="Avatar" style="width:100%">
                                <div class="team_profile_img_overlay">
                                    <i class="fa fa-plus"></i>
                                </div>
                            </div>
                            <div class="profile_container">
                                <h4><b>Jane Doe</b></h4>
                                <p> <b>Project Manager</b> </p>
                                <p>Admin@email.com</p> 
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-blue">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-md-12">
                            <i class="fa fa-tasks" style="font-size: 20px;"></i>
                            Team Members
                        </div>
                        
                    </div>
                </div>
                <div class="panel-body">
                    <div class="col-md-3">
                        <div class="team_profile">
                            <div class="team_profile_img">
                                <img src="http://cflyer.com//comprehensive/uploads/thumbnail/630044536ravi.png" alt="Avatar" style="width:100%">
                                <div class="team_profile_img_overlay">
                                    <i class="fa fa-plus"></i>
                                </div>
                            </div>
                            <div class="profile_container">
                                <h4><b>Jane Doe</b></h4>
                                <p> <b>Project Manager</b> </p>
                                <p>Admin@email.com</p> 
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="team_profile">
                            <div class="team_profile_img">
                                <img src="http://drforum.gemini.edu/wp-content/uploads/2019/05/he02rd_avatar_1557260843.jpg" alt="Avatar" style="width:100%">
                                <div class="team_profile_img_overlay">
                                    <i class="fa fa-plus"></i>
                                </div>
                            </div>
                            <div class="profile_container">
                                <h4><b>Jane Doe</b></h4>
                                <p> <b>Project Manager</b> </p>
                                <p>Admin@email.com</p> 
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="team_profile">
                            <div class="team_profile_img">
                                <img src="http://cflyer.com//comprehensive/uploads/thumbnail/630044536ravi.png" alt="Avatar" style="width:100%">
                                <div class="team_profile_img_overlay">
                                    <i class="fa fa-plus"></i>
                                </div>
                            </div>
                            <div class="profile_container">
                                <h4><b>Jane Doe</b></h4>
                                <p> <b>Project Manager</b> </p>
                                <p>Admin@email.com</p> 
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="team_profile">
                            <div class="team_profile_img">
                                <img src="http://cflyer.com//comprehensive/uploads/thumbnail/630044536ravi.png" alt="Avatar" style="width:100%">
                                <div class="team_profile_img_overlay">
                                    <i class="fa fa-plus"></i>
                                </div>
                            </div>
                            <div class="profile_container">
                                <h4><b>Jane Doe</b></h4>
                                <p> <b>Project Manager</b> </p>
                                <p>Admin@email.com</p> 
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="team_profile">
                            <div class="team_profile_img">
                                <img src="http://cflyer.com//comprehensive/uploads/thumbnail/630044536ravi.png" alt="Avatar" style="width:100%">
                                <div class="team_profile_img_overlay">
                                    <i class="fa fa-plus"></i>
                                </div>
                            </div>
                            <div class="profile_container">
                                <h4><b>Jane Doe</b></h4>
                                <p> <b>Project Manager</b> </p>
                                <p>Admin@email.com</p> 
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="team_profile">
                            <div class="team_profile_img">
                                <img src="http://cflyer.com//comprehensive/uploads/thumbnail/630044536ravi.png" alt="Avatar" style="width:100%">
                                <div class="team_profile_img_overlay">
                                    <i class="fa fa-plus"></i>
                                </div>
                            </div>
                            <div class="profile_container">
                                <h4><b>Jane Doe</b></h4>
                                <p> <b>Project Manager</b> </p>
                                <p>Admin@email.com</p> 
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="team_profile">
                            <div class="team_profile_img">
                                <img src="http://cflyer.com//comprehensive/uploads/thumbnail/630044536ravi.png" alt="Avatar" style="width:100%">
                                <div class="team_profile_img_overlay">
                                    <i class="fa fa-plus"></i>
                                </div>
                            </div>
                            <div class="profile_container">
                                <h4><b>Jane Doe</b></h4>
                                <p> <b>Project Manager</b> </p>
                                <p>Admin@email.com</p> 
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="team_profile">
                            <div class="team_profile_img">
                                <img src="http://cflyer.com//comprehensive/uploads/thumbnail/630044536ravi.png" alt="Avatar" style="width:100%">
                                <div class="team_profile_img_overlay">
                                    <i class="fa fa-plus"></i>
                                </div>
                            </div>
                            <div class="profile_container">
                                <h4><b>Jane Doe</b></h4>
                                <p> <b>Project Manager</b> </p>
                                <p>Admin@email.com</p> 
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



</div>
@endsection
