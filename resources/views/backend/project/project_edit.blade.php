<div id="editProject" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><i class="fa fa-pencil"></i> Edit Project</h4>
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
                    <form method="post" id="edit_project_modal_form" enctype="multipart/form-data">
                        @csrf
                        <div class="panel-body">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="department_name">Project Name <span style="color: red;">*</span> </label>
                                    <input type="text" class="form-control" id="edit_project_name" name="project_name" autocomplete="off">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="department_name">Select Branch</label>
                                    <select class="form-control" id="edit_all_branch" name="all_branch">
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
                            </div>


                            <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="department_name">Select Client <span style="color: red;">*</span></label>
                                        <select class="form-control" id="edit_client_id" name="client_name">
                                            <option value="">Select Branch First</option>
                                        </select>
                                    </div>
                                </div>


                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="department_name">Select Team Leader <span style="color: red;">*</span></label>
                                    <select class="form-control" id="edit_team_leader" name="team_leader">
                                        <option value="">Select Branch First</option>
                                    </select>
                                </div>
                            </div>


                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="department_name">Start Date <span style="color: red;">*</span> </label>
                                    <input type="date" class="form-control" id="edit_start_date" name="start_date" autocomplete="off">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="department_name">End Date <span style="color: red;">*</span> </label>
                                    <input type="date" class="form-control" id="edit_end_date" name="end_date" autocomplete="off">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="department_name">Price <span style="color: red;">*</span> </label>
                                    <input type="number" class="form-control" id="edit_price" name="price" autocomplete="off">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="department_name">Priority <span style="color: red;">*</span> </label>
                                    <select class="form-control"  id="edit_priority" name="priority">
                                        <option value="">Select</option>
                                        <option value="1">High</option>
                                        <option value="0">Low</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="remarks">Attachment </label>
                                    <input type="file" class="form-control" id="attachment" name="attachment">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="department_name">Status </label>
                                    <select class="form-control"  id="project_status" name="project_status">
                                        <option value="">Select</option>
                                        <option value="0">Pending</option>
                                        <option value="1">Approved</option>
                                        <option value="2">Running</option>
                                        <option value="3">Completed</option>
                                        <option value="4">Delivered</option>
                                        <option value="5">Rejected</option>
                                        <option value="6">Cancel</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="remarks">Description <span style="color: red;">*</span></label>
                                    <textarea id="edit_description" name="description" cols="5" rows="5" class="form-control" autocomplete="off"></textarea>
                                </div>
                            </div>
                            <input type="hidden" name="id" id="id">
                            <input type="hidden" name="attachment_default" id="attachment_default">
                            <div class="col-md-12">
                                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-info pull-right" id="project_update"><i class="fa fa-plus"></i> Update</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


