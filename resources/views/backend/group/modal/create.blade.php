<div id="group" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content animated bounceInLeft">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add New Group</h4>
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
                    <form id="group_modal_form">
                        @csrf
                    <div class="panel-body">
                          <!-- =============== Group Name ============= -->

                        <div class="form-group">
                            <label for="group_name">Group Name <span style="color:red">*</span></label>
                            <input type="text" class="form-control" id="group_name" name="group_name" required autocomplete="off" placeholder="Group Name">
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
                            <label for="department_name">Select Group Leader <span style="color: red;">*</span></label>
                            <select class="form-control" id="group_leader_id" name="group_leader_id">
                                <option value="">Select Branch First</option>
                            </select>
                        </div>
                        <!-- =============== End Group Leader ============= -->

                        <!-- =============== Remarks ============= -->
                        
                        <div class="form-group">
                            <label for="remarks">Remarks</label>
                            <textarea id="remarks" placeholder="Remarks" name="remarks" cols="5" rows="5" class="form-control" autocomplete="off"></textarea>
                        </div>
                        <!-- =============== End Remarks ============= -->

                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-info pull-right" id="gropu_add"><i class="fa fa-save"></i> Save</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>




 