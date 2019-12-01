@extends('layout.master')
@section('title', 'Create Attendance')
@section('content')
    <div class="page-content ">

        <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content animated bounceInLeft">
            <div class="modal-header">
                <h4 class="modal-title">Add Attendance</h4>
            </div>
            <div class="modal-body">
                <!-- Error list Start -->
                <span id="form_error">
                    @if ($errors->any())
                        <div id="alert_message" class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </span>

            <!-- Error list End -->
                <div class="panel panel-default" style="margin-bottom: 35px;">
                    <form method="post" action="{{route('attendance.store_attendance')}}" id="create_attendance_form">
                        @csrf
                        <div class="panel-body">
                            <div class="form-group">
                                <label for="branch_id" class="pull-left"><h5>Select Branch<span class='require'>*</span></h5></label>
                                <div>
                                    <select id="branch_id" required name="branch_id"  class="form-control">

                                        @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('super-admin'))
                                        <option value="">Select Branch</option>
                                        @foreach($branch as $b)
                                            <option value="{{$b->id}}">{{$b->branch_name}}</option>

                                        @endforeach
                                        @else 
                                         <option value="">Select Branch</option>
                                        <option value="{{$branch_list2->id}}">{{$branch_list2->branch_name}}</option>
                                        @endif

                                    </select>
                                    <b class="form-text text-danger pull-left" id="studentError"></b>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="emp_id">Select Employee<span class='require'>*</span></label>
                                <select id="emp_id" required name="emp_id"  class="form-control">
                                    <option value="">Select Employee</option>

                                </select>
                            </div>


                            <div class="form-group">
                                <label for="attendance_date">Date<span class='require'>*</span></label>
                                <div class='input-group datetimepicker-disable-date date'>
                                    <input type="date" required class="form-control" id="attendance_date" name="attendance_date" autocomplete="off">
                                    <span class="input-group-addon">
                                        <span class="fa fa-calendar"></span>
                                    </span>
                                </div>
                            </div>
                            <br><br>


                            <div class="form-group">
                                <label for="in_time">Entry Time<span class='require'>*</span></label>
                                <div class='input-group datetimepicker-disable-date date'  id='in_time' >
                                    <input type='text' required class="form-control" id="in_times" name="in_time" autocomplete="off"/>
                                    <span class="input-group-addon">
                                    <span class="fa fa-clock-o"></span>
                                </span>
                                </div>
                            </div>
                            <br><br>
                            <div class="form-group">
                                <label for="end_time">Exit Time</label>
                                <div class='input-group datetimepicker-disable-date date'  id='out_time' >
                                    <input type='text' class="form-control" autocomplete="off" id="out_times" name="out_time"/>
                                    <span class="input-group-addon">
                                    <span class="fa fa-clock-o"></span>
                                </span>
                                </div>
                            </div>
                            <br><br>
{{--                            <button type="reset" class="btn btn-default pull-left">Reset</button>--}}
                            <button type="submit" id="real_submit" class="btn btn-md btn-round btn-blue" style="display: none"><i class="fa fa-check"></i> </button>

                        </div>
                    </form>
                    <button style="margin-bottom: 10px;" type="submit" class="btn btn-info pull-right" id="fake_submit"><i class="fa fa-plus"></i> Add</button>

                </div>
            </div>
        </div>
    </div>
    </div>

@endsection

@section('extra_js')
    <script>

        $(function () {
            var form=$("#create_attendance_form");
            form.on('submit',function (event) {

                event.preventDefault();
                var url="{{route('attendance.store_attendance')}}";
                var method="post";
                $.ajax({
                    url:url,
                    method:method,
                    data:form.serialize(),
                    success:function (response) {
                        if(response.errors){
                            html = '<div class="alert alert-danger">';
                            for(var count = 0; count < response.errors.length; count++)
                            {
                                html += '<p>' + response.errors[count] + '</p>';
                            }
                            html += '</div>';
                            $('#form_error').html(html);
                            console.log(html);
                        }
                        else {
                            if(response==="success"){
                                swal("Success!", "Attendance inserted successfully!", "success");
                                $("#branch_id").val("").trigger('change');
                                $("#emp_id").val("").trigger('change');
                                $("#attendance_date").val("");
                                $("#in_times").val('');
                                $("#out_times").val("");
                                $("#form_error").css('display', 'none');
                            }
                            else if(response==="Greater"){
                                swal("Error!", "Entry time can not be greater than exit time", "error");

                            }
                            else {
                                swal("Data Exist!", "Already data exist for this employee", "error");

                            }

                        }


                    },
                    error:function (xhr) {

                    }
                });

            });

            $('#fake_submit').click(function (event) {
                event.preventDefault();
                $('#real_submit').click();

            });

            $('#in_time').datetimepicker({
                pickDate: false
            });
            $('#out_time').datetimepicker({
                pickDate: false
            });
            // $('#task_assign_date').datetimepicker({
            //     pickTime: false
            // });

            $("#emp_id").select2({
                placeholder: "Select Employee"
            });

            $("#branch_id").select2({
                placeholder: "Select Branch"
            });

            $('#branch_id').on('change',function () {
                var id = $("#branch_id").val();
                //alert(id);
                $.ajax({
                    type: "GET",
                    url:"{{url('/ajax/get_employee')}}"+"/"+id,
                    success:function (response) {
                        //console.log(response);
                        $('#emp_id').html(response);
                        $("#emp_id").select2({
                            placeholder: "Select Employee"
                        });
                    }
                });
            });

        });
    </script>

@endsection