<div id="editExpense" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Edit Expense Status</h4>
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
                    <form id="edit_expense_status_modal_form">
                        @csrf
                    <div class="panel-body">
                        <div class="form-group">
                            <label for="edit_date">Date</label>
                            <input type="text" class="form-control" id="edit_date" name="edit_date" disabled>
                        </div>
                            
                        
                        <label for="edit_status"  class="control-label">Status</label>
                        <select class="form-control" name="edit_status" id="edit_status">
                            <option value="1">Confirm</option>
                            <option value="0">Pending</option>
                            
                        </select>
                                  
                            
                        </div>
                        <br>
                        <input type="hidden" name="id" id="id">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-info pull-right" id="expense_status_update"><i class="fa fa-refresh"></i> Update</button>

                        
                        <br>
                        <br>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

