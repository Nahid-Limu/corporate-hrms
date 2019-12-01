<div id="edit_view_assign_Task" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content animated bounceInTop">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" style="text-align: center;">View  Task</h4>
            </div>
            <div class="modal-body">
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
                    <div class="row">
                        <div class="col-md-12">
                            <form action="" id="edit_announcement_modal_form">
                                @csrf
                                <table class="table table-striped">

                                    <tbody>
                                    <tr>
                                        <td>Title</td>
                                        <td id="edit_view_task_title"></td>
                                    </tr>
                                    <tr>
                                        <td>Assign Date</td>
                                        <td id="edit_view_task_assign_date"></td>
                                    </tr>


                                    <tr>
                                        <td>Status</td>
                                        <td>
                                            <div class="form-group">

                                                <select class="form-control" id="edit_view_task_status" name="edit_view_task_status">
                                                    <option value="1">Pending</option>
                                                    <option value="2">On Going</option>
                                                    <option value="3">Completed</option>
                                                    <option value="4">Rejected</option>
                                                </select>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Remark</td>
                                        <td>
                                            <div class="form-group">
                                                <textarea id="remarks_id" name="remarks" cols="5" rows="2" class="form-control" placeholder="Remark" autocomplete="off"></textarea>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <input type="text" id="id" name="id" hidden>
                                        </td>
                                        <td>
                                            <div class="form-group ">
                                                <button type="button" class="btn btn-secondary " data-dismiss="modal">Close</button>
                                                <button class="btn btn-primary" id="task_view_edit_btn" type="button">Submit</button>
                                            </div>
                                        </td>
                                    </tr>


                                    </tbody>
                                </table>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
