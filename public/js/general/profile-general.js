$("input").keypress(function (event) {

  alert('pressed')
  if (event.which == 13) {
    event.preventDefault();
    $("#profile-general").submit();
  }
});
$('#profile-general').submit(function (e) {
  e.preventDefault();
  url = $(this).attr('action');
  var u = $("#url").val();
  
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
        // alert("Company Setup Sucessful!");
        // window.location.href = u+'/dashboard';
        location.reload();
        Command: toastr["success"]("Profile Updated Successfully!")
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