<div id="edit_severance_package_employee" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content animated bounceInLeft">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Edit  Severance Package Employee</h4>
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

                    {{-- bb --}}
                    <!-- Error list End -->
                <div class="panel panel-default">
                    <form id="employee_package_modal_form">
                        @csrf
                    <div class="panel-body">
                        <!-- =============== Group Name ============= -->
                        <div class="form-group">
                            <label for="package_id"  class="control-label">Select Package</label>
                           
                            <select class="form-control" name="package_id" id="package_id">
                                  {{-- <option value="">Select</option> --}}
                              @foreach ($severancePackageNmae as $pname)
                            <option value="{{$pname->id}}">{{ $pname->package_name }}</option>
                              @endforeach
                         
                            </select>
                        </div> 
                        <!-- =============== End Group Name ============= -->

                        <!-- =============== Branch ============= -->
                        <div class="form-group">
                            <label for="department_name">Select Branch</label>
                            <select class="form-control" id="all_branch" name="all_branch">
                                {{-- <option value="">Select</option> --}}
                                @foreach($branch_list as $branchs)
                                <option value="{{$branchs->id}}">{{$branchs->branch_name}}</option>
                                @endforeach
                            </select>
                        </div> 

                        <!-- =============== End Branch ============= -->


                        <!-- =============== Employee Name ============= -->
                        {{-- <div class="form-group">
                            <label for="employee_id"  class="control-label">Employee Name</label>
                            <select class="form-control" name="employee_id" id="employee_id">
                                
                              @foreach ($employeeName as $name)
                                <option value="{{$name->id}}">{{$name->emp_first_name}} {{$name->emp_lastName}}  ({{ $name->employeeId }})</option>
                              @endforeach
                         
                            </select>
                        </div>  --}}


                       
                            <div class="form-group">
                                <label for="department_name">Select Employee <span style="color: red;">*</span></label>
                                <select class="form-control" id="emp_id" name="emp_id">
                                    <option value="">Select Branch First</option>
                                </select>
                            </div>  


                             <div class="form-group">
                                <label for="remarks">Remarks</label>
                                <textarea id="remarks" name="remarks" cols="5" rows="5" class="form-control" autocomplete="off"></textarea>
                            </div>

                        <!-- =============== End Employee Name ============= -->


                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-info pull-right" id="severance_package_employee_add"><i class="fa fa-plus"></i> Save</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

