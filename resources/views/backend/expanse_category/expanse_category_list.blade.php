@extends('layout.master')
@section('title', 'Expense Category List')
@section('content')
    <!--BEGIN TITLE & BREADCRUMB PAGE-->
    <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
        <div class="page-header pull-left">
            <div class="page-title">Expense Category List</div>
        </div>
        <ol class="breadcrumb page-breadcrumb pull-right">
            <li><i class="fa fa-home"></i>&nbsp;<a href="{{url('/')}}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
            <li><a href="#">Expense Category</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
            <li class="active">List</li>
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
                                        Expense Category List
                                    </div>
                                     {{-- @permission('expense_create') --}}
                                    <div class="col-md-6" style="text-align: right;">
                                        <a href="" class="add-new-modal btn btn-success btn-square btn-sm" data-toggle="modal" data-target="#expanse_category"> <i class="fa fa-plus"></i> Add New</a>
                                    </div>
                                     {{-- @endpermission --}}
                                </div>
                            </div>
                            <div class="panel-body">
                                <table id="expense" class="table table-striped table-bordered" >
                                    <thead>
                                    <tr> 
                                        <th>SN</th>
                                        <th>Category Name</th>
                                        <th>Status</th>
                                        <th>Description</th>
                                         {{-- @permission('manage_expense') --}}
                                        <th>Action</th>
                                         {{-- @endpermission --}}
                                    </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
    <!-- Modal Start -->
    @include('backend.expanse_category.modal.create')
    @include('backend.expanse_category.modal.edit')
    <!-- Modal End -->
    </div>
@endsection

@section('extra_js')
<script>
    $(document).ready(function(){
    
        $('#expense').DataTable({
        processing: true,
        serverSide: true,
        "order": [[ 1, "desc" ]],
        ajax:{
        url: "{{ route('expansecategory_list') }}",
        },
        columns:[
        { 
            data: 'DT_RowIndex', 
            name: 'DT_RowIndex' 
        },
        {
            data: 'category_name',
            name: 'category_name'
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
            data: 'description',
            name: 'description'
        },
        {
            data: 'action',
            name: 'action',
            orderable: false
        }
        ]
        });


        //add leave
        $( "#expanse_category_add" ).click(function() {
        var _token = '{{ csrf_token() }}';
        var categoryData = $('#expanse_category_modal_form').serialize();
        
        //console.log(categoryData);
        //alert(_token);
            $.ajax({
                url:"{{route('expansecategory_add')}}",
                method:"post",
                data: categoryData,
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
                    $('#expanse_category_modal_form')[0].reset();
                    $('#expense').DataTable().ajax.reload();
                    $('#expanse_category').modal('hide');
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
             url:"{{url('expansecategory_edit')}}"+"/"+id,
             dataType:"json",
             success:function(response){
                 //console.log(response);
                 $('#id').val(response.id);
                 $('#edit_category_name').val(response.category_name);
                 $('#edit_description').val(response.description);
                 $("#status option[value=" + response.status + "]").prop('selected', true);
             }
            })
           });

        
        //update leave
        $( "#expansecategory_update" ).click(function() {
            var _token = '{{ csrf_token() }}';
            var editexpansecategory = $('#edit_expansecategory_modal_form').serialize();
            //alert(department_name);
                $.ajax({
                    url:"{{route('expansecategory_update')}}",
                    method:"post",
                    data: editexpansecategory,
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
                            $('#edit_expansecategory_modal_form')[0].reset();
                            $('#expense').DataTable().ajax.reload();
                            $('#editexpansecategory').modal('hide');
                        }
                        
                    }
                });
            });
    
    
    });
    </script>
@endsection