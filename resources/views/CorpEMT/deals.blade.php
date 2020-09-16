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
                <li><a href="{{url('corpemt/deals')}}"><i class="ion ion-bag"></i> Deals</a></li>
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
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    @if($list_deals->isEmpty())
                                        <p>No deals made yet</p>
                                    @else
                                        <?php $sn = 0;?>
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Contact Name</th>
                                            <th>Deal Name</th>
                                            <th>Deal Owner</th>
                                            <th>Amount</th>
                                            <th>Date Created</th>
                                            <th>Expected Close Date</th>
                                            <th>Deal Stage</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($list_deals as $deal)
                                            <?php $sn += 1;?>
                                            <tr>
                                                <td>{{$sn}}.</td>
                                                <td><b><a href="{{url('corpemt/client/view/'.$deal->unique_id.'')}}"
                                                          title="Click to view">{{$deal->client_company}}</a></b></td>
                                                <td>{{$deal->deal_name}}</td>
                                                <td>{{$deal->name}}</td>
                                                <td>${{number_format($deal->amount, 2, '.', ',')}}</td>
                                                <td>{{date('D, M d Y', strtotime($deal->date_created))}}</td>
                                                <td>{{date('D, M d Y', strtotime($deal->expected_close_date))}}</td>
                                                <td>
                                                    <b>
                                                        @if($deal->deal_stage == '10')
                                                            Qualification Stage - {{ucfirst($deal->deal_stage)}}%
                                                        @elseif($deal->deal_stage == '25')
                                                            Pedning Stage - {{ucfirst($deal->deal_stage)}}%
                                                        @elseif($deal->deal_stage == '50')
                                                            Decision Stage - {{ucfirst($deal->deal_stage)}}%
                                                        @elseif($deal->deal_stage == '75')
                                                            Processing Stage - {{ucfirst($deal->deal_stage)}}%
                                                        @elseif($deal->deal_stage == '90')
                                                            Negotiation Stage - {{ucfirst($deal->deal_stage)}}%
                                                        @elseif($deal->deal_stage == 'won')
                                                            <span class="text-success"><i
                                                                        class="fa fa-check"></i> {{ucfirst($deal->deal_stage)}}</span>
                                                        @else
                                                            <span class="text-danger"><b><i
                                                                            class="fa fa-times"></i> {{ucfirst($deal->deal_stage)}}</b></span>
                                                        @endif
                                                    </b>
                                                </td>
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