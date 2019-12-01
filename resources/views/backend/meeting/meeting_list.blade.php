@extends('layout.master')
@section('title')
    Meeting  list
@endsection
@section('content')
    <!--BEGIN TITLE & BREADCRUMB PAGE-->
    <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
        <div class="page-header pull-left">
            <div class="page-title">Meeting List</div>
        </div>
        <ol class="breadcrumb page-breadcrumb pull-right">
            <li><i class="fa fa-home"></i>&nbsp;<a href="{{url('/')}}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
            <li><a href="#">Meeting</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
            <li class="active">Meeting List</li>
        </ol>
        <div class="clearfix"></div>
    </div>
    <!--END TITLE & BREADCRUMB PAGE-->

    <!--Flash Message Start-->
    @if(Session::has('success'))
        <p id="alert_message" class="alert alert-success">{{ Session::get('success') }}</p>
    @endif
    @if(Session::has('error'))
        <p id="alert_message" class="alert alert-error">{{ Session::get('error') }}</p>
    @endif
    <!--Flash Message End-->
    <div class="page-content">

        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-blue">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-md-6">
                                Meeting List
                            </div>
                            <div class="col-md-6" style="text-align: right;">
                                <a href="" class="add-new-modal btn btn-success btn-round btn-sm" data-toggle="modal" data-target="#createMeeting"> <i class="fa fa-plus"></i> Add Meeting</a>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body table-responsive">
                        <table id="metting_table" class="table table-striped table-bordered" >
                            <thead>
                            <tr>
							    <th>SN</th>
							    <th>Branch Name</th>
                                <th>Meeting Name</th>
                                <th>Place</th>
                                <th>Date</th>
                                <th>Start Time</th>
                                <th>End Time</th>
                                <th>Details</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    <!-- Modal Start -->
    @include('backend.meeting.modal.create')
    @include('backend.meeting.modal.edit')
    <!-- Modal End -->
    </div>
@endsection

@section('extra_js')
    <script>
        $(document).ready(function(){
            //Meeting List
            $('#metting_table').DataTable({
                processing: true,
                serverSide: true,
                "order": [[ 1, "desc" ]],
                ajax:{
                    url: "{{ route('meeting_list') }}",
                },
                columns:[
                    {
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                    },
                    {
                        data: 'branch_name',
                        name: 'branch_name'
                    },
                    {
                        data: 'meeting_subject',
                        name: 'meeting_subject'
                    },
                    {
                        data: 'venue',
                        name: 'venue'
                    },
                    {
                        data: 'meeting_date',
                        name: 'meeting_date'
                    },
                    {
                        data: 'start_time',
                        name: 'start_time'
                    },
                    {
                        data: 'end_time',
                        name: 'end_time'
                    },

                    {
                        data: 'description',
                        name: 'description'
                    },
                    {
                        data: 'status',
                        name: 'status',
                        render: function(data, type, full, meta){
                            return data == '1' ? '<span style="color:green">Active</span>' : '<span style="color:red">InActive</span>'
                        },
                    },

                    {
                        data: 'action',
                        name: 'action',
                        orderable: false
                    }
                ]
            });


            //Meeting Add
            $( "#meeting_add" ).click(function() {
                var _token = '{{ csrf_token() }}';
                var meeting_subject = $("#meeting_subject").val();
                var branch_id = $("#branch_id").val();
                var venue = $("#venue").val();
                var meeting_date = $("#meeting_date").val();
                var start_time = $("#start_time").val();
                var end_time = $("#end_time").val();
                var description = $("#description").val();
                //alert(_token);
                $.ajax({
                    url:"{{route('meeting_add')}}",
                    method:"post",
                    data: {_token : _token,branch_id:branch_id, meeting_subject : meeting_subject, venue : venue,meeting_date:meeting_date,start_time:start_time,end_time:end_time,description:description},
                    success:function (response) {

                        var html = '';
                        if(response.errors)
                        {
                            html = '<div class="alert alert-danger">';
                            for(var count = 0; count < response.errors.length; count++)
                            {
                                html += '<p>' + response.errors[count] + '</p>';
                            }
                            html += '</div>';
                            $('#form_result').html(html);
                        }

                        if(response.success)
                        {
                            swal(response.success, "", "success");
                            $('#meeting_modal_form')[0].reset();
                            $('#metting_table').DataTable().ajax.reload();
                            $('#createMeeting').modal('hide');
                        }

                    }
                });
            });


            //Edit Meeting
            $(document).on('click', '.edit', function(){
                var id = $(this).attr('id');
                $.ajax({
                    type: "GET",
                    url:"{{url('meeting/edit')}}"+"/"+id,
                    dataType:"json",
                    success:function(response){
                        $('#id').val(response.id);
                        $('#edit_meeting_subject').val(response.meeting_subject);
                        $('#edit_venue').val(response.venue);
                        $('#edit_meeting_date').val(response.meeting_date);
                        $('#edit_start_time').val(response.start_time);
                        $('#edit_end_time').val(response.end_time);
                        $('#edit_description').val(response.description);
                        $('#edit_status').val(response.status);
                        $("#edit_branch option[value="+response.branch_id+"]").attr("selected","selected")
                        $("#edit_branch").select2().select2('+response.branch_id+','+response.branch_name+');
                    },
                    error:function(response){
                        console.log(response);
                    }

                })
            });

            //update Meeting
            $( "#meeting_update" ).click(function() {
                var _token = '{{ csrf_token() }}';
                var id = $("#id").val();
                var edit_meeting_subject = $("#edit_meeting_subject").val();
                var edit_venue = $("#edit_venue").val();
                var edit_meeting_date = $("#edit_meeting_date").val();
                var edit_start_time = $("#edit_start_time").val();
                var edit_end_time = $("#edit_end_time").val();
                var edit_description = $("#edit_description").val();
                var edit_status = $("#edit_status").val();
                var edit_branch = $("#edit_branch").val();
                $.ajax({
                    url:"{{route('meeting_update')}}",
                    method:"post",
                    data: {_token : _token, id : id,edit_branch:edit_branch, edit_meeting_subject : edit_meeting_subject, edit_venue : edit_venue,edit_meeting_date:edit_meeting_date,edit_start_time:edit_start_time,edit_end_time:edit_end_time ,edit_description:edit_description,edit_status:edit_status},
                    success:function (response) {
                        var html = '';
                        if(response.errors)
                        {
                            html = '<div class="alert alert-danger">';

                            html += '<p>' + response.errors + '</p>';

                            html += '</div>';
                            $('#form_results_edit').html(html);
                        }
                        if(response.success)
                        {
                            swal(response.success, "", "success");
                            $('#edit_meeting_modal_form')[0].reset();
                            $('#metting_table').DataTable().ajax.reload();
                            $('#editMeeting').modal('hide');
                        }
                    }
                });
            });

            //Delete
            $(document).on('click', '.delete', function(){
                var _token = '{{ csrf_token() }}';
                var id = $(this).attr('id');

                swal({
                    title: "Are you sure?",
                    text: "Once deleted, you will not be able to recover this Meeting file!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                if(willDelete) {
                    $.ajax({

                        type: "POST",
                        url:"{{url('meeting/delete')}}"+"/"+id,
                        data: {_token : _token, id : id},
                        success:function (response) {

                            if(response.success)
                            {

                                $('#metting_table').DataTable().ajax.reload();

                            }
                        }
                    });
                    swal(" Meeting has successfully  Deleted!", {
                    icon: "success",
                    });
                }
                })

            })



            $('#end_time_t').datetimepicker({
                pickDate: false
            });
            $('#start_time_t').datetimepicker({
                pickDate: false
            });

            $('#edit_start_time_t').datetimepicker({
                pickDate: false
            });
            $('#edit_end_time_t').datetimepicker({
                pickDate: false
            });
            $("#branch_id").select2();
            $("#edit_branch").select2();


        });
    </script>
@endsection
