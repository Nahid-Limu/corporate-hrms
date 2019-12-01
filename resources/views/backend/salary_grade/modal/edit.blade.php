<div id="editsalary_grade" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Edit Salary Grade</h4>
            </div>
            <div class="modal-body">
                    <!-- Error list Start -->
                    <span id="edit_form_result"></span>
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
                    <form id="edit_salary_grade_modal_form">
                        @csrf
                    <div class="panel-body"> 
                        <!-- ===============  Grade Name ============= --> 
                       <div class="form-group">
                            <label for="edit_grade_name">Grade Name</label>
                            <input type="text" class="form-control" id="edit_grade_name" name="edit_grade_name" required autocomplete="off">
                        </div>
                        <!-- =============== End Grade Name ============= --> 

                        <!-- =============== Basic ============= --> 
                        <div class="form-group">
                            <label for="edit_basic">Basic</label>
                            <input type="number" class="form-control" id="edit_basic" name="edit_basic" step="any"  required autocomplete="off">
                        </div>
                        <!-- =============== End Basic ============= --> 

                        <!-- ===============House ============= --> 
                        <div class="form-group">
                            <label for="edit_house">House</label>
                            <input type="number" class="form-control" id="edit_house" name="edit_house" step="any"  required autocomplete="off" value="0">
                        </div> 
                        <!-- ===============End House ============= --> 

                        <!-- =============== Medical ============= -->                         
                        <div class="form-group">
                            <label for="edit_medical">Medical</label>
                            <input type="number" class="form-control" id="edit_medical" name="edit_medical" step="any"  required autocomplete="off" value="0">
                        </div>
                        <!-- =============== End Medical ============= -->    
                        
                        <!-- =============== Transportation ============= -->                                                 
                        <div class="form-group">
                            <label for="edit_transportation">Transportation</label>
                            <input type="number" class="form-control" id="edit_transportation" name="edit_transportation" step="any"  required autocomplete="off" value="0">
                        </div>
                        <!-- ===============End Transportation ============= -->  
                        
                        
                        <!-- =============== food ============= -->                         
                        <div class="form-group">
                            <label for="edit_food">Food</label>
                            <input type="number" class="form-control" id="edit_food" name="edit_food" step="any"  required autocomplete="off" value="0">
                        </div>
                        <!-- =============== End food ============= -->                         
                        <div class="form-group">
                            <label for="edit_other">Other</label>
                            <input type="number" class="form-control" id="edit_other" name="edit_other" step="10"  required autocomplete="off" value="0">
                        </div>
                        <!-- =============== Status ============= -->                         
                        <div class="form-group">
                                <label for="status"  class="col-md-4 control-label">Status</label>
                                <select class="form-control" name="status" id="status">
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                        </div>
                        <!-- =============== End Status ============= -->                         

                        <br>
                        <input type="hidden" name="id" id="id">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-info pull-right" id="salary_grade_update"><i class="fa fa-refresh"></i> Update</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

