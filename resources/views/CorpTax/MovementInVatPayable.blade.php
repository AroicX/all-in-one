@extends('CorpTax.layout.master')

@section('content')
<section class="content">
    <div class="row">
        @if(isset($success))
        <div class="alert alert-success">Successfully added</div>
        @endif

        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h5>Movement in VAT Payable</h5>
                </div>
                <div class="card-body">
                    <form id="form" action="{{url('/corptax/postMovementInVatPayable')}}" method="post">

                        <div class="form-group ">
                            <label for="start_date">Start Date:</label>
                            <input type="date" id="start_date" name="start_date" class="form-control"
                                required="required">
                        </div>

                        <div class="form-group ">
                            <label for="end_date">End Date:</label>
                            <input type="date" id="end_date" name="end_date" class="form-control" required="required">
                        </div>

                        <div class="form-group ">
                            <label for="balance">Balance:</label>
                        </div>

                        <div class="form-group ">
                            <input type="text" id="balance" name="balance" class="form-control" required="required">
                        </div>

                        <div class="form-group ">
                            <label for="vat_output">VAT Output:</label>
                        </div>

                        <div class="form-group ">
                            <input type="text" readonly="" id="vat_output" name="vat_output" class="form-control"
                                required="required">
                        </div>

                        <div class="form-group ">
                            <label for="vat_input">VAT Input:</label>
                        </div>

                        <div class="form-group ">
                            <input type="text" readonly="" name="vat_input" id="vat_input" class="form-control"
                                required="required">
                        </div>

                        <div class="form-group ">
                            <label for="less_payment">Less Payment:</label>
                        </div>

                        <div class="form-group ">
                            <input type="text" name="less_payment" id="less_payment" class="form-control"
                                required="required">
                        </div>

                        <div class="form-group ">
                            <label for="closing_balance">Closing Balance:</label>
                        </div>

                        <div class="form-group ">
                            <input type="text" name="closing_balance" readonly="" id="closing_balance"
                                class="form-control" required="required">
                        </div>

                        <div class="form-group col-sm-12">
                            <button type="submit" class="btn btn-primary has-ripple">Submit</button>
                        </div>

                    </form>

                </div>
            </div>
        </div>


    </div>
</section>
@stop

@section('js')
<script type='text/javascript'>
    $(document).ready(function () {

        var balance = 0;
        var vat_output = 0;
        var vat_input = 0;
        var less_payment = 0;
        var closing_balance = 0;

        $('#balance').change(function () {
            balance = $(this).val() == '' ? 0 : parseFloat($(this).val());
        });

        $('#less_payment').change(function () {
            less_payment = $(this).val() == '' ? 0 : parseFloat($(this).val());
        });

        $('#form').change(function () {


            if ($('#start_date').val() != '' && $('#end_date').val() != '') {

                var st_date = $('#start_date').val();
                var e_date = $('#end_date').val();

                $.ajax({
                    url: "postSalesTotalVatOutput",
                    type: "post",
                    data: {
                        start_date: st_date,
                        end_date: e_date
                    },
                    cache: false,

                    cache: false,
                    success: function (response) {
                        var d = JSON.parse(response);

                        if (d[0][0].vat_sum !== null) {
                            $('#vat_output').val(d[0][0].vat_sum);
                        } else {
                            $('#vat_output').val(0);
                        }

                        if (d[1][0].vat_sum !== null) {

                            $('#vat_input').val(d[1][0].vat_sum);
                        } else {
                            $('#vat_input').val(0);
                        }

                        vat_output = parseFloat($('#vat_output').val());

                        vat_input = parseFloat($('#vat_input').val());

                    },
                    error: function (xhr) {
                        alert('error occur');
                    }
                });
            }

            closing_balance = balance + vat_output - vat_input - less_payment;

            $('#closing_balance').val(closing_balance);
        });
    });
</script>
@stop