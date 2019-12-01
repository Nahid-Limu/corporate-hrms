@extends('layout.master')
@section('title', 'Add New Task')
@section('content')
<link href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round" rel="stylesheet">
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<style type="text/css">

	.modal-confirm {
		color: #636363;
		width: 400px;
	}
	.modal-confirm .modal-content {
		padding: 20px;
		border-radius: 5px;
		border: none;
        text-align: center;
		font-size: 14px;
	}
	.modal-confirm .modal-header {
		border-bottom: none;
        position: relative;
	}
	.modal-confirm h4 {
		text-align: center;
		font-size: 26px;
		margin: 30px 0 -10px;
	}
	.modal-confirm .close {
        position: absolute;
		top: -5px;
		right: -2px;
	}
	.modal-confirm .modal-body {
		color: #999;
	}
	.modal-confirm .modal-footer {
		border: none;
		text-align: center;
		border-radius: 5px;
		font-size: 13px;
		padding: 10px 15px 25px;
	}
	.modal-confirm .modal-footer a {
		color: #999;
	}
	.modal-confirm .icon-box {
		width: 80px;
		height: 80px;
		margin: 0 auto;
		border-radius: 50%;
		z-index: 9;
		text-align: center;
		border: 3px solid #f15e5e;
	}
	.modal-confirm .icon-box i {
		color: #f15e5e;
		font-size: 46px;
		display: inline-block;
		margin-top: 13px;
	}
    .modal-confirm .btn {
        color: #fff;
        border-radius: 4px;
		background: #60c7c1;
		text-decoration: none;
		transition: all 0.4s;
        line-height: normal;
		min-width: 120px;
        border: none;
		min-height: 40px;
		border-radius: 3px;
		margin: 0 5px;
		outline: none !important;
    }
	.modal-confirm .btn-info {
        background: #c1c1c1;
    }
    .modal-confirm .btn-info:hover, .modal-confirm .btn-info:focus {
        background: #a8a8a8;
    }
    .modal-confirm .btn-danger {
        background: #f15e5e;
    }
    .modal-confirm .btn-danger:hover, .modal-confirm .btn-danger:focus {
        background: #ee3535;
    }
	.trigger-btn {
		display: inline-block;
		margin: 100px auto;
	}
</style>
    <div class="page-content">
        @if(Session::has('success'))
            <p id="alert_message" class="alert alert-success">{{ Session::get('success') }}</p>
        @endif
        @if(Session::has('error'))
        <p id="alert_message" class="alert alert-danger">{{ Session::get('error') }}</p>
        @endif
        <div class="panel panel-default">
            <div class="panel-heading"><i class="fa fa-plus"></i> Add New Task</div>
            <div class="panel-body">
                {!! Form::open(['method'=>'post', 'route'=>['project_task_store']]) !!}
                <div class="col-md-12">
                    <table class="table table-bordered table-responsive">
                        <thead>
                        <tr>
                            <th>Task Title</th>
                            <th>Description</th>
                            <th>Due Date</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>
                              <div class="form-group">
                                  <input type="text" class="form-control" name="task_title[]" autocomplete="off" placeholder="Task Title" required>
                              </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <textarea class="form-control" name="task_description[]" autocomplete="off" placeholder="Task Description" required></textarea>
                                 </div>
                            </td>
                            <td>
                               <input type="date" class="form-control" name="task_due_date[]" autocomplete="off" required>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <div class="append_div"></div>
                    <button id="process_btn" type="button" class="btn btn-primary btn-sm"><i class="fa fa-plus"> Add More</i> </button>
                    <button type="Submit" id="add_employee_btn" class="btn btn-success"> <i class="fa fa-check"></i> Assign task</button>
                </div>

                <input id="pro_id" type="hidden" name="project_id" value="{{$projectid}}">
                <input id="mem_id" type="hidden" name="emp_id" value="{{$employee->emp_id}}">

                {!! Form::close() !!}
                <div class="col-md-12">
                            <div class="table-responsive">
                                    <table id="task_exists_table" class="table table-bordered table-responsive">
                                            <thead>
                                            <tr>
                                                <th>Project</th>
                                                <th>Employee</th>
                                                <th>Title</th>
                                                <th>Description</th>
                                                <th>Due Date</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($employee_task as $task)
                                            <tr>
                                               <td>{{$task->project_name}}</td>
                                                <td>({{$task->employeeId}}){{$task->emp_first_name}}{{$task->emp_lastName}}</td>
                                                <td>{{$task->task_title}}</td>
                                                <td>{{$task->task_description}}</td>
                                                <td>{{date('F-d-Y',strtotime($task->due_date))}}</td>
                                                <td>@if($task->task_status==0)<span style="color:red">Pending </span> @else <span style="color:green">Complete</span>  @endif</td>
                                                 <td>
                                                 <button type="button" data-toggle="modal" data-target="#{{$task->main_id}}" class="btn btn-warning btn-sm"><i class="fa fa-pencil"></i></button>
                                                 <button type="button" data-toggle="modal" data-target="#delete_task{{$task->main_id}}" class="btn btn-danger btn-sm"><i class="fa fa-trash-o"></i></button>
                                                 </td>
                                               </td>
                                            </tr>
                                         <!--Task edit  Modal content-->
                                         <div id="{{$task->main_id}}" class="modal fade" role="dialog">
                                                <div class="modal-dialog">
                                                <form method="post" action="{{url('project/assign/task/update/')}}">
                                                    @csrf
                                                  <div class="modal-content">
                                                    <div class="modal-header">
                                                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                      <h4 class="modal-title"><i class="fa fa-pencil"></i> Edit Task Information</h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label>Task Title</label>
                                                            <input type="text" class="form-control" name="task_title" autocomplete="off" placeholder="Task Title" value="{{$task->task_title}}" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Task Description</label>
                                                            <textarea class="form-control" name="task_description" autocomplete="off" placeholder="Task Description"  required>{{$task->task_description}}</textarea>
                                                        </div>
                                                        <div class="form-group">
                                                           <label>Due Date</label>
                                                           <input type="date" class="form-control" name="task_due_date" value="{{$task->due_date}}" autocomplete="off" required>
                                                        </div>
                                                       <input type="hidden" name="task_edit_id" value="{{$task->main_id}}">
                                                        <div class="modal-footer">
                                                        <button type="submit" class="btn btn-success"><i class="fa fa-check"></i> Update</button>
                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                  </form>
                                                </div>
												</div>
												</div>
                                          <!--Task edit  Modal content-->

                                            <!-- task delete Modal -->
                                          <div class="modal fade" id="delete_task{{$task->main_id}}" role="dialog">
                                                <div class="modal-dialog modal-confirm">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                            <div class="icon-box">
                                                                    <i class="material-icons">&#xE5CD;</i>
                                                                </div>
                                                                <h4 class="modal-title">Are you sure?</h4>
                                                    </div>
                                                    <div class="modal-body">
                                                            <p>Do you really want to delete these records?</p>
                                                    </div>
                                                    <form method="post" action="{{url('project/assign/task/delete')}}">
                                                        @csrf
                                                    <input type="hidden" name="task_delete_id" value="{{$task->main_id}}">
                                                    <div class="modal-footer">
                                                            <button type="submit" class="btn btn-danger">Delete</button>
                                                            <button type="button" class="btn btn-info" data-dismiss="modal">Cancel</button>
                                                    </div>
                                                  </form>
                                                </div>
                                                </div>
                                            </div>

                                         <!--  task delete Modal-->
                                            @endforeach
                                            </tbody>
                                        </table>
                                  </div>
                            </div>
                      </div>
                </div>
          </div>
@endsection

@section('extra_js')
    <script>
      $("#emp_id").select2();
      $("#process_btn").click(function(){
          $(".append_div").append("<table id='r_table' class='table table-bordered table-responsive'> <thead> <tr> <th>Task Title</th> <th>Description</th> <th>Due Date</th><th>Action</th> </tr> </thead> <tbody> <tr> <td> <div class='form-group'><input type='text' class='form-control' name='task_title[]' autocomplete='off' placeholder='Task Title' required></div></td> <td> <div class='form-group'><textarea class='form-control' name='task_description[]' autocomplete='off' placeholder='Task Description' required></textarea></div></td> <td><input type='date' class='form-control' name='task_due_date[]' autocomplete='off' required></td> <td><button type='button' id='remCF' class='btn btn-danger btn-sm'><i class='fa fa-times'></button></td> </tr></tbody></table>");
      });
      $(".append_div").on('click','#remCF',function(){
          $(this).parents("tr").remove();
      });
      $("#alert_message").fadeTo(1000, 500).slideUp(500, function(){
            $("#alert_message").alert('close');
      });
      $('#task_exists_table').DataTable({});
    </script>
@endsection

