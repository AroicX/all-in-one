@extends('CorpTax.layout.master')
<title>CorpTAX | Accounts Movement</title>
@section('content')
<section class="content">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h5>WHT Movement</h5>
                </div>
                <div class="card-body">
                    <form action="" id="accountMovement">
                        <div class="box-body">
                            <div class="form-group ">
                                <label for="">Balance Brought forward</label>
                                <input name="balance_bf" type="text" class="form-control" id=""
                                    placeholder="Balance Brought forward">
                            </div>



                            <div class="form-group ">
                                <label for="">Start of period</label>
                                <input required name="period_start" type="text" class="form-control"
                                    data-provide="datepicker" id="start_period" placeholder="Start of period">
                            </div>

                            <div class="form-group  ">
                                <label for="">End of period</label>
                                <input required name="period-end" type="text" class="form-control"
                                    data-provide="datepicker" id="end_period" placeholder="End of period">
                            </div>

                            <div class="form-group">
                                <label for="">Payable for the period</label>
                                <input required name="payable_for_period" type="text" class="form-control"
                                    id="period_payable" placeholder="Payable for the period">
                            </div>

                            <div class="form-group">
                                <label for="">Payment for the period</label>
                                <input required name="payment_for_period" type="text" class="form-control" id=""
                                    placeholder="Payment for the period">
                            </div>

                            <div class="form-group ">
                                <label for="">Closing balance</label>
                                <input required name="closing_balance" type="text" class="form-control" id=""
                                    placeholder="Closing balance">
                            </div>

                        </div>

                        <div class="box-footer">
                            <button type="submit" id="saveMovement" class="btn btn-primary has-ripple">Save</button>
                            <button class="btn btn-danger" id="printMovement">Print</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection