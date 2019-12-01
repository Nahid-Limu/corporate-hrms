<div id="createLeave" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content animated bounceInLeft">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add New Leave</h4>
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
                    <form id="leave_modal_form">
                        @csrf
                    <div class="panel-body">
                        <div class="form-group">
                            <label for="leave_type">Leave Type</label>
                            <input type="text" class="form-control" id="leave_type" name="leave_type" placeholder="Leave Type" required autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label for="total_days">Total Days</label>
                            <input type="number" class="form-control" id="total_days" name="total_days" placeholder="Total Days" required autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label for="policy">Policy</label>
                            <textarea id="policy" name="policy" cols="5" rows="5" class="form-control" placeholder="Leave Policy" autocomplete="off"></textarea>
                        </div>
                        
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-info pull-right" id="leave_add"><i class="fa fa-save"></i> Save</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

