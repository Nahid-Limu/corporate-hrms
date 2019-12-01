<div id="editShift" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Edit Shift</h4>
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
                    <form id="edit_shift_modal_form">
                        @csrf
                    <div class="panel-body">
                            <div class="form-group">
                                    <label for="edit_shift_name">Shift Name</label>
                                    <input type="text" class="form-control" id="edit_shift_name" name="edit_shift_name" required autocomplete="off">
                                </div>
                                <div class="form-group">
                                    <label for="edit_entry_time">Entry Time</label>
                                    <div class='input-group datetimepicker-disable-date date'  id='edit_entry' >
                                            <input type='text' class="form-control" id="edit_entry_time" name="edit_entry_time"/>
                                            <span class="input-group-addon">
                                                <span class="fa fa-clock-o"></span>
                                            </span>
                                        </div>
                                </div>
                                <br><br>
                                <div class="form-group">
                                    <label for="edit_exit_time">Exit Time</label>
                                    <div class='input-group datetimepicker-disable-date date'  id='edit_exit' >
                                        <input type='text' class="form-control" id="edit_exit_time" name="edit_exit_time"/>
                                        <span class="input-group-addon">
                                            <span class="fa fa-clock-o"></span>
                                        </span>
                                    </div>
                                </div>
                                <br><br>
                        <input type="hidden" name="id" id="id">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-info pull-right" id="shift_update"><i class="fa fa-refresh"></i> Update</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

