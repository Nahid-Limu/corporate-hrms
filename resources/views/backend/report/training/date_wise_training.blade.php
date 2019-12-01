@extends('layout.master')
@section('content')
    <!--BEGIN TITLE & BREADCRUMB PAGE-->
    <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
        <div class="page-header pull-left">
            <div class="page-title">Date Wise Training</div>
        </div>
        <ol class="breadcrumb page-breadcrumb pull-right">
            <li><i class="fa fa-home"></i>&nbsp;<a href="{{url('/')}}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
            <li><a href="#">Date Wise Training</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
            <li class="active">Date Wise Training</li>
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
                                            Date Wise Training
                                    </div>
                                </div>
                            </div>
                            <div class="panel-body">
                          {!! Form::open(['method'=>'post','url'=>'report/training/date/wise']) !!}
                                <div class="col-md-10 col-md-offset-1 ex-form">
                                    <div class="form-group">
                                            <div class="input-form-gap"></div>
                                            <label for="branch_id" class="col-md-4">Select Branch<span class="clon">:</span></label>
                                            <div class="col-md-8">
                                                <select name="branch_id" id="branch_id"  class="select2-container form-control" required>
                                                    <option value="">Select Branch</option>
                                                     @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('super-admin'))
                                                    @foreach($branch as  $branchs)
                                                       <option value="{{ $branchs->id}}">{{$branchs->branch_name}}</option>
                                                    @endforeach
                                                    @else 
                                                        <option value="{{$branch_list2->id}}">{{$branch_list2->branch_name}}</option>
                                                    @endif
                                                </select>
                                            </div>
                                       </div>
                                  </div>


                                  <div class="col-md-10 col-md-offset-1 ex-form">
                                        <div class="form-group">
                                                <div class="input-form-gap"></div>
                                                <label for="branch_id" class="col-md-4">Start Date<span class="clon">:</span></label>
                                                <div class="col-md-8">
                                                  <input type="text" id="start_date" class="form-control" name="start_date" autocomplete="off" required>
                                                </div>
                                           </div>
                                      </div>

                                      <div class="col-md-10 col-md-offset-1 ex-form">
                                            <div class="form-group">
                                                    <div class="input-form-gap"></div>
                                                    <label for="branch_id" class="col-md-4">End Date<span class="clon">:</span></label>
                                                    <div class="col-md-8">
                                                      <input type="text" id="end_date" class="form-control" name="end_date" autocomplete="off" required>
                                                    </div>
                                               </div>
                                          </div>
                                          <div class="col-md-10 col-md-offset-1 ex-form">
                                          <div class="form-group">
                                                <div class="input-form-gap"></div>
                                                <br>
                                                <div class="col-md-4">
                                                </div>
                                                <div class="col-md-8">
                                                    <button type="submit" name="preview" value="preview"  class="btn btn-success">
                                                    <i class="fa fa-search"></i> Preview</button>
                                                    <button type="submit" name="pdf" value="pdf" class="btn btn-success">
                                                        <i class="fa fa-download"></i> Generate PDF</button>
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
        $("#branch_id").select2({
            placeholder: "Select Branch"
        });
        $("#project_priorityhigh_id").select2({
            placeholder: "Select Project"
        });
        $('#start_date').datetimepicker({
            pickTime: false
        });
        $('#end_date').datetimepicker({
            pickTime: false
        });
    </script>
@endsection

