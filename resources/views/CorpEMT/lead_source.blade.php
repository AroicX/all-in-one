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
        {{$page}}
      </h1>
      <ol class="breadcrumb">
        <li class="active">{{$page}}</li>
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

          @if (session('success'))
            <div class="alert alert-success">
              <p>{{ session('success') }}</p>
            </div>
          @endif

          @if (session('error'))
            <div class="alert alert-danger">
              <p>{{ session('error') }}</p>
            </div>
          @endif
        </div>
      </div>

      <div class="row">
        <div class="col-sm-12">
          <div class="box">
            <div class="box-header with-border">
              <h5 class="box-title"> List of Lead Sources</h5>
              <span class="pull-right">
                <button class="btn btn-xs btn-primary" data-target="#add-leadsource" data-toggle="modal"><i class="fa fa-plus"></i> Add Lead Source</button>
              </span>
            </div>
            <div class="box-body">
              @if($sources->isEmpty())
                <p>Yet to add Lead Sources</p>
              @else
              <form method="post" action="{{url('corpemt/setting/delete')}}">
              <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <table class="table table-striped table-bordered">
                  <thead>
                    <tr>
                      <th><button class="btn btn-xs btn-danger btn-flat"><i class="fa fa-trash"></i> Delete</button></th>
                      <th>Items</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php $sn=0; ?>
                  @foreach ($sources as $source)
                    <?php $sn+=1;?>
                    <tr>
                      <td>{{$sn}}. <input type="checkbox" name="id[]" value="{{ $source->id }}"></td>
                      <td>{{ $source->title }}</td>
                    </tr>
                  @endforeach
                  </tbody>
              </table>
              </form>
              @endif
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
@include('CorpEMT.layout.modals.add_leadsource_modal')

