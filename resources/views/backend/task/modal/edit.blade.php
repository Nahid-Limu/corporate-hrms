<div id="editTask" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Edit Task</h4>
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
                        <form method="post" id="edit_task_modal_form" enctype="multipart/form-data">
                            @csrf
                        <div class="panel-body">
                            <div class="form-group">
                                <label for="edit_title">Titile</label>
                                <input type="text" class="form-control" id="edit_title" name="edit_title"  autocomplete="off">
                            </div>
                            <div class="form-group">
                                <label for="edit_description">Description</label>
                                <textarea id="edit_description" name="edit_description" cols="5" rows="3" class="form-control" autocomplete="off"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="edit_attachment">Attachment</label>
                                <input type="file" class="form-control" id="edit_attachment" name="edit_attachment" >
                            </div>
                            <div class="form-group">
                                <label for="edit_start_time">Entry Time</label>
                                <div class='input-group datetimepicker-disable-date date'  id='edit_entry' >
                                    <input type='text' class="form-control" id="edit_start_time" name="edit_start_time" readonly/>
                                    <span class="input-group-addon">
                                        <span class="fa fa-clock-o"></span>
                                    </span>
                                </div>
                            </div>
                            <br><br>
                            <div class="form-group">
                                <label for="edit_end_time">Exit Time</label>
                                <div class='input-group datetimepicker-disable-date date'  id='edit_exit' >
                                    <input type='text' class="form-control" id="edit_end_time" name="edit_end_time" readonly/>
                                    <span class="input-group-addon">
                                        <span class="fa fa-clock-o"></span>
                                    </span>
                                </div>
                            </div>
                            <br><br>
                            <div class="form-group">
                                    <label for="status"  class="col-md-4 control-label">Status</label>
                                    <select class="form-control" name="status" id="status">
                                        <option value="1">Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                            </div>
                            <input type="hidden" name="id" id="id">
                            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-info pull-right" id="task_update"><i class="fa fa-refresh"></i> Update</button>
                        </div>
                        </form>
                </div>
            </div>
        </div>
    </div>
</div>

