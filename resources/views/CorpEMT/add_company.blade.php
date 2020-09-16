@include('CorpEMT.layout.includes.header')
<title>CorpEMT | Dashboard</title>
@include('CorpEMT.layout.includes.common_stylesheet')
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
  @include('CorpEMT.layout.includes.topheader')
  <!-- Left side column. contains the logo and sidebar -->
  @include('CorpEMT.layout.includes.menu')
   <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Add User
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-users"></i> Home</a></li>
        <li class="active">Company</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-sm-12">
           @if (count($errors) > 0)
              <div class="alert alert-danger">
                  <ul>
                      @foreach ($errors->all() as $error)
                          <li>{{ $error }}</li>
                      @endforeach
                  </ul>
              </div>
          @endif

          @if (@$feedback == 'exist')
            <div class="alert alert-danger">
                <p>Company already exist</p>
            </div>
          @elseif (@$feedback === TRUE)
            <div class="alert alert-success">
              <p>Company successfully registered</p>
            </div>
          @elseif (@$feedback === FALSE)
            <div class="alert alert-danger">
              <p>An internal error occured, user could not be registered</p>
            </div>
          @endif
        </div>
      </div>

      <div class="row">
        <div class="col-sm-12">
          <div class="panel panel-default">
            <div class="panel-body">
              <form method="POST" action="{{ url('corpemt/company') }}" class="form-horizontal">
              <input type="hidden" name="_token" value="{{ csrf_token() }}">
                  <div class="form-group">
                     <div class="row">
                       <div class="col-sm-6">
                          <label class="col-sm-12">Company Name</label>
                          <div class="col-sm-12">
                            <input type="text" name="name" placeholder="Enter Company Tilte" class="form-control">
                          </div>
                       </div>
                       <div class="col-sm-6">
                          <label class="col-sm-12">Company Email</label>
                          <div class="col-sm-12">
                            <input type="text" name="email" placeholder="Enter Company Email" class="form-control">
                          </div>
                       </div>
                     </div>
                  </div>
                  <div class="form-group">
                    <div class="col-sm-12">
                      <button type="submit" class="btn btn-success btn-flat">Save Company</button>
                    </div>
                  </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
    @include('includes.Footer') 
@include('includes.Sidebar')
</div>
<!-- ./wrapper -->
 @include('includes.Includes')
</body>
</html>

