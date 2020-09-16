$("input").keypress(function (event) {
    if (event.which == 13) {
        event.preventDefault();
        $("#payment-form").submit();
    }
});


$('#payment-form').submit(function (e) {


    e.preventDefault();

    url = $(this).attr('action');

    var u = $("#url").val();

    // var value = $('.CorpEMT:checked').val();

    App.blockUI({
        target: '#blockUI',
        boxed: true,
        textOnly: true,
        message: '<img src="../../img/spinner.gif" /> Just a moment...'
    });

    $.ajax({
            url: url,
            type: 'post',
            dataType: 'json',

            beforeSend: function (xhr) {
                xhr.setRequestHeader('X-CSRF-TOKEN', $("#token").attr('content'));
            },

            data: $(this).serialize(),

            success: function(data) {

                if(data.result == 'success'){

                   App.unblockUI('#blockUI');

                   Command: toastr["success"](data.responsemessage);

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


                   // window.location.replace('/corpfin/dashboard');
                   window.location.href= '/corpfin/dashboard';

               }

                if(data.result == 'failTokenize'){

                    App.unblockUI('#blockUI');

                    Command: toastr["error"](data.responsemessage);

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

                }

                if(data.result == 'failCharge'){

                    App.unblockUI('#blockUI');

                    Command: toastr["error"](data.responsemessage);

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

                }

                if(data.result === 'failConnected'){

                    App.unblockUI('#blockUI');

                    Command: toastr["info"]('No Network Response. Please check your internet connection');

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

                }

            },
            error: function( jqXhr, textStatus, errorThrown ){
                alert(errorThrown);
            }
        });


});
