<div id="editProvident" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content animated bounceInRight">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Edit Provident Fund</h4>
                </div>
                <form id="edit_provident_modal_form">
                        @csrf
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

                    <h1 class="text-center" id="emp_name"></h1>
                    <hr>
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="form-group">
                                <label for="edit_provident_fund_percent">Provident Fund Percent</label>
                                <input type="text" class="form-control" id="edit_provident_fund_percent" name="edit_provident_fund_percent">
                            </div>
                        </div
                    </div>
                </div>
                <div class="modal-footer">
                        <input type="hidden" name="id" id="id">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-info pull-right" id="provident_update"><i class="fa fa-refresh"></i> Update</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    
    