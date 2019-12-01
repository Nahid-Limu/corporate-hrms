<div id="createDesignation" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content animated bounceInLeft">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add New Designation</h4>
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
                    <form id="modal_form">
                        @csrf
                    <div class="panel-body">
                        <div class="form-group">
                            <label for="designation_name">Designation Name</label>
                            <input type="text" class="form-control" id="designation_name" name="designation_name" placeholder="Designation Name" required autocomplete="off">
                        </div>
                        
                        <div class="form-group">
                            <label for="remarks">Remarks</label>
                            <textarea id="remarks" name="remarks" cols="5" rows="5" class="form-control" placeholder="Remarks" autocomplete="off"></textarea>
                        </div>
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-info pull-right" id="designation_add"><i class="fa fa-save"></i> Save</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

