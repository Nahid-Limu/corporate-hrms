@extends('layout.master')
<style>
.input-group.datetimepicker-disable-date input{
    background: #fff;
}
</style>

@section('content')
    <!--BEGIN TITLE & BREADCRUMB PAGE-->
    <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
        <div class="page-header pull-left">
            <div class="page-title">Announcement List</div>
        </div>
        <ol class="breadcrumb page-breadcrumb pull-right">
            <li><i class="fa fa-home"></i>&nbsp;<a href="{{url('/')}}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
            <li><a href="#">Announcement</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
            <li class="active">Announcement List</li>
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
                                Announcement 
                            </div>
                            <div class="col-md-6" style="text-align: right;">
                                <a href="" class="add-new-modal btn btn-success btn-round btn-sm" data-toggle="modal" data-target="#createAnnouncement"> <i class="fa fa-plus"></i> Add Announcement</a>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body table-responsive">
                        <table id="announcement_table" class="table table-striped table-bordered" >
                            <thead>
                            <tr>
							    <th>SN</th>
                                <th>Announcement Title</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Description</th>
                                <th>Branch Name</th>
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
    @include('backend.announcement.modal.create')
    @include('backend.announcement.modal.edit')
    <!-- Modal End -->
    </div>
@endsection

@section('extra_js')
    <script>
        $(document).ready(function(){
            //Meeting List
            $('#announcement_table').DataTable({
                processing: true,
                serverSide: true,
                "order": [[ 1, "desc" ]],
                ajax:{
                    url: "{{ route('announcement_list') }}",
                },
                columns:[
				{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                    },
                    {
                        data: 'announcement_title',
                        name: 'announcement_title'
                    },
                    
                    {
                        data: 'start_date',
                        name: 'start_date'
                    },
                    {
                        data: 'end_date',
                        name: 'end_date'
                    },
                    {
                        data: 'description',
                        name: 'description'
                    },
                    {
                        data: 'ann_branch_id',
                        name: 'ann_branch_id'
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

            //Announcement Add
            $( "#announcement_add" ).click(function() {
                var _token = '{{ csrf_token() }}';
                var announcement_title = $("#announcement_title").val();
                var start_date = $("#start_date").val();
                var end_date = $("#end_date").val();
                var ann_branch_id = $("#ann_branch_id").val();
                var description = $("#description").val();
                
               
                //alert(_token);
                $.ajax({
                    url:"{{route('announcement_add')}}",
                    method:"post",
                    data: {_token : _token, announcement_title : announcement_title, start_date:start_date,end_date:end_date,ann_branch_id:ann_branch_id,description:description},
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
                            $('#announcement_modal_form')[0].reset();
                            $('#announcement_table').DataTable().ajax.reload();
                            $('#createAnnouncement').modal('hide');
                        }
                    }
                });
            });

            //Edit Meeting
            
            $(document).on('click', '.edit', function(){
                var id = $(this).attr('id');
                $.ajax({
                    type: "GET",
                    url:"{{url('announcement/edit')}}"+"/"+id,
                    dataType:"json",
                    success:function(response){
                        $('#id').val(response.id);
                        $('#edit_announcement_title').val(response.announcement_title);
                        $('#edit_start_date').val(response.start_date);
                        $('#edit_end_date').val(response.end_date);
                        $('#edit_ann_branch_id').val(response.ann_branch_id);
                        $('#edit_description').val(response.description);
                        $('#edit_status').val(response.status);
                    },
                    error:function(response){
                        console.log(response);
                    }
                })
            });
            //update Meeting
          
            $('#editbtn_announcement').click(function(){
                var _token = '{{ csrf_token() }}';
                var id=$('#id').val();
                var edit_announcement_title=$('#edit_announcement_title').val();
                var edit_start_date=$('#edit_start_date').val();
                var edit_end_date=$('#edit_end_date').val();
                var edit_ann_branch_id=$('#edit_ann_branch_id').val();
                var edit_description=$('#edit_description').val();
                var edit_status=$('#edit_status').val();

                $.ajax({
                    url:"{{route('announcement_update')}}",
                    method:"post",
                    data: {_token : _token, id : id, edit_announcement_title : edit_announcement_title, edit_start_date:edit_start_date , edit_end_date:edit_end_date ,edit_ann_branch_id:edit_ann_branch_id, edit_description:edit_description,edit_status:edit_status},
                    success:function (response) {
                        var html = '';
                        if(response.errors)
                        {
                            html = '<div class="alert alert-danger">';

                            html += '<p>' + response.errors + '</p>';

                            html += '</div>';
                            $('#form_result_edit').html(html);
                        }
                        if(response.success)
                        {
                            swal(response.success, "", "success");
                          
                            $('#edit_announcement_modal_form')[0].reset();
                            $('#announcement_table').DataTable().ajax.reload();
                            $('#editAnnouncement').modal('hide');
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
                    text: "Once deleted, you will not be able to recover this Announcement file!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                if (willDelete) {
                    $.ajax({

                        type: "POST",
                        url:"{{url('announcement/delete')}}"+"/"+id,
                        data: {_token : _token, id : id},
                        success:function (response) {
                            if(response.success)
                            {
                                $('#announcement_table').DataTable().ajax.reload();
                            }
                        }
                    });
                    swal(" Announcement has successfully  Deleted!", {
                    icon: "success",
                    });
                }
                });
                
            })

           $("#ann_branch_id").select2();
           $("#edit_ann_branch_id").select2();

        });
    </script>
@endsection
