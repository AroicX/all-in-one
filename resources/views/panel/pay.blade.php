@include('includes.Head')
@include('includes.Header')

<body>
    <style>
        .demo-container {
            width: 100%;
            max-width: 350px;
            margin: 50px auto;
        }

        form {
            margin: 30px;
        }
        input {
            width: 200px;
            margin: 10px auto;
            display: block;
        }

    </style>

<!-- CREDIT CARD FORM STARTS HERE -->
            <div class="panel panel-default credit-card-box">
                <div class="panel-heading display-table" >
                    <div class="row display-tr" >
                        <h3 class="panel-title display-td" >Card Details</h3>
                        <div class="display-td" >                            
                            <img class="img-responsive pull-right" src="http://i76.imgup.net/accepted_c22e0.png">
                        </div>
                    </div>                    
                </div>
                <div class="panel-body">
                <div class="card-wrapper"></div>
<form role="form" id="payment-form" method="POST" action="{{url('subscription/pay')}}">
                        <div class="row">
                            <div class="col-xs-7 col-md-7">
                                <div class="form-group">
                                    <label for="cardNumber">CARD NUMBER</label>
                                    <div class="input-group">
<input type="tel" class="form-control" name="number" placeholder="Valid Card Number" autocomplete="cc-number"
 required autofocus/>
                                        <span class="input-group-addon"><i class="fa fa-credit-card"></i></span>
                                    </div>
                                </div>                            
                            </div>
                                                        <div class="col-xs-5 col-md-5 pull-right">
                                <div class="form-group">
                                    <label for="cardCVC">Card PIN</label>
<input type="tel" class="form-control" name="pin" placeholder="Card Pin" autocomplete="cc-csc" required/>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-7 col-md-7">
                                <div class="form-group">
                                    <label for="cardExpiry"><span class="hidden-xs">EXPIRATION</span><span class="visible-xs-inline">EXP</span> DATE</label>
<input type="tel" class="form-control" name="expiry" placeholder="Expiry Date" autocomplete="cc-exp" required />
                                </div>
                            </div>
                            <div class="col-xs-5 col-md-5 pull-right">
                                <div class="form-group">
                                    <label for="cardCVC">CV CODE</label>
    <input type="number" class="form-control" name="cvc" placeholder="CVC" autocomplete="cc-csc" required/>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
        <button type="submit" class="subscribe btn btn-primary btn-lg btn-block pay_btn" id="pay_btn">
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

   <script src="{{asset('creditcard/dist/card.js')}}"></script>
   <script src="{{asset('creditcard/initcard.js')}}"></script>
   @include('includes.Includes')
    @include('includes.Footer') 
@include('includes.Sidebar')
</body>