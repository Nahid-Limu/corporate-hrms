@extends('layout.master')
@section('title', 'Present Report')
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
                                Present Report
                            </div>

                        </div>
                    </div>
                    <div class="panel-body">

                        {!! Form::open(['method'=>'post','action'=>'AttendanceReportController@present_report_data']) !!}

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
                            <div class="form-group">
                                <div class="input-form-gap"></div>
                                <label for="emp_id" class="col-md-4">Select Branch <span class="clon">:</span></label>
                                <div class="col-md-8">
                                    <select id="branch_id" required name="branch_id"  class="form-control">
                                        <option value="">Select</option>
                                        @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('super-admin'))
                                        <option value="0">All</option>
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
                                <label for="emp_id" class="col-md-4">Select Employee <span class="clon">:</span></label>
                                <div class="col-md-8">

                                    <select name="emp_id" id="emp_id"  class="select2-container form-control"  title="Select Employee:">
                                        <option value="0">All</option>

                                    </select>

                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-form-gap"></div>
                                <label for="emp_id" class="col-md-4">Select Department <span class="clon">:</span></label>
                                <div class="col-md-8">

                                    <select name="department_id" id="department_id"  class="select2-container form-control"  title="Select Department:">
                                        <option value="0">All</option>
                                        @foreach($department as $d)
                                            <option value="{{$d->id}}">{{$d->department_name}}</option>
                                        @endforeach
                                    </select>

                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-form-gap"></div>
                                <label for="emp_id" class="col-md-4">Select Designation <span class="clon">:</span></label>
                                <div class="col-md-8">

                                    <select name="designation_id" id="designation_id" class="select2-container form-control"  title="Select Designation:">
                                        <option value="0">All</option>
                                        @foreach($designation as $d)
                                            <option value="{{$d->id}}">{{$d->designation_name}}</option>
                                        @endforeach
                                    </select>

                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-form-gap"></div>
                                <label for="emp_id" class="col-md-4">Select Gender <span class="clon">:</span></label>
                                <div class="col-md-8">

                                    <select name="gender_id" id="gender_id"  class="select2-container form-control"  title="Select Gender:">
                                        <option value="0">All</option>
                                        <option value="1">Male</option>
                                        <option value="2">Female</option>
                                        {{--                                        <option value="0">Other</option>--}}

                                    </select>

                                </div>
                            </div>
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
                    url:"{{url('/ajax/get_employee_for_report')}}"+"/"+id,
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

