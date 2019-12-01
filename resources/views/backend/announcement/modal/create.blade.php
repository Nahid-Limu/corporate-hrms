<div id="createAnnouncement" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><i class="fa fa-plus"></i> Add New Announcement</h4>
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
                    <form action="" id="announcement_modal_form">
                        <div class="panel-body">
                            <div class="form-group">
                                <label for="announcement_title">Announcement Title<span style="color: red;">*</span> </label>
                                <input type="text" class="form-control" id="announcement_title" name="announcement_title" placeholder="Announcement title" autocomplete="off">
                            </div>

                            <div class="form-group">
                                <label for="start_date">Start Date <span style="color: red;">*</span></label>
                                <input type="date" class="form-control" id="start_date" name="start_date" autocomplete="off">
                            </div>
                            <div class="form-group">
                                <label for="end_date">End Date <span style="color: red;">*</span></label>
                                <input type="date" class="form-control" id="end_date" name="end_date" autocomplete="off">
                            </div>
                            <div class="form-group">
                                <label for="ann_branch_id">Branch Name <span style="color: red;">*</span> </label>
                                <select class="form-control" id="ann_branch_id" name="ann_branch_id">
                                    <option value="">Select</option>
                                    @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('super-admin'))
                                    <option value="0">All</option>
                                    @foreach( $all_branch as $branch)
                                       <option value="{{$branch->id}}">{{$branch->branch_name}}</option>
                                    @endforeach
                                    @else 
                                     <option value="{{$branch_list2->id}}">{{$branch_list2->branch_name}}</option>
                                    @endif
                                </select>
                            </div>


                            
                         

                            <div class="form-group">
  
                                <label for="description">Description <span style="color: red;">*</span></label>
                                <textarea id="description" name="description" cols="5" rows="5" class="form-control" autocomplete="off"></textarea>
                            </div>

                            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-info pull-right" id="announcement_add"><i class="fa fa-save"></i> Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

