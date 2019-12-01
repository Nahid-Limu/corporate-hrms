<div id="createBranch" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content animated bounceInLeft">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add New Branch</h4>
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
                    <form id="branch_modal_form" onkeydown="return event.key != 'Enter';">
                        @csrf
                    <div class="panel-body">
                        <div class="form-group">
                            <label for="branch_name">Branch Name</label>
                            <input type="text" class="form-control" id="branch_name" name="branch_name" placeholder="Branch Name" required autocomplete="off">
                        </div>
                        
                        <div class="form-group">
                            <label for="remarks">Address</label>
                            <textarea id="address" name="address" cols="5" rows="5" class="form-control" placeholder="Branch Address" autocomplete="off"></textarea>
                        </div>
                        
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-info pull-right" id="branch_add"><i class="fa fa-save"></i> Save</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

