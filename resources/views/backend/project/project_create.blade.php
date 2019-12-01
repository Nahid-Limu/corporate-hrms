<div id="createProject" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><i class="fa fa-plus"></i> Add New Project</h4>
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
                    <form method="post" id="project_modal_form" enctype="multipart/form-data">
                        @csrf
                        <div class="panel-body">

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="department_name">Project Name <span style="color: red;">*</span> </label>
                                    <input type="text" class="form-control" id="project_name" name="project_name" autocomplete="off" placeholder="Project Name">
                                </div>
                            </div>

                            <div class="col-md-6">
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
                                </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="department_name">Select Client <span style="color: red;">*</span></label>
                                    <select class="form-control" id="clients_id" name="client_name">
                                            <option value="">Select Branch First</option>
                                    </select>
                                </div>
                            </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="department_name">Select Team Leader <span style="color: red;">*</span></label>
                                        <select class="form-control" id="team_leader" name="team_leader">
                                            <option value="">Select Branch First</option>
                                        </select>
                                    </div>
                                </div>


                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="department_name">Start Date <span style="color: red;">*</span> </label>
                                    <input type="date" class="form-control" id="start_date" name="start_date" autocomplete="off">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="department_name">End Date <span style="color: red;">*</span> </label>
                                    <input type="date" class="form-control" id="end_date" name="end_date" autocomplete="off">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="department_name">Price <span style="color: red;">*</span> </label>
                                    <input type="number" class="form-control" id="price" name="price" autocomplete="off" placeholder="Price">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="department_name">Priority <span style="color: red;">*</span> </label>
                                    <select class="form-control"  id="priority" name="priority">
                                        <option value="">Select</option>
                                        <option value="1">High</option>
                                        <option value="0">Low</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="remarks">Attachment <span style="color: red;">*</span></label>
                                    <input type="file" class="form-control" id="attachment" name="attachment">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="remarks">Description <span style="color: red;">*</span></label>
                                    <textarea id="description" name="description" cols="5" rows="5" class="form-control" autocomplete="off" placeholder="Description"></textarea>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-info pull-right" id="project_add"><i class="fa fa-plus"></i> Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


