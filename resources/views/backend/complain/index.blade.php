@extends('layout.master')
@section('title', 'Complain Box ')
@section('extra_css')
    {{ Html::style('corporate/vendors/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css') }}
@endsection
@section('content')

    <div class="page-content">

        <div class="row">
            <div class="col-lg-10 col-lg-offset-1">
                <div class="panel panel-blue">
                    <div class="panel-heading ex-panel">
                        <div class="row">
                            <div style="text-align: center" class="col-md-12">
                                Add New Complain
                            </div>

                        </div>
                    </div>
                    <div class="panel-body">



                        <div class="col-md-8 col-md-offset-2 ex-form">
                            <form >
                                @csrf
                                <br>
                                <br>
                                <div class="form-group col-md-12">
                                    <label for="complain_text">Complain TOKEN <span class='require'>*</span> <span class="clon">:</span></label>
                                    <div>
                                        <input name="complain_token" required="" value="" readonly="" class="form-control" placeholder="Complain TOKEN will be generate automatically" />
                                    </div>
                                </div>
                                <br>
                                <div class="form-group col-md-12">
                                    <label for="complain_text">Complain Message <span class='require'>*</span> <span class="clon">:</span></label>
                                    <div>
                                        <textarea name="complain_text" id="complain_text" required="" placeholder="Complain Message"  rows="8" class="wysihtml5 form-control "></textarea>
                                    </div>
                                </div>
                                <br><br>
                                <br>
                                    <div class="input-form-gap"></div>

                                <div class="form-group col-md-12" >
                                    <label for="complain_to">Complain To <span class='require'>*</span> <span class="clon">:</span></label>
                                    <div>
                                        <select name="complain_to"  id="complain_to" class="form-control" required=""  title="Select complain to:">
                                                <option value="">Select </option>
                                            @foreach($users as $user)
                                                <option value="{{$user->id}}">{{$user->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="input-form-gap"></div>
                                    <br>
                                    <div class="col-md-12">
                                        <hr>
                                       <center> <button id="complain_submit" type="button" class="btn btn-success"><i class="fa fa-plus-square"></i> Submit Complain</button></center>
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
{{ Html::script('corporate/vendors/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js') }}
    <script>
        $(function () {
            $('#complain_submit').on('click',function () {
                var _token = '{{ csrf_token() }}';
                var complain_text=$('#complain_text').val();
                var complain_to=$('#complain_to').val();

                if(complain_text!=''){
                    if(complain_to!=''){
                        $.ajax({
                            url:"{{route('complain.submit')}}",
                            type:"POST",
                            data:{_token:_token,complain_to:complain_to,complain_text:complain_text},
                            success:function (response) {
                                // console.log(response);
                                 swal("TOKEN NUMBER: "+response, "Complain has been successfully submitted.", "success");
                            }
                        })
                    }else{
                        $('#complain_to').focus();
                        swal("Please fill in the required fields!", {
                        icon: "error",
                        });
                    }
                }else{
                    $('#complain_text').focus();
                    swal("Please fill in the required fields!", {
                    icon: "error",
                    });
                }

            })

            $('.wysihtml5').wysihtml5({
                 "font-styles": true, //Font styling, e.g. h1, h2, etc.
                 "emphasis": true, //Italics, bold, etc.
                 "lists": true, //(Un)ordered lists, e.g. Bullets, Numbers.
                 "html": true, //Button which allows you to edit the generated HTML.
                 "link": false, //Button to insert a link.
                 "image": false, //Button to insert an image.
                 "color": false //Button to change color of font
            });

        })
    </script>

@endsection


