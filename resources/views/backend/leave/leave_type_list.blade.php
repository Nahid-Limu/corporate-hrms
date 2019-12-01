@extends('layout.master')
@section('title', 'Leave Setting')
@section('content')
    <!--BEGIN TITLE & BREADCRUMB PAGE-->
    <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
        <div class="page-header pull-left">
            <div class="page-title">Leave</div>
        </div>
        <ol class="breadcrumb page-breadcrumb pull-right">
            <li><i class="fa fa-home"></i>&nbsp;<a href="{{url('/')}}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
            <li><a href="#">Leave</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
            <li class="active">Leave List</li>
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
                                        Leave List
                                    </div>
                                    <div class="col-md-6" style="text-align: right;">
                                        @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('super-admin'))
                                        <a href="" class="add-new-modal btn btn-success btn-round btn-sm" data-toggle="modal" data-target="#createLeave"> <i class="fa fa-plus"></i> Add New</a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="panel-body table-responsive">
                                <table id="leave" class="table table-striped table-bordered" >
                                    <thead>
                                    <tr>
                                        <th>SN</th>
                                        <th>Leave Type</th>
                                        <th>Total Days</th>
                                        <th>Policy</th>
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
    @include('backend.leave.modal.create')
    @include('backend.leave.modal.edit')
    <!-- Modal End -->
    </div>
@endsection

@section('extra_js')
<script>
    $(document).ready(function(){
    
        $('#leave').DataTable({
        processing: true,
        response:true,
        serverSide: true,
        "order": [[ 0, "desc" ]],
        ajax:{
        url: "{{ route('leave_list') }}",
        },
        columns:[
        { 
            data: 'DT_RowIndex', 
            name: 'DT_RowIndex' 
        },
        {
            data: 'leave_type',
            name: 'leave_type'
        },
        {
            data: 'total_days',
            name: 'total_days'
        },
        {
            data: 'policy',
            name: 'policy'
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


        //add leave
        $( "#leave_add" ).click(function() {
        var _token = '{{ csrf_token() }}';
        var myData = $('#leave_modal_form').serialize();
        //alert(_token);
            $.ajax({
                url:"{{route('leave_add')}}",
                method:"post",
                data: myData,
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
                    $('#leave_modal_form')[0].reset();
                    $('#leave').DataTable().ajax.reload();
                    $('#createLeave').modal('hide');
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

        //Edit leave
        $(document).on('click', '.edit', function(){
            var id = $(this).attr('id');
            $.ajax({
             type: "GET",
             url:"{{url('leave_edit')}}"+"/"+id,
             dataType:"json",
             success:function(response){
                 //console.log(response);
                 $('#id').val(response.id);
                 $('#edit_leave_type').val(response.leave_type);
                 $('#edit_total_days').val(response.total_days);
                 $('#edit_policy').val(response.policy);
                 $("#status option[value=" + response.status + "]").prop('selected', true);
             }
            })
           });

        
        //update leave
        $( "#leave_update" ).click(function() {
            var _token = '{{ csrf_token() }}';
            var editLeave = $('#edit_leave_modal_form').serialize();
            // alert(editLeave);
                $.ajax({
                    url:"{{route('leave_update')}}",
                    method:"post",
                    data: editLeave,
                    success:function (response) {
                        //console.log(response);
                        var html = '';
                        if(response.errors)
                        {
                        html = '<div class="alert alert-danger">';
                        
                        html += '<p>' + response.errors + '</p>';
                        
                        html += '</div>';
                        $('#edit_form_result').html(html);
                        }
                        if(response.falied)
                        {
                            swal(response.falied, "", "warning");
                        }
                        if(response.success)
                        {
                            swal(response.success, "", "success");
                            $('#edit_form_result').hide();
                            $('#edit_leave_modal_form')[0].reset();
                            $('#leave').DataTable().ajax.reload();
                            $('#editLeave').modal('hide');
                        }
                        
                    }
                });
            });
    
    
    });
    </script>
@endsection