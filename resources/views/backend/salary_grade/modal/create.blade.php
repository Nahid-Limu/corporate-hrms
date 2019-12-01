<div id="salary_grade" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content animated bounceInLeft">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add New Salary Grade</h4>
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
                    <form id="salary_grade_modal_form">
                        @csrf
                    <div class="panel-body">
                        <!-- =============== End Grade Name ============= --> 
                        <div class="form-group">
                            <label for="grade_name">Grade Name <span style="color:red">*</span></label>
                            <input type="text" class="form-control" id="grade_name" name="grade_name" required autocomplete="off" placeholder="Grade Name">
                        </div>
                        <!-- =============== End Grade Name ============= --> 

                        <!-- =============== Basic ============= --> 
                        <div class="form-group">
                            <label for="basic">Basic <span style="color:red">*</span></label>
                            <input type="number" class="form-control" id="basic" name="basic" step="any"  required autocomplete="off" placeholder="Basic">
                        </div>
                        <!-- =============== End Basic ============= --> 
                        
                        <!-- ===============House ============= --> 

                        <div class="form-group">
                            <label for="house">House</label>
                            <input type="number" class="form-control" id="house" name="house" step="any"  required autocomplete="off" value="0">
                        </div>
                        <!-- =============== End House ============= --> 

                        <!-- =============== Medical ============= -->                         
                        <div class="form-group">
                            <label for="medical">Medical</label>
                            <input type="number" class="form-control" id="medical" name="medical" step="any"  required autocomplete="off" value="0">
                        </div>
                        <!-- =============== End Medical ============= --> 

                        <!-- =============== Transportation ============= -->                         
                        <div class="form-group">
                            <label for="transportation">Transportation</label>
                            <input type="number" class="form-control" id="transportation" name="transportation" step="any"  required autocomplete="off" value="0">
                        </div>
                        <!-- =============== End Transportation ============= -->                         

                        <!-- =============== food ============= -->                         
                        <div class="form-group">
                            <label for="food">Food</label>
                            <input type="number" class="form-control" id="food" name="food" step="any"  required autocomplete="off" value="0">
                        </div>
                        <!-- =============== End food ============= -->                         
                        <div class="form-group">
                            <label for="other">Other</label>
                            <input type="number" class="form-control" id="other" name="other" step="10"  required autocomplete="off" value="0">
                        </div>
                        
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-info pull-right" id="expanse_category_add"><i class="fa fa-plus"></i> Save</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

