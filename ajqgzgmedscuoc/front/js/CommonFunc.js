// Join Link Request Start
JoinRequestTypeChange = (event) => {
    if (event.value == 2) {
        $('#join-request-watapp')[0].disabled = false;
        $('#join-request-telegram')[0].disabled = true;
        // $('#join-request-telegram')[0].value = "";
    } else if (event.value == 3) {
        $('#join-request-watapp')[0].disabled = true;
        $('#join-request-telegram')[0].disabled = false;
        // $('#join-request-watapp')[0].value = "";
    } else {
        $('#join-request-watapp')[0].disabled = true;
        $('#join-request-telegram')[0].disabled = true;
        // $('#join-request-watapp')[0].value = "";
        // $('#join-request-telegram')[0].value = "";
    }
}

$("#Join_request_form").validate({
    rules: {
        email: { required: true, },
    },
    submitHandler: function (form, event) {
        event.preventDefault();
        let form_data = new FormData(form);
        $.ajax({
            url: base_urll + "/join_request",
            type: "POST",
            processData: false,
            contentType: false,
            cache: false,
            data: form_data,
            enctype: 'multipart/form-data',
            beforeSend: function () { start_loader(); },
            success: function (res) {
                stop_loader();
                if (!res) return;
                res = JSON.parse(res);
                if (res.status == 'success') {
                    growlFunc('success', 'join request success.');
                } else if (res.status == 'error') { growlFunc('error', 'join request failure.'); }
                else { growlFunc('error', 'join request failure.'); }
            },
            error: function (error) {
                stop_loader();
                growlFunc('error', error.statusText);
            }
        })
        return false;
    }
});

function growlFunc(type, message) {
    if (type == 'success') {
        $.growl.notice(
            { message: message },
            { position: { from: "bottom", align: "left" } }
        )
    } else if (type == 'error') {
        $.growl.error(
            { message: message },
            { position: { from: "bottom", align: "left" } }
        )
    }
}
// Join Link Request End