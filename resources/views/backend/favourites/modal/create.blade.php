<div id="favourite" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content animated bounceInLeft">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add New Favourite</h4>
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
                    <form id="favourite_modal_form" onkeydown="return event.key != 'Enter';">
                        @csrf
                    <div class="panel-body"> 

                        <!-- =============== Branch ============= -->
                        <div class="form-group">
                            <label for="department_name">Select Branch</label>
                            <select class="form-control" id="all_branch" name="all_branch">
                                <option value="">Select</option>
                                @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('super-admin'))
                                @foreach($branch_list as $branchs)
                                <option value="{{$branchs->id}}">{{$branchs->branch_name}}</option>
                                @endforeach
                                @else 
                                <option value="">Select</option>
                                 <option value="{{$branch_list2->id}}">{{$branch_list2->branch_name}}</option>
                                @endif
                            </select>
                        </div> 

                        <!-- =============== End Branch ============= -->

                        <!-- =============== Employee Name ============= -->
                        {{-- <div class="form-group">
                            <label for="emp_id"  class="control-label">Employee <span style="color:red">*</span></label>
                            
                            <select class="form-control" name="emp_id" id="emp_id">
                                 <option value="">Select Employee</option>
                              @foreach ($employee_list as $name)
                                <option value="{{$name->id}}">{{$name->emp_first_name}} {{$name->emp_lastName}}  ({{$name->employeeId}})</option>
                              @endforeach
                         
                            </select>
                        </div>  --}}


                         <div class="form-group">
                            <label for="department_name">Select Employee <span style="color: red;">*</span></label>
                            <select class="form-control" id="emp_id" name="emp_id">
                                <option value="">Select Branch First</option>
                            </select>
                        </div>
                        <hr>
                        <!-- =============== End Employee Name ============= -->

                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-info pull-right" id="favourite_add"><i class="fa fa-save"></i> Save</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

