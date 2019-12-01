<div id="editBenefit" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Edit Benefit</h4>
            </div>
            <div class="modal-body">
                    <!-- Error list Start -->
                    <span id="edit_form_result"></span>
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
                    <form id="edit_benefit_modal_form" onkeydown="return event.key != 'Enter';">
                        @csrf
                    <div class="panel-body">
                        <div class="form-group">
                            <label for="edit_benefit_name">Benefit Name</label>
                            <input type="text" class="form-control" id="edit_benefit_name" name="edit_benefit_name" required autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label for="edit_remarks">Remarks</label>
                            <textarea id="edit_remarks" name="edit_remarks" cols="5" rows="5" class="form-control" autocomplete="off"></textarea>
                        </div> 


                           <!-- =============== Branch ============= -->
                        <div class="form-group">
                            <label for="department_name">Select Branch</label>
                            <select class="form-control" id="edit_all_branch" name="edit_all_branch">
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
                                {{-- <select class="form-control" id="edit_emp_id" name="edit_emp_id">
                                @foreach($employee_list as $name)
                                    <option value="{{$name->id}}">{{$name->emp_first_name}}</option>
                                @endforeach
                            </select> --}} 

                            <select id="edit_emp_id" name="edit_emp_id"  class="form-control">
                                    <option value=''>-- Select Employee--</option>
                                    
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="status"  class="control-label">Status</label>
                            <select class="form-control" name="status" id="status">
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                        <br>
                        <input type="hidden" name="id" id="id">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-info pull-right" id="group_update"><i class="fa fa-refresh"></i> Update</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

