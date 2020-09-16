$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip(); 
});

$('.cancel_plan').click(function (){
      //   if ($('input.checkboxes').is(':checked')) {
      //       var values = $('input.checkboxes:checked').map(function () {
      //           return this.value;
      //       }).get();
      var id = $(this).attr('idd');
       var u = $("#url").val();
            confirm_statement = "Are you sure you want to cancel current plan?";
            if (confirm(confirm_statement)){
                App.blockUI({ 
                    target: '#BlockUI',
                    boxed: true,
                    textOnly: true,
                    message: '<img src="http://localhost:8000/img/spinner.gif" /> Just a moment...'
                });
                $.ajax({
                    // url: '{{ url('corpfin/del/tp') }}',
                    // type:'post',
                    // data: { "hall_id" : values },
                     type: "GET",
            url: u+"/cancel_plan/"+id,
                    dataType:'json',
                    success: function(data){
                                           if (data.result == 'success') {
         location.reload();
Command: toastr["success"]("Subscription Cancelled!")

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
                       window.location.href = u+'/login';
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

            }
        // }else{ 
        //     alert('Select Hall First');
        //     return false;
        // }
    })