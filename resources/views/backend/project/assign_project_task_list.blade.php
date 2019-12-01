@extends('layout.master')
@section('content')
    <!--BEGIN TITLE & BREADCRUMB PAGE-->
    <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
        <div class="page-header pull-left">
            <div class="page-title">Task List</div>
        </div>
        <ol class="breadcrumb page-breadcrumb pull-right">
            <li><i class="fa fa-home"></i>&nbsp;<a href="{{url('/')}}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
            <li><a href="#">Task List</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
            <li class="active">Task List</li>
        </ol>
        <div class="clearfix"></div>
    </div>
    <!--END TITLE & BREADCRUMB PAGE-->
    <!--Flash Message Start-->
    @if(Session::has('success'))
        <p id="alert_message" class="alert alert-success">{{ Session::get('success') }}</p>
    @endif
    <!--Flash Message End-->
    <div class="page-content">
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-blue">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-md-6">
                                    Task List
                            </div>
                        </div>
                    </div>
                    <div class="panel-body table-responsive">
                        <table id="task_table" class="table table-striped table-bordered" >
                            <thead>
                            <tr>
                                <th>SN</th>
                                <th>Task</th>
                                <th>Description</th>
                                <th>Due Date</th>
                                <th>Deadline</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                                 @php
                                    $order=0;
                                 @endphp
                                 @foreach($task as $tasks)
                                 @php
                                    $order++;
                                    $due_date=$tasks->due_date;
                                    $date1=date_create($due_date);
                                    $date2=date_create(date('Y-m-d'));
                                    $diff=date_diff($date1,$date2);
                                 @endphp
                                <tr>
                                    <td>{{$order}}</td>
                                    <td>{{$tasks->task_title}}</td>
                                    <td>{{$tasks->task_description}}</td>
                                    <td>{{date('F-d-Y',strtotime($tasks->due_date))}}</td>
                                    <td>
                                        @if(date('Y-m-d')>$due_date)
                                        0 Days
                                        @else
                                        {{$diff->format("%a Days")}}
                                        @endif
                                    </td>
                                    <td>@if($tasks->status==0) <span style="color:red">Pending</span> @else <span style="color:green">Complete</span>  @endif</td>
                                <td><button  data-toggle="modal" data-target="#{{$tasks->main_id}}" type="button" class="btn btn-success btn-xs"><i class="fa fa-pencil"></i></button></td>
                                </tr>
                                    <!-- task edit Modal -->
                                    <div class="modal fade" id="{{$tasks->main_id}}" role="dialog">
                                            <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                <h4 class="modal-title">Task Update</h4>
                                                </div>
                                                <div class="modal-body">
                                                  <form method="POST" action="{{url('project/employee/task/status/update')}}">
                                                    @csrf
                                                  <div class="form-group">
                                                   <label>Status</label>
                                                   <select class="form-control" name="task_status">
                                                       <option value="1">Complete</option>
                                                   </select>
                                                  </div>
                                                </div>
                                                <input type="hidden" name="task_id" value="{{$tasks->main_id}}">
                                                <div class="modal-footer">
                                                <button type="submit" class="btn btn-success"><i class="fa fa-check"></i> Update</button>
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                </div>
                                               </form>
                                            </div>
                                            </div>
                                        </div>
                                     <!-- task edit Modal -->
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
$('#task_table').DataTable();
$("#alert_message").fadeTo(1000, 500).slideUp(500, function(){
            $("#alert_message").alert('close');
      });
</script>
@endsection


