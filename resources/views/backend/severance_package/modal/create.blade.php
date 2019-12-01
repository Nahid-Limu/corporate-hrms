<div id="createSeverance" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content animated bounceInLeft">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add New Severance Package</h4>
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
                    <form id="Severance_modal_form">
                        @csrf
                    <div class="panel-body">
                        <div class="form-group">
                            <label for="package_name">Package Name <span style="color:red">*</span></label>
                            <input type="text" class="form-control" id="package_name" name="package_name" placeholder="Package Name" required autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label for="package_type">Package Type <span style="color:red">*</span></label>
                            <input type="text" class="form-control" id="package_type" name="package_type" placeholder="Package Type" required autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea id="description" name="description" cols="5" rows="5" class="form-control" placeholder="Description" autocomplete="off"></textarea>
                        </div>
                        
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-info pull-right" id="severance_add"><i class="fa fa-plus"></i> Save</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

