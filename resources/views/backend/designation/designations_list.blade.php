@extends('layout.master')
@section('title', 'Designation Setting')
@section('content')
    <!--BEGIN TITLE & BREADCRUMB PAGE-->
    <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
        <div class="page-header pull-left">
            <div class="page-title">Designation</div>
        </div>
        <ol class="breadcrumb page-breadcrumb pull-right">
            <li><i class="fa fa-home"></i>&nbsp;<a href="{{url('/')}}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
            <li><a href="#">Designation</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
            <li class="active">Designation List</li>
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
                                        Designation List
                                    </div>
                                    <div class="col-md-6" style="text-align: right;">
                                        <a href="" class="add-new-modal btn btn-success btn-round btn-sm" data-toggle="modal" data-target="#createDesignation"> <i class="fa fa-plus"></i> Add New</a>
                                    </div>
                                </div>
                            </div>
                            <div class="panel-body table-responsive">
                                <table id="designation" class="table table-striped table-bordered" >
                                    <thead>
                                    <tr>
                                        <th>SN</th>
                                        <th >Designation Name</th>
                                        <th>Status</th>
                                        <th>Created By</th>
                                        <th >Action</th>
                                    </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
    <!-- Modal Start -->
    @include('backend.designation.modal.create')
    @include('backend.designation.modal.edit')
    <!-- Modal End -->
    </div>
@endsection

@section('extra_js')
<script>
    $(document).ready(function(){
    
        $('#designation').DataTable({
        processing: true,
        serverSide: true,
        "order": [[ 1, "asc" ]],
        ajax:{
        url: "{{ route('designations_list') }}",
        },
        columns:[
        { 
            data: 'DT_RowIndex', 
            name: 'DT_RowIndex' 
        },
        {
            data: 'designation_name',
            name: 'designation_name'
        },
        {
            data: 'status',
            name: 'status',
            render: function(data, type, full, meta){
                return data == '1' ? '<span style="color:green">Active</span>' : '<span style="color:red">InActive</span>'
            },
        },
        
        {
            data: 'name',
            name: 'name'
        },
        {
            data: 'action',
            name: 'action',
            orderable: false
        }
        ]
        });


        //add designation
        $( "#designation_add" ).click(function() {
        var _token = '{{ csrf_token() }}';
        var designation_name = $("#designation_name").val();
        var remarks = $("#remarks").val();
        //alert(_token);
            $.ajax({
                url:"{{route('designation_add')}}",
                method:"post",
                data: {_token : _token, designation_name : designation_name, remarks : remarks},
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
                    $('#modal_form')[0].reset();
                    $('#designation').DataTable().ajax.reload();
                    $('#createDesignation').modal('hide');
                    }
                    
                }
            });
        });

        //edit designation
        $(document).on('click', '.edit', function(){
            var id = $(this).attr('id');
            //alert(id);
            //$('#form_result').html('');
            $.ajax({
             type: "GET",
             url:"{{url('designation_edit')}}"+"/"+id,
             dataType:"json",
             success:function(response){
                 //console.log(response);
                 $('#id').val(response.id);
                 $('#edit_designation_name').val(response.designation_name);
                 $('#edit_remarks').val(response.remarks);
                 //$("input[name=status][value=" + value + "]").prop('checked', true);
                 $("#status option[value=" + response.status + "]").prop('selected', true);
             }
            })
           });

        
        //update designation
        $( "#designation_update" ).click(function() {
            var _token = '{{ csrf_token() }}';
            var id = $("#id").val();
            var designation_name = $("#edit_designation_name").val();
            var remarks = $("#edit_remarks").val();
            var status = $("#status").val();
            //alert(remarks);
                $.ajax({
                    url:"{{route('designation_update')}}",
                    method:"post",
                    data: {_token : _token, id : id, designation_name : designation_name, remarks : remarks, status : status},
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
                            $('#edit_form_result').hide();
                            $('#modal_form')[0].reset();
                            $('#designation').DataTable().ajax.reload();
                            $('#editDesignation').modal('hide');
                        }
                        
                    }
                });
            });
    
    
    });
    </script>
@endsection