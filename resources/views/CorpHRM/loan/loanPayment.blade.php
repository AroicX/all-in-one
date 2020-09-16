@extends('CorpHRM.layout.master')
<script src="https://js.paystack.co/v1/inline.js"></script>
@section('content')
<section class="content">
    <div class="row">
        @if(isset($success))
        <div class="alert alert-success">Successfully added</div>
        @endif
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header with-border">
                    <h5>Loan Repayment </h5>
                    <a href="{{url('corphrm/loanpayment')}}">
                        <button class="btn btn-primary btn-sm" style="float:right;">Return Back</button>
                    </a>

                </div>

                <div class="card-body">
                    <form class="row" action="{{route('corphrm.loanpaymentform')}}" method="post" id="payment_form"
                        onsubmit="return checkform()">
                        <div class="form-group col-sm-12 col-md-6">
                            <label for="transaction_id">Transaction id:</label>
                            <input type="text" name="transaction_id" value="{{ $transaction_id }}" readonly=""
                                class="form-control" required="required">
                        </div>

                        <!--                                 <div class="form-group col-sm-6">
                                    <label for="transaction_date">Transaction Date:</label>
                                    <input type="date" name="transaction_date" class="form-control" required="required">
                                </div> -->

                        <div class="form-group col-sm-12 col-md-6">
                            <label>Employee Name</label>
                            <input type="text" name="" value="{{ Auth::user()->name }}" class="form-control"
                                readonly="">
                        </div>

                        <div class="form-group col-sm-12 col-md-6">
                            <label>Loan Name</label>
                            <select name="loan_id" id="loan_id" class="form-control" required="">
                                <option value="">select one</option>
                                @foreach($loanDetails as $detail)
                                <option value="{{ $detail['id'] }}">{{ $detail['name'] }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-sm-12 col-md-6">
                            <label for="outstanding_balance">Outstanding Balance:</label>
                            <input type="text" name="outstanding_balance" id="outstanding_balance" class="form-control"
                                required="required" readonly="">
                        </div>

                        <div class="form-group col-sm-12 col-md-6">
                            <label for="payment_mode">Payment mode:</label>
                            <select name="payment_mode" id="payment_mode" class="form-control" required="">
                                <option value="custom">Custom</option>
                                <option value="installment">Installment</option>
                            </select>
                        </div>

                        <div class="form-group col-sm-12 col-md-6">
                            <label for="payment_type">Payment type:</label>
                            <select name="payment_type" id="payment_type" class="form-control" required="">
                                <option value="">Select one</option>
                                <option value="bank">Bank payment (teller)</option>
                                <option value="card">Card payment </option>
                                <option value="salary">Salary Deduction</option>
                            </select>
                        </div>

                        <div class="form-group col-sm-12 col-md-6">
                            <label for="amount_paid">Amount to be paid:</label>
                            <input type="text" name="amount_paid" id="amount_paid" class="form-control" required="">
                        </div>

                        <div class="form-group col-sm-12 col-md-6" id="bank_proof" style="display: none;">
                            <label for="amount_to_pay">Proof of payment (Image or Pdf):</label>
                            <input type="file" name="bank_proof" id="" class="form-control" required="">
                        </div>
                        <div class="form-group col-sm-12 col-md-12" id="paystackcard" style="display: none;">
                            <p style="text-align: center; color: orange;">Online payment...</p>
                            <div id="paystackEmbedContainer"></div>
                        </div>
                        <div class="form-group col-sm-12 col-md-12">
                            {{csrf_field()}}
                            <button type="submit" class="btn btn-primary btn-submit">Submit</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<script src="{{asset('calendar/js/jquery.min.js')}}"></script>
<script type="text/javascript">
    // function submitFunction() {
    //     document.getElementById("payment_form").submit();
    // }
    function checkform() {

        var condition = true;
        if ($("#amount_paid").val() > $("#outstanding_balance").val()) {
            alert("Amount being paid must not be greater than outstanding balance.");
            condition = false;
            return false;
        }
        if (condition) {
            condition = confirm('Do you want to proceed?');
        } else {
            return false;
        }
    }
    $("#loan_id").change(function (e) {
        //alert("oksy")
        var loan_id = $(this).val();
        $.ajax({
            type: "GET",
            url: "{{url('corphrm/get/outstanding_balance')}}/" + loan_id,
            // dataType: "html",
            success: function (data) {
                $("#outstanding_balance").val(data);
            }
        });

    });

    $("#payment_mode").change(function (e) {
        //alert("oksy")
        if ($(this).val() == "installment") {
            var loan_id = $("#loan_id").val();
            if (loan_id == null || loan_id == "") {
                alert("select loan name first!");
                $(this).val("custom");
                return false;
            }
            document.getElementById("amount_paid").readOnly = true;
            $.ajax({
                type: "GET",
                url: "{{url('corphrm/get/amount_to_be_paid')}}/" + loan_id,
                // dataType: "html",
                success: function (data) {

                    $("#amount_paid").val(data);
                }
            });
        } else {
            document.getElementById("amount_paid").readOnly = false;
            $("#amount_paid").val("");
        }
        return false;
    });

    $("#payment_type").change(function (e) {
        //alert("oksy")
        if ($("#amount_paid ").val() == "" || $("#amount_paid ").val() == null) {
            $("#payment_type ").val("");
            alert("Enter Amount to be Paid");
        }
        if ($(this).val() == "bank") {
            // alert("okay")
            $('#bank_proof').css({
                'display': 'block'
            });
        } else {
            $('#bank_proof').css({
                'display': 'none'
            });
        }

        if ($(this).val() == "card") {
            document.getElementById("amount_paid").readOnly = true;
            $('#paystackcard').css({
                'display': 'block'
            });
            PaystackPop.setup({
                key: 'pk_test_b74cea21b07452cf31f529f24c31caf444a22ca7',
                email: "<?php echo Auth::user()->email; ?>",
                amount: $("#amount_paid").val() * 100,
                container: 'paystackEmbedContainer',
                callback: function (response) {
                    document.getElementById("payment_form").submit();
                    //alert('successfully subscribed. transaction ref is ' + response.reference);
                },
            });
            $('.btn-submit').css({
                'display': 'none'
            });
        } else {
            if ($("#payment_mode").val() == "installment") {
                document.getElementById("amount_paid").readOnly = true;
            } else {
                document.getElementById("amount_paid").readOnly = false;
            }
            $('#paystackcard').css({
                'display': 'none'
            });
            $('.btn-submit').css({
                'display': 'block'
            });
        }

    });
</script>
@stop