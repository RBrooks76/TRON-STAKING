// ImgSelect Func Start
function fileSelectChangeFunc(ElemetID, imgID, BtnID) {
    let El = $('#' + ElemetID)[0];
    let ImgContainEl = $('#' + imgID)[0];
    let ImgEl = $('#' + imgID).children()[0];
    let BtnEl = $('#' + BtnID)[0];
    const files = El.files[0];

    if (files) {
        const fileReader = new FileReader();
        fileReader.readAsDataURL(files);
        fileReader.addEventListener("load", function () {
            ImgContainEl.style.display = 'flex';
            BtnEl.style.display = 'none';
            ImgEl.src = this.result;
        });
    }
}
// ImgSelect Func End

// NewsLetter CommonFunc Start
let PlanChangeFunc = () => { demainLinkFunc(); }
let TreeChangeFunc = () => { demainLinkFunc(); }

let SearchEnterFunc = () => {
    let searchContent = $('#searchContent')[0].value;
    demainLinkFunc();
}

let SearchChangeFunc = (e) => {
    if (e.key == 'Enter') { SearchEnterFunc(); }
}

let demainLinkFunc = () => {
    let selectedPlan = $('#select_plan')[0].value;
    let selectedTree = $('#select_tree')[0].value;
    let searchContent = $('#searchContent')[0].value;
    let url = base_url + 'newsletter/';

    if (selectedPlan && selectedPlan != 'all') {
        url += selectedPlan;
        if (selectedPlan == 1 && selectedTree != 'all') { url += '/' + selectedTree; }
    }
    if (selectedPlan == 1) $('#select_tree').parent()[0].style.display = 'block';
    else $('#select_tree').parent()[0].style.display = 'none';

    if (searchContent) { url += '?searchContent=' + searchContent; }
    location.href = url;
}

let NewsUserAllSelFunc = (element) => {
    let checkState = element.checked;

    let usersEL = $('.NewsUsersSelect');
    if (usersEL.length) {
        for (let index = 0; index < usersEL.length; index++) {
            let childEL = usersEL[index];
            childEL.checked = checkState;
        }
    }
    if (checkState) $('#newsLetterSubmitBtn')[0].style.backgroundColor = '#3cab85';
    else $('#newsLetterSubmitBtn')[0].style.backgroundColor = '#a3a3a3';
}
let NewsUsersSelFunc = (element) => {
    let checkedCount = 0;

    let usersEL = $('.NewsUsersSelect');
    if (usersEL.length) {
        for (let index = 0; index < usersEL.length; index++) {
            let childEL = usersEL[index];
            if (childEL.checked) checkedCount++;
        }
    }

    if (usersEL.length == checkedCount) $('.newsAllUserSelect')[0].checked = true;
    else $('.newsAllUserSelect')[0].checked = false;
    if (checkedCount) $('#newsLetterSubmitBtn')[0].style.backgroundColor = '#3cab85';
    else {
        $('#newsLetterSubmitBtn')[0].style.backgroundColor = '#a3a3a3';
        $('.newsAllUserSelect')[0].checked = false;
    }
}

let GetNewsUserID = () => {
    let checkedCount = 0;
    let NewsUserEmails = [];

    let usersEL = $('.NewsUsersSelect');
    if (usersEL.length) {
        for (let index = 0; index < usersEL.length; index++) {
            let childEL = usersEL[index];
            if (childEL.checked) {
                checkedCount++;
                let UserId = $(childEL).data('id');
                if (UserId) NewsUserEmails.push(UserId);
            }
        }
    }

    if (checkedCount) {
        return NewsUserEmails;
    } else {
        if (usersEL.length) {
            $.growl.warning(
                { message: 'Please Select User' },
                { position: { from: "bottom", align: "left" } }
            )
        } else {
            $.growl.error(
                { message: 'Users not exist' },
                { position: { from: "bottom", align: "left" } }
            )
        }
        return false;
    }
}

$("#newsLetterForm").validate({
    rules: {
        subtitle: { required: true, },
        content: { required: true, },
        attachfile: { extension: "pdf|jpeg|txt|word|jpg|png" }
    },
    messages: {
        subtitle: { required: "please input news subtitle", },
        content: { required: "please input news content", },
        attachfile: { required: 'file extensions only PDF and JPEG and TXT and Word' }
    },
    submitHandler: function (form, event) {
        event.preventDefault();
        let usersID = GetNewsUserID();
        let subtitle = $('#news_subtitle').val();
        let content = CKEDITOR.instances['news_content'].getData();

        if (!subtitle) subtitle = '';
        if (!content) content = '';

        if (usersID && usersID.length > 0 && content && content.length > 0) {
            let form_data = new FormData();
            form_data.append('subtitle', subtitle);
            form_data.append('content', content);
            form_data.append('usersID', usersID.join('@@'));
            if ($('#news_attachfile')[0].files[0]) form_data.append('file', $('#news_attachfile')[0].files[0]);

            $.ajax({
                url: base_url + "sendNewsLetter",
                type: "POST",
                data: form_data,
                processData: false,
                contentType: false,
                cache: false,
                enctype: 'multipart/form-data',
                beforeSend: function () { start_loader(); },

                success: function (res) {
                    stop_loader();
                    if (!res) return;

                    res = JSON.parse(res);
                    if (res.state) {
                        $.growl.notice(
                            { message: res.message },
                            { position: { from: "bottom", align: "left" } }
                        )
                    } else {
                        $.growl.error(
                            { message: res.message },
                            { position: { from: "bottom", align: "left" } }
                        )
                    }
                },
                error: function (error) {
                    stop_loader();

                    $.growl.error(
                        { message: 'Error occured while sending Email' },
                        { position: { from: "bottom", align: "left" } }
                    )
                }
            })
            return false;
        }
    }
});
// NewsLetter CommonFunc End

// SMTP server commonfunc Start
$('#SMTPserver').validate({
    rules: {
        host: { required: true, },
        user: { required: true, },
        pass: { required: true, },
        port: { required: true, },
        sender: { required: true, }
    },
    messages: {
        host: { required: "please input smtp server host name", },
        user: { required: "please input smtp server user address", },
        pass: { required: 'please input smtp server pass' },
        port: { required: 'please input smtp server port' },
        sender: { required: 'please input smtp server email sender address' },
    },
    submitHandler: function (form, event) {
        event.preventDefault();
        let form_data = new FormData(form);
        $.ajax({
            url: base_url + "smtp_server_set",
            type: "POST",
            data: form_data,
            processData: false,
            contentType: false,
            cache: false,
            enctype: 'multipart/form-data',
            beforeSend: function () { start_loader(); },
            success: function (res) {
                stop_loader();
                if (!res) return;
                res = JSON.parse(res);
                console.log(res)
                if (res.state) {
                    $.growl.notice(
                        { message: res.message },
                        { position: { from: "bottom", align: "left" } }
                    )
                } else {
                    $.growl.error(
                        { message: res.message },
                        { position: { from: "bottom", align: "left" } }
                    )
                }
            },
            error: function (error) {
                stop_loader();
                $.growl.error(
                    { message: 'SMTP server setting error' },
                    { position: { from: "bottom", align: "left" } }
                )
            }
        })
        return false;
    }
})
// SMTP server commonfunc End