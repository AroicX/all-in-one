<!DOCTYPE html>
<html lang="en">

<head>

  <title>CorpERM | Login</title>
  <!-- Meta -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="description" content="" />
  <meta name="keywords" content="">
  <meta name="author" content="Ahead!!" />
  <!-- Favicon icon -->
  <link rel="icon" href="assets/images/favicon.ico" type="image/x-icon">

  <!-- vendor css -->
  <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
  
  <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>
  <meta name="csrf-token" content="{{ csrf_token() }}">


</head>

<!-- [ signin-img ] start -->
<div class="auth-wrapper align-items-stretch aut-bg-img">
  <div class="flex-grow-1">
    <div class="h-100 d-md-flex align-items-center auth-side-img">
      <div class="col-sm-10 auth-content w-auto">
        <!-- <img src="{{asset('assets/images/auth/auth-logo.png') }}" alt="" class="img-fluid"> -->
        <h1 class="text-white my-4">CorpERM!</h1>
        <h1 class="text-white my-4">Welcome!</h1>
        <h4 class="text-white font-weight-normal">SRegister a new membership</h4>
      </div>
    </div>
    <div class="auth-side-form">
      <div class=" auth-content">
        <img src="assets/images/auth/auth-logo-dark.png" alt="" class="img-fluid mb-4 d-block d-xl-none d-lg-none">
        <h3 class="mb-4 f-w-400">Signin</h3>
        <form action="{{url('/register')}}" method="post">
          @include('includes.errors')
          @include('includes.status')
           <input type="hidden" name="_token" value="{!! csrf_token() !!}">
           <div class="form-group mb-3">
            <label class="floating-label" for="Email">Fullname</label>
            <input type="text" class="form-control" name="fullname" placeholder="Full Name" required>
          </div>
           <div class="form-group mb-3">
            <label class="floating-label" for="Email">Email address</label>
            <input type="text" name="email" class="form-control" id="Email" placeholder="">
          </div>
          <div class="form-group mb-4">
            <label class="floating-label" for="Password">Password</label>
            <input type="password" class="form-control" name="password" id="Password" placeholder="">
          </div>
          <div class="form-group mb-4">
            <label class="floating-label" for="Password">Retype password</label>
            <input type="password" class="form-control" name="password_confirmation" minlength="6" placeholder="Retype password" required>
          </div>
          <div class="custom-control custom-checkbox text-left mb-4 mt-2">
            <input type="checkbox" name="remember" class="custom-control-input" id="customCheck1">
            <label class="custom-control-label" for="customCheck1">I agree to the <a href="#">terms</a></label>
          </div>
          <button class="btn btn-block btn-primary mb-4">Signup</button>
        </form>
        <div class="text-center">
          <div class="saprator my-4"><span>OR</span></div>
          <!-- <button class="btn text-white bg-facebook mb-2 mr-2  wid-40 px-0 hei-40 rounded-circle"><i class="fab fa-facebook-f"></i></button>
          <button class="btn text-white bg-googleplus mb-2 mr-2 wid-40 px-0 hei-40 rounded-circle"><i class="fab fa-google-plus-g"></i></button>
          <button class="btn text-white bg-twitter mb-2  wid-40 px-0 hei-40 rounded-circle"><i class="fab fa-twitter"></i></button> -->
          <p class="mb-2 mt-4 text-muted">Forgot password? <a href="auth-reset-password-img-side.html" class="f-w-400">Reset</a></p>
          <p class="mb-0 text-muted">I already have a membership <a href="{{ url('login') }}" class="f-w-400">Signin</a></p>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- [ signin-img ] end -->

<!-- Required Js -->
<script src="{{ asset('assets/js/vendor-all.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/js/ripple.js') }}"></script>
<script src="{{ asset('assets/js/pcoded.min.js') }}"></script>



</body>

</html>