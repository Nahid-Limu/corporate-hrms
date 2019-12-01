@extends('layout.master') 

    @if (Lang::locale()=='bn') 
        @section('title', 'গ্রুপ কর্মচারী')
        @else 
        @section('title', 'Group Employee')                                        
    @endif

{{-- @section('title', 'Group Employee') --}}
@section('content')
    <!--BEGIN TITLE & BREADCRUMB PAGE-->
    <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
        <div class="page-header pull-left">
            <div class="page-title"> <?php if(Lang::has('group_employee_list.group_employee')){ echo Lang::get('group_employee_list.group_employee'); }else{ echo "Group Employee"; } ?> </div>
        </div>
        <ol class="breadcrumb page-breadcrumb pull-right">
            <li><i class="fa fa-home"></i>&nbsp;<a href="{{url('/')}}"><?php if(Lang::has('group_employee_list.home')){ echo Lang::get('group_employee_list.home'); }else{ echo "Home"; } ?></a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
            <li><a href="#"><?php if(Lang::has('group_employee_list.group_employee')){ echo Lang::get('group_employee_list.group_employee'); }else{ echo "Group Employee"; } ?></a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
            <li class="active"> <?php if(Lang::has('group_employee_list.group_employee_list')){ echo Lang::get('group_employee_list.group_employee_list'); }else{ echo "Group Employee List"; } ?></li>
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
                                        <?php if(Lang::has('group_employee_list.group_employee_list')){ echo Lang::get('group_employee_list.group_employee_list'); }else{ echo "Group Employee List"; } ?>
                                    </div>
                                    <div class="col-md-6" style="text-align: right;">
                                        <a href="" class="add-new-modal btn btn-success btn-square btn-sm" data-toggle="modal" data-target="#employee_group"> <i class="fa fa-plus"></i> <?php if(Lang::has('group_employee_list.ad_new')){ echo Lang::get('group_employee_list.ad_new'); }else{ echo "Add New"; } ?> </a>
                                    </div>
                                </div>
                            </div>
                            <div class="panel-body">
                                <table id="Group" class="table table-striped table-bordered" >
                                    <thead>
                                    <tr>     
                                        <th><?php if(Lang::has('group_employee_list.sn')){ echo Lang::get('group_employee_list.sn'); }else{ echo "SN"; } ?></th>
                                        <th><?php if(Lang::has('group_employee_list.group_name')){ echo Lang::get('group_employee_list.group_name'); }else{ echo "Group Name"; } ?></th>
                                        <th><?php if(Lang::has('group_employee_list.employee_name')){ echo Lang::get('group_employee_list.employee_name'); }else{ echo "Employee Name"; } ?></th>

                                        {{-- <th>Status</th> --}}
                                        <th><?php if(Lang::has('group_employee_list.created_by')){ echo Lang::get('group_employee_list.created_by'); }else{ echo "Created By"; } ?></th>
                                        <th><?php if(Lang::has('group_employee_list.action')){ echo Lang::get('group_employee_list.action'); }else{ echo "Action"; } ?></th>
                                    </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
    <!-- Modal Start -->
    @include('backend.group_employee.modal.create')
    @include('backend.group_employee.modal.edit')
    <!-- Modal End -->
    </div>
@endsection

@section('extra_js')
<script> 
    $(document).ready(function(){
    
//  =============== Index List =============
        
     $("#group_id").select2();
     $("#employee_id").select2();

        $('#Group').DataTable({
        processing: true,
        response:true,
        serverSide: true,
        "order": [[ 1, "desc" ]],
        ajax:{
        url: "{{ route('group_employee_list') }}",
        },
        columns:[
        { 
            data: 'DT_RowIndex', 
            name: 'DT_RowIndex' 
        },
        {
            data: 'group_name',
            name: 'group_name'
        },
        {
            data: 'emp_first_name',
            name: 'emp_first_name'
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

    //  =============== Index List =============

    //  =============== Add Employee Group =============
    
        $( "#employee_group_add" ).click(function() {
        var _token = '{{ csrf_token() }}';
        var severanceData = $('#employee_group_modal_form').serialize();
        //alert(_token);
            $.ajax({
                url:"{{route('group_employee_add')}}",
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
                    $('#employee_group_modal_form')[0].reset();
                    $('#Group').DataTable().ajax.reload();
                    $('#employee_group').modal('hide');
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

    //  =============== End Add Employee Group =============

    //  =============== Edit Employee Group =============
    
        $(document).on('click', '.edit', function(){
            var id = $(this).attr('id');
            $.ajax({
             type: "GET",
             url:"{{url('group_employee_edit')}}"+"/"+id,
             dataType:"json",
             success:function(response){
                 console.log(response);
                 $('#id').val(response.id);
                 $('#edit_group_id').val(response.group_id);
                 $('#edit_all_branch').val(response.branch_id);
                //  $('#edit_employee_id').val(response.emp_id);

                     $.ajax({
                    type: "GET",
                    url:"{{route('ajax.get_employeegroup')}}",
                    success:function (grade) {
                        //console.log(response.id);
                        $('#edit_employee_id').html(grade);
                        $('#edit_employee_id').val(response.emp_id);
                        $('#edit_employee_id').select2().trigger('change');
                    }
                });
             }
            })
           });
    //  =============== End Edit Employee Group =============

        
    //  =============== Update Employee Group =============
    
        $( "#group_employee_update" ).click(function() {
            var _token = '{{ csrf_token() }}';
            var editSeverance = $('#edit_group_modal_form').serialize();
            //alert(department_name);
                $.ajax({
                    url:"{{route('group_employee_update')}}",
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
                        $('#edit_form_result').html(html);
                        }
                        if(response.falied)
                        {
                            swal(response.falied, "", "warning");
                        }
                        if(response.success)
                        {
                            swal(response.success, "", "success");
                            $('#edit_group_modal_form')[0].reset();
                            $('#Group').DataTable().ajax.reload();
                            $('#editGroup').modal('hide');
                        }
                        
                    }
                });
            });
    //  =============== End Update Employee Group =============
            
      

      //branch wise employee or team leader ajax
               $("#all_branch").change(function(){
                   var id = $("#all_branch").val();
                   $.ajax({
                       type: "GET",
                       url:"{{url('branch/employee')}}"+"/"+id,
                       dataType:"json",
                       success:function(response){
                             var leader = '';
                             leader+='<option value="">Select</option>'
                           $.each(response, function (i, item) {
                               leader += '<option value="'+item.emp_id+'">'+ item.emp_first_name+ ' ('+item.employeeId +')'+'</option>';
                           });
                           $('#employee_id').html(leader);
                           $("#employee_id").select2();
                       }
                   })
               });

              $("#clients").select2();
              $("#all_branch").select2();

    });
    </script>
@endsection