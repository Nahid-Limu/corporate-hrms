<div id="editClient" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><i class="fa fa-pencil"></i> Edit Client</h4>
            </div>
            <div class="modal-body">
                <!-- Error list Start -->
                <span id="form_results"></span>
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
                    <form id="modal_form">
                        @csrf
                        <div class="panel-body">

                                <div class="form-group">
                                        <label for="department_name">Branch <span style="color: red;">*</span> </label>
                            <select class="form-control" name="edit_branch_id" id="edit_branch_id">
                                    @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('super-admin'))
                                        @foreach($branch as $branches)
                                         <option value="{{$branches->id}}">{{$branches->branch_name}}</option>
                                        @endforeach
                                   @else
                                   <option value="{{$branch_list2->id}}">{{$branch_list2->branch_name}}</option>
                                   @endif

                             </select>
                                </div>

                            <div class="form-group">
                                <label for="department_name">Client Name <span style="color: red;">*</span> </label>
                                <input type="text" class="form-control" id="edit_clients_name" name="client_name" autocomplete="off" placeholder="Client Name">
                            </div>

                            <div class="form-group">
                                <label for="department_name">Client Phone <span style="color: red;">*</span></label>
                                <input type="text" class="form-control" id="edit_clients_phone" name="client_phone" autocomplete="off" placeholder="Client Phone">
                            </div>

                            <div class="form-group">
                                <label for="department_name">Client Email</label>
                                <input type="email" class="form-control" id="edit_clients_email" name="client_email" autocomplete="off" placeholder="Client Email">
                            </div>

                            <div class="form-group">
                                <label for="remarks">Client Address <span style="color: red;">*</span></label>
                                <textarea id="edit_clients_address" name="client_address" cols="5" rows="5" class="form-control" autocomplete="off" placeholder="Client Address"></textarea>
                            </div>

                            <div class="form-group">
                                <label for="remarks">Status <span style="color: red;">*</span></label>
                                <select class="form-control" id="c_status" name="c_status">
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>
                            <br>
                            <input type="hidden" name="id" id="id">
                            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-info pull-right" id="client_update"><i class="fa fa-save"></i> Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

