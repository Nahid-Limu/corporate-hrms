@extends('layout.master')
@section('title', 'Meeting Employee')
@section('content')
    <!--BEGIN TITLE & BREADCRUMB PAGE-->
    <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
        <div class="page-header pull-left">
            <div class="page-title">Meeting Employee</div>
        </div>
        <ol class="breadcrumb page-breadcrumb pull-right">
            <li><i class="fa fa-home"></i>&nbsp;<a href="{{url('/')}}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
            <li><a href="#">Meeting Employee</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
            <li class="active">Meeting Employee List</li>
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
                                       Meeting Employee List
                                    </div>
                                    <div class="col-md-6" style="text-align: right;">
                                        <a href="" class="add-new-modal btn btn-success btn-square btn-sm" data-toggle="modal" data-target="#meeting_employee"> <i class="fa fa-plus"></i> Add New</a>
                                    </div>
                                </div>
                            </div>
                            <div class="panel-body">
                                <table id="Group" class="table table-striped table-bordered" >
                                    <thead>
                                    <tr>    
                                         <th>SN</th>
                                        <th>Meeting Name</th>
                                        <th>Employee Name</th>
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
    @include('backend.meeting_employee.modal.create')
    @include('backend.meeting_employee.modal.edit')
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
        serverSide: true,
        "order": [[ 3, "desc" ]],
        ajax:{
        url: "{{ route('meeting_employee_list') }}",
        },
        columns:[
        { 
            data: 'DT_RowIndex', 
            name: 'DT_RowIndex' 
        },
        {
            data: 'meeting_subject',
            name: 'meeting_subject'
        },
        {
            data: 'emp_first_name',
            name: 'emp_first_name'
        },
         {
            data: 'status',
            name: 'status',
            render: function(data, type, full, meta){
                return data == '1' ? 'Active' : 'InActive'
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

    //  =============== Index List =============

    //  =============== Add Employee Group =============
    
        $( "#meeting_employee_add" ).click(function() {
        var _token = '{{ csrf_token() }}';
        var severanceData = $('#meeting_employee_modal_form').serialize();
        //alert(_token);
            $.ajax({
                url:"{{route('meeting_employee_add')}}",
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
                    $('#meeting_employee_modal_form')[0].reset();
                    $('#Group').DataTable().ajax.reload();
                    $('#meeting_employee').modal('hide');
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
             url:"{{url('meeting_employee_edit')}}"+"/"+id,
             dataType:"json",
             success:function(response){
                 console.log(response);
                 $('#id').val(response.id);
                 $('#edit_meeting_id').val(response.meeting_id);
                 $('#edit_emp_id').val(response.emp_id);
                 $('#editall_branch').val(response.branch_id);
                $("#status option[value=" + response.status + "]").prop('selected', true);

                  $.ajax({
                    type: "GET",
                    url:"{{route('ajax.get_meeting_employeegroup')}}",
                    success:function (grade) {
                        //console.log(response.id);
                        $('#edit_emp_id').html(grade);
                        $('#edit_emp_id').val(response.emp_id);
                        $('#edit_emp_id').select2().trigger('change');
                    }
                });
             }
            })
           });
    //  =============== End Edit Employee Group ============= 


        //branch wise employee or team leader ajax
               $("#all_branch").change(function(){
                   var id = $("#all_branch").val();
                   $.ajax({
                       type: "GET",
                       url:"{{url('branch/severance/employee')}}"+"/"+id,
                       dataType:"json",
                       success:function(response){
                             var leader = '';
                             leader+='<option value="">Select</option>'
                           $.each(response, function (i, item) {
                               leader += '<option value="'+item.emp_id+'">'+item.emp_first_name+' ('+item.employeeId+')'+'</option>';
                           });
                           $('#emp_id').html(leader);
                           $("#emp_id").select2();
                       }
                   })
               });

              $("#meeting_id").select2();
              $("#all_branch").select2();

    });

        
    //  =============== Update Employee Group =============
    
        $( "#meeting_employee_update" ).click(function() {
            var _token = '{{ csrf_token() }}';
            var editSeverance = $('#edit_meeting_employee_modal_form').serialize();
            //alert(department_name);
                $.ajax({
                    url:"{{route('meeting_employee_update')}}",
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
                            $('#edit_meeting_employee_modal_form')[0].reset();
                            $('#Group').DataTable().ajax.reload();
                            $('#edit_meeting_employee').modal('hide');
                        }
                        
                    }
                });
            });
    //  =============== End Update Employee Group =============
            
      
    </script>
@endsection
