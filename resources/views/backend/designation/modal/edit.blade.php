<div id="editDesignation" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Edit Designation</h4>
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
                    <form id="modal_form">
                        @csrf
                    <div class="panel-body">
                        <div class="form-group">
                            <label for="edit_designation_name">Designation Name</label>
                            <input type="text" class="form-control" id="edit_designation_name" name="edit_designation_name" placeholder="Designation Name">
                        </div>
                        
                        <div class="form-group">
                            <label for="edit_remarks">Remarks</label>
                            <textarea id="edit_remarks" name="edit_remarks" cols="5" rows="5" class="form-control" placeholder="Remarks"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="account_status"  class="col-md-4 control-label">Designation Status</label>
                            <select class="form-control" name="status" id="status">
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                        <br>
                        <input type="hidden" name="id" id="id">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-info pull-right" id="designation_update"><i class="fa fa-refresh"></i> Update</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

