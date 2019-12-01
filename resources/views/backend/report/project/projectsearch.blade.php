@extends('layout.master')
@section('content')
    <!--BEGIN TITLE & BREADCRUMB PAGE-->
    <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
        <div class="page-header pull-left">
            <div class="page-title">   Branch Wise Project</div>
        </div>
        <ol class="breadcrumb page-breadcrumb pull-right">
            <li><i class="fa fa-home"></i>&nbsp;<a href="{{url('/')}}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
            <li><a href="#">Manage Report</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
            <li><a href="#">Project</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
            <li class="active">Project List</li>
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
                                       Branch Wise Project
                                    </div>

                                </div>
                            </div>
                            <div class="panel-body">

                          {!! Form::open(['method'=>'post','url'=>'report/branch/project/show']) !!}
                                <div class="col-md-10 col-md-offset-1 ex-form">
                                    <div class="form-group">
                                            <div class="input-form-gap"></div>
                                            <label for="branch_id" class="col-md-4">Select Branch<span class="clon">:</span></label>
                                            <div class="col-md-8">
                                                <select name="branch_id" id="branch_id"  class="select2-container form-control" required>
                                                    <option value="">Select Branch</option>
                                                </select>
                                            </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="input-form-gap"></div>
                                        <label for="project_id" class="col-md-4">Select Project<span class="clon">:</span></label>
                                        <div class="col-md-8">
                                            <select name="project_id" id="project_id"  class="select2-container form-control" required>
                                                    <option value="">Select Project</option>
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
                                                {{-- <button type="submit" name="pdf" value="pdf" class="btn btn-success">
                                                    <i class="fa fa-search"></i> Generate PDF</button> --}}
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


            $.ajax({
                url:"{{route('ajax.get_branch')}}",
                method:"GET",
                success:function (response) {
                    //console.log(response);
                    $('#branch_id').html(response);
                }
            });
             //get employee
            $('#branch_id').on('change',function () {
                var id = $("#branch_id").val();
                //alert(id);
                $.ajax({
                    type: "GET",
                    url:"{{url('ajax/get_project')}}"+"/"+id,
                    success:function (response) {
                        console.log(response);
                        var project_list = '';
                        project_list+='<option value="">Select</option>'
                        $.each(response, function (i, item) {
                            project_list += '<option value="'+item.id+'">'+item.project_name+'</option>';
                        });
                        $('#project_id').html(project_list);

                    },
                    error:function(response){

                    }
                });
            });

        });

        $("#branch_id").select2({
            placeholder: "Select Branch"
        });
        $("#project_id").select2({
            placeholder: "Select Project"
        });

    </script>

@endsection

