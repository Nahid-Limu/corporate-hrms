<div id="createTask" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content animated bounceInLeft">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add New Task</h4>
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
                    <form method="post" id="task_modal_form" enctype="multipart/form-data">
                        @csrf
                    <div class="panel-body">
                        <div class="form-group">
                            <label for="title">Titile</label>
                            <input type="text" class="form-control" id="title" name="title" placeholder="Task Titile" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea id="description" name="description" cols="5" rows="3" class="form-control" placeholder="Description" autocomplete="off"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="attachment">Attachment</label>
                            <input type="file" class="form-control" id="attachment" name="attachment" >
                        </div>
                        <div class="form-group">
                            <label for="start_time">Start Time</label>
                            <div class='input-group datetimepicker-disable-date date'  id='entry' >
                                <input type='text' class="form-control" id="start_time" name="start_time" placeholder="Start Time" readonly/>
                                <span class="input-group-addon">
                                    <span class="fa fa-clock-o"></span>
                                </span>
                            </div>
                        </div>
                        <br><br>
                        <div class="form-group">
                            <label for="end_time">End Time</label>
                            <div class='input-group datetimepicker-disable-date date'  id='exit' >
                                <input type='text' class="form-control" id="end_time" name="end_time" placeholder="End Time" readonly/>
                                <span class="input-group-addon">
                                    <span class="fa fa-clock-o"></span>
                                </span>
                            </div>
                        </div>
                        <br><br>
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-info pull-right" id="task_add"><i class="fa fa-plus"></i> Save</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>