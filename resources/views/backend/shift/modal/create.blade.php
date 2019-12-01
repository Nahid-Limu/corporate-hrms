<div id="createShift" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content animated bounceInLeft">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add New Shift</h4>
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
                    <form id="shift_modal_form">
                        @csrf
                    <div class="panel-body">
                        <div class="form-group">
                            <label for="shift_name">Shift Name</label>
                            <input type="text" class="form-control" id="shift_name" name="shift_name" placeholder="Shift Name" required autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label for="entry_time">Entry Time</label>
                            <div class='input-group datetimepicker-disable-date date'  id='entry' >
                                <input type='text' class="form-control" id="entry_time" name="entry_time" placeholder="Entry Time" readonly/>
                                <span class="input-group-addon">
                                    <span class="fa fa-clock-o"></span>
                                </span>
                            </div>
                        </div>
                        <br><br>
                        <div class="form-group">
                            <label for="exit_time">Exit Time</label>
                            <div class='input-group datetimepicker-disable-date date'  id='exit' >
                                <input type='text' class="form-control" id="exit_time" name="exit_time" placeholder="Exit Time" readonly/>
                                <span class="input-group-addon">
                                    <span class="fa fa-clock-o"></span>
                                </span>
                            </div>
                        </div>
                        <br><br>
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-info pull-right" id="shift_add"><i class="fa fa-plus"></i> Save</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>