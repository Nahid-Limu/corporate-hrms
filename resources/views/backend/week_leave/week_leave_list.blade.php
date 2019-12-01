@extends('layout.master')
@section('title', 'Week Leave')
@section('content')
    <!--BEGIN TITLE & BREADCRUMB PAGE-->
    <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
        <div class="page-header pull-left">
            <div class="page-title">Week Leave</div>
        </div>
        <ol class="breadcrumb page-breadcrumb pull-right">
            <li><i class="fa fa-home"></i>&nbsp;<a href="{{url('/')}}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
            <li><a href="#">Week Leave</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
            <li class="active">Week Leave List</li>
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
                                        Week Leave List
                                    </div>
                                    <div class="col-md-6" style="text-align: right;">
                                        {{-- <a href="" class="add-new-modal btn btn-success btn-square btn-sm" data-toggle="modal" data-target="#weekLeave"> <i class="fa fa-plus"></i> Add New</a> --}}
                                    </div>
                                </div>
                            </div>
                            <div class="panel-body">
                                <table id="weekleave" class="table table-striped table-bordered" >
                                    <thead>
                                    <tr>    
                                        <th>SN</th>
                                        <th >Day Name</th>
                                        <th>Status</th>
                                        {{-- <th>Created By</i></th> --}}
                                        <th >Action</th>
                                    </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
    <!-- Modal Start -->
    @include('backend.week_leave.modal.create')
    @include('backend.week_leave.modal.edit')
    <!-- Modal End -->
    </div>
@endsection

@section('extra_js')
<script>
    $(document).ready(function(){
    
        $('#weekleave').DataTable({
        processing: true,
        serverSide: true,
        "order": [[ 1, "desc" ]],
        ajax:{
        url: "{{ route('weekleave_list') }}",
        },
        columns:[
        { 
            data: 'DT_RowIndex', 
            name: 'DT_RowIndex' 
        },
        {
            data: 'day',
            name: 'day'
        },
        {
            data: 'status',
            name: 'status',
            render: function(data, type, full, meta){
                // return data == '1' ? 'Active' : 'InActive'
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


        //add departments
        $( "#week_leave_add" ).click(function() {
        var _token = '{{ csrf_token() }}';
        var day = $("#day").val();
        // var status = $("#status").val();
        // alert(status);
            $.ajax({
                url:"{{route('weekleave_add')}}",
                method:"post",
                data: {_token : _token, day : day},
                success:function (response) {
                    // console.log(response);
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
                    $('#create_weekleave_form')[0].reset();
                    $('#weekleave').DataTable().ajax.reload();
                    $('#weekLeave').modal('hide');
                    }
                    
                }
            });
        });

        //Edit departments
        $(document).on('click', '.edit', function(){
            var id = $(this).attr('id');
            //alert(id);
            //$('#form_result').html('');
            $.ajax({
             type: "GET",
             url:"{{url('weekleave_edit')}}"+"/"+id,
             dataType:"json",
             success:function(response){
                 console.log(response);
                 $('#id').val(response.id);
                 $('#edit_day').val(response.day);
                $("#edit_status option[value=" + response.status + "]").prop('selected', true);
             }
            })
           });

        
        //update departments
        $( "#week_leave_update" ).click(function() {
            var _token = '{{ csrf_token() }}';
            var id = $("#id").val();
            var day = $("#edit_day").val();
            var status = $("#edit_status").val();
            // alert(status);
                $.ajax({
                    url:"{{route('weekleave_update')}}",
                    method:"post",
                    data: {_token : _token, id : id, day : day, status : status},
                    success:function (response) {
                
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
                            $('#edit_weekleave_modal_form')[0].reset();
                            $('#weekleave').DataTable().ajax.reload();
                            $('#editweekLeave').modal('hide');
                        }
                        
                    }
                });
            });
    
    
    });
    </script>
@endsection