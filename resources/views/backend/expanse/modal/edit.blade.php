<div id="editExpanse" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content animated bounceInLeft">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Edit Expense</h4>
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
                    <form id="edit_expanse_modal_form"  enctype="multipart/form-data">
                        @csrf
                    <div class="panel-body">
                
                        <!-- =============== Branch ============= -->
                        <div class="form-group">
                            {{-- <label for="edit_category_id">Select  Expanse Category Name <span style="color:red">*</span></label>
                            <select class="form-control" id="edit_category_id" name="edit_category_id">
                                <option value="">Select</option>
                                @foreach($expanse_category as $e_category)
                                <option value="{{$e_category->id}}">{{ $e_category->category_name}}</option>
                                @endforeach
                            </select>  --}}


                            <label for="department_name">Select Expense Catyegory Name <span style="color: red;">*</span></label>
                                <select class="form-control" id="edit_category_id" name="edit_category_id">
                                <option value="">Select Catyegory Name</option>
                                @foreach($expanse_category as $e_category)
                                    <option value="{{$e_category->id}}">{{$e_category->category_name}}</option>
                                @endforeach
                            </select>
                        </div> 

                        <!-- =============== End Branch ============= -->  



                           <!-- =============== Branch ============= -->
                        <div class="form-group">
                            <label for="department_name">Select Branch</label>
                            <select class="form-control" id="edit_all_branch" name="edit_all_branch" disabled>
                                <option value="">Select</option>
                                @foreach($branch_list as $branchs)
                                <option value="{{$branchs->id}}">{{$branchs->branch_name}}</option>
                                @endforeach
                            </select>
                        </div> 

                        <!-- =============== End Branch ============= -->
                        
                        <div class="form-group">
                        
                            <label for="edit_emp_id">Select Employee <span style="color: red;">*</span></label>
                                {{-- <select class="form-control" id="edit_emp_id" name="edit_emp_id">
                                @foreach($employee_list as $name)
                                    <option value="{{$name->id}}">{{$name->emp_first_name}}</option>
                                @endforeach
                            </select> --}} 

                            <select id="edit_emp_id" name="edit_emp_id"  class="form-control">
                                    <option value=''>-- Select Employee--</option>
                                    
                            </select>
                        </div>


                          <!-- =============== Group Name ============= -->

                        <div class="form-group">
                            <label for="edit_amount">Amount<span style="color:red">*</span></label>
                            <input type="number" step="any" class="form-control" id="edit_amount" name="edit_amount" required autocomplete="off" placeholder="amount">
                        </div>
                          <!-- =============== End Group Name ============= -->  


                        <!-- =============== Group Leader ============= -->

                         <div class="form-group">
                                <label for="department_name">Expanse Date <span style="color: red;">*</span> </label>
                                <input type="date" placeholder="Expanse Date" class="form-control" id="edit_expanse_date" name="edit_expanse_date" autocomplete="off">
                        </div> 

                        <!-- =============== End Group Leader ============= -->

                        <!-- =============== Remarks ============= -->
                        
                        <div class="form-group">
                            <label for="edit_remarks">Remarks</label>
                            <textarea placeholder="Remarks" id="edit_remarks" name="edit_remarks" cols="5" rows="5" class="form-control" autocomplete="off"></textarea>
                        </div>
                        <!-- =============== End Remarks ============= -->  

                          <!-- =============== Status ============= -->
                        <div class="form-group">
                            <label for="status"  class="control-label">Status</label>
                            <select class="form-control" name="status" id="status">
                                <option value="1" style="color:green">Confirm</option>
                                <option value="0" style="color:red">Pending</option>
                            </select>
                        </div> 
                        <!-- =============== End  Status ============= -->

                        <div class="form-group">
                            <label for="edit_attachment">Attachment</span></label>
                            <input type="file" class="form-control" id="edit_attachment" name="edit_attachment">
                        </div> 


                         <input type="hidden" name="id" id="id">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-info pull-right" id="expanse_edit"><i class="fa fa-plus"></i> Save</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>




 