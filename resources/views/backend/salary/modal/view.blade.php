<div id="viewSalary" tabindex="-1" role="dialog" aria-labelledby="modal-responsive-label" aria-hidden="true" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content animated bounceInLeft">
            <div class="modal-header">
                <button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
                <h4 id="modal-responsive-label" class="modal-title">SALARY DETAILS</h4></div>
            <div class="modal-body">
                <h1 class="text-center" id="emp_name"></h1>
                <hr>
                <div class="row">
                    <div class="form-group">
                        <div class="col-md-6">
                            <label for="employeeId" class="pull-left"><h5>EmpId:</h5></label>
                            <div>
                                <input class="form-control select2Style" type="number" name="employeeId" id="employeeId" readonly>
                                <b class="form-text text-danger pull-left" id="transportationError"></b>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="grade_name" class="pull-left"><h5>Grade:</h5></label>
                            <div>
                                <input class="form-control select2Style" type="text" name="grade_name" id="grade_name" readonly>
                                <b class="form-text text-danger pull-left" id="transportationError"></b>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-6">
                            <label for="basic_salary" class="pull-left"><h5>Basic:</h5></label>
                            <div>
                                <input class="form-control select2Style" type="number" name="basic_salary" id="basic_salary" readonly>
                                <b class="form-text text-danger pull-left" id="transportationError"></b>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="house_rant" class="pull-left"><h5>House rant:</h5></label>
                            <div>
                                <input class="form-control select2Style" type="number" name="house_rant" id="house_rant" readonly>
                                <b class="form-text text-danger pull-left" id="transportationError"></b>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-6">
                            <label for="medical" class="pull-left"><h5>Medical Allowance:</h5></label>
                            <div>
                                <input class="form-control select2Style" type="number" name="medical" id="medical" readonly>
                                <b class="form-text text-danger pull-left" id="transportationError"></b>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="transport" class="pull-left"><h5>Transportation Allowance:</h5></label>
                            <div>
                                <input class="form-control select2Style" type="number" name="transport" id="transport" readonly>
                                <b class="form-text text-danger pull-left" id="transportationError"></b>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-6">
                            <label for="food" class="pull-left"><h5>Food Allowance:</h5></label>
                            <div>
                                <input class="form-control select2Style" type="number" name="food" id="food" readonly>
                                <b class="form-text text-danger pull-left" id="transportationError"></b>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="other" class="pull-left"><h5>Other:</h5></label>
                            <div>
                                <input class="form-control select2Style" type="number" name="other" id="other" readonly>
                                <b class="form-text text-danger pull-left" id="transportationError"></b>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-6">
                            <label for="total_salary" class="pull-left"><h5>Totla Salary:</h5></label>
                            <div>
                                <input class="form-control select2Style" type="number" name="total_salary" id="total_salary" readonly>
                                <b class="form-text text-danger pull-left" id="transportationError"></b>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="provident_fund_amount" class="pull-left"><h5>Provident Fund Ammount:</h5></label>
                            <div>
                                <input class="form-control select2Style" type="number" name="provident_fund_amount" id="provident_fund_amount" readonly>
                                <b class="form-text text-danger pull-left" id="transportationError"></b>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <h4 class="text-danger">GROSS SALARY: <b id="net_salary"></b> TAKA</h4>
            </div>
            
        </div>
    </div>
</div>
