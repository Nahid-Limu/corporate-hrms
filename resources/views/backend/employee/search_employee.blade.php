@extends('layout.master')
@section('title', 'Employee Search')
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
                                Employee Search
                            </div>

                        </div>
                    </div>
                    <div class="panel-body">

                        {!! Form::open(['method'=>'post','action'=>'AttendanceController@manual_attendance_date_wise_data','id'=>'submit-form']) !!}

                        <div class="col-md-10 col-md-offset-1 ex-form">

                            <div class="form-group">
                                <div class="input-form-gap"></div>
                                <label for="emp_id" class="col-md-4">Employee Name or ID <span class='require'>*</span> <span class="clon">:</span></label>
                                <div class="col-md-8">

                                    <input type="text" name="emp_name_id" id="emp_name_id" autocomplete="off" value="" class="form-control" placeholder="Enter Employee Name or ID" required/>

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
                                        <i class="fa fa-search" aria-hidden="true"></i>
                                        Search</button>
                                </div>
                            </div>
                        </div>




                    </div>

                </div>
            </div>

            <div class="col-lg-10 col-lg-offset-1">
                <div class="panel panel-blue">
                    <div class="panel-body" id="profile_data_form">

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('extra_js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>
    <script>

        var url = "{{ route('autocomplete.employee') }}";
        $('#emp_name_id').typeahead({
            source:  function (query, process) {
                return $.get(url, { query: query }, function (data) {
                    return process(data);
                });
            }
        });

        $(function () {
            var form=$("#submit-form");
            form.on('submit',function (event) {
                event.preventDefault();
                var url="{{route('employee.short_profile')}}";
                // alert(url);
                var method="get";
                $.ajax({
                    url:url,
                    method:method,
                    data:form.serialize(),
                    success:function (response) {
                        $('#profile_data_form').html(response);
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

