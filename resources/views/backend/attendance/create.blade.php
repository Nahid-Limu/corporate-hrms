@extends('layout.master')
@section('title', 'Attendance File')
@section('content')
    <!--BEGIN TITLE & BREADCRUMB PAGE-->
    <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
        <div class="page-header pull-left">
            <div class="page-title">Attendance Files</div>
        </div>
        <ol class="breadcrumb page-breadcrumb pull-right">
            <li><i class="fa fa-home"></i>&nbsp;<a href="{{url('/')}}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
            <li><a href="#">Attendance</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
            <li class="active">Upload Files</li>
        </ol>
        <div class="clearfix"></div>
    </div>
    <!--END TITLE & BREADCRUMB PAGE-->

    <!--Flash Message Start-->
    @if(Session::has('success'))
            <p id="alert_message" class="alert alert-success">{{ Session::get('success') }}</p>
    @endif
    @if(Session::has('error'))
        <p id="alert_message" class="alert alert-error">{{ Session::get('error') }}</p>
    @endif
    @if(Session::has('delete'))
        <p id="alert_message" class="alert alert-danger">{{ Session::get('delete') }}</p>
    @endif
    <!--Flash Message End-->
    <div class="page-content">
            <div class="row">
                <span id="form_error">
                    @if ($errors->any())
                        <div id="alert_message" class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </span>
                    <div class="col-lg-12">
                        <div class="panel panel-blue">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-md-6">
                                        Upload Attendance File
                                    </div>
                                </div>
                            </div>
                            {!! Form::open(['method'=>'post','action'=>'AttendanceController@store','files'=>true,'id'=>'file_form']) !!}
                                <div class="panel-body">
                                    <div class="form-group">
                                        <div class="col-md-3">
                                            <label for="title" class="pull-left"><h5>Title <span class='require'>*</span></h5></label>
                                            <div>
                                                <input type="text" id="title" required class="form-control" name="title" placeholder="Enter Title" />
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <label for="task_id" class="pull-left"><h5>Select File<span class='require'>*</span></h5></label>
                                            <div>
                                                <input type="file" id="file" required class="form-control" name="file"/>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="pull-left"><h5>Description</h5></label>
                                            <div>
                                                <input id="description" type="text" class="form-control" name="description" placeholder="Description" />
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <button type="submit" id="real_submit" class="btn btn-md btn-round btn-blue" style="display: none"><i class="fa fa-check"></i> </button>
                                        </div>


                                        {!! Form::close() !!}
                                        <button type="button" id="submit_file" class="btn btn-md btn-round btn-blue" style="margin-top: 39px;"><i class="fa fa-check"></i> Add File</button>
                                    </div>
                                </div>

                        </div>
                    </div>
                </div>

                <div class="row">
                        <div class="col-lg-12">
                            <div class="panel panel-blue">
                                <div class="panel-heading">
                                    <div class="row">
                                        <div class="col-md-6">
                                            Process Attendance Files (Recent 5 Upload)
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-body table-responsive">
                                    <div style="padding: 15px;" id="table-sorter-tab" class="tab-pane fade in active">
                                        <div class="row">
                                                <table class="table table-hover table-striped table-bordered table-advanced tablesorter">
                                                    <thead>
                                                    <tr>
                                                        <th width="15%">Title</th>
                                                        <th width="15%">File Name</th>
                                                        <th width="10%">Description</th>
                                                        <th width="15%">Upload Time</th>
                                                        <th width="10%">Process Status</th>
                                                        <th width="15%">Process Time</th>
                                                        <th width="12%">Actions</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody id="table_body">
                                                    @if(count($files)!=0)
                                                        @foreach($files as $f)
                                                            <tr>
                                                                <td>{{$f->title}}</td>
                                                                <td><a href="{{asset('/../attendance_file')."/".$f->attendance_file}}">{{$f->attendance_file}} &nbsp; <i class="fa fa-download"></i> </a></td>
                                                                <td>{{$f->description}}</td>
                                                                <td>{{\Carbon\Carbon::parse($f->upload_date)->format('j-M-Y h:i A')}}</td>
                                                                <td>
                                                                    @if($f->process_status==0)
                                                                        <span style="color:black;" class="label label-sm label-warning">Pending</span>
                                                                    @elseif($f->process_status==1)
                                                                        <span class="label label-sm label-success">Processed</span>
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    @if($f->process_date!=null)
                                                                        {{\Carbon\Carbon::parse($f->process_date)->format('j-M-Y h:i A')}}
                                                                    @endif
                                                                </td>

                                                                <td>
{{--                                                                    @if($f->process_status==1)--}}

{{--                                                                    @else--}}
                                                                    <a target="_blank" href="{{route('attendance_file.process',base64_encode($f->id))}}"><button type="button" class="btn btn-green btn-xs"><i class="fa fa-cog" aria-hidden="true"></i>&nbsp;
                                                                        Process
                                                                        </button>
                                                                    </a>

{{--                                                                    @endif--}}
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    @else
                                                        <tr>
                                                            <td align="center" colspan="7"><span style="font-weight: bold" class="text-danger">No Data Found</span></td>
                                                        </tr>
                                                    @endif

                                                    </tbody>
                                                </table>
                                                <hr class="mtxl mbxl"/>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <h3 class="text-center text-danger" id="errorMssg"></h3>
                                </div>
                            </div>
                        </div>
                    </div>

    
@endsection

@section('extra_js')
<script>
    $(document).ready(function () {
        var form = $('#file_form');
        form.on('submit', function(event) {
            event.preventDefault();
            var url="{{route('attendance_file.store')}}";
            $.ajax({
                url:url,
                method:"post",
                data:new FormData(this),
                processData: false,
                contentType: false,
                success:function (response) {
                    if(response.errors){
                        html = '<div class="alert alert-danger">';
                        for(var count = 0; count < response.errors.length; count++)
                        {
                            html += '<p>' + response.errors[count] + '</p>';
                        }
                        html += '</div>';
                        $('#form_error').html(html);
                    }
                    else {
                        swal("Attendance file uploaded and ready for processing.");
                        $("#title").val("");
                        $("#description").val("");
                        $("#file").val("");
                        $("#form_error").css('display', 'none');
                        $("#table_body").html(response);


                    }

                }

            });
            // return false;
        });

        $('#submit_file').click(function (event) {
            event.preventDefault();
            $('#real_submit').click();
        });

    })
</script>
@endsection