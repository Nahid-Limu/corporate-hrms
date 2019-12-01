<div id="createTraining" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><i class="fa fa-plus"></i> Add New Training</h4>
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
                    <form method="post" id="training_modal_form" enctype="multipart/form-data">
                        @csrf
                        <div class="panel-body">

                               <div class="col-md-6">
                                    <div class="form-group">
                                            <label for="department_name">Select Branch <span style="color: red;">*</span> </label>
                                            <select class="form-control" id="branch_id" name="branch_id" required>
                                                <option value="">Select Branch</option>
                                                @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('super-admin'))
                                                @foreach($branch as $branches)
                                                  <option value="{{$branches->id}}">{{$branches->branch_name}}</option>
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
                                    <input type="text" class="form-control" id="training_name" name="training_name" autocomplete="off">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="department_name">Duration <span style="color: red;">*</span></label>
                                    <input type="number" class="form-control" id="duration" name="duration" autocomplete="off">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="department_name">Start Date <span style="color: red;">*</span> </label>
                                    <input type="date" class="form-control" id="training_start" name="training_start" autocomplete="off">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="department_name">End Date <span style="color: red;">*</span> </label>
                                    <input type="date" class="form-control" id="training_end" name="training_end" autocomplete="off">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="remarks">Attachment <span style="color: red;">*</span></label>
                                    <input type="file" class="form-control" id="training_attachment" name="training_attachment">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="department_name">Institution <span style="color: red;">*</span> </label>
                                    <input type="text" class="form-control" id="training_institution" name="training_institution" autocomplete="off">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="department_name">Month <span style="color: red;">*</span> </label>
                                    <input type="date" class="form-control" id="training_month" name="training_month" autocomplete="off">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="remarks">Description <span style="color: red;">*</span></label>
                                    <textarea id="description" name="description" cols="5" rows="5" class="form-control" autocomplete="off"></textarea>
                                </div>
                            </div>


                            <div class="col-md-12">
                                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-info pull-right" id="training_add"><i class="fa fa-plus"></i> Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


