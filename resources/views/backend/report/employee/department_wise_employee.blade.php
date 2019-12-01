@extends('layout.master')
@section('content')
    <!--BEGIN TITLE & BREADCRUMB PAGE-->
    <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
        <div class="page-header pull-left">
            <div class="page-title">Department Wise Employee</div>
        </div>
        <ol class="breadcrumb page-breadcrumb pull-right">
            <li><i class="fa fa-home"></i>&nbsp;<a href="{{url('/')}}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
            <li><a href="#">Department Wise Employee</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
            <li class="active">Department Wise Employee</li>
        </ol>
        <div class="clearfix"></div>
    </div>
    <!--END TITLE & BREADCRUMB PAGE-->
    <div class="page-content">

        <div class="row">
            <div class="col-lg-10 col-lg-offset-1">
                <div class="panel panel-blue">
                    <div class="panel-heading ex-panel">
                        <div class="row">
                            <div class="col-md-12">
                                Department Wise Employee
                            </div>

                        </div>
                    </div>
                    <div class="panel-body">

                        {!! Form::open(['method'=>'post','url'=>'report/department/employee/show']) !!}

                        <div class="col-md-10 col-md-offset-1 ex-form">
                            {{--<div class="form-group">--}}
                            {{--<div class="input-form-gap"></div>--}}
                            {{--<label class="col-md-4">Start Date<span class="clon">:</span></label>--}}
                            {{--<div class="col-md-8">--}}
                            {{--<input type="date" name="date" class="date-picker form-control hasDatepicker" value="" required="" placeholder="Select a date..." id="">--}}
                            {{--</div>--}}
                            {{--</div>--}}
                            {{--<div class="form-group">--}}
                            {{--<div class="input-form-gap"></div>--}}
                            {{--<label class="col-md-4">Start Date<span class="clon">:</span></label>--}}
                            {{--<div class="col-md-8">--}}
                            {{--<input type="date" name="date" class="date-picker form-control hasDatepicker" value="" required="" placeholder="Select a date..." id="">--}}
                            {{--</div>--}}
                            {{--</div>--}}
                            <div class="form-group">
                                <div class="input-form-gap"></div>
                                <label for="emp_id" class="col-md-4">Select Department<span class="clon">:</span></label>
                                <div class="col-md-8">
                                    <select name="department_id" id="department_id"  class="select2-container form-control" required>
                                        <option value="">Select Department</option>
                                        @foreach($department as $departments)
                                            <option value="{{$departments->id}}">{{$departments->department_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-form-gap"></div>
                                <br>
                                <div class="col-md-4">
                                </div>
                                <div class="col-md-8">
                                    <button name="preview" value="preview" type="submit" class="btn btn-success">
                                        <i class="fa fa-search"></i> Preview</button>
                                        <button name="pdf" value="pdf" type="submit" class="btn btn-success">
                                                <i class="fa fa-download"></i> Download PDF</button>
                                </div>
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
        $("#department_id").select2();
    </script>

@endsection

