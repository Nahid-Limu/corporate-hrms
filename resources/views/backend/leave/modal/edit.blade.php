<div id="editLeave" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Edit Leave</h4>
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
                    <form id="edit_leave_modal_form">
                        @csrf
                    <div class="panel-body">
                        <div class="form-group">
                            <label for="edit_leave_type">Leave Type</label>
                            <input type="text" class="form-control" id="edit_leave_type" name="edit_leave_type">
                        </div>
                        
                        <div class="form-group">
                            <label for="edit_total_days">Total Days</label>
                            <input type="number" class="form-control" id="edit_total_days" name="edit_total_days" required autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label for="policy">Policy</label>
                            <textarea id="edit_policy" name="edit_policy" cols="5" rows="5" class="form-control" autocomplete="off"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="account_status"  class="col-md-4 control-label">Status</label>
                            <select class="form-control" name="status" id="status">
                                <option value="1">Active</option>
                                <option value="0">Inactive</option> 
                            </select>     
                        </div>
                        <br>
                        <input type="hidden" name="id" id="id">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-info pull-right" id="leave_update"><i class="fa fa-refresh"></i> Update</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

