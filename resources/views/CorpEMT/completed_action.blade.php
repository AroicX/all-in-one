@include('CorpEMT.layout.includes.header')
<title>CorpEMT | {{$page}}</title>
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
                {{ $page }}
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{url('corpemt/action_stream')}}"><i class="ion ion-bag"></i> Action Stream</a></li>
                <li class="active">{{ $page }}</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-sm-12">
                    <div class="box">
                        <div class="box-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    @if($actions->isEmpty())
                                        <p>No pending Action found!</p>
                                    @else
                                        <?php $sn = 0;?>
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <td></td>
                                            <th>Client</th>
                                            <th>Action Name</th>
                                            <th>Date</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($actions as $action)
                                            <?php
                                            $sn += 1;
                                            $client = DB::table('emt_clients')->select('name', 'unique_id')->where('id', $action->client_id)->first();
                                            ?>
                                            <tr>
                                                <td>{{$sn}}.</td>
                                                <td><input type="checkbox" name="actions[] " value="{{ $action->id }}"></td>
                                                <td><b><a href="{{ url('corpemt/client/view/'.$client->unique_id.'')}}"
                                                          title="Click to view">{{ $client->name }}</a></b></td>
                                                <td>{{$action->note}}</td>
                                                <td>{{date('M d Y', strtotime($action->schedule_date))}}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    @endif
                                </table>
                            </div>
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

