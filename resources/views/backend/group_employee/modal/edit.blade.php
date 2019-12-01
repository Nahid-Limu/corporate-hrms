<div id="editEmployee_group" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><?php if(Lang::has('group_employee_edit.edit_group_employee')){ echo Lang::get('group_employee_edit.edit_group_employee'); }else{ echo "Edit Group Employee"; } ?></h4>
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
                            <label for="edit_group_id"  class="control-label"><?php if(Lang::has('group_employee_edit.group_name')){ echo Lang::get('group_employee_edit.group_name'); }else{ echo "Group Name"; } ?> </label>
                            <select class="form-control" name="edit_group_id" id="edit_group_id">    
                              @foreach ($group_name_table as $gname)
                                <option value="{{$gname->id}}">{{ $gname->group_name }}</option>
                              @endforeach
                         
                            </select>
                        </div>
                        <!-- =============== End Group Name ============= -->


                     

                        <div class="form-group">
                            <label for="department_name"><?php if(Lang::has('group_employee_edit.select_branch')){ echo Lang::get('group_employee_edit.select_branch'); }else{ echo "Select Branch"; } ?></label>
                            <select class="form-control" id="edit_all_branch" name="all_branch" disabled>

                                @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('super-admin')))
                                <option value="">Select</option>
                                @foreach($branch_list as $branchs)
                                <option value="{{$branchs->id}}">{{$branchs->branch_name}}</option>
                                @endforeach
                                @else 
                                 <option value="{{$branch_list2->id}}">{{$branch_list2->branch_name}}</option>
                                @endif
                            </select>
                        </div> 

                        <!-- =============== Employee Name ============= -->

       

                           <div class="form-group">
                            <label for="edit_employee_id"  class="control-label"><?php if(Lang::has('group_employee_edit.select_employee')){ echo Lang::get('group_employee_edit.select_employee'); }else{ echo "Employee Name"; } ?></label>
                            <select class="form-control" name="edit_employee_id" id="edit_employee_id">
                            </select>
                        </div> 

                        <!-- =============== End Employee Name ============= -->

                      
                        <br>
                        <input type="hidden" name="id" id="id">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal"><?php if(Lang::has('group_employee_edit.close')){ echo Lang::get('group_employee_edit.close'); }else{ echo "Close"; } ?></button>
                        <button type="button" class="btn btn-info pull-right" id="group_employee_update"><i class="fa fa-plus"></i><?php if(Lang::has('group_employee_edit.update')){ echo Lang::get('group_employee_edit.update'); }else{ echo "Update"; } ?></button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

