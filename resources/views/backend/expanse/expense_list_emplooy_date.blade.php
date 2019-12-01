@extends('layout.master')
@section('title', 'Date Wise ExpenseReport')
@section('content')
    <!--BEGIN TITLE & BREADCRUMB PAGE-->
    <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
        <div class="page-header pull-left">
            <div class="page-title">Date Wise Expense Report</div>
        </div>
        <ol class="breadcrumb page-breadcrumb pull-right">
            <li><i class="fa fa-home"></i>&nbsp;<a href="{{url('/')}}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
            <li><a href="#">Date Wise Expense Report</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
            <li class="active">Date Wise Expense Report List</li>
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
                                       Wise Expense Report List
                                    </div>
                                </div>
                            </div>
                            <div class="panel-body">
                                <table id="Expanse_table" class="table table-striped table-bordered" >
                                    <thead>
                                    <tr>    
                                        <th>SN</th>
                                        <th>Category Name</th>
                                        <th>Employee Name</th>
                                        <th>Amount</th>
                                        <th>Expanse Date</th>
                                        <th>Attachment</th>
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
    @include('backend.expanse.modal.create')
    @include('backend.expanse.modal.edit')
    <!-- Modal End -->
    </div>
@endsection

@section('extra_js')
<script> 

   // =============== Index List ============= --> 

    $(document).ready(function(){
    
        $('#Expanse_table').DataTable({
        processing: true,
        serverSide: true,
        "order": [[ 1, "desc" ]],
        ajax:{
        url: "{{ route('expanse_list') }}",
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
            data: 'emp_first_name',
            name: 'emp_first_name'
        },
        {
            data: 'amount',
            name: 'amount'
        },
        {
            data: 'expanse_date',
            name: 'expanse_date'
        },
        {
            data: 'attachment',
            name: 'attachment',
            render: function (data, type, full, meta) {
                return "<a href='../expanse_attachment/"+data+"'>"+data+"&nbsp;&nbsp;<i class='fa fa-download' aria-hidden='true'></i></a>"
            }

        },
        {
            data: 'status',
            name: 'status',
            render: function(data, type, full, meta){
                return data == '1' ? '<span style="color:green">Confirm</span>' : '<span style="color:red">Pending</span>'
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

          $('#expanse_modal_form').on('submit', function(event){
                event.preventDefault();
                $.ajax({
                    url:"{{ route('expanse_add') }}",
                    method:"POST",
                    data:new FormData(this),
                    dataType:'JSON',
                    contentType: false,
                    cache: false,
                    processData: false,
                    success:function(response)
                    {
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
                            $('#expanse_modal_form')[0].reset();
                            $('#Expanse_table').DataTable().ajax.reload();
                            $('#expanseadd').modal('hide');
                        }
                    },
                    error: function(response) {
                        console.log(response);
                    }

                })
            });
   // =============== End Add group ============= --> 

   // =============== Edit group ============= --> 
        $(document).on('click', '.edit', function(){
            var id = $(this).attr('id');
            $.ajax({
             type: "GET",
             url:"{{url('expanse_edit')}}"+"/"+id,
             dataType:"json",
             success:function(response){
                 console.log(response);
                 $('#id').val(response.id);
                 $('#edit_amount').val(response.amount);
                 $('#edit_expanse_date').val(response.expanse_date);
                 $('#edit_remarks').val(response.remarks);
                 $('#edit_attachment').val(response.attachmen);
                 $("#status option[value=" + response.status + "]").prop('selected', true);
                   if(response.c_id==response.cate_id){
                        $("#edit_category_id option[value=" + response.c_id + "]").prop('selected', true);
                        }

                
                    $.ajax({
                    type: "GET",
                    url:"{{route('ajax.get_employeebenefit')}}",
                    success:function (grade) {
                        //console.log(response.id);
                        $('#edit_emp_id').html(grade);
                        $('#edit_emp_id').val(response.expance_emp_id);
                        $('#edit_all_branch').val(response.branch_id);
                        $('#edit_emp_id').select2().trigger('change');
                    }
                });


                
             }
            })
           });
   // =============== End Edit group ============= --> 

   

        //update project
        
            $('#edit_expanse_modal_form').on('submit', function(event){
                event.preventDefault();
                $.ajax({
                    url:"{{ route('expanse_update') }}",
                    method:"POST",
                    data:new FormData(this),
                    dataType:'JSON',
                    contentType: false,
                    cache: false,
                    processData: false,
                    success:function(response)
                    {
                        var html = '';
                        if(response.errors)
                        {
                            html = '<div class="alert alert-danger">';
                            for(var count = 0; count < response.errors.length; count++)
                            {
                                html += '<p>' + response.errors[count] + '</p>';
                            }
                            html += '</div>';
                            $('#edit_form_result').html(html);
                        }
                        if(response.success)
                        {
                            swal(response.success, "", "success");
                            $('#edit_expanse_modal_form')[0].reset();
                            $('#Expanse_table').DataTable().ajax.reload();
                            $('#editExpanse').modal('hide');
                        }
                    },
                    error: function(response) {
                        console.log(response);
                    }
                })
            });


            $("#all_branch").change(function(){
                   var id = $("#all_branch").val();
                   $.ajax({
                       type: "GET",
                       url:"{{url('branch/benefit/employee')}}"+"/"+id,
                       dataType:"json",
                       success:function(response){
                             var leader = '';
                             leader+='<option value="">Select</option>'
                           $.each(response, function (i, item) {
                               leader += '<option value="'+item.emp_id+'">'+ item.emp_first_name+ ' ('+item.employeeId+')'+'</option>';
                           });
                           $('#emp_id').html(leader);
                           $("#emp_id").select2();
                       }
                   })
               });

              $("#all_branch").select2();


           

    }); 

   // =============== End Update group ============= --> 

    </script>
@endsection





 
