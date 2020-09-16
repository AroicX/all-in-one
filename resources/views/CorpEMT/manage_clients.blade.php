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
        <li><a href="#"><i class="fa fa-users"></i> Home</a></li>
        <li class="active">{{$page}}</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-sm-12">
          <div class="box">
            <div class="box-body">
              @if($clients->isEmpty())
              <p>No yet to add clients</p>
              @else
                <table class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Client</th>
                      <th>Option</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php $sn=0; ?>
                  @foreach($clients as $client)
                    <?php $sn+=1;?>
                    <tr>
                      <td>{{$sn}}.</td>
                      <td><b>{{$client->client_company}}</b> - <span class="text-muted">{{$client->name}}</span></td>
                      <td><a class="btn btn-xs btn-primary" href="{{url('corpemt/client/view/'.$client->unique_id.'')}}"><i class="fa fa-user"></i> View Details</a></td>
                    </tr>
                  @endforeach
                  </tbody>
                </table>
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

