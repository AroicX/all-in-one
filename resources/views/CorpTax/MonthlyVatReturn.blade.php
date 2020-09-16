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
                    <h5>Monthly VAT Return</h5>
                </div>
                <div class="card-body">
                    <form id="form" action="{{url('corptax/monthlyvatreturnform')}}" method="post">
                        <div class="row">
                            <div class="form-group col-sm-6">
                                <label for="Tax_Period">Period:</label>
                                <input type="text" name="tax_period" class="form-control" required="required">
                            </div>

                            <div class="form-group col-sm-6">
                                <label for="start_of_month">Start of Period :</label>
                                <input type="date" name="start_of_month" class="form-control" required="required">
                            </div>

                            <div class="form-group col-sm-6">
                                <label for="end_of_month">End of Period :</label>
                                <input type="date" name="end_of_month" class="form-control" required="required">
                            </div>

                        </div>

                        <div class="row" style="margin-top: 70px;">
                            <div class="form-group col-sm-6">
                                <label for="sales_income">Sales/Income:</label>
                                <input type="text" id="sales_income" name="sales_income" class="form-control"
                                    required="required">
                            </div>

                            <div class="form-group col-sm-6">
                                <label for="exempted_supplies">Exempted supplies:</label>
                                <input type="text" id="exempted_supplies" name="exempted_supplies" class="form-control"
                                    required="required">
                            </div>

                            <div class="form-group col-sm-6">
                                <label for="total_subject_to_vat">Total supplies subject to VAT:</label>
                                <input type="text" id="total_subject_to_vat" readonly="" name="total_subject_to_vat"
                                    class="form-control" required="required">
                            </div>

                            <div class="form-group col-sm-6">
                                <label for="vat_charged_by_you">VAT Charged By You:</label>
                                <input type="text" id="vat_charged_by_you" readonly="" name="vat_charged_by_you"
                                    class="form-control" required="required">
                            </div>

                            <div class="form-group col-sm-6">
                                <label for="add_adjustments">Add adjustments:</label>
                                <input type="text" id="add_adjustments" name="add_adjustments" class="form-control"
                                    required="required">
                            </div>

                            <div class="form-group col-sm-6">
                                <label for="total_output_vat">Total Output VAT:</label>
                                <input type="text" id="total_output_vat" readonly name="total_output_vat"
                                    class="form-control" required="required">
                            </div>
                        </div>

                        <div class="row" style="margin-top: 70px;">

                            <div class="form-group col-sm-6">
                                <label for="vat_on_domestics">VAT on Domestic Supplies/Purchases for which invoicing
                                    requirement have been met:</label>
                                <input type="text" id="vat_on_domestics" name="vat_on_domestics" class="form-control"
                                    required="required">
                            </div>

                            <div class="form-group col-sm-6">
                                <label for="add_adjustment_two">Add Adjustment:</label>
                                <input type="text" id="add_adjustment_two" name="add_adjustment_two"
                                    class="form-control" required="required">
                            </div>

                            <div class="form-group col-sm-6">
                                <label for="vat_on_import">VAT on Import:</label>
                                <input type="text" id="vat_on_import" name="vat_on_import" class="form-control"
                                    required="required">
                            </div>

                            <div class="form-group col-sm-6">
                                <label for="total_vat_payable">Total VAT payable by you:</label>
                                <input type="text" id="total_vat_payable_by_you" readonly=""
                                    name="total_vat_payable_by_you" class="form-control" required="required">
                            </div>

                            <div class="form-group col-sm-6">
                                <label for="not_vatable_supplies_vat">VAT on purchases not wholly used in making vatable
                                    supplies:</label>
                                <input type="text" id="not_vatable_supplies_vat" name="not_vatable_supplies_vat"
                                    class="form-control" required="required">
                            </div>

                            <div class="form-group col-sm-6">
                                <label for="vat_taken_at_source">VAT Taken at Source:</label>
                                <input type="text" id="vat_taken_at_source" name="vat_taken_at_source"
                                    class="form-control" required="required">
                            </div>

                            <div class="form-group col-sm-6">
                                <label for="total_input_vat">Total deductions(input VAT):</label>
                                <input type="text" id="total_input_vat" readonly="" name="total_input_vat"
                                    class="form-control" required="required">
                            </div>

                            <div class="form-group col-sm-6">
                                <label for="amount_refundable">Amount payable/refundable:</label>
                                <input type="text" id="amount_refundable" readonly="" name="amount_refundable"
                                    class="form-control" required="required">
                            </div>

                        </div>

                        <div class="form-group col-sm-12">
                            <button type="submit" class="btn btn-primary has-ripple">Save</button>
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

        var sales_income = 0;
        var exempted_supplies = 0;
        var total_subject_to_vat = 0;
        var vat_charged_by_you = 0;
        var total_output_vat = 0;
        var add_adjustments = 0;
        var total_input_vat = 0;
        var amount_refundable = 0;
        var vat_on_domestics = 0;
        var add_adjustment_two = 0;
        var vat_on_import = 0;
        var total_vat_payable_by_you = 0;
        var not_vatable_supplies_vat = 0;
        var vat_taken_at_source = 0;

        $('#sales_income').change(function () {
            sales_income = parseFloat($(this).val());
        });

        $('#exempted_supplies').change(function () {
            exempted_supplies = $(this).val() == '' ? 0 : parseFloat($(this).val());
        });

        $('#add_adjustments').change(function () {
            add_adjustments = $(this).val() == '' ? 0 : parseFloat($(this).val());
        });

        $('#total_input_vat').change(function () {
            total_input_vat = $(this).val() == '' ? 0 : parseFloat($(this).val());
        });

        $('#vat_on_domestics').change(function () {
            vat_on_domestics = $(this).val() == '' ? 0 : parseFloat($(this).val());
        });

        $('#add_adjustment_two').change(function () {
            add_adjustment_two = $(this).val() == '' ? 0 : parseFloat($(this).val());
        });

        $('#vat_on_import').change(function () {
            vat_on_import = $(this).val() == '' ? 0 : parseFloat($(this).val());
        });

        $('#total_vat_payable_by_you').change(function () {
            total_vat_payable_by_you = $(this).val() == '' ? 0 : parseFloat($(this).val());
        });

        $('#not_vatable_supplies_vat').change(function () {
            not_vatable_supplies_vat = $(this).val() == '' ? 0 : parseFloat($(this).val());
        });

        $('#vat_taken_at_source').change(function () {
            vat_taken_at_source = $(this).val() == '' ? 0 : parseFloat($(this).val());
        });

        $('#form').change(function () {

            if (sales_income <= 0) {
                $('#total_subject_to_vat').val(0);
                $('#vat_charged_by_you').val(0);
                $('#total_output_vat').val(0);
                $('#amount_refundable').val(0);
            }

            total_subject_to_vat = sales_income - exempted_supplies;

            $('#total_subject_to_vat').val(total_subject_to_vat);

            vat_charged_by_you = (5 / 100) * total_subject_to_vat;

            $('#vat_charged_by_you').val(vat_charged_by_you);

            total_output_vat = vat_charged_by_you + add_adjustments;

            $('#total_output_vat').val(total_output_vat);

            amount_refundable = total_output_vat - total_input_vat;

            $('#amount_refundable').val(amount_refundable);

            total_vat_payable_by_you = vat_on_domestics + add_adjustment_two + vat_on_import;

            $('#total_vat_payable_by_you').val(total_vat_payable_by_you);

            total_input_vat = total_vat_payable_by_you - not_vatable_supplies_vat - vat_taken_at_source;

            $('#total_input_vat').val(total_input_vat);

        });

    });
</script>
@stop