<div id="createMeeting" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><i class="fa fa-plus"></i> Add New Meeting</h4>
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
                    <form action="" id="meeting_modal_form">
                        <div class="panel-body">
                            
                            <div class="form-group">
                                <label for="branch_id">Select Branch<span style="color: red;">*</span> </label>
                                <select name="branch_id" id="branch_id"  class="select2-container form-control" required>
                                    <option value="">Select Branch</option>
                                    @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('super-admin'))
                                    @foreach($branch_list as $branchs)
                                        <option value="{{$branchs->id}}">{{$branchs->branch_name}}</option>
                                    @endforeach
                                    @else 
                                        <option value="{{$branch_list2->id}}">{{$branch_list2->branch_name}}</option>
                                    @endif
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="meeting_subject">Meeting Title/Subject<span style="color: red;">*</span> </label>
                                <input type="text" class="form-control" id="meeting_subject" name="meeting_subject" autocomplete="off" placeholder="Meeting Title/Subject">
                            </div>

                            <div class="form-group">
                                <label for="venue">Location <span style="color: red;">*</span></label>
                                <input type="text" class="form-control" id="venue" name="venue" autocomplete="off" placeholder="Location">
                            </div>
                            
                            <div class="form-group">
                                <label for="meeting_date">Meeting Date <span style="color: red;">*</span></label>
                                <input type="date" class="form-control" id="meeting_date" name="meeting_date" autocomplete="off" placeholder="Meeting Date">
                            </div>
                            <div class="form-group">
                                <label for="start_time">Start Time</label>
                                <div class='input-group datetimepicker-disable-date date'  id='start_time_t' >
                                    <input type='text' class="form-control" id="start_time" placeholder="Start Time" name="start_time"/>
                                    <span class="input-group-addon">
                                        <span class="fa fa-clock-o"></span>
                                    </span>
                                </div>
                            </div>
                            <br><br>
                            <div class="form-group">
                                <label for="end_time">End Time</label>
                                <div class='input-group datetimepicker-disable-date date'  id='end_time_t' >
                                    <input type='text' class="form-control" id="end_time" placeholder="End Time" name="end_time"/>
                                    <span class="input-group-addon">
                                        <span class="fa fa-clock-o"></span>
                                    </span>
                                </div>
                            </div>
                            <br><br>

                            

                            <div class="form-group">
                                <label for="remarks">Description <span style="color: red;">*</span></label>
                                <textarea id="description" name="description" cols="5" rows="5" class="form-control" autocomplete="off" placeholder="Description"></textarea>
                            </div>

                            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-info pull-right" id="meeting_add"><i class="fa fa-plus"></i> Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

