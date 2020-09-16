@extends('CorpFIN.layout.corpfin')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5>Add New Service</h5>
                <span class="d-block m-t-5">Service</span>
            </div>
            <div class="card-body table-border-style">
                <div class="col-md-12">
                    <!-- general form elements -->
                    <div class="box box-primary">
                        <!-- /.box-header -->
                        <!-- form start -->
                        <form role="form" id="add_service" method="post" action="{{ route('corpfin.service.add') }}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="company_id" value="{{$company->id}}">
{{--                            <input type="hidden" name="url" id="url" value="{{url('')}}">--}}
                            {{--todo: how to go about category--}}
                            {{--<input type="hidden" name="category" value="Product">--}}
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="product_name">Service Name</label>
                                    <input type="text" class="form-control" name="name" id="product_name"
                                           placeholder="Name of Service" required>
                                </div>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Measure</label>
                                            <select class="form-control" name="measure" id="measure" required>
                                                <option value="Quantity">Quantity</option>
                                                <option value="Unit">Unit</option>
                                                <option value="Hrs">Hrs</option>
                                                <option value="Miles">Miles</option>
                                                <option value="KM">KM</option>
                                                <option value="Inches">Inches</option>
                                                <option value="Kg">Kg</option>
                                                <option value="Mg">Mg</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Rate / Price</label>
                                            <select class="form-control" name="rp" id="RP" required>
                                                <option value="">Select Rate / Price</option>
                                                <option value="Rate">Rate</option>
                                                <option value="Price">Price</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Rate / Price per service</label>
                                            <div class="input-group">
                                                @foreach($currency as $c)
                                                    <span class="input-group-addon"
                                                          id="basic-addon1">{{ $c->p_currency }}</span>
                                                    <input type="number" class="form-control" name="price" min="0"
                                                           max="100000000.00" placeholder="0"
                                                           aria-describedby="basic-addon1" required>
                                                    <span class="input-group-addon"
                                                          id="basic-addon1"><strong>.</strong></span>
                                                    <input type="number" class="form-control" name="price2" min="0"
                                                           max="100000000.00" placeholder="00"
                                                           aria-describedby="basic-addon1" required>
                                                    <span class="input-group-addon"
                                                          id="basic-addon1">{{ $c->s_currency }}</span>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="taxes">Taxes</label>
                                            <select class="form-control" id="taxes" name="taxes" required>
                                                <option value="">Select Taxes Type</option>
                                                <option value="vat">VAT</option>
                                                <option value="wht">WHT</option>
                                                <option value="both">Both</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-6" id="wht_type_id" style="display:none;">
                                        <div class="form-group">
                                            <label for="wht_type">WHT Type</label>
                                            <select class="form-control" id="wht_id" name="wht_id">
                                                <option value="">Select WHT Type</option>
                                                {{--@foreach($company->whts as $wht)
                                                <option value="{{ $wht->id }}"
                                                        id="{{ $wht->id }}">
                                                     {{ $wht->type }}
                                                </option>
                                                @endforeach--}}
                                                <option value="">5</option>
                                                <option value="">10</option>
                                                <option value="">20</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-6" id="vat_type_id" style="display:none;">
                                        <div class="form-group">
                                            <label for="vat_type">VAT Type</label>
                                            <select class="form-control" name="vat_id" id="vat_id">
                                                <option value="">Select VAT Type</option>
                                                {{--@foreach($company->vats as $vat)
                                                    <option value="{{ $vat->type }}">{{ $vat->type }}</option>
                                                @endforeach--}}
                                                <option value="Inclusive">Inclusive</option>
                                                <option value="Exclusive">Exclusive</option>
                                            </select>
                                        </div>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-sm-6" id="c_init" style="display:none;">
                                        <div class="form-group">
                                            <label for="company">Company Percentage</label>
                                            <input type="text" name="company" class="form-control" readonly>
                                        </div>
                                    </div>
                                    <div class="col-sm-6" id="i_init" style="display:none;">
                                        <div class="form-group">
                                            <label for="individual">Individual Percentage</label>
                                            <input type="text" name="individual" class="form-control" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.box-body -->

                            <div class="box-footer">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>


                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="view_modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-md" style="">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i
                                class="fa fa-close"></i></button>
                    <center><h4 class="modal-title" style="color:#1d74b7;">Product</h4></center>
                </div>
                <form action="{{ route('corpfin.product.edit') }}" method="post"
                      enctype="multipart/form-data" name="form" id="form">
                    <input type="hidden" name="id" autocomplete="off" style="background:#ffffff;"
                           class="form-control" placeholder="" required>
                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="control-label">Product Name</label>
                                    <div class="append-icon">
                                        <input type="text" name="name" autocomplete="off"
                                               style="background:#ffffff;" class="form-control"
                                               placeholder="Enter Product Name" required>
                                        <i class="icon-user"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Measure</label>
                                    <select class="form-control" name="measure" id="measure"
                                            required>
                                        <option value="Quantity">Quantity</option>
                                        <option value="Unit">Unit</option>
                                        <option value="Hrs">Hrs</option>
                                        <option value="Miles">Miles</option>
                                        <option value="KM">KM</option>
                                        <option value="Inches">Inches</option>
                                        <option value="Kg">Kg</option>
                                        <option value="Mg">Mg</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Rate / Price</label>
                                    <select class="form-control" name="rp" id="RP" required>
                                        <option>Select Rate / Price</option>
                                        <option value="Rate">Rate</option>
                                        <option value="Price">Price</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="control-label">Price</label>
                                    <div class="option-group">
                                        <input type="text" class="form-control" autocomplete="off"
                                               name="price">
                                    </div>
                                </div>
                            </div>
                            <div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <center>
                                <button type="submit" class="btn btn-embossed btn-success"
                                        style="background:#1d74b7;">Update
                                </button>
                            </center>
                        </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $("#taxes").click(function (e) {
        console.log(e);
        var style = $('#taxes :selected').attr('value');
        var vat_type_id = document.getElementById('vat_type_id');
        var wht_type_id = document.getElementById('wht_type_id');
        if (style == "vat") {
            if (vat_type_id.style.display != 'block') {
                vat_type_id.style.display = 'block';
                wht_type_id.style.display = 'none';
                var c_init = document.getElementById('c_init');
                c_init.style.display = 'none';
                var i_init = document.getElementById('i_init');
                i_init.style.display = 'none';
                document.getElementById("vat_type_id").className = "col-sm-12";
            } else {
                vat_type_id.style.display = 'none';
            }
        } else if (style == "wht") {
            vat_type_id.style.display = 'none';
            wht_type_id.style.display = 'block';
            document.getElementById("wht_type_id").className = "col-sm-12";
        }
        else if (style == "both") {
            if (wht_type_id.style.display != 'block' && vat_type_id.style.display != 'block') {
                vat_type_id.style.display = 'block';
                wht_type_id.style.display = 'block';
                document.getElementById("wht_type_id").className = "col-sm-6";
                document.getElementById("vat_type_id").className = "col-sm-6";
            }
            else if (wht_type_id.style.display != 'block' || vat_type_id.style.display != 'block') {
                vat_type_id.style.display = 'block';
                wht_type_id.style.display = 'block';
                document.getElementById("wht_type_id").className = "col-sm-6";
                document.getElementById("vat_type_id").className = "col-sm-6";
            }
            else {
                wht_type_id.style.display = 'none';
                vat_type_id.style.display = 'none';
            }
        }
    });
</script>
<script type="text/javascript">
    $("#wht_type_id").click(function (e) {
//        console.log(e);
        var wt_id = $('#wht_type :selected').attr('id');
        $.ajax({
            type: "GET",
            url: "{{ route('list_wht') }}?id=" + wt_id,
            // dataType: "html",
            success: function (data) {
                wht_type_id.style.display = 'block';
                var c_init = document.getElementById('c_init');
                c_init.style.display = 'block';
                var i_init = document.getElementById('i_init');
                i_init.style.display = 'block';
                for (var key in data) {
                    $('[name="company"]').val(data[key].company);
                    $('[name="individual"]').val(data[key].individual);
                }
            }
        });
    });
</script>
<script type="text/javascript">
    $("input").keypress(function (event) {
        if (event.which == 13) {
            event.preventDefault();
            $("#add_service").submit();
        }
    });
    $('#add_service').submit(function (e) {
        e.preventDefault();
        url = $(this).attr('action');
        $('#empty').hide();
        $('#val_fail').hide();
        var u = $("#url").val();
        $('#fail').hide();
        if ($('[name|="product_name"]').val() == "" || $('[name|="measure"]  ').val() == "" || $('[name|="RP"]  ').val() == "" || $('[name|="price1"]  ').val() == "" || $('[name|="price2"]  ').val() == "") {
            $('#empty').show();
            return false;
        }
        ;
        // App.blockUI({
        //     target: '#blockUI',
        //     boxed: true,
        //     textOnly: true,
        //     message: '<img src="{{asset('img/spinner.gif')}}" /> Just a moment...'
        // });
        postData = $(this).serialize();
        $.ajax({
            url: url,
            type: 'post',
            data: postData,
            dataType: 'json',
            success: function (data) {
                if (data.result == 'success') {
                    window.location.href = '{{ route('corpfin.service.view') }}';
                    Command: toastr["success"]("Service added Successfully!")
                    toastr.options = {
                        "closeButton": false,
                        "debug": false,
                        "newestOnTop": false,
                        "progressBar": false,
                        "positionClass": "toast-top-right",
                        "preventDuplicates": false,
                        "onclick": null,
                        "showDuration": "300",
                        "hideDuration": "1000",
                        "timeOut": "5000",
                        "extendedTimeOut": "1000",
                        "showEasing": "swing",
                        "hideEasing": "linear",
                        "showMethod": "fadeIn",
                        "hideMethod": "fadeOut"
                    }
                    // alert("OKK");
                }
                if (data.result == 'val_fail') {
                    // App.unblockUI('#blockUI');
                    Command: toastr["error"](data.error)
                    toastr.options = {
                        "closeButton": false,
                        "debug": false,
                        "newestOnTop": false,
                        "progressBar": false,
                        "positionClass": "toast-top-right",
                        "preventDuplicates": false,
                        "onclick": null,
                        "showDuration": "3000",
                        "hideDuration": "1000",
                        "timeOut": "5000",
                        "extendedTimeOut": "1000",
                        "showEasing": "swing",
                        "hideEasing": "linear",
                        "showMethod": "fadeIn",
                        "hideMethod": "fadeOut"
                    }
                }
                if (data.result == 'fail') {
                    // App.unblockUI('#blockUI');
                    // $('#fail').show();
                    Command: toastr["error"]("Error Completing Request. Try Again!")

                    toastr.options = {
                        "closeButton": false,
                        "debug": false,
                        "newestOnTop": false,
                        "progressBar": false,
                        "positionClass": "toast-top-right",
                        "preventDuplicates": false,
                        "onclick": null,
                        "showDuration": "3000",
                        "hideDuration": "1000",
                        "timeOut": "5000",
                        "extendedTimeOut": "1000",
                        "showEasing": "swing",
                        "hideEasing": "linear",
                        "showMethod": "fadeIn",
                        "hideMethod": "fadeOut"
                    }
                }
                if (data.result == 'login') {
                    window.location.href = u + '/login';
                    Command: toastr["error"]("Session Expired. Login to continue!")

                    toastr.options = {
                        "closeButton": false,
                        "debug": false,
                        "newestOnTop": false,
                        "progressBar": false,
                        "positionClass": "toast-top-right",
                        "preventDuplicates": false,
                        "onclick": null,
                        "showDuration": "3000",
                        "hideDuration": "1000",
                        "timeOut": "5000",
                        "extendedTimeOut": "1000",
                        "showEasing": "swing",
                        "hideEasing": "linear",
                        "showMethod": "fadeIn",
                        "hideMethod": "fadeOut"
                    }
                }
            }
        })
    });
</script>
<script type="text/javascript">
    //display vat, net  and gross amount
    $('#vat_id').click(function(){
        var type = $(this).val();

        if(type == "Inclusive"){
            inclusive();
            $("#tax-box").show();
        }
        else{
            exclusive();
            $("#tax-box").show();
        }
    });


    function inclusive(){
        var price =parseFloat( $('#price').val()).toFixed(2);
        var price2 = parseFloat($('#price2').val()).toFixed(2);
        var amount = price + price2;

        var gross = amount;
        var vat = (5/105) * amount;
        var net_amount = gross - vat;
        $("#gross").val(gross);
        $("#vat").val(vat);
        $("#net").val(net_amount);
    }

    function exclusive(){
        var price =parseFloat( $('#price').val()).toFixed(2);
        var price2 = parseFloat($('#price2').val()).toFixed(2);
        var amount = parseFloat(price) + parseFloat(price2);

        var vat = (5/100) * amount;
        var net_amount = amount;
        var gross = amount + vat;
        $("#gross").val(gross);
        $("#vat").val(vat);
        $("#net").val(net_amount);
    }

    $(".price").change(function(){
        if($("#vat_id").val() == "Inclusive"){
            inclusive();
        }
        else{
            exclusive();
        }
    });
</script>

@endsection
