    
                       var handler = PaystackPop.setup({
      key: 'pk_test_b74cea21b07452cf31f529f24c31caf444a22ca7',
      email: email,
      amount: total * 100,
      ref: code,
      callback: function(response){
        var rep_code = response.trxref;
           $.ajax({
                type: 'POST',
                //url: "<?php echo base_url()."checkout_auth/confirm_booking/" ?>/"+rep_code,
				url: base_url+"/pay/process/"+rep_code,
                data: { code: response.trxref },
                dataType: "JSON",
                 success: function(data){
                  if (data.result == 'success') {
                window.location.href=base_url+'/myaccount/order_success?c='+data.code;
                      }
                  if (data.result == 'failed') {
               $.alert({
    title: 'Error!',
    content: 'Error Completing Request. Try Again!',
    confirm: function(){
       window.location.href=base_url+'/myaccount/mycart';
    }
});
                      }
                 }
           }); 
                   //  alert('success. transaction ref is ' + rep_code); 
      },
      onClose: function(){
          alert('window closed');
      }
    }); 
    handler.openIframe();