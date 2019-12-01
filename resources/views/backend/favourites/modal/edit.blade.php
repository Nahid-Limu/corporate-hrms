<div id="editFavourite" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Edit Favourite</h4>
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
                    <form id="edit_favourite_modal_form" onkeydown="return event.key != 'Enter';">
                        @csrf
                    <div class="panel-body">
                        <!-- =============== Employee Name ============= -->

                         <div class="form-group">
                            <label for="department_name">Select Branch</label>
                            <select class="form-control" id="edit_all_branch" name="edit_all_branch">
                                @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('super-admin'))
                                <option value="">Select</option>
                                @foreach($branch_list as $branchs)
                                <option value="{{$branchs->id}}">{{$branchs->branch_name}}</option>
                                @endforeach
                                @else 
                                      <option value="{{$branch_list2->id}}">{{$branch_list2->branch_name}}</option>
                                @endif
                            </select>
                        </div> 

                        
                         <div class="form-group">
                            <label for="department_name">Select Employee <span style="color: red;">*</span></label>
                            <select class="form-control" id="edit_emp_id" name="edit_emp_id">
                                <option value="">Select Branch First</option>
                            </select>
                        </div>

                        <!-- =============== End Employee Name ============= --> 

                        <!-- =============== Status ============= -->
                        <div class="form-group">
                            <label for="status"  class="control-label">Status</label>
                            <select class="form-control" name="status" id="status">
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div> 
                        <!-- =============== End Status ============= -->

                        <br>
                        <input type="hidden" name="id" id="id">
                        {{-- <input type="text" name="id" id="id" value="1"> --}}
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-info pull-right" id="favourite_update"><i class="fa fa-refresh"></i> Update</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

