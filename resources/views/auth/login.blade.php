<?php
use App\Http\Controllers\AccessController;
if(AccessController::ipAccess()==false){
    redirect('/AccessDenied')->send();
} 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>FEITS | One HRMS</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->  
    <link rel="icon" type="image/png" href="{{asset('login_assets/images/icons/favicon.ico')}}"/>
<!--===============================================================================================-->
    {{ Html::style('login_assets/vendor/bootstrap/css/bootstrap.min.css') }}
<!--===============================================================================================-->
    {{ Html::style('login_assets/fonts/font-awesome-4.7.0/css/font-awesome.min.css') }}
<!--===============================================================================================-->
    {{ Html::style('login_assets/fonts/iconic/css/material-design-iconic-font.min.css') }}
<!--===============================================================================================-->
    {{ Html::style('login_assets/vendor/animate/animate.css') }}
<!--===============================================================================================-->  
    {{ Html::style('login_assets/vendor/css-hamburgers/hamburgers.min.css') }}
<!--===============================================================================================-->
    {{ Html::style('login_assets/vendor/animsition/css/animsition.min.css') }}
<!--===============================================================================================-->
    {{ Html::style('login_assets/vendor/select2/select2.min.css') }}
<!--===============================================================================================-->
    {{ Html::style('login_assets/css/util.css') }}
    {{ Html::style('login_assets/css/main.css') }}
<!--===============================================================================================-->
    {{ Html::style('corporate/vendors/animate.css/animate.css') }}
</head>
<body>
    
    <div class="limiter">
        <div class="container-login100" style="background-image: url({{asset('login_assets/images/9.jpg')}});">
            <div class="wrap-login100  zoomIn animated"  >
                <form class="login100-form validate-form"  method="POST" action="{{ route('login') }}" aria-label="{{ __('Login') }}" autocomplete="off">
                    <span class="login100-form-logo">
                        <i class="zmdi zmdi-lock"></i>
                    </span>

                    <span class="login100-form-title p-b-25 p-t-20">
                        Log in
                    </span>
                        @csrf
                        <?php if ($errors->has('email') OR $errors->has('password')){ ?>
                        <div style="color: #ff382e; background: transparent; padding: 0px; border-radius: 16px; font-size: 12px; text-align: center;">
                            @if ($errors->has('email'))
                                <strong>{{ $errors->first('email') }}</strong>
                            @endif

                            @if ($errors->has('password'))
                                <strong>{{ $errors->first('password') }}</strong>
                            @endif
                        </div>
                        
                        <br>
                           <?php } ?>
                        
                        <div class="wrap-input100 validate-input" data-validate = "Enter username">
                            <input class="input100"  id="email" type="email" name="email" value="{{ old('email') }}" placeholder="Email" required autofocus  autocomplete="off" >
                            <span class="focus-input100" data-placeholder="&#xf207;"></span>
                        </div>

                        <div class="wrap-input100 validate-input" data-validate="Enter password">
                            <input class="input100"  id="password" type="password" name="password" placeholder="password" required  autocomplete="new-password" >
                            <span class="focus-input100" data-placeholder="&#xf191;"></span>

                        </div>

                        <div class="contact100-form-checkbox">
                            <input class="input-checkbox100"  class="form-check-input" type="checkbox" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }} >
                            <label class="label-checkbox100" for="ckb1">
                                Remember me
                            </label>
                        </div>

                        <div class="container-login100-form-btn">
                            <button class="login100-form-btn"  type="submit">
                                Login
                            </button>
                        </div>

                    <div class="text-center p-t-20">
                        <hr>
                        <a class="txt1" href="#">
                            Developed By <b>FEITS</b>
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    

    <div id="dropDownSelect1"></div>
    
<!--===============================================================================================-->
    {{ Html::script('login_assets/vendor/jquery/jquery-3.2.1.min.js') }}
<!--===============================================================================================-->
    {{ Html::script('login_assets/vendor/animsition/js/animsition.min.js') }}
<!--===============================================================================================-->
    {{ Html::script('login_assets/vendor/bootstrap/js/popper.js') }}
    {{ Html::script('login_assets/vendor/bootstrap/js/bootstrap.min.js') }}
<!--===============================================================================================-->
    {{ Html::script('login_assets/vendor/select2/select2.min.js') }}
<!--===============================================================================================-->
    {{ Html::script('login_assets/js/main.js') }}

</body>
</html>
