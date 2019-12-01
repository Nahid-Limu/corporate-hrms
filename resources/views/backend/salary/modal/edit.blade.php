<div id="editSalary" tabindex="-1" role="dialog" aria-labelledby="modal-responsive-label" aria-hidden="true" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
                <h4 id="modal-responsive-label" class="modal-title">SALARY UPDATE</h4></div>
            <form id="edit_salary_modal_form">
                    @csrf
            <div class="modal-body">
                <h1 class="text-center" id="name"></h1>
                <hr>
                <div class="row">
                    <div class="form-group">
                        <div class="col-md-12">
                            <label for="salary_grade_id" class="pull-left"><h5>Grade:</h5></label>
                            <div>
                                <select id="salary_grade_id" name="salary_grade_id"  class="form-control">
                                        <option value=''>-- Select Gread--</option>
                                       
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-6">
                            <label for="edit_basic_salary" class="pull-left"><h5>Basic:</h5></label>
                            <div>
                                <input class="form-control select2Style" type="number" name="edit_basic_salary" id="edit_basic_salary">
                                <b class="form-text text-danger pull-left" id="transportationError"></b>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="edit_house_rant" class="pull-left"><h5>House rant:</h5></label>
                            <div>
                                <input class="form-control select2Style" type="number" name="edit_house_rant" id="edit_house_rant" >
                                <b class="form-text text-danger pull-left" id="transportationError"></b>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-6">
                            <label for="edit_medical" class="pull-left"><h5>Medical Allowance:</h5></label>
                            <div>
                                <input class="form-control select2Style" type="number" name="edit_medical" id="edit_medical" >
                                <b class="form-text text-danger pull-left" id="transportationError"></b>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="edit_transport" class="pull-left"><h5>Transportation Allowance:</h5></label>
                            <div>
                                <input class="form-control select2Style" type="number" name="edit_transport" id="edit_transport" >
                                <b class="form-text text-danger pull-left" id="transportationError"></b>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-6">
                            <label for="edit_food" class="pull-left"><h5>Food Allowance:</h5></label>
                            <div>
                                <input class="form-control select2Style" type="number" name="edit_food" id="edit_food" >
                                <b class="form-text text-danger pull-left" id="transportationError"></b>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="edit_other" class="pull-left"><h5>Other:</h5></label>
                            <div>
                                <input class="form-control select2Style" type="number" name="edit_other" id="edit_other" >
                                <b class="form-text text-danger pull-left" id="transportationError"></b>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <input type="hidden" name="id" id="id">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-info pull-right" id="updae"><i class="fa fa-refresh"></i> Update</button>
            </div>
            </form>
        </div>
    </div>
</div>
