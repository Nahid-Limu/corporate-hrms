@extends('layout.master')
@section('title', 'Project Details')
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
        /*height:200px;*/
        width: 100%;
        position: relative;
        box-shadow: 0px 3px 2px 0px rgba(0,0,0,.1)!important;
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
        /*background: -webkit-linear-gradient(left, rgba(56,107,12,.6) 0%, rgba(133,153,115,.6) 100%);*/
        /*background: linear-gradient(to right, rgba(56,107,12,.6) 0%, rgba(133,153,115,.6) 100%);*/
        /*box-shadow: 0 5px 10px 0 rgba(56,107,12, 0.5)!important;*/

        background: linear-gradient(to right, rgba(40, 55, 84, 0.48) 0%, rgba(73, 102, 156, 0.63) 71%, rgba(73, 102, 156, 0.77) 100%);
        box-shadow: 0 2px 5px 0 rgba(40,55,84,0.5)!important;
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
        /*border-radius: 3px 3px 0 0;*/
        /*height: 100%;*/
        width: 100%;
        border-radius: 50%;
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
    .search_opt .fa-search{
        position: relative;
        top: -27px;
        float: right;
        right: 20px;
        color:#ccc;
    }
    .chat_person_img{
        float: left;
        margin-right: 10px;
    }
    .chat_person_img img{
        width:50px;
        border-radius: 50%;
    }
    .chat_person_data{
        float: left;
    }
    .employee_list ul{
        margin:0;
        padding: 0;
    }
    .employee_list ul li {
        padding-bottom: 60px;
        border-bottom: 1px dotted #ccc;
        padding-top: 17px;
        list-style: none;
    }
    .left_chat_list {
        margin-left: 28px;
        margin-right: 36px;
        box-shadow: 0px 0px 4px 2px rgba(0,0,0,0.2);

        padding-bottom: 20px;
    }
    .chat_person_data p{
        margin-bottom: 2px;
    }
    .search_bg{
        background: #444753;
        padding-top: 20px;
        margin-bottom: 25px;
    }
    .chat_container .chat{
        width:100%;
    }
    .chat_container .chat-history ul li{
        list-style: none;
    }
</style>
{{ Html::style('corporate/css/chatstyle.css')}}
@endsection

@section('content')
<!--BEGIN TITLE & BREADCRUMB PAGE-->
<div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
    <div class="page-header pull-left">
        <div class="page-title">Project Details</div>
    </div>
    <ol class="breadcrumb page-breadcrumb pull-right">
        <li><i class="fa fa-home"></i>&nbsp;<a href="{{url('/')}}">Home</a>&nbsp;&nbsp;<i
                class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
        <li><a href="#">Project </a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
        <li class="active">Project Details</li>
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
<div class="page-content" id="project_profile_page_id_1">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-blue">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-md-6">
                            <i class="fa fa-tasks" style="font-size: 20px;"></i>
                           Project Details
                        </div>
                        <div class="col-md-6" style="text-align: right;">
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    <table class="table table-bordered table-hover table-striped table-responsive" style="margin-top:20px; color:#000!important;">
                        <thead >
                            <tr>
                                <th>Project Name</th>
                                <th>Client</th>
                                <th>Team leader</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Deadline</th>
                                <th>Price</th>
                                <th>Priority</th>
                                <th>Description</th>
                                <th>Status</th>
                              </tr>
                        </thead>
                        <tbody>
                            <tr>
                                  <td>{{$project->project_name}}</td>
                                  <td>{{$project->client_name}}</td>
                                  <td>{{$project->employeeId}}( {{$project->emp_first_name}})</td>
                                  <td>{{date('F-d-Y',strtotime($project->start_date))}}</td>
                                  <td>{{date('F-d-Y',strtotime($project->end_date))}}</td>
                                  <td>{{$project->days}} Days</td>
                                  <td>{{$project->price}}</td>
                                  <td>@if($project->priority==0) Low @else High @endif</td>
                                  <td>{{$project->description}}</td>
                                  <td>@if($project->status==0)
                                         Pending
                                         @elseif($project->status==1)
                                         Approve
                                         @elseif($project->status==2)
                                         Running
                                         @elseif($project->status==3)
                                         Completed
                                         @elseif($project->status==4)
                                         Delivered
                                         @elseif($project->status==5)
                                         Rejected
                                         @else
                                         Cancel
                                       @endif
                                  </td>
                                </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>



        <div class="col-md-3" style="padding:0px">
            <div class="panel panel-blue">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-md-12">
                            <i class="fa fa-tasks" style="font-size: 20px;"></i>
                            Poject Manager
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="col-md-9">
                        <div class="team_profile">
                            <div class="team_profile_img">
                              @if(isset($project_manager->emp_photo))
                              @if($project_manager->emp_photo=='')
                              <img src="{{asset('employee_image/profile_image.jpg')}}" alt="employee image" />
                              @else
                              <img  src="{{asset('employee_image/'.$project_manager->emp_photo)}}" alt="employee image"/>
                              @endif
                              @endif

                                {{--     Project Manager Image                  --}}
                                  <img src="{{asset('employee_image/profile_image.jpg')}}" alt="employee image" />


                                <div class="team_profile_img_overlay">

                                </div>
                            </div>
                            <div class="profile_container">

                            <h4 style="color:#000000">
                                <p style="color:#fff;margin-top: 0px;margin-bottom: 0px;font-size: 5px;">1</p>

                                <b>
                                    @if(isset($project_manager->employeeId))
                                    {{$project_manager->employeeId}}<br> {{$project_manager->emp_first_name}} {{$project_manager->emp_lastName}}</b></h4>
                                    @else

                                    {{$project_manager->name}}
                                    @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-9">
            <div class="panel panel-blue">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-md-12">
                            <i class="fa fa-tasks" style="font-size: 20px;"></i>
                            Assign Members
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                  @foreach($assign_member as  $assign_members)
                    <div class="col-md-3">
                        <div class="team_profile">
                            <div class="team_profile_img">
                               @if($assign_members->emp_photo=='')
                                  <img src="{{asset('employee_image/profile_image.jpg')}}" alt="employee image" class="img-responsive" height="20px"/>
                                @else
                                    <img  src="{{asset('employee_image/'.$assign_members->emp_photo)}}" alt="employee image" class="img-responsive" height="20px"/>
                                @endif
                                @if(auth()->user()->hasrole('admin') || auth()->user()->hasrole('super-admin') || auth()->user()->hasrole('project-manager'))
                                <div class="team_profile_img_overlay">
                                    <a target="_blank" title="Assign Task" href="{{url('project/assign/task/'.base64_encode($project->project_id).'/'.base64_encode($assign_members->member_id))}}"><i class="fa fa-plus"></i></a>
                                </div>
                                @endif
                            </div>
                            <div class="profile_container">
                            <h4 style="color:#000000"><b>{{$assign_members->employeeId}}</b></h4>
                                <p style="color:#000000"> <b>{{$assign_members->emp_first_name}} {{$assign_members->emp_lastName}}</b> </p>
                            </div>
                        </div>
                    </div>
                  @endforeach
                </div>
            </div>
        </div>
    {{--    live chat--}}
    <div class="row">
        <div class="col-md-12">
            <div class="container clearfix chat_container" style="background-color: #fff">
                <div class="chat">
                    <div class="chat-header clearfix">
                        <div class="chat-about">
                            <div class="chat-with">Project Group Chat</div>
                        </div>
                        <i class="fa fa-star"></i>

                    </div> <!-- end chat-header -->
                    <div class="chat-history">
                        <ul>
                          <div id="chattt"></div>
                        </ul>
                    </div> <!-- end chat-history -->
                    <div class="chat-message clearfix">
                        <textarea class="form-control" name="conversation" id="conversation" placeholder ="Type your message" rows="3"></textarea>
                        <input type="hidden" id="project_id" name="project_id" value="{{$id}}">
                        <button onclick="send_message()" type="button"  class=" btn btn-success btn-lg"><i class="fa fa-check"></i>Send</button>
                    </div> <!-- end chat-message -->
                </div> <!-- end chat -->
            </div> <!-- end container -->
        </div>
    </div>
</div>
@endsection

@section('extra_js')
<script>

 //send message to database
  function send_message(){
            var _token = '{{ csrf_token() }}';
            var project_id = $("#project_id").val();
            var conversation = $("#conversation").val();
            $.ajax({
                url:"{{url('project/group/chat')}}",
                method:"post",
                data: {_token : _token, project_id : project_id,conversation : conversation},
                success:function (response) {
                    document.getElementById('conversation').value = ''
                    $("#hide_cont").hide();
                    latestMessage()
                }
            });
   }

   //latest message show here
   function latestMessage(){
          var project_id=$("#project_id").val();
          $.ajax({
                url:"{{url('project/group/conversation/')}}"+'/'+project_id,
                method:"get",
                success:function (response) {
                    var chat_message = '';
                    $.each(response, function (i, item) {
                    if(item.emp_first_name==null){
                      var user='System Admin';
                    }else{
                      var user=item.emp_first_name+item.emp_lastName;
                    }
                    chat_message+='<li class="clearfix testt"><div class="message-data align-right"><span class="message-data-time"> '+moment(item.created_at).fromNow()+' </span> &nbsp; &nbsp;<span class="message-data-name">'+user+'</span> <i class="fa fa-circle me"></i></div><div class="message other-message float-right">'+item.conversation+'</div></li>';
                    });
                    $('#chattt').html(chat_message);
                }
        });
   }

   setInterval(function(){
    latestMessage()
}, 1000)

</script>
@endsection

