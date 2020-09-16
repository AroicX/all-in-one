@include('layout.includes.header')
<title>CorpEMT | {{ $page }} </title>
@include('layout.includes.common_stylesheet')
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="#"><b>corp</b>EMT</a>
  </div>
  @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('alert'))
    <div class="alert alert-danger">
        {{ session('alert') }}
    </div>
    @endif

     @if (session('message'))
    <div class="alert alert-success">
        {{ session('message') }}
    </div>
    @endif
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">Login with your details</p>
    <form action="{{ url('/login') }}" method="post">
      <div class="form-group has-feedback">
        <input type="email" class="form-control" placeholder="Email" name="email">
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" class="form-control" placeholder="Password" name="password">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="row">
        <div class="col-xs-12">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
        </div>
        <!-- /.col -->
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
      </div>
    </form>
  </div>
  <!-- /.login-box-body -->
</div>

<script src="{{ asset('adminLTE/plugins/jQuery/jQuery-2.1.4.min.js') }}"></script>
<!-- Bootstrap 3.3.5 -->
<script src="{{asset('adminLTE/bootstrap/js/bootstrap.min.js')}}"></script>
<!-- AdminLTE App -->
</body>
@include('layout.includes.footer')