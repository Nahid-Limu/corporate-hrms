@extends('layout.master')
@section('title', 'Group')
@section('content')
    <!--BEGIN TITLE & BREADCRUMB PAGE-->
    <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
        <div class="page-header pull-left">
            <div class="page-title">Group</div>
        </div>
        <ol class="breadcrumb page-breadcrumb pull-right">
            <li><i class="fa fa-home"></i>&nbsp;<a href="{{url('/')}}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
            <li><a href="#">Group</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
            <li class="active">Group List</li>
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
                                        Group List
                                    </div>
                                    <div class="col-md-6" style="text-align: right;">
                                        <a href="" class="add-new-modal btn btn-success btn-square btn-sm" data-toggle="modal" data-target="#group"> <i class="fa fa-plus"></i> Add New</a>
                                    </div>
                                </div>
                            </div>
                            <div class="panel-body">
                                <table id="Group" class="table table-striped table-bordered" >
                                    <thead>
                                    <tr>
                                        
                                        <th>Group Name</th>
                                        <th>Group Leader Name</th>
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
    @include('backend.group.modal.create')
    @include('backend.group.modal.edit')
    <!-- Modal End -->
    </div>
@endsection

@section('extra_js')
<script> 

   // =============== Index List ============= --> 

    $("#group_leader_id").select2();
    $("#edit_group_leader_id").select2();
    $(document).ready(function(){
    
        $('#Group').DataTable({
        processing: true,
        serverSide: true,
        "order": [[ 1, "desc" ]],
        ajax:{
        url: "{{ route('group_list') }}",
        },
        columns:[
        {
            data: 'group_name',
            name: 'group_name'
        },
        {
            data: 'emp_first_name',
            name: 'emp_first_name'
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

   // =============== End Index List ============= --> 

   // =============== ADD group ============= --> 
        $( "#gropu_add" ).click(function() {
        var _token = '{{ csrf_token() }}';
        var severanceData = $('#group_modal_form').serialize();
        //alert(_token);
            $.ajax({
                url:"{{route('group_add')}}",
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
                    $('#group_modal_form')[0].reset();
                    $('#Group').DataTable().ajax.reload();
                    $('#group').modal('hide');
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
             url:"{{url('group_edit')}}"+"/"+id,
             dataType:"json",
             success:function(response){
                 console.log(response);
                 $('#id').val(response.id);
                 $('#edit_group_name').val(response.group_name);
                 $('#edit_remarks').val(response.remarks);
                 $("#status option[value=" + response.status + "]").prop('selected', true);

                  $.ajax({
                    type: "GET",
                    url:"{{route('ajax.get_employeegroup')}}",
                    success:function (grade) {
                        //console.log(response.id);
                        $('#edit_group_leader_id').html(grade);
                        $('#edit_group_leader_id').val(response.group_leader_id);
                        $('#edit_group_leader_id').select2().trigger('change');
                    }
                });
                // $.ajax({
                //     type: "GET",
                //     url:"{{route('ajax.get_all_branch')}}",
                //     success:function (grade) {
                //         // console.log(response.id);
                //         $('#edit_all_branch').html(grade);
                //         $('#edit_all_branch').val(response.group_leader_id);
                //         $('#edit_all_branch').select2().trigger('change');
                //     }
                // });
             }
            })
           });
   // =============== End Edit group ============= --> 

   // =============== Update group ============= --> 
        $( "#group_update" ).click(function() {
            var _token = '{{ csrf_token() }}';
            var editSeverance = $('#edit_group_modal_form').serialize();
            //alert(department_name);
                $.ajax({
                    url:"{{route('group_update')}}",
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


            //branch wise employee or team leader ajax
               $("#all_branch").change(function(){
                   var id = $("#all_branch").val();
                   $.ajax({
                       type: "GET",
                       url:"{{url('branch/group/employee')}}"+"/"+id,
                       dataType:"json",
                       success:function(response){
                             var leader = '';
                             leader+='<option value="">Select</option>'
                           $.each(response, function (i, item) {
                               leader += '<option value="'+item.emp_id+'">' + item.emp_first_name+  ' (' +item.employeeId +')'+'</option>';
                           });
                           $('#group_leader_id').html(leader);
                           $("#group_leader_id").select2();
                       }
                   })
               });

              $("#all_branch").select2();

    }); 

   // =============== End Update group ============= --> 

    </script>
@endsection





 
