$("input").keypress(function (event) {
    if (event.which == 13) {
        event.preventDefault();
        $("#subscription_form").submit();
    }
});

$('#subscription_form').submit(function (e) {

    e.preventDefault();
    url = $(this).attr('action');
    var u = $("#url").val();
    var value = $('.CorpEMT:checked').val();
    if (value == "") {
        alert("select a plan")
        return false;
    };

    App.blockUI({
        target: '#blockUI',
        boxed: true,
        textOnly: true,
        message: '<img src="http://localhost:8000/img/spinner.gif" /> Just a moment...'
    });
    postData = $(this).serialize();
    $.ajax({
        url: url,
        type: 'post',
        beforeSend: function (xhr) {
            xhr.setRequestHeader('X-CSRF-TOKEN', $("#token").attr('content'));
        },
        data: postData,
        dataType: 'json',
        success: function (data) {
            if (data.result == 'success') {
                //alert("subscription Successful");
                window.location.href = u + '/subscription/pay?refx_code=' + data.refx_code;
                // alert("OKK");
            }
            if (data.result == 'fail') {
                App.unblockUI('#blockUI');
                //$('#fail').show();
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

var cart_arr = [];
var corpfin_package;
var corpfin_fee = 0;
var corphrm_package;
var corphrm_fee = 0;
var corppay_package;
var corppay_fee = 0;
var corpemt_package;
var corpemt_fee = 0;
var corptax_package = 0;
var corptax_fee = 0;
var cart_item = 0;
var corpfin_duration = 1;
var corphrm_duration = 1;
var corppay_duration = 1;
var corpemt_duration = 1;
var corptax_duration = 1;
var discount = "0.00";
document.getElementById("discount_p").innerHTML = discount;
document.getElementById("cart-item").innerHTML = "0";
$('.add_to_cart_btn').on('click', function (e) {
    $("#corpfin_cart_detail").hide();
    $("#corphrm_cart_detail").hide();
    $("#corppay_cart_detail").hide();
    $("#corpemt_cart_detail").hide();
    $("#corptax_cart_detail").hide();
    e.preventDefault();
    cart_item = 0;
    var parent = $(this).attr('parent');
    var package = $(this).attr('package');
    var fee = $(this).attr('fee');
    if (parent == "CorpFIN") {
        corpfin_package = package;
        corpfin_fee = fee;
        $("#collapse_corpfin_btn").click();
        $("#corpfin_duration").val("1");
        corpfin_duration = 1;
        $("#corpfin_package").val(package);
        // document.getElementById("corpfin_package").innerHTML = package;
        document.getElementById("corpfin_price").innerHTML = fee;
        document.getElementById("corpfin_total_price").innerHTML = fee;
    }
    if (parent == "CorpHRM") {
        corphrm_package = package;
        corphrm_fee = fee;
        corphrm_duration = 1;
        $("#collapse_corphrm_btn").click();
        $("#corphrm_duration").val("1");
        $("#corphrm_package").val(package);
        // document.getElementById("corphrm_package").innerHTML = package;
        document.getElementById("corphrm_price").innerHTML = fee;
        document.getElementById("corphrm_total_price").innerHTML = fee;
    }
    if (parent == "CorpPAY") {
        corppay_package = package;
        corppay_fee = fee;
        corppay_duration = 1;
        $("#collapse_corppay_btn").click();
        $("#corppay_duration").val("1");
        $("#corppay_package").val(package);
        // document.getElementById("corppay_package").innerHTML = package;
        document.getElementById("corppay_price").innerHTML = fee;
        document.getElementById("corppay_total_price").innerHTML = fee;
    }
    if (parent == "CorpEMT") {
        corpemt_package = package;
        corpemt_fee = fee;
        corpemt_duration = 1;
        $("#collapse_corpemt_btn").click();
        $("#corpemt_duration").val("1");
        $("#corpemt_package").val(package);
        // document.getElementById("corpemt_package").innerHTML = package;
        document.getElementById("corpemt_price").innerHTML = fee;
        document.getElementById("corpemt_total_price").innerHTML = fee;
    }
    if (parent == "CorpTAX") {
        corptax_package = package;
        corptax_fee = fee;
        corptax_duration = 1;
        $("#collapse_corptax_btn").click();
        $("#corptax_duration").val("1");
        $("#corptax_package").val(package);
        // document.getElementById("corptax_package").innerHTML = package;
        document.getElementById("corptax_price").innerHTML = fee;
        document.getElementById("corptax_total_price").innerHTML = fee;
    }
    cart_arr = {
        "CorpFIN": {
            "package": corpfin_package,
            "fee": corpfin_fee,
            "duration": corpfin_duration
        },
        "CorpHRM": {
            "package": corphrm_package,
            "fee": corphrm_fee,
            "duration": corphrm_duration
        },
        "CorpPAY": {
            "package": corppay_package,
            "fee": corppay_fee,
            "duration": corppay_duration
        },
        "CorpEMT": {
            "package": corpemt_package,
            "fee": corpemt_fee,
            "duration": corpemt_duration
        },
        "CorpTAX": {
            "package": corptax_package,
            "fee": corptax_fee,
            "duration": corptax_duration
        }
    };
    if (cart_arr.CorpFIN.fee != "0") {
        cart_item++;
        $("#corpfin_cart_detail").show();
    } if (cart_arr.CorpHRM.fee != "0") {
        cart_item++;
        $("#corphrm_cart_detail").show();
    } if (cart_arr.CorpPAY.fee != "0") {
        $("#corppay_cart_detail").show();
        cart_item++;
    } if (cart_arr.CorpEMT.fee != "0") {
        $("#corpemt_cart_detail").show();
        cart_item++;
    } if (cart_arr.CorpTAX.fee != "0") {
        $("#corptax_cart_detail").show();
        cart_item++;
    }
    if (cart_item > 0) {
        document.getElementById('cart_a').href = "#cart_panel";
        document.getElementById('cart_a').classList.remove("IsDisabled");
        document.getElementById('checkout_a').href = "#checkout_panel";
        document.getElementById('checkout_a').classList.remove("IsDisabled");
        if($("#cart_btn").hasClass("disabled")){
            document.getElementById('cart_btn').classList.remove("disabled");
        }
    }
    $('html,body').animate({
        scrollTop: 0
    }, 700);
    document.getElementById("cart-item").innerHTML = cart_item;
    document.getElementById("total_p").innerHTML = ((cart_arr.CorpFIN.fee * cart_arr.CorpFIN.duration) + (cart_arr.CorpHRM.fee * cart_arr.CorpHRM.duration) + (cart_arr.CorpPAY.fee * cart_arr.CorpPAY.duration) + (cart_arr.CorpEMT.fee * cart_arr.CorpEMT.duration) + (cart_arr.CorpTAX.fee * cart_arr.CorpTAX.duration)).toFixed(2);
    document.getElementById("subtotal_p").innerHTML = (((cart_arr.CorpFIN.fee * cart_arr.CorpFIN.duration) + (cart_arr.CorpHRM.fee * cart_arr.CorpHRM.duration) + (cart_arr.CorpPAY.fee * cart_arr.CorpPAY.duration) + (cart_arr.CorpEMT.fee * cart_arr.CorpEMT.duration) + (cart_arr.CorpTAX.fee * cart_arr.CorpTAX.duration)) - discount).toFixed(2);
    $(".packages_corpfin_").val(["CorpFIN", cart_arr.CorpFIN.package, cart_arr.CorpFIN.duration, cart_arr.CorpFIN.fee]);
    $(".packages_corphrm_").val(["CorpHRM", cart_arr.CorpHRM.package, cart_arr.CorpHRM.duration, cart_arr.CorpHRM.fee]);
    $(".packages_corpemt_").val(["CorpEMT", cart_arr.CorpEMT.package, cart_arr.CorpEMT.duration, cart_arr.CorpEMT.fee]);
    $(".packages_corppay_").val(["CorpPAY", cart_arr.CorpPAY.package, cart_arr.CorpPAY.duration, cart_arr.CorpPAY.fee]);
    $(".packages_corptax_").val(["CorpTAX", cart_arr.CorpTAX.package, cart_arr.CorpTAX.duration, cart_arr.CorpTAX.fee]);
    Command: toastr["success"]("Item added to cart!")
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
});

function remove_from_cart(item) {
    if (item == "CorpFIN" && cart_arr.CorpFIN.fee != "0") {
        cart_arr.CorpFIN.fee = "0";
        cart_item = cart_item - 1;
        $("#corpfin_cart_detail").hide();
    } if (item == "CorpHRM" && cart_arr.CorpHRM.fee != "0") {
        cart_arr.CorpHRM.fee = "0";
        cart_item = cart_item - 1;
        $("#corphrm_cart_detail").hide();
    } if (item == "CorpPAY" && cart_arr.CorpPAY.fee != "0") {
        cart_arr.CorpPAY.fee = "0";
        cart_item = cart_item - 1;
        $("#corppay_cart_detail").hide();
    } if (item == "CorpEMT" && cart_arr.CorpEMT.fee != "0") {
        cart_arr.CorpEMT.fee = "0";
        cart_item = cart_item - 1;
        $("#corpemt_cart_detail").hide();
    } if (item == "CorpTAX" && cart_arr.CorpTAX.fee != "0") {
        cart_arr.CorpTAX.fee = "0";
        cart_item = cart_item - 1;
        $("#corptax_cart_detail").hide();
    }
    if (cart_item <= 0) {
        $("#packages_panel_btn").click();
        if(!$("#cart_btn").hasClass("disabled")){
            document.getElementById('cart_btn').classList.add("disabled");
        }
        document.getElementById('cart_a').href = "#packages_panel";
        document.getElementById('cart_a').classList.add("IsDisabled");
        document.getElementById('checkout_a').href = "#packages_panel";
        document.getElementById('checkout_a').classList.add("IsDisabled");
    }
    document.getElementById("cart-item").innerHTML = cart_item;
    document.getElementById("total_p").innerHTML = (cart_arr.CorpFIN.fee * cart_arr.CorpFIN.duration) + (cart_arr.CorpHRM.fee * cart_arr.CorpHRM.duration) + (cart_arr.CorpPAY.fee * cart_arr.CorpPAY.duration) + (cart_arr.CorpEMT.fee * cart_arr.CorpEMT.duration) + (cart_arr.CorpTAX.fee * cart_arr.CorpTAX.duration);
    document.getElementById("subtotal_p").innerHTML = ((cart_arr.CorpFIN.fee * cart_arr.CorpFIN.duration) + (cart_arr.CorpHRM.fee * cart_arr.CorpHRM.duration) + (cart_arr.CorpPAY.fee * cart_arr.CorpPAY.duration) + (cart_arr.CorpEMT.fee * cart_arr.CorpEMT.duration) + (cart_arr.CorpTAX.fee * cart_arr.CorpTAX.duration)) - discount;
    $(".packages_corpfin_").val(["CorpFIN", cart_arr.CorpFIN.package, cart_arr.CorpFIN.duration, cart_arr.CorpFIN.fee]);
    $(".packages_corphrm_").val(["CorpHRM", cart_arr.CorpHRM.package, cart_arr.CorpHRM.duration, cart_arr.CorpHRM.fee]);
    $(".packages_corpemt_").val(["CorpEMT", cart_arr.CorpEMT.package, cart_arr.CorpEMT.duration, cart_arr.CorpEMT.fee]);
    $(".packages_corppay_").val(["CorpPAY", cart_arr.CorpPAY.package, cart_arr.CorpPAY.duration, cart_arr.CorpPAY.fee]);
    $(".packages_corptax_").val(["CorpTAX", cart_arr.CorpTAX.package, cart_arr.CorpTAX.duration, cart_arr.CorpTAX.fee]);
    Command: toastr["success"]("Item removed from cart!")
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

function update_package(params, type, package) {
    if (package == "CorpFIN") {
        if(type == "duration"){
            document.getElementById("corpfin_total_price").innerHTML = (cart_arr.CorpFIN.fee * params.value).toFixed(2);
            cart_arr.CorpFIN.duration = params.value;
        }
        if(type == "package"){
            var fee = $('option:selected', params).attr('fee');
            document.getElementById("corpfin_price").innerHTML = fee;
            document.getElementById("corpfin_total_price").innerHTML = (fee * cart_arr.CorpFIN.duration).toFixed(2);
            cart_arr.CorpFIN.fee = fee;
            cart_arr.CorpFIN.package = params.value;
        }
    }
    if (package == "CorpHRM") {
        if(type == "duration"){
            document.getElementById("corphrm_total_price").innerHTML = (cart_arr.CorpHRM.fee * params.value).toFixed(2);
            cart_arr.CorpHRM.duration = params.value;
        }
        if(type == "package"){
            var fee = $('option:selected', params).attr('fee');
            document.getElementById("corphrm_price").innerHTML = fee;
            document.getElementById("corphrm_total_price").innerHTML = (fee * cart_arr.CorpHRM.duration).toFixed(2);
            cart_arr.CorpHRM.fee = fee;
            cart_arr.CorpHRM.package = params.value;
        }
    }
    if (package == "CorpPAY") {
        if(type == "duration"){
            document.getElementById("corppay_total_price").innerHTML = (cart_arr.CorpPAY.fee * params.value).toFixed(2);
            cart_arr.CorpPAY.duration = params.value;
        }
        if(type == "package"){
            var fee = $('option:selected', params).attr('fee');
            document.getElementById("corppay_price").innerHTML = fee;
            document.getElementById("corppay_total_price").innerHTML = (fee * cart_arr.CorpPAY.duration).toFixed(2);
            cart_arr.CorpPAY.fee = fee;
            cart_arr.CorpPAY.package = params.value;
        }
    }
    if (package == "CorpEMT") {
        if(type == "duration"){
            document.getElementById("corpemt_total_price").innerHTML = (cart_arr.CorpEMT.fee * params.value).toFixed(2);
            cart_arr.CorpEMT.duration = params.value;
        }
        if(type == "package"){
            var fee = $('option:selected', params).attr('fee');
            document.getElementById("corpemt_price").innerHTML = fee;
            document.getElementById("corpemt_total_price").innerHTML = (fee * cart_arr.CorpEMT.duration).toFixed(2);
            cart_arr.CorpEMT.fee = fee;
            cart_arr.CorpEMT.package = params.value;
        }
    }
    if (package == "CorpTAX") {
        if(type == "duration"){
            document.getElementById("corptax_total_price").innerHTML = (cart_arr.CorpTAX.fee * params.value).toFixed(2);
            cart_arr.CorpTAX.duration = params.value;
        }
        if(type == "package"){
            var fee = $('option:selected', params).attr('fee');
            document.getElementById("corptax_price").innerHTML = fee;
            document.getElementById("corptax_total_price").innerHTML = (fee * cart_arr.CorpTAX.duration).toFixed(2);
            cart_arr.CorpTAX.fee = fee;
            cart_arr.CorpTAX.package = params.value;
        }
    }
    $(".packages_corpfin_").val(["CorpFIN", cart_arr.CorpFIN.package, cart_arr.CorpFIN.duration, cart_arr.CorpFIN.fee]);
    $(".packages_corphrm_").val(["CorpHRM", cart_arr.CorpHRM.package, cart_arr.CorpHRM.duration, cart_arr.CorpHRM.fee]);
    $(".packages_corpemt_").val(["CorpEMT", cart_arr.CorpEMT.package, cart_arr.CorpEMT.duration, cart_arr.CorpEMT.fee]);
    $(".packages_corppay_").val(["CorpPAY", cart_arr.CorpPAY.package, cart_arr.CorpPAY.duration, cart_arr.CorpPAY.fee]);
    $(".packages_corptax_").val(["CorpTAX", cart_arr.CorpTAX.package, cart_arr.CorpTAX.duration, cart_arr.CorpTAX.fee]);
    document.getElementById("subtotal_p").innerHTML = (((cart_arr.CorpFIN.fee * cart_arr.CorpFIN.duration) + (cart_arr.CorpHRM.fee * cart_arr.CorpHRM.duration) + (cart_arr.CorpPAY.fee * cart_arr.CorpPAY.duration) + (cart_arr.CorpEMT.fee * cart_arr.CorpEMT.duration) + (cart_arr.CorpTAX.fee * cart_arr.CorpTAX.duration))- discount).toFixed(2);
    document.getElementById("total_p").innerHTML = ((cart_arr.CorpFIN.fee * cart_arr.CorpFIN.duration) + (cart_arr.CorpHRM.fee * cart_arr.CorpHRM.duration) + (cart_arr.CorpPAY.fee * cart_arr.CorpPAY.duration) + (cart_arr.CorpEMT.fee * cart_arr.CorpEMT.duration) + (cart_arr.CorpTAX.fee * cart_arr.CorpTAX.duration)).toFixed(2);   
}

function show_cart_panel(){
    if(cart_item > 0){
        $("#cart_a").click();
    }
    return false;
}

function show_checkout_panel(){
    if(cart_item > 0){
        $("#checkout_a").click();
    }
    return false;
}

function show_package_panel(){
        $("#packages_panel_btn").click();
    return false;
}