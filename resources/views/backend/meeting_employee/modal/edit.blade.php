<div id="edit_meeting_employee" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content animated bounceInLeft">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Edit Meeting Employee</h4>
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

                    {{-- bb --}}
                    <!-- Error list End -->
                <div class="panel panel-default">
                    <form id="edit_meeting_employee_modal_form">
                        @csrf
                    <div class="panel-body">
                        <!-- =============== Group Name ============= -->
                        <div class="form-group">
                            <label for="edit_meeting_id"  class="control-label">Select metting <span style="color: red;">*</span></label>
                           
                            <select class="form-control" name="edit_meeting_id" id="edit_meeting_id">
                                  <option value="">Select</option>
                              @foreach ($smeetingNmae as $mname)
                            <option value="{{$mname->id}}">{{ $mname->meeting_subject }}</option>
                              @endforeach
                         
                            </select>
                        </div> 
                        <!-- =============== End Group Name ============= -->

                        <!-- =============== Branch ============= -->
                        <div class="form-group">
                            <label for="department_name">Select Branch</label>
                            <select class="form-control" id="editall_branch" name="editall_branch">
                                @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('super-admin'))
                                <option value="">Select</option>
                                @foreach($branch_list as $branchs)
                                <option value="{{$branchs->id}}">{{$branchs->branch_name}}</option>
                                @endforeach
                                @else 
                                  <option value="{{$branch_list2->id}}">{{$branch_list2->branch_name}}</option>
                                @endif
                            </select>
                        </div> 

                        <!-- =============== End Branch ============= -->               
                            <div class="form-group">
                                <label for="edit_emp_id">Select Employee <span style="color: red;">*</span></label>
                                <select class="form-control" id="edit_emp_id" name="edit_emp_id">
                                    <option value="">Select Branch First</option>
                                </select>
                            </div>  


                        <!-- =============== Status ============= -->
                        <div class="form-group">
                            <label for="status"  class="control-label">Status</label>
                            <select class="form-control" name="status" id="status">
                                <option value="1" style="color:green">Active</option>
                                <option value="0" style="color:red">Inactive</option>
                            </select>
                        </div> 
                        <!-- =============== End  Status ============= -->
                        <br>
                        <input type="hidden" name="id" id="id">

                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-info pull-right" id="meeting_employee_update"><i class="fa fa-refresh"></i> Save</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

