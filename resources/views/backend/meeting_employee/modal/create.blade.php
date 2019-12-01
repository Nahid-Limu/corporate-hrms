<div id="meeting_employee" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content animated bounceInLeft">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add New  Meeting Employee</h4>
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
                    <form id="meeting_employee_modal_form">
                        @csrf
                    <div class="panel-body">
                        <!-- =============== Group Name ============= -->
                        <div class="form-group">
                            <label for="meeting_id"  class="control-label">Select meeting <span style="color: red;">*</span></label>
                           
                            <select class="form-control" name="meeting_id" id="meeting_id">
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
                            <div class="form-group">
                                <label for="department_name">Select Employee <span style="color: red;">*</span></label>
                                <select class="form-control" id="emp_id" name="emp_id[]" multiple>
                                    <option value="">Select Branch First</option>
                                </select>
                            </div>  


                             {{-- <div class="form-group">
                                <label for="remarks">Remarks</label>
                                <textarea id="remarks" placeholder="Remarks" name="remarks" cols="5" rows="5" class="form-control" autocomplete="off"></textarea>
                            </div> --}}

                        <!-- =============== End Employee Name ============= -->


                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-info pull-right" id="meeting_employee_add"><i class="fa fa-save"></i> Save</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

