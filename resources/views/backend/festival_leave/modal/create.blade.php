<div id="festival_leave" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content animated bounceInLeft">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add New Festival Leave</h4>
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
                    <form id="festival_leave_modal_form">
                        @csrf
                    <div class="panel-body">
                          <!-- =============== Group Name ============= -->

                        <div class="form-group">
                            <label for="title">Title <span style="color:red">*</span></label>
                            <input type="text" class="form-control" id="title" name="title" required autocomplete="off" placeholder="Title">
                        </div> 
                          <!-- =============== End Group Name ============= -->  

                        <!-- =============== End Group Leader ============= -->


                        <div class="form-group">
                           
                             <label for="start_date">Start Date <span style="color: red;">*</span> </label>
                                <input type="date" class="form-control" id="start_date" name="start_date" autocomplete="off">
                        </div> 
                        <div class="form-group">
                           
                             <label for="end_date">End Date <span style="color: red;">*</span> </label>
                                <input type="date" class="form-control" id="end_date" name="end_date" autocomplete="off">
                        </div> 

                   

                        <!-- =============== Remarks ============= -->
                        
                        <div class="form-group">
                            <label for="remarks">Remarks <span style="color:red">*</span></label>
                            <textarea id="remarks" name="remarks" cols="5" rows="5" class="form-control" autocomplete="off"></textarea>
                        </div>
                        <!-- =============== End Remarks ============= -->

                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-info pull-right" id="festival_leave_add"><i class="fa fa-save"></i> Save</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>




 