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
                {{$page}}
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{url('corpemt/engagement/manage')}}"><i class="fa fa-paperclip"></i> Engagement</a></li>
                <li class="active">{{$page}}</li>
            </ol>
        </section>


        <!-- Main content -->
        <section class="content">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-sm-12">
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                </div>
                <div class="col-sm-12">
                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif
                </div>
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
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="box">
                        <div class="box-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    @if($list_deals->isEmpty())
                                        <p>No Engagements yet</p>
                                    @else
                                        <?php $sn = 0;?>
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Deal Name</th>
                                            <th>Amount</th>
                                            <th>Date Created</th>
                                            <th>Month</th>
                                            <th>Year</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($list_deals as $deal)
                                            @if($deal->deal_stage == 'won')
                                                <?php $sn += 1;?>
                                                <tr>
                                                    <td>{{$sn}}.</td>
                                                    <td>
                                                        <b><a href="{{url('corpemt/engagement/manage/'.base64_encode($deal->id.'+'.$deal->client_id).'')}}">{{$deal->deal_name}}</a></b>
                                                    </td>
                                                    <td>${{number_format($deal->amount, 2, '.', ',')}}</td>
                                                    <td>{{date('D, M d Y', strtotime($deal->date_created))}}</td>
                                                    <td>{{date("F", mktime(null, null, null, $deal->month, 1))}}</td>
                                                    <td>{{$deal->year}}</td>
                                                </tr>
                                            @endif
                                        @endforeach
                                        </tbody>
                                    @endif
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--prospect task ends here-->

        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    @include('includes.Footer')
</div>
<!-- ./wrapper -->

<!-- jQuery 2.1.4 -->
<script src="{{ asset('adminLTE/plugins/jQuery/jQuery-2.1.4.min.js') }}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
    $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.5 -->
<script src="{{asset('adminLTE/bootstrap/js/bootstrap.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('adminLTE/dist/js/app.min.js')}}"></script>
</body>
@include('CorpEMT.layout.includes.footer')