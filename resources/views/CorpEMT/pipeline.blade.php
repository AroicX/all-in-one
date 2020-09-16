@include('CorpEMT.layout.includes.header')
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
@include('CorpEMT.layout.includes.topheader')
<!-- Left side column. contains the logo and sidebar -->
@include('CorpEMT.layout.includes.menu')
<!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>Pipeline</h1>
            <ol class="breadcrumb">
                <li><a href="{{ route('emt.deal') }}"><i class="ion ion-bag"></i> Deal</a></li>
                <li class="active">Pipeline</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content" id="blockUI">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-sm-12">
                    <div class="box">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="dropdown">
                                        <button class="btn btn-default dropdown-toggle btn-sm" type="button" data-toggle="dropdown">Filter By <span class="caret"></span></button>
                                        <ul class="dropdown-menu">
                                            <li><a href="#">Status</a></li>
                                            <li><a href="#">Pending Deal</a></li>
                                            <li><a href="#">By Prospect</a></li>
                                            <li><a href="#">Tag</a></li>
                                        </ul>
                                    </div>
                                    <?php $current_month = date('m'); ?>
                                    <div class="filtering-date"> Month
                                        <select name="pipeline_month" id="pipeline_month">
                                            <option value="01" <?php echo $current_month == 1 ? 'selected' : ''; ?> >January</option>
                                            <option value="02" <?php echo $current_month == 2 ? 'selected' : ''; ?>>February</option>
                                            <option value="03" <?php echo $current_month == 3 ? 'selected' : ''; ?>>March</option>
                                            <option value="04" <?php echo $current_month == 4 ? 'selected' : ''; ?>>April</option>
                                            <option value="05" <?php echo $current_month == 5 ? 'selected' : ''; ?>>May</option>
                                            <option value="06" <?php echo $current_month == 6 ? 'selected' : ''; ?>>June</option>
                                            <option value="07" <?php echo $current_month == 7 ? 'selected' : ''; ?>>July</option>
                                            <option value="08" <?php echo $current_month == 8 ? 'selected' : ''; ?>>August</option>
                                            <option value="09" <?php echo $current_month == 9 ? 'selected' : ''; ?>>September</option>
                                            <option value="10" <?php echo $current_month == 10 ? 'selected' : ''; ?>>October</option>
                                            <option value="11" <?php echo $current_month == 11 ? 'selected' : ''; ?>>November</option>
                                            <option value="12" <?php echo $current_month == 12 ? 'selected' : ''; ?>>December</option>
                                        </select>

                                        Year
                                        <select name="pipeline_year" id="pipeline_year">
                                            <?php
                                            $current_year = date('Y');
                                            for ($i = 2010; $i <= 2050; ++$i){
                                                $checked = $current_year == $i ? 'selected': '';
                                                echo "<option value=\"{$i}\" $checked>$i</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="dropdown">
                                        <button class="btn btn-default dropdown-toggle btn-sm" type="button" data-toggle="dropdown">Filter By Date <span class="caret"></span></button>
                                        <ul class="dropdown-menu">
                                            <li>Date</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div>
                                        <h3>Deal stages funnel</h3>
                                        <ul class="pipeline-nav">
                                            <li><div class="percent10" data-percent="10"><span class="percentage">10%</span> <span>Qualification</span></div></li>
                                            <li><div class="percent25" data-percent="25"><span class="percentage">25%</span> <span>Pending</span></div></li>
                                            <li><div class="percent50" data-percent="50"><span class="percentage">50%</span> <span>Decision</span></div></li>
                                            <li><div class="percent75" data-percent="75"><span class="percentage">75%</span> <span>Processing</span></div></li>
                                            <li><div class="percent90" data-percent="90"><span class="percentage">90%</span> <span>Negotiation</span></div></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-md-8 col-md-offset-1">
                                    <div class="main-pipeline">
                                        <div class="row">
                                            <div class="col-sm-12 pipeline-heading">
                                                <div class="pipeline-type"><span id="type">10%</span> Deal</div>
                                                <span id="company_id">{{$company_id}}</span>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div id="pipeline-data">
                                                    <table class="table table-striped">
                                                        <tr>
                                                            <th>Total Month Deal( 10% )</th>
                                                            <td><span id="month_deal">{{ $stage_month_deal }}</span></td>
                                                        </tr>
                                                        <tr>
                                                            <th>Total Pending</th>
                                                            <td><span id="year_deal">{{ $stage_year_deal }}</span></td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="deal-summary">
                                        <h3>All pending deals</h3>
                                        <div class="table-responsive">
                                            <table class="table table-striped">
                                                <tr>
                                                    <th>Contact Name</th>
                                                    <th>Deal Name</th>
                                                    <th>Deal Owner</th>
                                                    <th>Amount</th>
                                                    <th>Deal Created</th>
                                                    <th>Exp. close date</th>
                                                    <th>Dale stage</th>
                                                </tr>
                                                <?php $pending_total = 0; $complete_total = 0; ?>
                                                @forelse($all_pending_deal as $deal)
                                                    <?php $owner = DB::table('emt_clients')->where('id', $deal->client_id)->value('name'); $pending_total += $deal->amount; ?>
                                                    <tr>
                                                        <td>Contact Name</td>
                                                        <td>{{ $deal->deal_name }}</td>
                                                        <td>{{ $owner }}</td>
                                                        <td>{{ $deal->amount }}</td>
                                                        <td>{{ $deal->date_created }}</td>
                                                        <td>{{ $deal->expected_close_date }}</td>
                                                        <td>{{ $deal->deal_stage }}{{ is_numeric($deal->deal_stage) ? '%' : '' }}</td>
                                                    </tr>
                                                @empty
                                                    <td colspan="7" style="text-align: center">No Pending Deal</td>
                                                @endforelse
                                            </table>
                                        </div>
                                        <p class="deal-summary-total"><strong>Total:</strong> <span id="deal-summary-total-pending">{{ $pending_total }}</span></p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <h3>Recently closed deals (Won or Lost)</h3>
                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            <tr>
                                                <th>Contact Name</th>
                                                <th>Deal Name</th>
                                                <th>Deal Owner</th>
                                                <th>Amount</th>
                                                <th>Deal Created</th>
                                                <th>Exp. close date</th>
                                                <th>Dale stage</th>
                                            </tr>
                                            @forelse($won_lost_month_deal as $winLostDeal)
                                                <?php $owner = DB::table('emt_clients')->where('id', $winLostDeal->client_id)->value('name'); $complete_total+= $winLostDeal->amount ?>
                                                <tr>
                                                    <td>Contact Name</td>
                                                    <td>{{$winLostDeal->deal_name}}</td>
                                                    <td> {{ $owner }}</td>
                                                    <td>{{ $winLostDeal->amount }}</td>
                                                    <td>{{ $winLostDeal->date_created }}</td>
                                                    <td>{{ $winLostDeal->expected_close_date }}</td>
                                                    <td>{{ $winLostDeal->deal_stage }}{{ is_numeric($winLostDeal->deal_stage) ? '%' : '' }}</td>
                                                </tr>
                                            @empty
                                                <td colspan="7" style="text-align: center">No Pending Deal</td>
                                            @endforelse
                                        </table>
                                    </div>
                                    <p class="deal-summary-total"><strong>Total:</strong> <span id="deal-summary-total-completed">{{ $complete_total }}</span></p>
                                </div>
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

<script>
    $(document).ready(function(){
        var type = $('.pipeline-heading #type'),
            month = $('#pipeline_month').val(),
            year = $('#pipeline_year').val(),
            month_span = $('#month_deal'),
            year_span = $('#year_deal'),
            company_id = $('#company_id').text();

        function populate_data(month, year, deal, company_id){
            var host = window.location.host;
            var url = "http://"+ host +"/corpemt/api/pipeline/get_deal_info/";
            url += month + '/';
            url += year + "/";
            url += deal + "/";
            url += company_id;

            App.blockUI({
                target: '#blockUI',
                boxed: true,
                textOnly: true,
                message: '<img src="../../img/spinner.gif" /> Just a moment...'
            });

            $.ajax({
                url: url,
                type: 'get',
                dataType: 'json',
                success: function (result) {
                    month_span.text(result.month_deal);
                    year_span.text(result.year_deal);

                    App.unblockUI('#blockUI');

                    type.text(deal+'%');
                }
            })
        }

        $('.pipeline-nav li div').click(function(){

            var deal_num = $(this).data('percent');

            populate_data(month, year, deal_num, company_id);

        })

        $('#pipeline_month').add('#pipeline_year').change(function(){
            month = $('#pipeline_month').val();
            year = $('#pipeline_year').val();
            deal = type.text().replace('%', '');

            populate_data(month, year, deal, company_id);
        })
    });
</script>
</body>
@include('CorpEMT.layout.includes.common_stylesheet')
<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
<title>CorpEMT | Pipeline</title>
<style>
    .pipeline-nav{
        list-style: none;
        padding: 0;
        margin: 0;
    }
    .pipeline-nav li{
        background-color: #cddbc8;
        margin-top: 10px;
        border-radius: 5px;
        color: #fff;
    }
    .pipeline-nav li div{
        cursor: pointer;
        background-color: #db1b56;
        border-radius: 5px;
        text-align: center;
        margin: 0px auto;
    }
    .pipeline-nav li span{
        display: block;
    }
    .pipeline-nav li .percentage{
        font-size: 21px;
        font-weight: bold;
        height: 25px;
    }
    .pipeline-nav li .percent10{
        width: 100%;
    }
    .pipeline-nav li .percent25{
        width: 85%;
    }
    .pipeline-nav li .percent50{
        width: 70%;
    }
    .pipeline-nav li .percent75{
        width: 50%;
    }
    .pipeline-nav li .percent90{
        min-width: 40%;
        width: 10%;
    }
    .pipeline-heading{
        text-align: center;
        font-size: 20px;
    }
    #company_id{
        display: none;
    }
</style>
</head>

</html>