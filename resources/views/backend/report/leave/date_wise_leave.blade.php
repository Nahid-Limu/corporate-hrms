@extends('layout.master')
@section('content')
    <!--BEGIN TITLE & BREADCRUMB PAGE-->
    <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
        <div class="page-header pull-left">
            <div class="page-title">Date Wise Leave Report</div>
        </div>
        <ol class="breadcrumb page-breadcrumb pull-right">
            <li><i class="fa fa-home"></i>&nbsp;<a href="{{url('/')}}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
            <li><a href="#">Date Wise Leave Report</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
            <li class="active">Date Wise Leave Report</li>
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
                                      Date Wise Leave Report
                                    </div>

                                </div>
                            </div>
                            <div class="panel-body">

                          {!! Form::open(['method'=>'post','url'=>'report/leave/date/wise/show']) !!}

                                <div class="col-md-10 col-md-offset-1 ex-form">
                                    <div class="form-group">
                                        <div class="input-form-gap"></div>
                                        <label class="col-md-4">Start Date<span class="clon">:</span></label>
                                        <div class="col-md-8">
                                            <input type="text" id="start_date" name="start_date" class="date-picker form-control hasDatepicker" autocomplete="off" required="" placeholder="Select a date...">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="input-form-gap"></div>
                                        <label class="col-md-4">End Date<span class="clon">:</span></label>
                                        <div class="col-md-8">
                                            <input type="text" id="end_date" name="end_date" class="date-picker form-control hasDatepicker" autocomplete="off" required="" placeholder="Select a date...">
                                        </div>
                                    </div>

                                    {{-- <div class="form-group">
                                            <div class="input-form-gap"></div>
                                            <label for="emp_id" class="col-md-4">Select Branch<span class="clon">:</span></label>
                                            <div class="col-md-8">
                                                <select name="branch_id" id="branch_id"  class="select2-container form-control" required>
                                                    <option value="">Select Branch</option>
                                                    @foreach($branch as $branches)
                                                      <option value="{{$branches->id}}">{{$branches->branch_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                    </div> --}}
                                    <div class="form-group">
                                        <div class="input-form-gap"></div>
                                        <br>
                                        <div class="col-md-4">
                                        </div>
                                        <div class="col-md-8">
                                            <button name="preview" value="preview" type="submit" class="btn btn-success">
                                            <i class="fa fa-search"></i> Preview</button>
                                        </div>
                                    </div>
                                </div>

                              {!! Form::close() !!}

                          </div>
                      </div>

                </div>
            </div>
    </div>
@endsection
@section('extra_js')
    <script>
        $("#branch_id").select2();

        $('#start_date').datetimepicker({
            pickTime: false
        });

        $('#end_date').datetimepicker({
            pickTime: false
        });
    </script>
@endsection

