 var month = $('#FYE1 :selected').attr('id');
  if(month == "0"){
//remove days 30 and 31
$('#30').hide();
$('#31').hide();
  }else if(month == "1"){
//remove day 31
$('#31').hide();
  }

  var counter = 1;
var counterp = 1;
var counters = 1;
var limit = 1050;
function addInput(divName){
     if (counter == limit)  {
          alert("You have reached the limit of adding " + counter + " inputs");
     }
     else {
          var newdiv = document.createElement('div');
          newdiv.innerHTML = "Branch " + (counter + 1) + " <br><input type='text' class='form-control' name='branches[]'><br>";
          document.getElementById(divName).appendChild(newdiv);
          counter++;
     }
}
function addproduct(divName){
     if (counterp == limit)  {
          alert("You have reached the limit of adding " + counterp + " inputs");
     }
     else {
          var newdiv = document.createElement('div');
          newdiv.innerHTML = "Product Name " + (counterp + 1) + " <br><input type='text' class='form-control' name='products[]'> Product Price " + (counterp + 1) + " <input type='number' class='form-control' name='product_price[]'><br>";
          document.getElementById(divName).appendChild(newdiv);
          counter++;
     }
}
function addservice(divName){
     if (counters == limit)  {
          alert("You have reached the limit of adding " + counters + " inputs");
     }
     else {
          var newdiv = document.createElement('div');
          newdiv.innerHTML = "Service Name " + (counters + 1) + " <br><input type='text' class='form-control' name='services[]'> Service Price " + (counters + 1) + " <input type='number' class='form-control' name='service_price[]'><br>";
          document.getElementById(divName).appendChild(newdiv);
          counter++;
     }
}

//  var checkbox_product = document.getElementById('product_check');
// var input_product = document.getElementById('products');
//   var checkbox_service = document.getElementById('service_check');
// var input_service = document.getElementById('services');

// checkbox_product.addEventListener('click', function () {
//     if (input_product.style.display != 'block') {
//         input_product.style.display = 'block';
//     } else {
//         input_product.style.display = '';
//     }
// });
// checkbox_service.addEventListener('click', function () {
//     if (input_service.style.display != 'block') {
//         input_service.style.display = 'block';
//     } else {
//         input_service.style.display = '';
//     }
// });

 $("input").keypress(function(event) {
            if (event.which == 13) {
                event.preventDefault();
                $("#setup1").submit();
            }
        });


 $('#setup2').submit(function (e) {
    e.preventDefault();
    url = $(this).attr('action');
    var u = $("#url").val();
    $('#empty').hide();
    $('#val_fail').hide();
    $('#fail').hide();
if ($('[name|="industry_type"]').val() == "" || $('[name|="business_type"]  ').val() == ""){
$('#empty').show();
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
                type:'post',
beforeSend: function(xhr){xhr.setRequestHeader('X-CSRF-TOKEN', $("#token").attr('content'));},
                data: postData,
                dataType:'json',
                success: function(data){
                    if (data.result == 'success') {
                       window.location.href = u+'/corpfin/dashboard';
                       Command: toastr["success"]("Company Setup Sucessful!")
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
}                    }
                    if (data.result == 'val_fail'){
                        App.unblockUI('#blockUI');
                        $('#val_fail').show();
                    }
                    if (data.result == 'fail') {
                        App.unblockUI('#blockUI');
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
                }
            })
  });