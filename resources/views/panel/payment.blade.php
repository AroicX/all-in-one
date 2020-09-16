<!DOCTYPE html>
<html>
<title>CorpERM | Subscription</title>
@include('includes.Head')
<meta id="token" name="token" content="{ { csrf_token() } }">
<body class="hold-transition skin-blue sidebar-mini">
<!-- <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.13.1/jquery.validate.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.payment/1.2.3/jquery.payment.min.js"></script> -->

<div class="wrapper">

@include('includes.Header')
@include('includes.Menu')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">


    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Subscription
            <small>CorpERM</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li href="javascript:void(0)" class="">Subscription</li>
            <li href="javascript:void(0)" class="active">Payment</li>
        </ol>
    </section>


@include('includes.status')
<!-- Main content -->
    <style type="text/css">
        /* CSS for Credit Card Payment form */
        .credit-card-box .panel-title {
            display: inline;
            font-weight: bold;
        }

        .credit-card-box .form-control.error {
            border-color: red;
            outline: 0;
            box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075), 0 0 8px rgba(255, 0, 0, 0.6);
        }

        .credit-card-box label.error {
            font-weight: bold;
            color: red;
            padding: 2px 8px;
            margin-top: 2px;
        }

        .credit-card-box .payment-errors {
            font-weight: bold;
            color: red;
            padding: 2px 8px;
            margin-top: 2px;
        }

        .credit-card-box label {
            display: block;
        }

        /* The old "center div vertically" hack */
        .credit-card-box .display-table {
            display: table;
        }

        .credit-card-box .display-tr {
            display: table-row;
        }

        .credit-card-box .display-td {
            display: table-cell;
            vertical-align: middle;
            width: 100%;
        }

        /* Just looks nicer */
        .credit-card-box .panel-heading img {
            min-width: 180px;
        }
    </style>

    <section class="content" style="background:#fff !important;" id="blockUI">


        <div class="card-box card-tabs">

            <ul class="nav nav-tabs">
                <li class="active">
                    <a href="#modules" data-toggle="tab" aria-expanded="true">Payment</a>
                </li>
            </ul>

            <div class=" payment">

                <div class="form-group" style="">
                    <br>
                    <h1 style="text-align:center; font-size:25px;">ORDER SUMMARY</h1>
                    <br>

                    @foreach($tranx as $det)

                        <div class="col-md-12" style="padding:10px;">
                            <div class="col-sm-6" style="text-align: center;">
                                <label for="sub-total"><b>Sub Total:</b>{{ $det->amount }}<span class="subtotal" id="subtotal"></span></label>
                            </div>

                            <div class="col-sm-6" style="text-align: center;">
                                <label for="plan_no"><b>No Of plans:</b>{{ $det->no_plan }}<span class="plan_no" id="plan_no"></span></label>
                            </div>
                        </div>

                    @endforeach

                    <hr>
                    <!-- CREDIT CARD FORM STARTS HERE -->
                    <div class="panel panel-default credit-card-box">
                        <div class="panel-heading display-table">
                            <div class="row display-tr">
                                <h3 class="panel-title display-td">Card Details</h3>
                                <div class="display-td">
                                    <img class="img-responsive pull-right"
                                         src="http://i76.imgup.net/accepted_c22e0.png">
                                </div>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="card-wrapper"></div>


                            <form role="form" id="payment-form" method="POST" action="{{url('subscription/paynow')}}">

                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" name="url" id="url" value="{{url('')}}">

                                @foreach($tranx as $det)

                                    <input type="hidden" name="amount" value="{{ $det->amount }}">
                                    <input type="hidden" name="narration" value="{{ $det->narration }}">
                                    <input type="hidden" name="refx_code" value="{{ $det->refx_code }}">

                                @endforeach

                                <div class="row">
                                    <div class="col-xs-12 col-md-12">
                                        <div class="form-group">
                                            <label for="cardNumber">CARD Holder's FullName</label>
                                            <input class="form-control" type="text" name="name" id="name"
                                                   placeholder="Enter card name" autocomplete="cc-number"
                                                   required autofocus/>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-xs-7 col-md-7">
                                        <div class="form-group">
                                            <label for="cardNumber">CARD NUMBER</label>
                                            <div class="input-group">
                                                <input type="tel" class="form-control" name="number" id="number"
                                                       placeholder="Valid Card Number" autocomplete="cc-number"
                                                       required autofocus/>
                                                <span class="input-group-addon"><i
                                                            class="fa fa-credit-card"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-5 col-md-5 pull-right">
                                        <div class="form-group">
                                            <label for="cardCVC">Card PIN</label>
                                            <input type="password" class="form-control" name="pin" id="pin"
                                                   placeholder="Card Pin" autocomplete="cc-csc" required/>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-xs-7 col-md-7">
                                        <div class="form-group">
                                            <label for="cardExpiry"><span class="hidden-xs">EXPIRATION</span><span
                                                        class="visible-xs-inline">EXP</span> DATE</label>
                                            <input type="tel" class="form-control" name="expiry" id="expiry"
                                                   placeholder="Expiry Date" autocomplete="cc-exp" required/>
                                        </div>
                                    </div>
                                    <div class="col-xs-5 col-md-5 pull-right">
                                        <div class="form-group">
                                            <label for="cardCVC">CV CODE</label>
                                            <input type="number" class="form-control" name="cvc" placeholder="CVC"
                                                   autocomplete="cc-csc" required/>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-xs-12">
                                        <button type="submit"
                                                class="subscribe btn btn-primary btn-lg btn-block pay_btn"
                                                id="pay_btn">
                                            PAY NOW
                                        </button>
                                    </div>
                                </div>

                                <div class="row" style="display:none;">
                                    <div class="col-xs-12">
                                        <p class="payment-errors"></p>
                                    </div>
                                </div>


                            </form>
                        </div>
                    </div>
                    <!-- CREDIT CARD FORM ENDS HERE -->

                </div>

            </div>

        </div>


    </section>


</div>

<!-- /.content -->
</div>
<!-- /.content-wrapper -->
<script src="{{asset('creditcard/dist/card.js')}}"></script>
<script src="{{asset('creditcard/initcard.js')}}"></script>
@include('includes.Footer')
@include('includes.Sidebar')
</div>

<!-- ./wrapper -->
@include('includes.Includes')
<script src="{{asset('js/flutterwave/flutterwave.js')}}"></script>
</body>
</html>
