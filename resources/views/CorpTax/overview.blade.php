@extends('CorpTax.layout.master')

@section('title')
<title>CorpTAX | Dashboard</title>
@endsection


@section('content')
<div class="row">
    <div class="col-lg-12 col-md-12">
        <!-- page statustic card start -->
        <div class="row">
            <div class="col-sm-3">
                <div class="card">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h4 class="text-c-yellow">$0</h4>
                                <h6 class="text-muted m-b-0">Transaction Partners</h6>
                            </div>
                            <div class="col-4 text-right">
                                <i class="feather icon-bar-chart-2 f-28"></i>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-c-yellow">
                        <div class="row align-items-center">
                            <div class="col-9">
                                <p class="text-white m-b-0">% change</p>
                            </div>
                            <div class="col-3 text-right">
                                <i class="feather icon-trending-up text-white f-16"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="card">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h4 class="text-c-green">$0</h4>
                                <h6 class="text-muted m-b-0">Products/Services</h6>
                            </div>
                            <div class="col-4 text-right">
                                <i class="feather icon-file-text f-28"></i>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-c-green">
                        <div class="row align-items-center">
                            <div class="col-9">
                                <p class="text-white m-b-0">% change</p>
                            </div>
                            <div class="col-3 text-right">
                                <i class="feather icon-trending-up text-white f-16"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="card">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h4 class="text-c-red">$0</h4>
                                <h6 class="text-muted m-b-0">Transaction Type</h6>
                            </div>
                            <div class="col-4 text-right">
                                <i class="feather icon-calendar f-28"></i>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-c-red">
                        <div class="row align-items-center">
                            <div class="col-9">
                                <p class="text-white m-b-0">% change</p>
                            </div>
                            <div class="col-3 text-right">
                                <i class="feather icon-trending-down text-white f-16"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="card">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h4 class="text-c-blue">$00</h4>
                                <h6 class="text-muted m-b-0">Net Asset</h6>
                            </div>
                            <div class="col-4 text-right">
                                <i class="feather icon-thumbs-down f-28"></i>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-c-blue">
                        <div class="row align-items-center">
                            <div class="col-9">
                                <p class="text-white m-b-0">% change</p>
                            </div>
                            <div class="col-3 text-right">
                                <i class="feather icon-trending-down text-white f-16"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- page statustic card end -->
    </div>

    <!-- seo end -->

    <!-- Latest Customers start -->
    <div class="col-lg-12 col-md-12">
        <div class="row">
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="mb-3">Total Assets</h5>
                        <h2>2789<span class="text-muted m-l-5 f-14">kw</span></h2>
                        <div id="power-card-chart1"></div>
                        <div class="row">
                            <div class="col col-auto">
                                <div class="map-area">
                                    <h6 class="m-0">2876 <span> kw</span></h6>
                                    <p class="text-muted m-0">month</p>
                                </div>
                            </div>
                            <div class="col col-auto">
                                <div class="map-area">
                                    <h6 class="m-0">234 <span> kw</span></h6>
                                    <p class="text-muted m-0">Today</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="mb-3">Total Liablilty</h5>
                        <h2>7.3<span class="text-muted m-l-10 f-14">deg</span></h2>
                        <div id="power-card-chart3"></div>
                        <div class="row">
                            <div class="col col-auto">
                                <div class="map-area">
                                    <h6 class="m-0">4.5 <span> deg</span></h6>
                                    <p class="text-muted m-0">month</p>
                                </div>
                            </div>
                            <div class="col col-auto">
                                <div class="map-area">
                                    <h6 class="m-0">0.5 <span> deg</span></h6>

                                    <p class="text-muted m-0">Today</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection