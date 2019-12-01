<div id="passwordUpdate" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"> <i class="fa fa-key"></i> Update Password</h4>
            </div>
            <div class="modal-body">
                <div class="row">

                    {!! Form::open(['method'=>'POST','route'=>'employee.password']) !!}
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="department_name">Password <span style="color:red">*</span> </label>
                            <input type="password" class="form-control" id="password" name="password"  autocomplete="off" placeholder="Password" required>
                        </div>
                        <div class="form-group">
                            <button id="add_vendor_btn" type="Submit" class="btn btn-primary"><i class="fa fa-save"></i> Update Password</button>
                        </div>
                        <input type="hidden" name="emp_id" value="{{$employee_profile->emp_id}}">
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>