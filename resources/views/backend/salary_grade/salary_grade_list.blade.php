@extends('layout.master')
@section('title', 'Salary Grade')
@section('content')
    <!--BEGIN TITLE & BREADCRUMB PAGE-->
    <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
        <div class="page-header pull-left">
            <div class="page-title">Salary Grade</div>
        </div>
        <ol class="breadcrumb page-breadcrumb pull-right">
            <li><i class="fa fa-home"></i>&nbsp;<a href="{{url('/')}}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
            <li><a href="#">Salary Grade</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
            <li class="active">Salary Grade List</li>
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
                                        Salary Grade List
                                    </div>
                                    <div class="col-md-6" style="text-align: right;">
                                        <a href="" class="add-new-modal btn btn-success btn-round btn-sm" data-toggle="modal" data-target="#salary_grade"> <i class="fa fa-plus"></i> Add New</a>
                                    </div>
                                </div>
                            </div>
                            <div class="panel-body">
                                <table id="grade" class="table table-striped table-bordered" >
                                    <thead>
                                    <tr>
                                        <th>SN</th>
                                        <th>Grade Name</th>
                                        <th>Basic</th>
                                        <th>House</th>
                                        <th>Medical</th>
                                        <th>Transportation</th>
                                        <th>Food</th>
                                        <th>Other</th>
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
    @include('backend.salary_grade.modal.create')
    @include('backend.salary_grade.modal.edit')
    <!-- Modal End -->
    </div>
@endsection

@section('extra_js')
<script> 
   // =============== Index List ============= --> 
    $(document).ready(function(){
    
        $('#grade').DataTable({
        processing: true,
        serverSide: true,
        "order": [[ 1, "desc" ]],
        ajax:{
        url: "{{ route('salarygrade_list') }}",
        },
        columns:[
        { 
            data: 'DT_RowIndex', 
            name: 'DT_RowIndex' 
        },
        {
            data: 'grade_name',
            name: 'grade_name'
        },
        {
            data: 'basic',
            name: 'basic'
        },
        {
            data: 'house',
            name: 'house'
        },
        {
            data: 'medical',
            name: 'basmedicalic'
        },
        {
            data: 'transportation',
            name: 'transportation'
        },
        {
            data: 'food',
            name: 'food'
        },
        {
            data: 'other',
            name: 'other'
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
   // =============== End Index List ============= -->  

   // ===============  Add Grade ============= --> 

        $( "#expanse_category_add" ).click(function() {
        var _token = '{{ csrf_token() }}';
        var categoryData = $('#salary_grade_modal_form').serialize();
        
        //console.log(categoryData);
        //alert(_token);
            $.ajax({
                url:"{{route('salarygrade_add')}}",
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
                    $('#salary_grade_modal_form')[0].reset();
                    $('#grade').DataTable().ajax.reload();
                    $('#salary_grade').modal('hide');
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

   // ===============  End Add Grade ============= --> 
    

   // =============== Edit Grade ============= --> 
        $(document).on('click', '.edit', function(){
            var id = $(this).attr('id');
            $.ajax({
             type: "GET",
             url:"{{url('salary_grade_edit')}}"+"/"+id,
             dataType:"json",
             success:function(response){
                 //console.log(response);
                 $('#id').val(response.id);
                 $('#edit_grade_name').val(response.grade_name);
                 $('#edit_basic').val(response.basic);
                 $('#edit_house').val(response.house);
                 $('#edit_medical').val(response.medical);
                 $('#edit_transportation').val(response.transportation);
                 $('#edit_food').val(response.food);
                 $('#edit_other').val(response.other);
                 $("#status option[value=" + response.status + "]").prop('selected', true);
             }
            })
           });

   // ===============  End Edit Grade ============= --> 
        
   // =============== Update Grade ============= --> 
        $( "#salary_grade_update" ).click(function() {
            var _token = '{{ csrf_token() }}';
            var salary_grade = $('#edit_salary_grade_modal_form').serialize();
           
                $.ajax({
                    url:"{{route('salarygrade_update')}}",
                    method:"post",
              
                    data: salary_grade,
                    success:function (response) {
                        // console.log(response);
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
                            $('#edit_salary_grade_modal_form')[0].reset();
                            $('#grade').DataTable().ajax.reload();
                            $('#editsalary_grade').modal('hide');
                        }
                        
                    }
                });
            });
    
   // ===============  End Update Grade ============= --> 

    
    });
    </script>
@endsection