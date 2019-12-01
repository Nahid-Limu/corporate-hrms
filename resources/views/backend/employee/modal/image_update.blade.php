<div id="editPhoto" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Update Photo</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    {!! Form::open(['method'=>'POST','route'=>'employee.image','files'=>true]) !!}
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="emp_photo">Update Photo <span style="color:red">*</span> </label>
                            <input type="file" class="form-control" id="emp_photo" name="emp_photo" autocomplete="off" required>
                        </div>
                        <input type="hidden" name="emp_id" value="{{$employee_profile->emp_id}}">
                        <div class="form-group">
                            <button id="add_vendor_btn" type="Submit" class="btn btn-primary"><i class="fa fa-refresh"></i> Update Image</button>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>