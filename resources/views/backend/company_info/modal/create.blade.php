<div id="createCompany" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content animated bounceInLeft">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add New Company Information</h4>
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
                    <form id="company_modal_form">
                        @csrf
                    <div class="panel-body">
                        <div class="form-group">
                            <label for="company_name">Company Name</label>
                            <input type="text" class="form-control" id="company_name" name="company_name" required autocomplete="off">
                        </div>

                        <div class="form-group">
                            <label for="company_phone">Company Phone</label>
                            <input type="tel" class="form-control" id="company_phone" name="company_phone" pattern="[0-9]{11}" maxlength="11" placeholder="Ex: 017xxxxxxxx" title="Type Eleven digits Number" required autocomplete="off">
                        </div>

                        <div class="form-group">
                            <label for="company_email">Company Email</label>
                            <input type="email" class="form-control" id="company_email" name="company_email"  required autocomplete="off">
                        </div>
                        
                        <div class="form-group">
                            <label for="company_address">Address</label>
                            <textarea id="company_address" name="company_address" cols="5" rows="5" class="form-control" autocomplete="off"></textarea>
                        </div>
                        
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-info pull-right" id="company_add"><i class="fa fa-save"></i> Save</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

