<div id="editGroup" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Edit Group</h4>
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
                    <form id="edit_group_modal_form">
                        @csrf
                    <div class="panel-body"> 
                        <!-- =============== Group Name ============= -->
                        <div class="form-group">
                            <label for="edit_group_name">Group Name</label>
                            <input type="text" placeholder="Group Name" class="form-control" id="edit_group_name" name="edit_group_name" required autocomplete="off">
                        </div>
                        <!-- =============== End  Group Name ============= -->

                        <!-- =============== Remarks ============= -->
                        <div class="form-group">
                            <label for="edit_remarks">Remarks</label>
                            <textarea id="edit_remarks" placeholder="Remarks" name="edit_remarks" cols="5" rows="5" class="form-control" autocomplete="off"></textarea>
                        </div>
                        <!-- =============== End Remarks ============= --> 

                        
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
                        {{-- <div class="form-group">
                            <label for="department_name">Select Branch</label>
                            <select class="form-control" id="edit_all_branch" name="edit_all_branch">
                               
                            </select>
                        </div>  --}}

                        <!-- =============== End Branch ============= -->

                        <!-- =============== Group Leader ============= -->

                        <div class="form-group">
                            <label for="edit_group_leader_id"  class="control-label">Group Leader</label>
                            <select class="form-control" name="edit_group_leader_id" id="edit_group_leader_id">
                            </select>
                        </div> 

                        <!-- =============== End Group Leader ============= -->

                        <!-- =============== Status ============= -->
                        <div class="form-group">
                            <label for="status"  class="col-md-4 control-label">Status</label>
                            <select class="form-control" name="status" id="status">
                                <option value="1" style="color:green">Active</option>
                                <option value="0" style="color:red">Inactive</option>
                            </select>
                        </div> 
                        <!-- =============== End  Status ============= -->
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

