<div id="weekLeave" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content animated bounceInLeft">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add New  Week Leave</h4>
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
                    <form id="create_weekleave_form">
                        @csrf
                    <div class="panel-body">
                        <div class="form-group">
                            <label for="day">Day Name <span style="color:red">*</span></label>
                            <input type="text" class="form-control" id="day" name="day"  required autocomplete="off">
                        </div>
                        {{-- <div class="form-group">
                            
                            <label for="account_status"  class="control-label">Package Status</label>
                                
                            <select class="form-control" name="status" id="status">
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                                
                            </select>
                        </div> --}}
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-info pull-right" id="week_leave_add"><i class="fa fa-plus"></i> Save</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

