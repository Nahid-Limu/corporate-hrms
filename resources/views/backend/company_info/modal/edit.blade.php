<div id="editCompany" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Edit Company Information</h4>
            </div>
            <div class="modal-body">
                <div class="panel panel-default">
                {!! Form::open(['method'=>'POST','route'=>'company_update','files'=>true]) !!}
                    <div class="panel-body">
                        <div class="form-group">
                            <label for="edit_company_name">Company Name</label>
                            <input type="text" class="form-control" id="edit_company_name" name="company_name">
                        </div>

                        <div class="form-group">
                            <label for="edit_company_phone">Company Phone</label>
                            <input type="tel" class="form-control" id="edit_company_phone" name="company_phone" pattern="[0-9]{11}" maxlength="11" placeholder="Ex: 017xxxxxxxx" title="Type Eleven digits Number" required autocomplete="off">
                        </div>

                        <div class="form-group">
                            <label for="edit_company_email">Company Email</label>
                            <input type="email" class="form-control" id="edit_company_email" name="company_email">
                        </div>

                        <div class="form-group">
                                <label for="edit_company_email">Company Logo</label>
                                <input type="file" class="form-control"  name="company_logo">
                        </div>

                        <div class="form-group">
                            <label for="edit_company_address">Address</label>
                            <textarea id="edit_company_address" name="company_address" cols="5" rows="5" class="form-control" autocomplete="off"></textarea>
                        </div>
                        <br>
                        <input type="hidden" name="id" id="id">
                        <input type="hidden" name="default_logo" id="default_logo">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-info pull-right" id="company_update"><i class="fa fa-refresh"></i> Update</button>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>

