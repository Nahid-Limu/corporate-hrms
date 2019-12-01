@extends('layout.master')
@section('title', 'Branch List')
@section('content')
    <!--BEGIN TITLE & BREADCRUMB PAGE-->
    <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
        <div class="page-header pull-left">
            <div class="page-title">Branch List</div>
        </div>
        <ol class="breadcrumb page-breadcrumb pull-right">
            <li><i class="fa fa-home"></i>&nbsp;<a href="{{url('/')}}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
            <li><a href="#">Branch</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
            <li class="active">Branch List</li>
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
                                            Branch List
                                    </div>
                                    <div class="col-md-6" style="text-align: right;">
                                         @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('super-admin'))
                                        <a href="" class="add-new-modal btn btn-success btn-round btn-sm" data-toggle="modal" data-target="#createBranch"> <i class="fa fa-plus"></i> Add New</a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="panel-body table-responsive">
                                <table id="branch" class="table table-striped table-bordered" >
                                    <thead>
                                    <tr>
                                        <th>SN</th>
                                        <th>Branch</th>
                                        <th>Address</th>
                                        <th>Status</th>
                                        <th>Created By</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
    <!-- Modal Start -->
    @include('backend.branch.modal.create')
    @include('backend.branch.modal.edit')
    <!-- Modal End -->
    </div>
@endsection

@section('extra_js')
<script>
    $(document).ready(function(){
    
        $('#branch').DataTable({
        processing: true,
        serverSide: true,
        "order": [[ 0, "desc" ]],
        ajax:{
        url: "{{ route('branch_list') }}",
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
            data: 'address',
            name: 'address'
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


        //add departments
        $( "#branch_add" ).click(function() {
        var _token = '{{ csrf_token() }}';
        var myData = $('#branch_modal_form').serialize();
        //alert(_token);
            $.ajax({
                url:"{{route('branch_add')}}",
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
                    $('#branch_modal_form')[0].reset();
                    $('#branch').DataTable().ajax.reload();
                    $('#createBranch').modal('hide');
                    }
                    
                }
            });
        });

        //Edit branch
        $(document).on('click', '.edit', function(){
            var id = $(this).attr('id');
            //alert(id);
            //$('#form_result').html('');
            $.ajax({
             type: "GET",
             url:"{{url('branch_edit')}}"+"/"+id,
             dataType:"json",
             success:function(response){
                 //console.log(response);
                 $('#id').val(response.id);
                 $('#edit_branch_name').val(response.branch_name);
                 $('#edit_address').val(response.address);
                 //$("input[name=status][value=" + value + "]").prop('checked', true);
                 $("#status option[value=" + response.status + "]").prop('selected', true);
             }
            })
           });

        
        //update branch
        $( "#branch_update" ).click(function() {
            var _token = '{{ csrf_token() }}';
            var editData = $('#edit_branch_modal_form').serialize();
            //alert(department_name);
                $.ajax({
                    url:"{{route('branch_update')}}",
                    method:"post",
                    data: editData,
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
                            $('#edit_branch_modal_form')[0].reset();
                            $('#branch').DataTable().ajax.reload();
                            $('#editBranch').modal('hide');
                        }
                        
                    }
                });
            });
    
    
    });
    </script>
@endsection
