/*const getStatesByCountryName = () => {
        var id = $('#country :selected').attr('value');
        console.log(id)
        $.ajax({
            type: "GET",
            url: window.localStorage.getItem('cpurl')+'/corpfin/api/state',//"{{ route("corpfin.api.state.name.get") }}?name=" + id,
            // dataType: "html",
            success: function (data) {
                $('#state').empty();
                for (var key in data) {
                    var name = data[key].name;
                    var sel = document.getElementById('state');
                    var opt = document.createElement('option');
                    opt.text = data[key].name;
                    opt.value = data[key].name;
                    sel.appendChild(opt);

                }
            }
        });
    } */

$("#country").change(function (e) {
    console.log(e);
    var id = $('#country :selected').attr('id');
    var u = $("#url").val();
    $.ajax({
        type: "GET",
        url: u + "/api/getstates/" + id,
        // dataType: "html",
        success: function (data) {
            $('#state').empty();
            for (var key in data) {
                var name = data[key].name;
                var sel = document.getElementById('state');
                var opt = document.createElement('option');
                opt.text = data[key].name;
                opt.value = data[key].name;
                sel.appendChild(opt);

            }
        }
    });
});


$("input").keypress(function (event) {
    if (event.which == 13) {
        event.preventDefault();
        $("#setup1").submit();
    }
});
$('#setup1').submit(function (e) {
    e.preventDefault();
    url = $(this).attr('action');
    var u = $("#url").val();
    $('#empty').hide();
    $('#val_fail').hide();
    $('#fail').hide();
    if ($('[name|="name"]').val() == "" || $('[name|="crn"]  ').val() == "" || $('[name|="address"]  ').val() == "") {
//$('#empty').show();
        new PNotify.alert({
            title: 'Validation Error',
            text: 'All fields are Required',
            type: 'error'
        });
        return false;
    }
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
                window.location.href = u + '/subscription';
                new PNotify.alert({
                    title: 'Successful',
                    text: 'Data addedd Successfully',
                    type: 'success'
                });
                // alert("OKK");
            }
            if (data.result == 'val_fail') {
                new PNotify.alert({
                    title: 'Server Error',
                    text: 'Error',
                    type: 'error'
                });
            }
            if (data.result == 'fail') {
                new PNotify.alert({
                    title: 'Server Error',
                    text: 'Error',
                    type: 'error'
                });
            }
            if (data.result == 'login') {
                window.location.href = u + '/login';
                new PNotify.alert({
                    title: 'Session Expired',
                    text: 'Please login to continuentinue',
                    type: 'error'
                });
            }
        }
    })
});