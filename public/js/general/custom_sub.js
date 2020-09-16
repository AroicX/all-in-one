
$(document).ready(function(){

    $("input").keypress(function (event) {
        if (event.which == 13) {
            event.preventDefault();
            $("#subscription_form").submit();
        }
    });

     // check if plan number is greater than 0 to enable/disable the continue button
    if(getElemProperty($('#pay_btn'),'disabled') == false){

        if(parseInt($('#no_plan').val()) <= 0){

            setElemProperty($('#pay_btn'),'disabled',true);

        }else{

            setElemProperty($('#pay_btn'),'disabled',false);

        }

    }

     modalSetUp();
     priceSetUp();

});

function modalSetUp(){

   var chkBoxes,frm,fieldName,pModal,mTitle,mPlan,mPrice,planCt;
   var pPackage,plan,price;

    //set variables
    frm = 'sub-form';
    fieldName = 'package[]';
    pModal = $('#pricing');
    mTitle = $('.modal-title');
    mPlan = $('#mplan');
    mPrice = $('#pp');
    planCt = 0;

   //check for the form
    if(!document.forms[frm]){

        return false;

    }

    //get all checkboxes in the form
    chkBoxes = document.forms[frm].elements[fieldName];

    //get the class attribute of the check box
    if(!chkBoxes){

        return false;
    }else{

        for(var i = 0; i < chkBoxes.length; i++){


            $(chkBoxes[i]).change(function (e) {

                if($(this).is(':checked')){

                    console.log(e);

                    //set the number of plans
                    planCt += 1;
                    $('#plan_no').text(planCt);
                    $('#no_plan').val(parseInt(planCt));

                    plan = $(this).val(); // get the value e.g. CorpPAY Enterprise
                    pPackage = $(this).attr('data-package'); //get the package from the attribute e.g. CorpPAY
                    price = parseFloat($(this).attr('data-price').replace(/,/g, '.')); // get the price from the attribute e.g. 12999

                    if(plan != "" && pPackage != "" && price != 0.00){

                        mTitle.text(plan); // set the title of the modal
                        pModal.modal('show'); // show the modal (from bootstrap)
                        mPlan.val(pPackage); // set the package type
                        mPrice.val(price); // set the price of the package type

                        $('.' + pPackage).prop('disabled',true); // disable all checkbox with the class name
                        $(this).prop('disabled',false); // enable this checkbox


                    }else{

                        // come back here for setting the _price and _d values
                        $('#' + mPlan + '_price').val(0);
                        $('#' + mPlan + '_d').val(0);

                    }

                }
                else if(!$(this).is(':checked')){

                    // reduce the number of plans
                    planCt = $('#no_plan').val() - 1;

                    //disable the continue button
                    if(planCt < 0){

                        planCt = 0;
                        setElemProperty($('#pay_btn'),'disabled',true); //disable the continue button
                    }else if(planCt == 0){

                        setElemProperty($('#pay_btn'),'disabled',true); //disable the continue button
                    }
                    $('#plan_no').text(planCt);
                    $('#no_plan').val(parseInt(planCt));

                    //reduce price
                    pPackage = $(this).attr('data-package'); //get the package from the attribute e.g. CorpPAY
                    var pPrice = $('#' + pPackage + '_price').val(); // get the price
                    var curPrice = $('#tp').val();
                    var nPrice = Math.round(parseFloat(curPrice) - parseFloat(pPrice));

                    //set teh new price
                    $('#' + pPackage + '_price').val(0);
                    $('#' + pPackage + '_d').val(0);

                    $('#subtotal').text(nPrice);
                    $('#tp').val(nPrice);
                    $('#subtotal-value').val(nPrice);

                    //set packages
                    pPackage = $(this).attr('data-package'); //get the package from the attribute
                    $('.' + pPackage).prop('disabled',false); // disable all checkbox with the class name
                    $(this).prop('disabled',false); // enable this checkbox

                }

            });

        }

    }


}

function priceSetUp() {

    var qty, pPrice, total, tFormat, tPrice, subTotVal;

    $('#duration').change(function () {

        qty = $('#duration').val();
        pPrice = $('#pp').val();
        tPrice = $('#total-price');

        total = parseFloat(pPrice) * parseInt(qty);
        tFormat = (total + '').replace(/(\d)(?=(\d{3})+$)/g, '$1');
        //alert(tFormat);

        // ** NB: come back to check for the value of tFormat if its NaN
        tPrice.val(tFormat);

    });

}

function contModal() {

    var pDuration, mPlan, tPrice;

    pDuration = $('#duration :selected').attr('data-dd');

    if (pDuration == "") {

        alert('Please select a duration!');

    }
    else{

        //set variables
        tPrice = $('#total-price').val();
        mPlan = $('#mplan').val();
        $('#' + mPlan + '_price').val(tPrice);
        $('#' + mPlan + '_d').val(pDuration);

        $('#pricingform')[0].reset();
        $('#pricing').modal('hide');

        ///put price
        $('#subtotal').text(addUpPrice());
        $('#tp').val(addUpPrice());
        $('#subtotal-value').val(addUpPrice());

        //enable the pay button
        if($('#pay_btn').prop('disabled') == true){

            $('#pay_btn').prop('disabled',false);

        }

    }
}

function exitModal() {
    // sub_tot();
    $('#pricingform')[0].reset();
    $('#pricing').modal('hide');
}

function addUpPrice(){

    var a = parseFloat($('#CorpFIN_price').val());
    var b = parseFloat($('#CorpHRM_price').val());
    var c = parseFloat($('#CorpTAX_price').val());
    var d = parseFloat($('#CorpEMT_price').val());
    var e = parseFloat($('#CorpPAY_price').val());

    return a + b + c + d + e;

}

function setElemProperty(elem,property,state){

    elem.prop(property,state);

}

function getElemProperty(elem,property){

    return elem.prop(property) == true ? true : false;

}

$('#subscription_form').submit(function (e) {

    e.preventDefault(); // prevent default action of the button

    var mainUrl, dataToken;

    url = $(this).attr('action'); // get the url of the action attribute of the form


    // check if user had select a plan
    if($('.CorpFIN:checked').val() === undefined && $('.CorpTAX:checked').val() === undefined &&
        $('.CorpHRM:checked').val() === undefined && $('.CorpEMT:checked').val() === undefined &&
        $('.CorpPAY:checked').val() === undefined){

        alert('Please select a plan');
        return false;
    }


    App.blockUI({
        target: '#blockUI',
        boxed: true,
        textOnly: true,
        message: '<img src="../../img/spinner.gif" /> Just a moment...'
    });

    //capture data and save using ajax
    $.ajax({

        url:  url,
        dataType: 'json',
        type: 'post',

        beforeSend: function (xhr) {
            xhr.setRequestHeader('X-CSRF-TOKEN', $("#token").attr('content'));
        },

        data: $(this).serialize(),

        success: function(data){

            if(data.result == 'success'){

                App.unblockUI('#blockUI');

                Command: toastr["success"]("Subscription Plan Successful!");

                toastr.options = {
                    "closeButton": false,
                    "debug": false,
                    "newestOnTop": false,
                    "progressBar": false,
                    "positionClass": "toast-top-center",
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

                window.location.href = 'subscription/pay?refx_code=' + data.refx_code;
            }

            if (data.result == 'fail') {

                App.unblockUI('#blockUI');

                Command: toastr["error"]("Error Completing Request. Please Try Again!");

                toastr.options = {
                    "closeButton": false,
                    "debug": false,
                    "newestOnTop": false,
                    "progressBar": false,
                    "positionClass": "toast-top-center",
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

        },
        error: function( jqXhr, textStatus, errorThrown ){
            alert(errorThrown);
            App.unblockUI('#blockUI');
        }


    });


});




