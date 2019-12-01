<div id="expanseadd" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content animated bounceInLeft">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add New Expense</h4>
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
                    <form id="expanse_modal_form"  enctype="multipart/form-data">
                        @csrf
                    <div class="panel-body">
                
                        <!-- =============== Branch ============= -->
                        <div class="form-group">
                            <label for="category_id">Select  Expense Category Name <span style="color:red">*</span></label>
                            <select class="form-control" id="category_id" name="category_id">
                                <option value="">Select</option>
                                @foreach($expanse_category as $e_category)
                                <option value="{{$e_category->id}}">{{$e_category->category_name}}</option>
                                @endforeach
                            </select>
                        </div> 

                        <!-- =============== End Branch ============= --> 

                         @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('super-admin'))
                          <!-- =============== Branch ============= -->
                        <div class="form-group">
                            <label for="department_name">Select Branch <span style="color:red">*</span></label>
                            <select class="form-control" id="all_branch" name="all_branch">
                                <option value="">Select</option>
                                @foreach($branch_list as $branchs)
                                <option value="{{$branchs->id}}">{{$branchs->branch_name}}</option>
                                @endforeach
                            </select>
                        </div> 

                        <!-- =============== End Branch ============= -->

                        <div class="form-group">
                            <label for="department_name">Select Employee <span style="color: red;">*</span></label>
                            <select class="form-control" id="emp_id" name="emp_id">
                                <option value="">Select Branch First</option>
                            </select>
                        </div>
                         @endif

                          <!-- =============== Group Name ============= -->

                        <div class="form-group">
                            <label for="amount">Amount<span style="color:red">*</span></label>
                            <input type="number" step="any" class="form-control" id="amount" name="amount" required autocomplete="off" placeholder="Amount">
                        </div>
                          <!-- =============== End Group Name ============= -->  

                       
                        <!-- =============== Group Leader ============= -->

                         <div class="form-group">
                           
                             <label for="department_name">Expense Date <span style="color: red;">*</span> </label>
                                <input placeholder="Expense Date" type="date" class="form-control" id="expanse_date" name="expanse_date" autocomplete="off">
                        </div> 

                        <!-- =============== End Group Leader ============= -->

                        <!-- =============== Remarks ============= -->
                        
                        <div class="form-group">
                            <label for="remarks">Remarks</label>
                            <textarea id="remarks" name="remarks" placeholder="Remarks" cols="5" rows="5" class="form-control" autocomplete="off"></textarea>
                        </div>
                        <!-- =============== End Remarks ============= -->  

                        <div class="form-group">
                            <label for="attachment">Attachment</span></label>
                            <input type="file" class="form-control" id="attachment" name="attachment">
                        </div>

                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-info pull-right" id="expanse_add"><i class="fa fa-plus"></i> Save</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>




 