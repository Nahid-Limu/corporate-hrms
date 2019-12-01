@extends('layout.master')
@section('content')
    <!--BEGIN TITLE & BREADCRUMB PAGE-->
    <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
        <div class="page-header pull-left">
            <div class="page-title">Search Employee List</div>
        </div>
        <ol class="breadcrumb page-breadcrumb pull-right">
            <li><i class="fa fa-home"></i>&nbsp;<a href="{{url('/')}}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
            <li><a href="">Search Employee List</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
            <li class="active">Search Employee List</li>
        </ol>
        <div class="clearfix"></div>
    </div>
    <!--END TITLE & BREADCRUMB PAGE-->
    <div class="page-content">
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-blue">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-md-6">
                               Search Employee List
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="col-md-12">
                            <form method="post" id="file_sharing_form" enctype="multipart/form-data" novalidate>
                                @csrf
                            <div id="type_div">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Select Type</label>
                                        <select class="form-control" id="type_id" name="type_id">
                                            <option value="">Select</option>
                                            <option value="1">Individual Share</option>
                                            <option value="2">Multiple Share</option>
                                            <option value="3">Branch wise Share</option>
                                            <option value="4">Department wise Share</option>
                                            <option value="5">Designation wise Share</option>
                                        </select>
                                    </div>
                                </div>



                                <div id="type_one" style="display: none">
                                   <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Select Employee</label>
                                            <select class="form-control" id="emp_id" name="emp_id" required>
                                                <option value="">Select</option>
                                                @foreach($employee as $employees)
                                                   <option value="{{$employees->id}}">{{$employees->employeeId}} {{$employees->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                   </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                           <label>Chose File</label>
                                            <input type="file" id="share_file_one" name="share_file_one[]" accept=".gif,.jpg,.jpeg,.png,.doc,.docx,.pdf" multiple required>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <button class="btn btn-success" type="submit" id="share_id"><i class="fa fa-share-alt"></i> Share</button>
                                    </div>
                               </div>



                                <div id="type_two" style="display: none">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Select Employee</label>
                                            <select class="form-control" id="emp_id_multiple" name="emp_id_multiple[]" multiple required>
                                                <option value="">Select</option>
                                                @foreach($employee as $employees)
                                                    <option value="{{$employees->id}}">{{$employees->employeeId}} {{$employees->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Chose File</label>
                                            <input type="file" id="share_file_two" name="share_file_two[]" accept=".gif,.jpg,.jpeg,.png,.doc,.docx,.pdf" multiple required>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <button class="btn btn-success" type="submit" id="share_id_two"><i class="fa fa-share-alt"></i> Share</button>
                                    </div>
                                </div>





                                <div id="type_three" style="display: none">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Select Branch</label>
                                            <select class="form-control" id="branch_id" name="branch_id" required>
                                                <option value="">Select</option>
                                                @foreach($branch as $branches)
                                                    <option value="{{$branches->id}}">{{$branches->branch_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Chose File</label>
                                            <input type="file" id="share_file_three" name="share_file_three[]" accept=".gif,.jpg,.jpeg,.png,.doc,.docx,.pdf" multiple required>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <button class="btn btn-success" type="submit" id="share_id_three"><i class="fa fa-share-alt"></i> Share</button>
                                    </div>
                                </div>




                                <div id="type_four" style="display: none">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Select Department</label>
                                            <select class="form-control" id="dept_id" name="dept_id" required>
                                                <option value="">Select</option>
                                                @foreach($department as $departments)
                                                    <option value="{{$departments->id}}">{{$departments->department_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Chose File</label>
                                            <input type="file" id="share_file_four" name="share_file_four[]" multiple required>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <button class="btn btn-success" type="submit" id="share_id_four"><i class="fa fa-share-alt"></i> Share</button>
                                    </div>
                                </div>





                                <div id="type_five" style="display: none">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Select Designation</label>
                                            <select class="form-control" id="designation_id" name="designation_id" required>
                                                <option value="">Select</option>
                                                @foreach($designation as $designations)
                                                    <option value="{{$designations->id}}">{{$designations->designation_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Chose File</label>
                                            <input type="file" id="share_file_five" name="share_file_five[]" multiple required>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <button class="btn btn-success" type="submit" id="share_id_five"><i class="fa fa-share-alt"></i> Share</button>
                                    </div>
                                </div>
                            </div>
                           </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('extra_js')
    <script>
        //type change from select
        $("#type_id").change(function () {
           var select_type=$("#type_id").val();
            if(select_type==1){
              $("#type_one").show();
              $("#type_two").hide();
              $("#type_three").hide();
              $("#type_four").hide();
              $("#type_five").hide();
            }
            if(select_type==2){
                $("#type_two").show();
                $("#type_one").hide();
                $("#type_three").hide();
                $("#type_four").hide();
                $("#type_five").hide();
            }
            if(select_type==3){
                $("#type_three").show();
                $("#type_two").hide();
                $("#type_one").hide();
                $("#type_four").hide();
                $("#type_five").hide();
            }
            if(select_type==4){
                $("#type_four").show();
                $("#type_two").hide();
                $("#type_one").hide();
                $("#type_three").hide();
                $("#type_five").hide();
            }
            if(select_type==5){
                $("#type_five").show();
                $("#type_two").hide();
                $("#type_one").hide();
                $("#type_three").hide();
                $("#type_four").hide();
            }
        });


        //branch wise employee or team member ajax
        //project Add
        $('#file_sharing_form').on('submit', function(event){
            event.preventDefault();
            $.ajax({
                url:"{{ route('file_share_store') }}",
                method:"POST",
                data:new FormData(this),
                dataType:'JSON',
                contentType: false,
                cache: false,
                processData: false,
                success:function(response)
                {
                    if(response.success){
                        swal(response.success, "", "success");
                    }
                },
                error: function(response) {
                    console.log(response);
                }

            })
        });
        $("#emp_id").select2();
        $("#emp_id_multiple").select2({
            placeholder: "Select"
        });
        $("#branch_id").select2();
        $("#dept_id").select2();
        $("#designation_id").select2();
    </script>
@endsection

