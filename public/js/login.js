      $("input").keypress(function(event) {
            if (event.which == 13) {
                event.preventDefault();
                $(".login-form").submit();
            }
        });
        $('.login-form').submit(function (e) {
            e.preventDefault();
            $('#wrong').hide();
            $('#loggedout').hide();
            $('#deactivated').hide();
            $('#denied').hide();
            $('#empty').hide();
            url = $(this).attr('action');
            // alert('sss');
            // e.preventDefault();
           if ($('[name|="email"]').val() == "" || $('[name|="password"]').val() == ""){
                $('#empty').show();
                return false;
            };
            App.blockUI({ 
                target: '#FORMUI',
                boxed: true,
                textOnly: true,
                message: 'public/img/spinner1.gif" /> Just a moment...'
            });
            postData = $(this).serialize();
            $.ajax({
                url: url,
                type:'post',
                data: postData,
                dataType:'json',
                success: function(data){
                    if (data.result == 'success') {

                    }
                    if (data.result == 'denied'){
                        App.unblockUI('#FORMUI');
                        $('#denied').show();
                    }
                    if (data.result == 'deactivated'){
                        App.unblockUI('#FORMUI');
                        $('#deactivated').show();
                    }
                    if (data.result == 'wrong') {
                        App.unblockUI('#FORMUI');
                        $('#wrong').show();
                    }
                }
            })
        });