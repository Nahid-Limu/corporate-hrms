@extends('layout.master')
@section('title', 'Salary Settings')
@section('content')
    <!--BEGIN TITLE & BREADCRUMB PAGE-->
    <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
        <div class="page-header pull-left">
            <div class="page-title">Salary Settings</div>
        </div>
        <ol class="breadcrumb page-breadcrumb pull-right">
            <li><i class="fa fa-home"></i>&nbsp;<a href="{{url('/')}}">Home</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
            <li><a href="#">Salary</a>&nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;&nbsp;</li>
            <li class="active">Salary Settings</li>
        </ol>
        <div class="clearfix"></div>
    </div>
    <!--END TITLE & BREADCRUMB PAGE-->

   
    <div class="page-content" id="settings">
            <!--Flash Message Start-->
                {{ Html::script('corporate/js/sweetalert.min.js') }}
                @if(Session::has('success'))
                <script>
                    var msg =' <?php echo Session::get('success');?>'
                    swal(msg, "", "success");
                </script>
                @elseif(Session::has('delete'))
                <script>
                    var msg =' <?php echo Session::get('delete');?>'
                    swal(msg, "", "warning");
                </script>
                @endif
            <!--Flash Message End-->
            <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-blue">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-md-6"> 
                                        <i class="fa fa-cog" style="font-size: 20px;"></i>
                                        Settings
                                    </div>
                                    
                                </div>
                            </div>
                            <div class="panel-body" >
                                <form id="salary_settings_form">
                                        @csrf
                                @foreach ($salary_settings as $settings)
                                <div class="row">
                                    <div class="form-group">
                                        <div class="col-md-6">
                                            <div>
                                                <label for="food" class="pull-left"><h4>{{$settings->title}}:</h4></label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div>
                                                <input type="checkbox" @if ($settings->status == 1) checked  @endif   data-toggle="toggle" data-on="Active" data-off="InActive" data-onstyle="success" data-offstyle="danger" name="on[]" value="{{$settings->id}}" >
                                                {{--  <input type="hidden" name="handymanid" value="{{$settings->status}}">  --}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                                <hr>
                                <div class="row">
                                    <div class="form-group">
                                        <div class="col-md-6">
                                            <div>
                                                    <button type="button" id="apply" class="btn btn-md btn-info"><i class="fa fa-check"></i> Apply</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- <button type="button" id="change" class="btn btn-md btn-info"><i class="fa fa-check"></i> change</button> --}}
    <!-- Modal Start -->
    @include('backend.salary.modal.view')
    @include('backend.salary.modal.edit')
    <!-- Modal End -->
    </div>
@endsection

@section('extra_js')
<script>
    $(document).ready(function(){
    
        //update branch
        $( "#apply" ).click(function() {
            var _token = '{{ csrf_token() }}';
            var salarySettings = $('#salary_settings_form').serialize();
            //alert(_token);
                $.ajax({
                    url:"{{route('salary_settings_update')}}",
                    method:"post",
                    data: salarySettings,
                    success:function (response) {
                        //console.log(response);
                        var html = '';
                        if(response.errors)
                        {
                        html = '<div class="alert alert-danger">';
                        
                        html += '<p>' + response.errors + '</p>';
                        
                        html += '</div>';
                        $('#edit_form_result').html(html);
                        }
                        if(response.falied)
                        {
                            swal(response.falied, "", "warning");
                        }
                        if(response.success)
                        {
                            //$("#settings").load(" #settings");
                            $('#settings').delay(10000).load();
                            swal(response.success, "", "success");

                            {{-- $('#edit_form_result').hide();
                            $('#edit_branch_modal_form')[0].reset();
                            $('#branch').DataTable().ajax.reload();
                            $('#editBranch').modal('hide'); --}}
                            
                        }
                        
                    }
                });
            });


            //test code
            {{-- $( "#change" ).click(function() {
               
                var pageUrl = "{{route('salary_assign_view')}}";
                //alert(pageUrl);
                $.ajax({
                    url:pageUrl,
                    success:function (response) {
                        console.log('data sent')
                        $('.page-content').delay(10000).load(pageUrl);
                    }
                });
                if(pageUrl != window.location){
                    window.history.pushState({path:pageUrl},'',pageUrl);
                }
                return false;
            }); --}}
       
    
    });
</script>
@endsection
