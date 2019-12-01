@extends('layout.master')
@section('content')
    <!--BEGIN TITLE & BREADCRUMB PAGE-->
    <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
        <div class="page-header pull-left">
            <div class="page-title">  Meeting Report</div>
        </div>
        <ol class="breadcrumb page-breadcrumb pull-right">
            <li><i class="fa fa-home"></i>&nbsp;<a href="{{url('/')}}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
            <li><a href="#"> Meeting Report</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
            <li><a href="#"> Meeting Report</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
            <li class="active"> Meeting Report</li>
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
                                       Meeting Report
                                    </div>
                                </div>
                            </div>
                            <div class="panel-body">
                          {!! Form::open(['method'=>'post','url'=>'report/meeting/preview']) !!}
                                <div class="col-md-10 col-md-offset-1 ex-form">

                                    <div class="form-group">
                                                <div class="input-form-gap"></div>
                                                <label for="project_id" class="col-md-4">Select Branch<span class="clon">:</span></label>
                                                <div class="col-md-6">
                                               <select class="form-control" name="branch_id" id="branch_id" required>

                                                   <option value="">Select Branch</option>
                                                     @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('super-admin'))
                                                   @foreach($branch as $branches)
                                               <option value="{{$branches->id}}">{{$branches->branch_name}}</option>
                                                   @endforeach
                                                   @else 
                                                        <option value="{{$branch_list2->id}}">{{$branch_list2->branch_name}}</option>
                                                   @endif
                                               </select>
                                          </div>
                                    </div>

                                    <div class="form-group">
                                            <div class="input-form-gap"></div>
                                            <label for="project_id" class="col-md-4">Select Meeting<span class="clon">:</span></label>
                                            <div class="col-md-6">
                                           <select class="form-control" name="meeting_id" id="meeting_id" required>
                                               <option>Select Branch First</option>
                                           </select>
                                        </div>
                                    </div>


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
        $(document).ready(function(){
            $('#start_date').datetimepicker({
            pickTime: false
            });
            $('#end_date').datetimepicker({
            pickTime: false
            });



            //branch wise meeting ajax
            $("#branch_id").change(function(){
                   var id = $("#branch_id").val();
                   $.ajax({
                       type: "GET",
                       url:"{{url('report/meeting/branch_wise_ajax')}}"+"/"+id,
                       dataType:"json",
                       success:function(response){
                             var meeting = '';
                             meeting+='<option value="">Select</option>'
                           $.each(response, function (i, item) {
                            meeting += '<option value="'+item.id+'">'+item.meeting_subject+'</option>';
                           });
                           $('#meeting_id').html(meeting);
                           $("#meeting_id").select2();
                       }
                   })
               });

            $("#branch_id").select2();
        });
    </script>
@endsection

