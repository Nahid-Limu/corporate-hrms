@extends('layout.master')
@section('title', 'Festival Leave')
@section('content')
    <!--BEGIN TITLE & BREADCRUMB PAGE-->
    <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
        <div class="page-header pull-left">
            <div class="page-title">Festival Leave</div>
        </div>
        <ol class="breadcrumb page-breadcrumb pull-right">
            <li><i class="fa fa-home"></i>&nbsp;<a href="{{url('/')}}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
            <li><a href="#">Festival Leave</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
            <li class="active">Festival Leave List</li>
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
    @if(Session::has('delete'))
        <p id="alert_message" class="alert alert-danger">{{ Session::get('delete') }}</p>
    @endif
    <!--Flash Message End-->
    <div class="page-content">

            <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-blue">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-md-6">
                                       Festival Leave List
                                    </div>
                                    <div class="col-md-6" style="text-align: right;">
                                         @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('super-admin'))
                                        <a href="" class="add-new-modal btn btn-success btn-square btn-sm" data-toggle="modal" data-target="#festival_leave"> <i class="fa fa-plus"></i> Add New</a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="panel-body">
                                <table id="FestivalLeavetable" class="table table-striped table-bordered" >
                                    <thead>
                                    <tr>   
                                        <th>SN</th>
                                        <th>Title</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th>Remarks</th>
                                    </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
    <!-- Modal Start -->
    @include('backend.festival_leave.modal.create')
    @include('backend.festival_leave.modal.edit')
    <!-- Modal End -->
    </div>
@endsection

@section('extra_js')
<script> 

   // =============== Index List ============= --> 

    // $("#group_leader_id").select2();
    // $("#edit_group_leader_id").select2();
    $(document).ready(function(){
    
        $('#FestivalLeavetable').DataTable({
        processing: true,
        serverSide: true,
        "order": [[ 1, "desc" ]],
        ajax:{
        url: "{{ route('festival_leave_list') }}",
        },
        columns:[
        { 
            data: 'DT_RowIndex', 
            name: 'DT_RowIndex' 
        },
        {
            data: 'title',
            name: 'title'
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
            data: 'remarks',
            name: 'remarks',
        }
        ]
        });

   // =============== End Index List ============= --> 

   // =============== ADD group ============= --> 
        $( "#festival_leave_add" ).click(function() {
        var _token = '{{ csrf_token() }}';
        var severanceData = $('#festival_leave_modal_form').serialize();
        //alert(_token);
            $.ajax({
                url:"{{route('festival_leave_add')}}",
                method:"post",
                data: severanceData,
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
                    $('#festival_leave_modal_form')[0].reset();
                    $('#FestivalLeavetable').DataTable().ajax.reload();
                    $('#festival_leave').modal('hide');
                    }
                    
                },
                error: function(jqXHR, exception) {
                    if (jqXHR.status === 0) {
                        console.log('Not connect.\n Verify Network.');
                    } else if (jqXHR.status == 404) {
                        console.log('Requested page not found. [404]');
                    } else if (jqXHR.status == 500) {
                        console.log('Internal Server Error [500].');
                    } else if (exception === 'parsererror') {
                        console.log('Requested JSON parse failed.');
                    } else if (exception === 'timeout') {
                        console.log('Time out error.');
                    } else if (exception === 'abort') {
                        console.log('Ajax request aborted.');
                    } else {
                        console.log('Uncaught Error.\n' + jqXHR.responseText);
                    }
                }
            });
        });
   // =============== End Add group ============= --> 

   // =============== Edit group ============= --> 
        $(document).on('click', '.edit', function(){
            var id = $(this).attr('id');
            $.ajax({
             type: "GET",
             url:"{{url('festival_leave_edit')}}"+"/"+id,
             dataType:"json",
             success:function(response){
                 console.log(response);
                 $('#id').val(response.id);
                 $('#edit_title').val(response.title);
                 $('#edit_start_date').val(response.start_date);
                 $('#edit_end_date').val(response.end_date);
                 $('#edit_remarks').val(response.remarks);
             }
            })
           });
   // =============== End Edit group ============= --> 

   // =============== Update group ============= --> 
        $( "#festival_leave_Update" ).click(function() {
            var _token = '{{ csrf_token() }}';
            var editSeverance = $('#edit_festival_leave_modal_form').serialize();
            //alert(department_name);
                $.ajax({
                    url:"{{route('festival_leave_update')}}",
                    method:"post",
                    data: editSeverance,
                    success:function (response) {
                        //console.log(response);
                        var html = '';
                        if(response.errors)
                        {
                        html = '<div class="alert alert-danger">';
                        
                        html += '<p>' + response.errors + '</p>';
                        
                        html += '</div>';
                        $('#festival_leave_update').html(html);
                        }
                        if(response.falied)
                        {
                            swal(response.falied, "", "warning");
                        }
                        if(response.success)
                        {
                            swal(response.success, "", "success");
                            $('#edit_festival_leave_modal_form')[0].reset();
                            $('#FestivalLeavetable').DataTable().ajax.reload();
                            $('#edit_festival_leave').modal('hide');
                        }
                        
                    }
                });
            });


           

    }); 

   // =============== End Update group ============= --> 

    </script>
@endsection





 
