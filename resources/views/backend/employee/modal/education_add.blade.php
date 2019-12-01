<div id="addEducation" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">New Educational Information</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    {!! Form::open(['method'=>'POST','route'=>'employee.education','files'=>true]) !!}
                    <div class="col-md-12">

                        <div class="form-group">
                            <label for="department_name">Examination Name <span style="color:red">*</span> </label>
                            <input type="text" class="form-control" id="exam_name" name="emp_exam_title" autocomplete="off"  placeholder="Examination Name" required>
                        </div>

                        <div class="form-group">
                            <label for="department_name">Institution <span style="color:red">*</span> </label>
                            <input type="text" class="form-control" id="institution" name="emp_Institution_name" autocomplete="off"  placeholder="Institution" required>
                        </div>

                        <div class="form-group">
                            <label for="department_name">Exam Result <span style="color:red">*</span> </label>
                            <input type="text"  class="form-control" id="exam_result" name="emp_result" autocomplete="off" placeholder="Exam Result" required>
                        </div>

                        <div class="form-group">
                            <label for="department_name">Scale</label>
                            <input type="text" class="form-control" id="scale" name="emp_scale" placeholder="Scale" autocomplete="off">
                        </div>

                        <div class="form-group">
                            <label for="passing_year">Passing Year <span style="color:red">*</span> </label>
                            <input type="text" class="form-control" id="passing_year" name="emp_passing_year" autocomplete="off" placeholder="Passing Year" required>
                        </div>

                        <div class="form-group">
                            <label for="attachment">Attachment</label>
                            <input type="file" class="form-control" id="attachment" name="emp_attachment" autocomplete="off">
                        </div>
                        <input type="hidden" name="emp_id" value="{{$employee_profile->emp_id}}">
                        <div class="form-group">
                            <button id="add_vendor_btn" type="Submit" class="btn btn-primary"><i class="fa fa-save"></i> Save Information</button>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>