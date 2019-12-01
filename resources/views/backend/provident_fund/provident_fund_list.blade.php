@extends('layout.master')
@section('title', 'Provident Fund List')
@section('content')
    <!--BEGIN TITLE & BREADCRUMB PAGE-->
    <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
        <div class="page-header pull-left">
            <div class="page-title">Employee Provident Fund List</div>
        </div>
        <ol class="breadcrumb page-breadcrumb pull-right">
            <li><i class="fa fa-home"></i>&nbsp;<a href="{{url('/')}}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
            <li><a href="#">Provident</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
            <li class="active">Provident Fund List</li>
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
                                             Provident Fund List
                                    </div>
                                </div>
                            </div>
                            <div class="panel-body table-responsive">
                                <table id="provident_list_tbl" class="table table-striped table-bordered" >
                                    <thead>
                                    <tr>
                                        <th>SN</th>
                                        <th>Employee</th>
                                        <th>Provident Fund Percent</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
    <!-- Modal Start -->
    @include('backend.provident_fund.modal.edit')
    <!-- Modal End -->
    </div>
@endsection

@section('extra_js')
<script>
    $(document).ready(function(){
    
        $('#provident_list_tbl').DataTable({
        processing: true,
        serverSide: true,
        "order": [[ 0, "desc" ]],
        ajax:{
        url: "{{ route('employee_provident_list') }}",
        },
        columns:[
        { 
            data: 'DT_RowIndex', 
            name: 'DT_RowIndex' 
        },
        {
            data: 'emp_name',
            name: 'emp_name'
        },
        {
            data: 'provident_fund_percent',
            name: 'provident_fund_percent'
        },
        {
            data: 'action',
            name: 'action',
            orderable: false
        }
        ]
        });

        //Edit Provident
        $(document).on('click', '.edit', function(){
            var id = $(this).attr('id');
            //alert(id);
            $.ajax({
             type: "GET",
             url:"{{url('/provident_fund_percent_edit')}}"+"/"+id,
             dataType:"json",
             success:function(response){
                 //console.log(response);
                 $('#id').val(response.id);
                 $('#emp_name').html(response.emp_name);
                 $('#edit_provident_fund_percent').val(response.provident_fund_percent);
             }
            })
           });

        
        //update branch
        $( "#provident_update" ).click(function() {
            var _token = '{{ csrf_token() }}';
            //var id = $('#id').val();
            var editProvident = $('#edit_provident_modal_form').serialize();
            //alert(id);
                $.ajax({
                    url:"{{route('provident_percent_update')}}",
                    method:"post",
                    data: editProvident,
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
                            $('#edit_provident_modal_form')[0].reset();
                            $('#provident_list_tbl').DataTable().ajax.reload();
                            $('#editProvident').modal('hide');
                        }
                        
                    }
                });
            });
    
    
    });
    </script>
@endsection