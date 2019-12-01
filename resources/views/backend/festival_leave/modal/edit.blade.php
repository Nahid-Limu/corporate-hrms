<div id="edit_festival_leave" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content animated bounceInLeft">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Edit Festival Leave</h4>
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
                    <form id="edit_festival_leave_modal_form">
                        @csrf
                    <div class="panel-body">
                          <!-- =============== Group Name ============= -->

                        <div class="form-group">
                            <label for="edit_title">Title <span style="color:red">*</span></label>
                            <input type="text" class="form-control" id="edit_title" name="edit_title" required autocomplete="off" placeholder="Title">
                        </div> 
                          <!-- =============== End Group Name ============= -->  

                        <!-- =============== End Group Leader ============= -->


                        <div class="form-group">
                           
                             <label for="edit_start_date">Start Date <span style="color: red;">*</span> </label>
                                <input type="date" class="form-control" id="edit_start_date" name="edit_start_date" autocomplete="off">
                        </div> 
                        <div class="form-group">
                           
                             <label for="edit_end_date">End Date <span style="color: red;">*</span> </label>
                                <input type="date" class="form-control" id="edit_end_date" name="edit_end_date" autocomplete="off">
                        </div> 

                   

                        <!-- =============== Remarks ============= -->
                        
                        <div class="form-group">
                            <label for="edit_remarks">Remarks</label>
                            <textarea id="edit_remarks" name="edit_remarks" cols="5" rows="5" class="form-control" autocomplete="off"></textarea>
                        </div>
                        <!-- =============== End Remarks ============= -->
                         <input type="hidden" name="id" id="id">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-info pull-right" id="festival_leave_Update"><i class="fa fa-save"></i> Save</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>




 