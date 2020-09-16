@extends('CorpTax.layout.master')


@section('content')

<div class="row">

    <div class="col-lg-12">
        {{-- <h5 class="mb-3 mt-4">Wizard vertical</h5> --}}
        <div class="bt-wizard" id="verticalwizard">
            <div class="row align-items-stratched mb-4">
                <div class="col-12 col-md-auto col-sm-12">
                    <div class="card h-100 mb-0">
                        <div class="card-body">
                            <ul class="nav flex-column nav-pills" role="tablist" aria-orientation="vertical">
                                <li class="nav-item"><a href="#v-tabs-t-tab1" class="nav-link has-ripple active"
                                        data-toggle="tab">Sale of Transactions<span class="ripple ripple-animate"
                                            style="height: 84.9531px; width: 84.9531px; animation-duration: 0.7s; animation-timing-function: linear; background: rgb(70, 128, 255); opacity: 0.4; top: -16.4688px; left: 22.7031px;"></span></a>
                                </li>
                                <li class="nav-item"><a href="#v-tabs-t-tab2" class="nav-link has-ripple"
                                        data-toggle="tab">Purchase of Transactions<span class="ripple ripple-animate"
                                            style="height: 84.9531px; width: 84.9531px; animation-duration: 0.7s; animation-timing-function: linear; background: rgb(70, 128, 255); opacity: 0.4; top: -31.4688px; left: 22.7031px;"></span></a>
                                </li>

                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="tab-content card mb-0" id="v-pills-tabContent">
                        <div class="tab-pane card-body show active" id="v-tabs-t-tab1">
                            <h5 class="mb-3 mt-4">Sale of Transactions</h5>

                            <form id="form" action="{{route('logSalesTransaction')}}" method="post">
                                <div class="row">
                                    <div class="form-group col-sm-6">
                                        <label for="name_of_product">Name of Product:</label>
                                        <input type="text" name="name_of_product" class="form-control"
                                            required="required">
                                    </div>

                                    <div class="form-group col-sm-6">
                                        <label for="price">Price :</label>
                                        <input type="text" id="price" name="price" class="form-control"
                                            required="required">
                                    </div>

                                    <div class="form-group col-sm-12">
                                        <label>Vatable?</label>
                                        <label class="radio-inline">
                                            <input type="radio" name="vatable" class="vatable" value="1" checked>Yes
                                        </label>
                                        <label class="radio-inline">
                                            <input type="radio" name="vatable" class="vatable" value="0">No
                                        </label>
                                    </div>


                                    <div class="form-group col-sm-6">
                                        <label>Select VAT Options</label>
                                        <select id="vat_options" name="vat_options" class="form-control">
                                            <option value="">Choose</option>
                                            <option value="inc">VAT Inclusive</option>
                                            <option value="exc">VAT Exclusive</option>
                                        </select>
                                    </div>

                                    <div class="form-group col-sm-6">
                                        <label for="gross_amount">Gross amount :</label>
                                        <input type="text" readonly="" id="gross_amount" name="gross_amount"
                                            class="form-control" required="required">
                                    </div>

                                    <div class="form-group col-sm-6">
                                        <label for="net_amount">Net amount :</label>
                                        <input type="text" readonly="" id="net_amount" name="net_amount"
                                            class="form-control" required="required">
                                    </div>

                                    <div class="form-group col-sm-6">
                                        <label for="vat_amount1">VAT amount :</label>
                                        <input type="text" id="vat_amount" readonly="" name="vat_amount"
                                            class="form-control" required="required">
                                    </div>

                                    <div class="form-group col-sm-6">
                                        <label for="date">Date :</label>
                                        <input type="date" name="date" class="form-control" required="required">
                                    </div>

                                </div>

                                <div class="form-group col-sm-12">
                                    <button type="submit" class="btn btn-primary has-ripple">Submit</button>
                                </div>

                            </form>
                        </div>
                        <div class="tab-pane card-body" id="v-tabs-t-tab2">
                            <form id="form1" action="{{route('logPurchaseTransaction')}}"
                                method="post">
                                <h5 class="mb-3 mt-4">Purchase of Transactions</h5>

                                <div class="row">
                                    <div class="form-group col-sm-6">
                                        <label for="name_of_product">Name of Product:</label>
                                        <input type="text" id="name_of_product1" name="name_of_product"
                                            class="form-control" required="required">
                                    </div>

                                    <div class="form-group col-sm-6">
                                        <label for="price">Price :</label>
                                        <input type="text" id="price1" name="price" class="form-control"
                                            required="required">
                                    </div>

                                    <div class="form-group col-sm-12">
                                        <label>Vatable?</label>
                                        <label class="radio-inline">
                                            <input type="radio" name="vatable" class="vatable1" value="1" checked>Yes
                                        </label>
                                        <label class="radio-inline">
                                            <input type="radio" name="vatable" class="vatable1" value="0">No
                                        </label>
                                    </div>


                                    <div class="form-group col-sm-6">
                                        <label>Select VAT Options</label>
                                        <select id="vat_options1" name="vat_options" class="form-control">
                                            <option value="">Choose</option>
                                            <option value="inc">VAT Inclusive</option>
                                            <option value="exc">VAT Exclusive</option>
                                        </select>
                                    </div>

                                    <div class="form-group col-sm-6">
                                        <label for="gross_amount">Gross amount :</label>
                                        <input type="text" readonly="" id="gross_amount1" name="gross_amount"
                                            class="form-control" required="required">
                                    </div>

                                    <div class="form-group col-sm-6">
                                        <label for="net_amount">Net amount :</label>
                                        <input type="text" readonly="" id="net_amount1" name="net_amount"
                                            class="form-control" required="required">
                                    </div>

                                    <div class="form-group col-sm-6">
                                        <label for="vat_amount1">VAT amount :</label>
                                        <input type="text" id="vat_amount1" readonly="" name="vat_amount"
                                            class="form-control" required="required">
                                    </div>


                                    <div class="form-group col-sm-6">
                                        <label for="date">Date :</label>
                                        <input type="date" name="date" class="form-control" required="required">
                                    </div>

                                </div>

                                <div class="form-group col-sm-12">
                                    <button type="submit" class="btn btn-primary has-ripple">Submit</button>

                                </div>

                            </form>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- [ form-element ] end -->
</div>


@stop

@section('js')
<script type="text/javascript">
    $(document).ready(function () {
        // alert('hey')
        var net_amount = 0;
        var price = 0;
        var vat_option = null;
        var gross_amount = 0;
        var vat = 0;


        $('#price').change(function () {

            price = $(this).val() == '' ? 0 : $(this).val();

            console.log(price);
        });

        $('#price1').change(function () {
            price = $(this).val() == '' ? 0 : $(this).val();
        });

        $('#vat_options').change(function () {
            vat_option = $(this).val();
        });

        $('#vat_options1').change(function () {
            vat_option = $(this).val();
        });

        $('#form').change(function () {

            if ($('.vatable:checked').val() == '1') {
                $('#vatBlock').show();

                if (vat_option == 'inc') {
                    vat = parseFloat(price * (5 / 105));
                    net_amount = price - vat;
                    gross_amount = price;
                    $('#net_amount').val(net_amount);
                    $('#gross_amount').val(gross_amount);
                    $('#vat_amount').val(vat);
                    // alert(vat);
                }

                if (vat_option == 'exc') {
                    net_amount = price;
                    vat = price * (5 / 100);
                    gross_amount = parseFloat(vat) + parseFloat(net_amount);
                    $('#net_amount').val(net_amount);
                    $('#gross_amount').val(gross_amount);
                    $('#vat_amount').val(vat);
                }
            } else {
                $('#vatBlock').hide();
                $('#net_amount').val(null);
                $('#gross_amount').val(null);
                $('#vat_amount').val(null);
            }

        });

        $('#form1').change(function () {

            if ($('.vatable1:checked').val() == '1') {
                $('#vatBlock1').show();

                if (vat_option == 'inc') {
                    vat = parseFloat(price * (5 / 105));
                    net_amount = price - vat;
                    gross_amount = price;
                    $('#net_amount1').val(net_amount);
                    $('#gross_amount1').val(gross_amount);
                    $('#vat_amount1').val(vat);
                }

                if (vat_option == 'exc') {
                    net_amount = price;
                    vat = price * (5 / 100);
                    gross_amount = parseFloat(vat) + parseFloat(net_amount);
                    $('#net_amount1').val(net_amount);
                    $('#gross_amount1').val(gross_amount);
                    $('#vat_amount1').val(vat);
                }
            } else {
                $('#vatBlock1').hide();
                $('#vatBlock').hide();
                $('#net_amount').val(null);
                $('#gross_amount').val(null);
                $('#vat_amount').val(null);
            }


        });
    });
</script>
@stop