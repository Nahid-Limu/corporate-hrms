@extends('layout.master')
@section('title', 'System Settings')
@section('content')

    <script>
        setTimeout(function() {
            $('#alert_message').fadeOut('fast');
        }, 5000);
    </script>
    <div class="page-content">

        @if(Session::has('message'))
            <p id="alert_message" class="alert {{ Session::get('alert-class', 'alert-success') }}">{{ Session::get('message') }}</p>
        @endif
        <div class="row">
            <div class="col-md-12">

                <div class="panel panel-default">
                    <div class="panel-heading"><h4><b>Theme Style </b></h4></div>
                    <div class="panel-body">
                        {!! Form::open(array('url' => 'change_style', 'method' => 'POST')) !!}
                        <table class="" width="100%">
                            <tr>
                                <td style="padding:30px;" >
                                    <label class="rcontainer">
                                        <input id="colorVersion" type="radio" <?php if(Auth::user()->theme_style==1){ echo "checked"; } ?> value="1" name="themeStyle" required="">
                                        <span class="checkmark"></span>Color touch version
                                    </label>
                                    <img  onclick="changeselector(0)" style="cursor: pointer;" src="{{url('corporate/images/theme/default.jpg')}}" width="" class="img-responsive" >
                                </td>
                                <td style="padding:30px;">
                                    <label class="rcontainer">
                                        <input  id="lightVersion"  type="radio" <?php if(Auth::user()->theme_style==2){ echo "checked"; } ?>  value="2" name="themeStyle" required="">
                                        <span class="checkmark"></span> Dark version
                                    </label>
                                    <img onclick="changeselector(1)" style="cursor: pointer;" src="{{url('corporate/images/theme/dark.jpg')}}" width="" class="img-responsive" >
                                </td>
                            </tr>

                                <td style="padding-top:60px;text-align: center;" colspan="2" >
                                    <hr>
                                    <button onclick="return confirm('Are you sure to change?')" class="btn btn-success" type="submit"> <i class="fa fa-refresh"></i>&nbsp; &nbsp; Change Theme Style</button>
                                </td>
                            </tr>
                        </table>
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        function changeselector(val){
            if(val==1){
                document.getElementById('colorVersion').checked = true;
            }else if(val==2){
                document.getElementById('lightVersion').checked = true;
            }else if(val==3){
                document.getElementById('darkVersion').checked = true;
            }else if(val==4){
                document.getElementById('lightBlueVersion').checked = true;
            }else{
                alert("Please choose a theme.");
            }
        }
    </script>
    @include('include.copyright')
@endsection
