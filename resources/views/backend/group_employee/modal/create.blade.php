<div id="employee_group" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content animated bounceInLeft">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><?php if(Lang::has('group_employee_create.add_new_group_employee')){ echo Lang::get('group_employee_create.add_new_group_employee'); }else{ echo "Add New Group Employee"; } ?></h4>
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
                    <form id="employee_group_modal_form">
                        @csrf
                    <div class="panel-body">
                        <!-- =============== Group Name ============= -->
                        <div class="form-group">
                            <label for="group_id"  class="control-label"><?php if(Lang::has('group_employee_create.group_name')){ echo Lang::get('group_employee_create.group_name'); }else{ echo "Group Name"; } ?></label>
                            <select class="form-control" name="group_id" id="group_id">
                             <option value=""><?php if(Lang::has('group_employee_create.select')){ echo Lang::get('group_employee_create.select'); }else{ echo "Select"; } ?></option>
                              @foreach ($group_name_table as $gname)
                            <option value="{{$gname->id}}">{{ $gname->group_name }}</option>
                              @endforeach
                         
                            </select>
                        </div> 
                        <!-- =============== End Group Name ============= -->

                        <!-- =============== Branch ============= -->
                        <div class="form-group">
                            <label for="department_name"><?php if(Lang::has('group_employee_create.select_branch')){ echo Lang::get('group_employee_create.select_branch'); }else{ echo "Select Branch"; } ?></label>
                            <select class="form-control" id="all_branch" name="all_branch">
                                <option value=""><?php if(Lang::has('group_employee_create.select')){ echo Lang::get('group_employee_create.select'); }else{ echo "Select"; } ?></option>
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


                        <!-- =============== Employee Name ============= -->
                        {{-- <div class="form-group">
                            <label for="employee_id"  class="control-label">Employee Name</label>
                            <select class="form-control" name="employee_id" id="employee_id">
                                
                              @foreach ($employeeName as $name)
                                <option value="{{$name->id}}">{{$name->emp_first_name}} {{$name->emp_lastName}}  ({{ $name->employeeId }})</option>
                              @endforeach
                         
                            </select>
                        </div>  --}}


                       
                            <div class="form-group">
                                <label for="department_name"> <?php if(Lang::has('group_employee_create.select_employee')){ echo Lang::get('group_employee_create.select_employee'); }else{ echo "Select Employee"; } ?><span style="color: red;">*</span></label>
                                <select class="form-control" id="employee_id" name="employee_id">
                                    <option value=""><?php if(Lang::has('group_employee_create.select_branch_first')){ echo Lang::get('group_employee_create.select_branch_first'); }else{ echo "Select Branch First"; } ?></option>
                                </select>
                            </div>

                        <!-- =============== End Employee Name ============= -->

                        <hr>
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal"><?php if(Lang::has('group_employee_create.close')){ echo Lang::get('group_employee_create.close'); }else{ echo "Close"; } ?></button>
                        <button type="button" class="btn btn-info pull-right" id="employee_group_add"><i class="fa fa-plus"></i> <?php if(Lang::has('group_employee_create.save')){ echo Lang::get('group_employee_create.save'); }else{ echo "Save"; } ?></button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

