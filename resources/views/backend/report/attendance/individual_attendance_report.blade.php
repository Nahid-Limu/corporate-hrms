@extends('layout.master')
@section('title', 'Individual Attendance Report')
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
                                Individual Attendance Report
                            </div>

                        </div>
                    </div>
                    <div class="panel-body">

                        {!! Form::open(['method'=>'post','action'=>'AttendanceReportController@individual_attendance_report_data']) !!}

                        <div class="col-md-10 col-md-offset-1 ex-form">

                            <div class="form-group">
                                <div class="input-form-gap"></div>
                                <label class="col-md-4">Start Date <span class='require'>*</span> <span class="clon">:</span></label>
                                <div class="col-md-8">
                                    <input type="date" name="date" class="date-picker form-control hasDatepicker" value="{{\Carbon\Carbon::now()->toDateString()}}" required="" placeholder="Select a date..." id="">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-form-gap"></div>
                                <label class="col-md-4">End Date <span class='require'>*</span> <span class="clon">:</span></label>
                                <div class="col-md-8">
                                    <input type="date" name="end_date" class="date-picker form-control hasDatepicker" value="{{\Carbon\Carbon::now()->toDateString()}}" required="" placeholder="Select a date..." id="">
                                </div>
                            </div>

                            @if(auth()->user()->hasRole('employee'))
                            @else
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
                            @endif


                            @if(auth()->user()->hasRole('employee'))
                            <input type="hidden" name="emp_id" value="{{auth()->user()->emp_id}}">
                            @else
                            <div class="form-group">
                                <div class="input-form-gap"></div>
                                <label for="emp_id" class="col-md-4">Select Employee <span class='require'>*</span> <span class="clon">:</span></label>
                                <div class="col-md-8">
                                    <select name="emp_id" required id="emp_id"  class="select2-container form-control"  title="Select Employee:">
                                        <option value="">Select Employee</option>
                                    </select>
                                </div>
                            </div>
                           @endif



                            <div class="form-group">
                                <div class="input-form-gap"></div>
                                <br>
                                <div class="col-md-4">

                                </div>
                                <div class="col-md-8">
                                    <button id="real-submit" type="submit" class="btn btn-success">
                                        <i class="fa fa-eye-slash"></i> Preview</button>
                                </div>
                            </div>
                            {!! Form::close() !!}
                        </div>

                    </div>

                </div>
            </div>

        </div>
    </div>
@endsection
@section('extra_js')
    <script>
        $(function () {
            $("#emp_id").select2({
                placeholder: "Select Employee"
            });

            $("#branch_id").select2({
                placeholder: "Select Branch"
            });
            $("#department_id").select2({
                placeholder: "All"
            });
            $("#gender_id").select2({
                placeholder: "All"
            });
            $("#designation_id").select2({
                placeholder: "All"
            });
            $('#branch_id').on('change',function () {
                var id = $("#branch_id").val();
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

