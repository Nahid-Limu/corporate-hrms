@extends('layout.master')
@section('content')
    <!--BEGIN TITLE & BREADCRUMB PAGE-->
    <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
        <div class="page-header pull-left">
            <div class="page-title">Project</div>
        </div>
        <ol class="breadcrumb page-breadcrumb pull-right">
            <li><i class="fa fa-home"></i>&nbsp;<a href="{{url('/')}}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
            <li><a href="">Project</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
            <li class="active">Assign Project</li>
        </ol>
        <div class="clearfix"></div>
    </div>
    <!--END TITLE & BREADCRUMB PAGE-->
    <div class="page-content">
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-blue">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-md-6">
                                Assign Project
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Select Project</label>
                                <select class="form-control" id="project_id" nae="project_id">
                                    <option value="">Select</option>
                                    @foreach($project_list as $item)
                                        <option value="{{$item->id}}">{{$item->project_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <h4 style="display: none" id="display_title" class="text-center">Project Details</h4>
                            <div class="table-responsive">
                                <table id="project_table" class="table table-striped table-bordered table-hover">
                                    <thead>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                            <h4 style="display: none" id="display_title_member" class="text-center">Assign Member</h4>
                            <div class="table-responsive">
                                <table id="assign_table" class="table table-striped table-bordered table-hover">
                                    <thead>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>

                            <div id="assign_div" style="display: none">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Select Branch</label>
                                        <select class="form-control" id="branch_id">
                                            <option value="">Select</option>
                                            @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('super-admin'))
                                            @foreach($branch as $branches)
                                              <option value="{{$branches->id}}">{{$branches->branch_name}}</option>
                                            @endforeach
                                            @else 
                                            <option value="{{$branch_list2->id}}">{{$branch_list2->branch_name}}</option>
                                            @endif
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Select Team Member</label>
                                        <select class="form-control" id="member_id" name="member_id" multiple>
                                            <option value="">Select Branch First</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <button type="button" id="project_assign_btn" class="btn btn-success"><i class="fa fa-check"></i> Assign</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('extra_js')
    <script>
        //project details bind in table
        $("#project_id").change(function(){
            var id = $("#project_id").val();
            $.ajax({
                type: "GET",
                url:"{{url('project/details')}}"+"/"+id,
                dataType:"json",
                success:function(response){
                    console.log(response);
                    var project = '';
                    project+='<tr><th>Branch</th><th>Project</th><th>Client</th><th>Team Leader</th><th>Start Date</th><th>End Date</th><th>Price</th><th>Priority</th><th>Description</th><th>Deadline</th><th>Status</th></tr>'
                    $.each(response, function (i, item) {
                        if(item.priority==1){
                            var priority='High'
                        }else{
                            var priority='Low'
                        }
                        if(item.project_status==0){
                                var project_status='Pending';
                            }else if(item.project_status==1){
                                 project_status='Approved';
                            }
                            else if(item.project_status==2){
                                var project_status='Running';
                            }
                            else if(item.project_status==3){
                                var project_status='Completed';
                            }
                            else if(item.project_status==4){
                                var project_status='Delivered';
                            }
                            else if(item.project_status==5){
                                var project_status='Rejected';
                            }
                            else{
                                var project_status='Cancel';
                            }
                        project += '<tr><td>'+item.branch_name+'</td><td>'+item.project_name+'</td><td>'+item.client_name+'</td><td>'+item.emp_first_name+'</td><td>'+item.start_date+'</td><td>'+item.end_date+'</td><td>'+item.price+'</td><td>'+priority+'</td><td>'+item.description+'</td><td>'+item.days+ 'Days'+'</td><td>'+project_status+'</td></tr>';
                    });
                    $('#project_table').html(project);
                    $("#assign_div").show();
                    $("#display_title").show();
                    $("#display_title_member").show();
                }
            })
            $.ajax({
                type: "GET",
                url:"{{url('assign/project/member')}}"+"/"+id,
                dataType:"json",
                success:function(response){
                    var assign_member = '';
                    assign_member+='<tr><th>Branch</th><th>Employee Id</th><th>Team Member</th></tr>'
                    $.each(response, function (i, item) {
                        assign_member += '<tr><td>'+item.branch_name+'</td> <td>'+item.employeeId+'</td><td>'+item.emp_first_name+'</td></tr>';
                    });
                    $('#assign_table').html(assign_member);
                },
                error:function(response){
                    console.log(response);
                }
            })
        });


        //branch wise employee or team member ajax
        $("#branch_id").change(function(){
            var id = $("#branch_id").val();
            $.ajax({
                type: "GET",
                url:"{{url('branch/team/leader')}}"+"/"+id,
                dataType:"json",
                success:function(response){
                    var team_member = '';
                    team_member+='<option value="">Select Branch First</option>'
                    $.each(response, function (i, item) {
                        team_member += '<option value="'+item.emp_id+'">'+item.employeeId+' ('+ item.emp_first_name+')</option>';
                    });
                    $('#member_id').html(team_member);
                    $("#member_id").select2({
                        placeholder: "Select Member"
                    });
                }
            })
        });

        //project Assign
        $( "#project_assign_btn" ).click(function() {
            var _token = '{{ csrf_token() }}';
            var project_id = $("#project_id").val();
            var branch_id = $("#branch_id").val();
            var member_id = $("#member_id").val();
            $.ajax({
                url:"{{route('assign_project_store')}}",
                method:"post",
                data: {_token : _token, project_id : project_id, branch_id : branch_id,member_id:member_id},
                success:function (response) {
                    console.log(response);
                    if(response.success)
                    {
                        swal(response.success, "", "success");
                        setTimeout(function(){location.reload();},3000);
                    }
                    $("#assign_div").hide();
                    $("#display_title").hide();
                    $("#display_title_member").hide();
                    $("#project_table").hide();
                    $("#assign_table").hide();
                    $('#project_id').val('');

                    $("#project_id").select2({
                        placeholder: "Select Project",
                        allowClear: true
                    });
                }
            });
        });

        $("#project_id").select2();
        $("#branch_id").select2();
    </script>
@endsection

