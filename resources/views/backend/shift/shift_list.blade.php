@extends('layout.master')
@section('title', 'Shift Setting')
@section('content')
    <!--BEGIN TITLE & BREADCRUMB PAGE-->
    <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
        <div class="page-header pull-left">
            <div class="page-title">Shift</div>
        </div>
        <ol class="breadcrumb page-breadcrumb pull-right">
            <li><i class="fa fa-home"></i>&nbsp;<a href="{{url('/')}}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
            <li><a href="#">Shift</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
            <li class="active">Shift List</li>
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
                                        Shift List
                                    </div>
                                    <div class="col-md-6" style="text-align: right;">
                                          @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('super-admin'))
                                        <a href="" class="add-new-modal btn btn-success btn-round btn-sm" data-toggle="modal" data-target="#createShift"> <i class="fa fa-plus"></i> Add New</a>
                                         @endif
                                    </div>
                                </div>
                            </div>
                            <div class="panel-body table-responsive">
                                <table id="shift" class="table table-striped table-bordered" >
                                    <thead>
                                    <tr>
                                        <th>SN</th>
                                        <th>Shift Name</th>
                                        <th>Entry Time</th>
                                        <th>Exit Time</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                
    <!-- Modal Start -->
    @include('backend.shift.modal.create')
    @include('backend.shift.modal.edit')
    <!-- Modal End -->
    </div>
@endsection

@section('extra_js')
<script>
    $(document).ready(function(){
    
        $('#shift').DataTable({
        processing: true,
        serverSide: true,
        "order": [[ 0, "desc" ]],
        ajax:{
        url: "{{ route('shift_list') }}",
        },
        columns:[
        { 
            data: 'DT_RowIndex', 
            name: 'DT_RowIndex' 
        },
        {
            data: 'shift_name',
            name: 'shift_name'
        },
        {
            data: 'entry_time',
            name: 'entry_time'
        },
        {
            data: 'exit_time',
            name: 'exit_time'
        },
        {
            data: 'action',
            name: 'action',
            orderable: false
        }
        ]
        });


        //add shift
        $( "#shift_add" ).click(function() {
        var _token = '{{ csrf_token() }}';
        var shiftData = $('#shift_modal_form').serialize();
        //alert(_token);
            $.ajax({
                url:"{{route('shift_add')}}",
                method:"post",
                data: shiftData,
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
                    $('#shift_modal_form')[0].reset();
                    $('#shift').DataTable().ajax.reload();
                    $('#createShift').modal('hide');
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

        //Edit shift
        $(document).on('click', '.edit', function(){
            var id = $(this).attr('id');
            $.ajax({
             type: "GET",
             url:"{{url('shift_edit')}}"+"/"+id,
             dataType:"json",
             success:function(response){
                 console.log(response);
                 $('#id').val(response.id);
                 $('#edit_shift_name').val(response.shift_name);
                 $('#edit_entry_time').val(convertTime24to12(response.entry_time));
                 $('#edit_exit_time').val(convertTime24to12(response.exit_time));
                
                 //am pm time function
                function convertTime24to12(time24){
                    var tmpArr = time24.split(':'), time12;
                        if(+tmpArr[0] == 12) {
                            time12 = tmpArr[0] + ':' + tmpArr[1] + ' pm';
                        } else {
                            if(+tmpArr[0] == 00) {
                            time12 = '12:' + tmpArr[1] + ' am';
                            } else {
                                if(+tmpArr[0] > 12) {
                                time12 = (+tmpArr[0]-12) + ':' + tmpArr[1] + ' pm';
                                } else {
                                time12 = (+tmpArr[0]) + ':' + tmpArr[1] + ' am';
                                }
                            }
                        }
                        return time12;
                    }
             }
            })
           });

        
        //update shift
        $( "#shift_update" ).click(function() {
            var _token = '{{ csrf_token() }}';
            var editShift = $('#edit_shift_modal_form').serialize();
            //alert(department_name);
                $.ajax({
                    url:"{{route('shift_update')}}",
                    method:"post",
                    data: editShift,
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
                            $('#edit_shift_modal_form')[0].reset();
                            $('#shift').DataTable().ajax.reload();
                            $('#editShift').modal('hide');
                        }
                        
                    }
                });
            });

            $('#entry').datetimepicker({
                pickDate: false
            });
            $('#exit').datetimepicker({
                pickDate: false
            });

            $('#edit_entry').datetimepicker({
                pickDate: false
            });
            $('#edit_exit').datetimepicker({
                pickDate: false
            });
            
    
    });
    </script>
@endsection