<div id="editweekLeave" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Edit  Week Leave</h4>
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
                    <form id="edit_weekleave_modal_form">
                        @csrf
                    <div class="panel-body">
                        <div class="form-group">
                            <label for="edit_day">Day Name</label>
                            <input type="text" class="form-control" id="edit_day" name="edit_day" disabled>
                        </div>
                            
                        
                        <label for="edit_status"  class="control-label">Status</label>
                        <select class="form-control" name="edit_status" id="edit_status">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                            
                        </select>
                                  
                            
                        </div>
                        <br>
                        <input type="hidden" name="id" id="id">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-info pull-right" id="week_leave_update"><i class="fa fa-refresh"></i> Update</button>

                        
                        <br>
                        <br>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

