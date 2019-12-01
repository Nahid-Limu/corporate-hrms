<div id="editAnnouncement" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><i class="fa fa-plus"></i> Edit Announcement</h4>
            </div>
            <div class="modal-body">
                <!-- Error list Start -->
                <span id="form_result_edit"></span>
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
                    <form action="" id="edit_announcement_modal_form">

                        <div class="panel-body">
                            <div class="form-group">
                                <label for="edit_announcement_title">Announcement Title<span style="color: red;">*</span> </label>
                                <input type="text" class="form-control" id="edit_announcement_title" name="edit_announcement_title" >
                            </div>

                            <div class="form-group">
                                <label for="edit_start_date">Start Date <span style="color: red;">*</span></label>
                                <input type="date" class="form-control" id="edit_start_date" name="edit_start_date" >
                            </div>
                            <div class="form-group">
                                <label for="edit_end_date">End Date <span style="color: red;">*</span></label>
                                <input type="date" class="form-control" id="edit_end_date" name="edit_end_date" >
                            </div>
                            <div class="form-group">
                                <label for="edit_status">Status <span style="color: red;">*</span></label>
                                <select class="form-control" id="edit_status" name="edit_status">
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="edit_ann_branch_id">Branch Name <span style="color: red;">*</span> </label>
                                <select class="form-control" id="edit_ann_branch_id" name="edit_ann_branch_id">
                                @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('super-admin'))
                                    <option value="">Select</option>
                                    <option value="0">All</option>
                                        @foreach( $all_branch as $branch)
                                            <option value="{{$branch->id}}">{{$branch->branch_name}}</option>
                                        @endforeach 
                                @else 
                                     <option value="{{$branch_list2->id}}">{{$branch_list2->branch_name}}</option>
                                @endif
                                </select>
                            </div>
                            <input type="text" hidden id="id" name="id">

                            <div class="form-group">
    
                                <label for="edit_description">Description <span style="color: red;">*</span></label>
                                <textarea id="edit_description" name="edit_description" cols="5" rows="5" class="form-control" ></textarea>
                            </div>

                            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-info pull-right" id="editbtn_announcement"><i class="fa fa-refresh"></i> Update</button>
                        </div>
                   
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

