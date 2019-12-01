<div id="editTraining" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><i class="fa fa-plus"></i> Edit Training</h4>
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
                    <form method="post" id="edit_training_modal_form" enctype="multipart/form-data">
                        @csrf
                        <div class="panel-body">

						 <div class="col-md-6">
                                <div class="form-group">
                                        <label for="edit_branch">Select Branch<span style="color: red;">*</span> </label>
                                        <select name="edit_branch" id="edit_branch"  class="select2-container form-control" required>
                                            @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('super-admin'))                                            
                                            <option value="">Select Branch</option>
                                            @foreach($branch as $branchs)
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
                                    <label for="department_name">Training Name <span style="color: red;">*</span> </label>
                                    <input type="text" class="form-control" id="edit_training_name" name="training_name" autocomplete="off">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="department_name">Duration <span style="color: red;">*</span></label>
                                    <input type="number" class="form-control" id="edit_duration" name="duration" autocomplete="off">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="department_name">Start Date <span style="color: red;">*</span> </label>
                                    <input type="date" class="form-control" id="edit_training_start" name="training_start" autocomplete="off">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="department_name">End Date <span style="color: red;">*</span> </label>
                                    <input type="date" class="form-control" id="edit_training_end" name="training_end" autocomplete="off">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="remarks">Attachment</label>
                                    <input type="file" class="form-control" id="training_attachment" name="training_attachment">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="department_name">Institution <span style="color: red;">*</span> </label>
                                    <input type="text" class="form-control" id="edit_training_institution" name="training_institution" autocomplete="off">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="department_name">Month <span style="color: red;">*</span> </label>
                                    <input type="date" class="form-control" id="edit_training_month" name="training_month" autocomplete="off">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="department_name">Status </label>
                                    <select class="form-control" id="edit_training_status" name="training_status">
                                        <option value="1">Active</option>
                                        <option value="0">Inactive</option>
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
                                <button type="submit" class="btn btn-info pull-right" id="training_edit"><i class="fa fa-plus"></i> Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


