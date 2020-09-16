'use strict';


$('.edit_services').click(function () {
    var id = $(this).attr('id');
    console.log(id)
    $.ajax({
        url: `${api}/corpfin/api/service?id=${id}`,
        type: "GET",
        dataType: "JSON",
        success: function (data) {
            //alert(data);
            $('#view_service_modal').modal('show'); // show bootstrap modal when complete loaded
            $('[name="id"]').val(data.id);
            $('[name="name"]').val(data.name);
            $('[name="measure"]').val(data.measure);
            $('[name="rp"]').val(data.rp);
            $('[name="price"]').val(data.price);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            // alert('Error Retrieving Data!');
        }
    });
});
$('.delete_service_selected').click(function () {
        //   if ($('input.checkboxes').is(':checked')) {
        //       var values = $('input.checkboxes:checked').map(function () {
        //           return this.value;
        //       }).get();
        var id = $(this).attr('id');
        swal({
		    title: "Are you sure you want to delete this Service?",
		    text: "Once deleted, you will not be able to recover this data!",
		    icon: "warning",
		    buttons: true,
		    dangerMode: true,
		})
		.then((willDelete) => {
		    if (willDelete) {
		    	let url= api +`/corpfin/service/delete?id=`+id;
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