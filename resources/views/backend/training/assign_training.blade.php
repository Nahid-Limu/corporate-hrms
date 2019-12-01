@extends('layout.master')
@section('content')
    <!--BEGIN TITLE & BREADCRUMB PAGE-->
    <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
        <div class="page-header pull-left">
            <div class="page-title">Training</div>
        </div>
        <ol class="breadcrumb page-breadcrumb pull-right">
            <li><i class="fa fa-home"></i>&nbsp;<a href="{{url('/')}}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
            <li><a href="">Training</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
            <li class="active">Assign Training</li>
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
                                Assign Training
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Select</label>
                                <select class="form-control" id="project_id" nae="project_id">
                                    <option value="">Select Training</option>
                                    @foreach($training as $trainings)
                                        <option value="{{$trainings->id}}">{{$trainings->training_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <h4 style="display: none" id="display_title" class="text-center">Training Details</h4>
                            <div class="table-responsive">
                                <table id="project_table" class="table table-striped table-bordered table-hover">
                                    <thead>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                            <h4 style="display: none" id="display_title_member" class="text-center">Assign Employee</h4>
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
                                        <select class="form-control" id="branch_id" name="branch_id">
                                            <option value="">Select</option>
                                                @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('super-admin'))
                                            @foreach($branch as $branchs)
                                                <option value="{{$branchs->id}}">{{$branchs->branch_name}}</option>
                                            @endforeach
                                            @else 
                                                <option value="{{$branch_list2->id}}">{{$branch_list2->branch_name}}</option>
                                            @endif
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Select Employee</label>
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
                url:"{{url('training/details')}}"+"/"+id,
                dataType:"json",
                success:function(response){
                    var project = '';
                    project+='<tr><th>Branch</th><th>Training</th><th>Duration</th><th>Start Date</th><th>End Date</th><th>Institution</th><th>Description</th> <th>Month</th> <th>Created By</th> <th>Status</th></tr>'
                    $.each(response, function (i, item) {
                        if(item.status==1){
                            var priority='Active'
                        }
                        project += '<tr><td>'+item.branch_name+'</td><td>'+item.training_name+'</td><td>'+item.duration+'</td><td>'+item.training_start+'</td><td>'+item.training_end+'</td><td>'+item.training_institution+'</td><td>'+item.description+'</td><td>'+item.training_month+'</td><td>'+item.name+'</td><td>'+priority+'</td></tr>';
                    });
                    $('#project_table').html(project);
                    $("#assign_div").show();
                    $("#display_title").show();
                    $("#display_title_member").show();
                }
            })
            $.ajax({
                type: "GET",
                url:"{{url('assign/member')}}"+"/"+id,
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
                        team_member += '<option value="'+item.emp_id+'">'+item.employeeId+ item.emp_first_name+'</option>';
                    });
                    $('#member_id').html(team_member);
                    $("#member_id").select2({
                        placeholder: "Select Employee"
                    });
                }
            })
        });

        //Meeting Assign
        $( "#project_assign_btn" ).click(function() {
            var _token = '{{ csrf_token() }}';
            var project_id = $("#project_id").val();
            var branch_id = $("#branch_id").val();
            var member_id = $("#member_id").val();
            $.ajax({
                url:"{{route('assign_member_store')}}",
                method:"post",
                data: {_token : _token, project_id : project_id, branch_id : branch_id,member_id:member_id},
                success:function (response) {
                    if(response.success)
                    {
                        swal(response.success, "", "success");
                    }
                    $("#assign_div").hide();
                    $("#display_title").hide();
                    $("#display_title_member").hide();
                    $("#project_table").hide();
                    $("#assign_table").hide();
                    setTimeout(function(){location.reload();},3000);
                },
                error:function(response){
                    console.log(response);
                }
            });
        });

        $("#project_id").select2();
        $("#branch_id").select2();
    </script>
@endsection

