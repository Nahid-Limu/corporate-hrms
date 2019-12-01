<div id="employee_assets" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content animated bounceInLeft">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add New Employee Assets</h4>
            </div>
            <div class="modal-body">
                    <!-- Error list Start -->
                    <span id="form_result"></span>
                    @if ($errors->any())
                    <div id="alert_message" class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    <!-- Error list End -->
                <div class="panel panel-default">
                    <form id="employee_assets_modal_form" onkeydown="return event.key != 'Enter';">
                        @csrf
                    <div class="panel-body">
                          <!-- =============== Group Name ============= -->

                        <div class="form-group">
                            <label for="assets_name">Assets Name <span style="color:red">*</span></label>
                            <input type="text" class="form-control" id="assets_name" name="assets_name" required autocomplete="off" placeholder="Assets Name">
                        </div> 
                          <!-- =============== End Group Name ============= -->  


                        <!-- =============== Branch ============= -->
                        <div class="form-group">
                            <label for="department_name">Select Branch</label>
                            <select class="form-control" id="all_branch" name="all_branch">
                                <option value="">Select</option>
                                @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('super-admin'))
                                @foreach($branch_list as $branchs)
                                <option value="{{$branchs->id}}">{{$branchs->branch_name}}</option>
                                @endforeach
                                @else 
                                 <option value="{{$branch_list2->id}}">{{$branch_list2->branch_name}}</option>
                                @endif
                            </select>
                        </div> 

                        <!-- =============== End Branch ============= -->


                        <!-- =============== Group Leader ============= -->

                        {{-- <div class="form-group">
                            <label for="group_leader_id"  class="control-label">Group Leader</label>
                            <select class="form-control" name="group_leader_id" id="group_leader_id">
                                
                              @foreach ($group_leader as $name)
                            <option value="{{$name->id}}">{{$name->emp_first_name}} {{$name->emp_lastName}} ({{$name->employeeId}})</option>
                              @endforeach
                         
                            </select>
                        </div>  --}} 

                         <div class="form-group">
                            <label for="emp_id">Select Employee  <span style="color: red;">*</span></label>
                            <select class="form-control" id="emp_id" name="emp_id">
                                <option value="">Select Branch First</option>
                            </select>
                        </div>
                        <!-- =============== End Group Leader ============= -->


                        <div class="form-group">
                           
                             <label for="assets_date"> Date <span style="color: red;">*</span> </label>
                                <input type="date" placeholder="Date" class="form-control" id="assets_date" name="assets_date" autocomplete="off">
                        </div> 

                          <div class="form-group">
                                <label for="start_time">Start Time</label>
                                <div class='input-group datetimepicker-disable-date date'  id='start_time_t' >
                                    <input type='text' placeholder="Start Time" class="form-control" id="start_time" name="start_time" >
                                    <span class="input-group-addon">
                                        <span class="fa fa-clock-o"></span>
                                    </span>
                                </div>
                            </div>
                            <br><br>
                            <div class="form-group">
                                <label for="end_time">End Time</label>
                                <div class='input-group datetimepicker-disable-date date'  id='end_time_t' >
                                    <input type='text' placeholder="End Time" class="form-control" id="end_time" name="end_time" >
                                    <span class="input-group-addon">
                                        <span class="fa fa-clock-o"></span>
                                    </span>
                                </div>
                            </div>
                              <br><br>

                        <!-- =============== Remarks ============= -->
                        
                        <div class="form-group">
                            <label for="remarks">Remarks</label>
                            <textarea id="remarks" placeholder="Remarks" name="remarks" cols="5" rows="5" class="form-control" autocomplete="off"></textarea>
                        </div>
                        <!-- =============== End Remarks ============= -->
                        <hr>
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-info pull-right" id="employee_assets_add"><i class="fa fa-save"></i> Save</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>




 