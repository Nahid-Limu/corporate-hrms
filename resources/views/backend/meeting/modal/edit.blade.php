<div id="editMeeting" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><i class="fa fa-plus"></i> Edit Meeting</h4>
            </div>
            <div class="modal-body">
                <!-- Error list Start -->
                <span id="form_results_edit"></span>
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
                    <form  id="edit_meeting_modal_form">
                        <div class="panel-body">

                            <div class="form-group">
                                <label for="edit_branch">Select Branch<span style="color: red;">*</span> </label>
                                <select name="edit_branch" id="edit_branch"  class="select2-container form-control" required>
                                    @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('super-admin'))                                   
                                    <option value="">Select Branch</option>
                                    @foreach($branch_list as $branchs)
                                        <option value="{{$branchs->id}}">{{$branchs->branch_name}}</option>
                                    @endforeach
                                    @else 
                                      <option value="{{$branch_list2->id}}">{{$branch_list2->branch_name}}</option>
                                    @endif
                                   
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="edit_meeting_subject">Meeting Subject<span style="color: red;">*</span> </label>
                                <input type="text" class="form-control" id="edit_meeting_subject" name="meeting_subject" >
                             
                            
                            </div>

                            <div class="form-group">
                                <label for="edit_venue">Location <span style="color: red;">*</span></label>
                                <input type="text" class="form-control" id="edit_venue" name="venue">
                            </div>
                            
                            <div class="form-group">
                                <label for="edit_meeting_date">Meeting Date <span style="color: red;">*</span></label>
                                <input type="date" class="form-control" id="edit_meeting_date" name="meeting_date" >
                            </div>
                            <div class="form-group">
                                <label for="edit_start_time">Start Time</label>
                                <div class='input-group datetimepicker-disable-date date'  id='edit_start_time_t' >
                                    <input type='text' class="form-control" id="edit_start_time" name="start_time"/>
                                    <span class="input-group-addon">
                                        <span class="fa fa-clock-o"></span>
                                    </span>
                                </div>
                            </div>
                            <br><br>
                            <div class="form-group">
                                <label for="edit_end_time">End Time</label>
                                <div class='input-group datetimepicker-disable-date date'  id='edit_end_time_t' >
                                    <input type='text' class="form-control" id="edit_end_time" name="end_time"/>
                                    <span class="input-group-addon">
                                        <span class="fa fa-clock-o"></span>
                                    </span>
                                </div>
                            </div>
                            <br><br>

                            <div class="form-group">
                                <label for="edit_status">Status <span style="color: red;">*</span></label>
                                <select class="form-control" id="edit_status" name="edit_status">
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>
                           
                            <div class="form-group">
                                <label for="edit_description">Description <span style="color: red;">*</span></label>
                                <textarea id="edit_description" name="description" cols="5" rows="5" class="form-control" autocomplete="off"></textarea>
                            </div>

                            <input type="text"  hidden id="id" name="id">

                            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-info pull-right" id="meeting_update"><i class="fa fa-refresh"></i> Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

