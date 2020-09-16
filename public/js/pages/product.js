'use strict';
// $(document).ready(function() {
const api = window.localStorage.getItem('cpurl')
	
	$("#taxes").click(function (e) {
    $("#tax-box").hide();
    
    var style = $('#taxes :selected').attr('value');
    var vat_type_id = document.getElementById('vat_type_id');
    var wht_type_id = document.getElementById('wht_type_id');
    if (style == "vat") {
        console.log('tax');
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

$('.view_deliverable').click(function () {
    var id = $(this).attr('id');
    $.ajax({
        url: `${api}/corpfin/api/product?id=${id}`,
        type: "GET",
        dataType: "JSON",
        success: function (data) {
            $('#view_modal').modal('show'); // show bootstrap modal when complete loaded
            $('[name="id"]').val(data.id);
            $('[name="name"]').val(data.name);
            $('[name="measure"]').val(data.measure);
            $('[name="rp"]').val(data.rp);
            $('[name="price"]').val(data.price);

        }
    });
});

/*$('#add_product').submit(function (e) {
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
        postData = $(this).serialize();
        console.log(postData)
        // return;
        $.ajax({
            url: url,
            type: 'post',
            data: postData,
            dataType: 'json',
            success: function (data) {
            	console.log(data)
                if (data.result == 'success') {
                	new PNotify.alert({
			            title: 'Success notice',
			            text: 'Check me out! I\'m a notice.',
			            type: 'success'
			        });
                    // window.location.href = '{{ route('corpfin.product.view') }}';
                   
                }
                if (data.result == 'val_fail') {
                    
                }
                if (data.result == 'fail') {
                   
                }
                if (data.result == 'login') {
                    // window.location.href = u + '/login';
                }
            }
        })
});*/
    
/*


$("input").keypress(function (event) {
        if (event.which == 13) {
            event.preventDefault();
            $("#add_product").submit();
        }
    });
    




   

    $(".price").change(function(){
        if($("#vat_id").val() == "Inclusive"){
            inclusive();
        }
        else{
            exclusive();
        }
    });
*/
 	$('.delete_selected').click(function () {
        //   if ($('input.checkboxes').is(':checked')) {
        //       var values = $('input.checkboxes:checked').map(function () {
        //           return this.value;
        //       }).get();
        var id = $(this).attr('id');
        swal({
		    title: "Are you sure you want to delete this Product?",
		    text: "Once deleted, you will not be able to recover this data!",
		    icon: "warning",
		    buttons: true,
		    dangerMode: true,
		})
		.then((willDelete) => {
		    if (willDelete) {
		    	let url= api +`/corpfin/product/delete?id=`+id;
		    	console.log(url)
		    	// return 
		    	$.ajax({
	                type: "GET",
	                url: url,
	                dataType: 'json',
	                success: function (data) {
	                    if (data.result == 'success') {
	                    	swal("Successful! Data has been deleted!", {
					            icon: "success",
					        });
	                        location.reload();
	                        
	                    }
	                    if (data.result == 'fail') {
	                        
	                    }
	                    if (data.result == 'login') {
	                        window.location.href = u + '/login';
	                        
	                    }
	                }
	            })
		    } else {
		        swal("Cancelled!", {
		            icon: "error",
		        });
		    }
		});
    })
// });
