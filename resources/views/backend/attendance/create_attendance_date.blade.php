@extends('layout.master')
@section('title', 'Attendance Date Wise')
@section('content')

    <div class="page-content">
        @if(Session::has('success'))
            <p id="alert_message" class="alert alert-success">{{ Session::get('success') }}</p>

        @elseif(Session::has('error'))
            <p id="alert_message" class="alert alert-warning">{{ Session::get('error') }}</p>

        @endif
        <div class="row">
            <div class="col-lg-10 col-lg-offset-1">
                <div class="panel panel-blue">
                    <div class="panel-heading ex-panel">
                        <div class="row">
                            <div style="text-align: left" class="col-md-12">
                                Manual Attendance (Date Wise)
                            </div>

                        </div>
                    </div>
                    <div class="panel-body">

                        {!! Form::open(['method'=>'post','action'=>'AttendanceController@manual_attendance_date_wise_data','id'=>'submit-form']) !!}

                        <div class="col-md-10 col-md-offset-1 ex-form">

                            <div class="form-group">
                                <div class="input-form-gap"></div>
                                <label class="col-md-4">Start Date <span class='require'>*</span> <span class="clon">:</span></label>
                                <div class="col-md-8">
                                    <input type="date" name="start_date" class="date-picker form-control hasDatepicker" value="" required="" placeholder="Select a date..." id="">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-form-gap"></div>
                                <label class="col-md-4">End Date <span class='require'>*</span> <span class="clon">:</span></label>
                                <div class="col-md-8">
                                    <input type="date" name="end_date" class="date-picker form-control hasDatepicker" value="" required="" placeholder="Select a date..." id="">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-form-gap"></div>
                                <label for="emp_id" class="col-md-4">Select Branch <span class='require'>*</span> <span class="clon">:</span></label>
                                <div class="col-md-8">
                                    <select id="branch_id" required name="branch_id"  class="form-control">
                                        <option value="">Select Branch</option>
                                         @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('super-admin'))
                                        @foreach($branch as $b)
                                            <option value="{{$b->id}}">{{$b->branch_name}}</option>
                                        @endforeach
                                        @else 
                                        <option value="{{$branch_list2->id}}">{{$branch_list2->branch_name}}</option>
                                        @endif


                                    </select>
                                    <b class="form-text text-danger pull-left" id="studentError"></b>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-form-gap"></div>
                                <label for="emp_id" class="col-md-4">Select Single Employee <span class='require'>*</span> <span class="clon">:</span></label>
                                <div class="col-md-8">

                                    <select name="emp_id" id="emp_id" required  class="select2-container form-control"  title="Select Single Employee:">
                                        <option value="">Select Employee</option>
                                    </select>

                                </div>
                            </div>
                            <div style="display: none" class="form-group">
                                <div class="input-form-gap"></div>
                                <br>
                                <div class="col-md-4">

                                </div>
                                <div class="col-md-8">
                                    <button id="real-submit" type="submit" class="btn btn-success">
                                        <i class="fa fa-search"></i> Process</button>
                                </div>
                            </div>
                            {!! Form::close() !!}

                            <div class="form-group">
                                <div class="input-form-gap"></div>
                                <br>
                                <div class="col-md-4">

                                </div>
                                <div class="col-md-8">
                                    <button id="fake-submit" type="button" class="btn btn-success">
                                        <i class="fa fa-cogs" aria-hidden="true"></i>
                                        Process</button>
                                </div>
                            </div>
                        </div>




                    </div>
                    
                </div>
            </div>

            <div class="col-lg-10 col-lg-offset-1">
                <div class="panel panel-blue">
                    <div class="panel-body" id="attendance_date_wise_data">

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('extra_js')
    <script>
        $(function () {
            var form=$("#submit-form");
            form.on('submit',function (event) {
                event.preventDefault();
                var url="{{route('attendance.manual_attendance_date_wise_data')}}";
                // alert(url);
                var method="post";
                $.ajax({
                    url:url,
                    method:method,
                    data:form.serialize(),
                    success:function (response) {
                        $('#attendance_date_wise_data').html(response);
                    },
                    error:function (xhr) {
                        
                    }
                });

            });

            $('#fake-submit').click(function (event) {
                event.preventDefault();
                $('#real-submit').click();

            });

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

