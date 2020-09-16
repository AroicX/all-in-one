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
        <li class="active">Users</li>
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

          @if (@$feedback === TRUE)
            <div class="alert alert-success">
              <p>User successfully registered</p>
            </div>
          @endif

          @if (@$feedback === FALSE)
            <div class="alert alert-danger">
              <p>An internal error occured, user could not be registered</p>
            </div>
          @endif

          @if (@$feedback == 'exist')
            <div class="alert alert-danger">
                <p> User already exist</p>
            </div>
          @endif
        </div>
      </div>

      <div class="row">
        <div class="col-sm-12">
          <div class="panel panel-default">
            <div class="panel-body">
              <form method="POST" action="{{ url('corpemt/users') }}" class="form-horizontal">
              <input type="hidden" name="_token" value="{{ csrf_token() }}">
                  <div class="form-group">
                    <div class="row">
                      <div class="col-sm-4">
                        <label class="col-sm-12">Full Name</label>
                        <div class="col-sm-12">
                          <input type="text" name="fullname" placeholder="Firstname Lastname" class="form-control">
                        </div>
                      </div>
                      <div class="col-sm-4">
                        <label class="col-sm-12">Email</label>
                        <div class="col-sm-12">
                          <input type="email" name="email" class="form-control" placeholder="Enter Email">
                        </div>
                      </div>
                      <div class="col-sm-4">
                        <label class="col-sm-12">Password</label>
                        <div class="col-sm-12">
                          <input type="password" name="password" class="form-control" placeholder="Enter Password">
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="row">
                      <div class="col-sm-6">
                        <label class="col-sm-12">Company</label>
                        <div class="col-sm-12">
                          <select name="company" class="form-control">
                            <option value="">--SELECT--</option>
                            @foreach(@$list_company as $company)
                              <option value="{{ $company->id }}">{{ $company->name }} </option>
                            @endforeach
                          </select>
                        </div>
                      </div>
                      <div class="col-sm-6">
                        <label class="col-sm-12">User Role</label>
                        <div class="col-sm-12">
                          <select name="user_role" class="form-control">
                            <option value="">--SELECT--</option>
                            @foreach(@$list_roles as $role)
                              <option value="{{ $role->id }}">{{ $role->roles }} </option>
                            @endforeach
                          </select>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-sm-12">
                      <button type="submit" class="btn btn-success btn-flat">Save User</button>
                    </div>
                  </div>
              </form>
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-sm-12">
          <div class="panel panel-default">
            <div class="panel-body">
              <table class="table table-striped table-bordered">
                <thead>
                  <tr>
                    <th>&nbsp;</th>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Password</th>
                  </tr>
                </thead>
                <tbody>
                @foreach (@$list_users as $users)
                  <tr>
                    <td><input type="checkbox" name="userid[]" value="{{ $users->id }}"></td>
                    <td>{{ $users->name }}</td>
                    <td>{{ $users->email }}</td>
                    <td>{{ $users->password }}</td>
                  </tr>
                @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
    @include('includes.Footer') 
@include('includes.Sidebar')
</div>
<!-- ./wrapper -->
 @include('includes.Includes')
</body>
</html>



