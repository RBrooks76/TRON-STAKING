

$.validator.addMethod("customemail",
  function (value, element) {
    return /^\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/.test(value);
  },
  "Please Enter a Valid email address"
);

$.validator.addMethod("checkpw",
  function (value, element) {
    return /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,20}$/.test(value);
  },
  "Password Must Contain Atleast Oneuppercase, Atleast Onelowercase, ATleast Onenumber, Atleast One Special Character and Length of 8"
);

$('#site_settings').validate({
  rules: {
    site_name: { required: true },
    site_email: { required: true },
    contactno: { number: true, required: true },
    altcontactno: { number: true, },
    country: { required: true },
    state: { required: true, },
    city: { required: true, },
    address: { required: true, },
    facebooklink: { required: true, },
    twitterlink: { required: true, },
    googlelink: { required: true, },
    youtubelink: { required: true, },
    telegramlink: { required: true, },
    android_app_link: { required: true, },
    ios_app_link: { required: true, },
    x_gas_limit: { required: true, },
    y_gas_limit: { required: true, },
    // site_logo: { required: true, },
    // fav_icon: { required: true },
    copyright: { required: true, },
  },
  highlight: function (element) {
    //$(element).parent().addClass('error')
  },
  unhighlight: function (element) { $(element).parent().removeClass('error') }
});



$('#profile_form').validate({
  rules: {
    email: { required: true },
    fname: { required: true },
    lname: { required: true, },
    // admin_img: { required   : true, },
    phone_no: { required: true, number: true },
  },
  highlight: function (element) {
    //$(element).parent().addClass('error')
  },
  unhighlight: function (element) { $(element).parent().removeClass('error') }
});



$('#change_pass').validate({
  rules: {
    cpass: {
      required: true,
      remote: {
        url: base_url + 'check_pass',
        type: "post",
        data: {
          old_password: function () {
            return $("#cpass").val();
          }
        }
      },
    },
    npass: { required: true, minlength: 6 },
    cnpass: { required: true, equalTo: '#npass' }
  },
  messages: { cpass: { remote: "Enter Correct Password", } },
  highlight: function (element) {
    //$(element).parent().addClass('error')
  },
  unhighlight: function (element) { $(element).parent().removeClass('error') }
});



$('#level_password_one').validate({
  rules: {
    levelPasswrd: {
      required: true,
      remote: {
        url: base_url + 'en/levelPassCheck',
        type: "post",
        data: {
          levelid: function () {
            return 1;
          }
        }
      },
    },
    npass: { required: true, minlength: 6 },
    cnpass: { required: true, equalTo: '#npass' }
  },
  messages: {
    levelPasswrd: { remote: "Old Password Wrong", },
    cnpass: { equalTo: "New and confirm password should be same." }
  },
  highlight: function (element) {
    //$(element).parent().addClass('error')
  },
  unhighlight: function (element) { $(element).parent().removeClass('error') }
});

$('#level_password_two').validate({
  rules: {
    levelPasswrd: {
      required: true,
      remote: {
        url: base_url + 'en/levelPassCheck',
        type: "post",
        data: {
          levelid: function () {
            return 16;
          }
        }
      },
    },
    npass: { required: true, minlength: 6 },
    cnpass: { required: true, equalTo: '#tcnpass' }
  },
  messages: {
    levelPasswrd: { remote: "Old Password Wrong", },
    cnpass: { equalTo: "New and confirm password should be same." }
  },
  highlight: function (element) {
    //$(element).parent().addClass('error')
  },
  unhighlight: function (element) { $(element).parent().removeClass('error') }
});



$('#edit_email').validate({
  ignore: [],
  debug: false,
  rules: {
    name: { required: true },
    subject: { required: true },
    language: { required: true, },
    content_description: {
      required: function () {
        CKEDITOR.instances.content_description.updateElement();
      }
    },
  },
  highlight: function (element) {
    //$(element).parent().addClass('error')
  },
  unhighlight: function (element) { $(element).parent().removeClass('error') }
});

$('#edit_cms').validate({
  ignore: [],
  debug: false,
  rules: {
    heading: { required: true },
    title: { required: true },
    meta_keyword: { required: true, },
    meta_description: { required: true, },
    link: { required: true, },
    joinLink: { required: true, },
    language: { required: true, },
    content_description: {
      required: function () {
        CKEDITOR.instances.content_description.updateElement();
      }
    },
  },
  highlight: function (element) {
    //$(element).parent().addClass('error')
  },
  unhighlight: function (element) { $(element).parent().removeClass('error') }
});

$('#edit_faq').validate({
  rules: {
    question: { required: true },
    answer: { required: true },
    status: { required: true, },
    language: { required: true, },
  },
  highlight: function (element) {
    //$(element).parent().addClass('error')
  },
  unhighlight: function (element) { $(element).parent().removeClass('error') }
});


$('#add_faq').validate({
  rules: {
    addquestion: { required: true, },
    addanswer: { required: true },
    addstatus: { required: true, },
    addlanguage: { required: true, },
  },
  highlight: function (element) {
    //$(element).parent().addClass('error')
  },
  unhighlight: function (element) { $(element).parent().removeClass('error') }
});



$('#homecontent').validate({
  rules: {
    smart_head_one: { required: true },
    smart_head_two: { required: true },
    how_work_one: { required: true },
    how_work_two: { required: true },
    adv_tech_one: { required: true },
    adv_tech_two: { required: true },
    market_plan_one: { required: true },
    market_plan_two: { required: true },
    reg_page_one: { required: true },
    reg_page_two: { required: true },
    adv_tech_1: { required: true },
    adv_tech_2: { required: true },
    adv_tech_logo: { extension: "jpg|png|jpeg" },
    footer_content_1: { required: true },
    footer_content_2: { required: true },
    footer_content_logo: { extension: "jpg|png|jpeg" },
    footer_link_1: { required: true },
    footer_link_2: { required: true },
    embeed_code: { required: true },
    joinLink: { required: true },
  },
  highlight: function (element) {
    //$(element).parent().addClass('error')
  },
  unhighlight: function (element) { $(element).parent().removeClass('error') }
});



$('#homecontent_sp').validate({
  rules: {
    smart_head_one_sp: { required: true },
    smart_head_two_sp: { required: true },
    how_work_one_sp: { required: true },
    how_work_two_sp: { required: true },
    adv_tech_one_sp: { required: true },
    adv_tech_two_sp: { required: true },
    market_plan_one_sp: { required: true },
    market_plan_two_sp: { required: true },
    reg_page_one_sp: { required: true },
    reg_page_two_sp: { required: true },
  },
  highlight: function (element) {
    //$(element).parent().addClass('error')
  },
  unhighlight: function (element) { $(element).parent().removeClass('error') }
});


$('#edit_work').validate({
  rules: {
    content: { required: true, },
    long_content: { required: true, },
    heading: { required: true, },
    language: { required: true, },
  },
  highlight: function (element) {
    //$(element).parent().addClass('error')
  },
  unhighlight: function (element) { $(element).parent().removeClass('error') }
});

$('#edit_address').validate({
  rules: {
    heading: { required: true },
    address_name: { required: true },
    banner_img: { extension: "gif|jpg|png|jpeg" },
    // language: { required   : true, }, 
  },
  highlight: function (element) {
    //$(element).parent().addClass('error')
  },
  unhighlight: function (element) { $(element).parent().removeClass('error') }
});



$('#add_banner').validate({
  rules: {
    addtitle: { required: true, },
    addlink: { required: true },
    addstatus: { required: true, },
    addlanguage: { required: true, },
    addbanner_img: { required: true, extension: "gif|jpg|png|jpeg" },
  },
  highlight: function (element) {
    //$(element).parent().addClass('error')
  },
  unhighlight: function (element) { $(element).parent().removeClass('error') }
});

$('#edit_banner').validate({
  rules: {
    title: { required: true, },
    link: { required: true },
    status: { required: true, },
    language: { required: true, },
  },
  highlight: function (element) {
    //$(element).parent().addClass('error')
  },
  unhighlight: function (element) { $(element).parent().removeClass('error') }
});



$('#edit_video').validate({
  rules: {
    title: { required: true, },
    link: { required: true },
    code: { required: true },
    status: { required: true, },
    language: { required: true, },
  },
  highlight: function (element) {
    //$(element).parent().addClass('error')
  },
  unhighlight: function (element) { $(element).parent().removeClass('error') }
});

$('#add_video').validate({
  rules: {
    addtitle: { required: true, },
    addlink: { required: true },
    addcode: { required: true },
    addstatus: { required: true, },
    addlanguage: { required: true, },
  },
  highlight: function (element) {
    //$(element).parent().addClass('error')
  },
  unhighlight: function (element) { $(element).parent().removeClass('error') }
});


$('#edit_presen').validate({
  rules: {
    title: { required: true, },
    presen_img: { extension: "gif|jpg|png|jpeg" },
    presen_doc: { extension: "doc|pdf|docx|ppt" },
    status: { required: true, },
    language: { required: true, },
  },
  highlight: function (element) {
    //$(element).parent().addClass('error')
  },
  unhighlight: function (element) { $(element).parent().removeClass('error') }
});

$('#add_presen').validate({
  rules: {
    addtitle: { required: true, },
    addstatus: { required: true, },
    addpresen_img: { required: true, extension: "gif|jpg|png|jpeg" },
    addpresen_doc: { required: true, extension: "doc|pdf|docx|ppt" },
    addlanguage: { required: true, },
  },
  highlight: function (element) {
    //$(element).parent().addClass('error')
  },
  unhighlight: function (element) { $(element).parent().removeClass('error') }
});



$('#edit_text').validate({
  ignore: [],
  debug: false,
  rules: {
    title: { required: true },
    status: { required: true },
    language: { required: true, },
    content_description: {
      required: function () { CKEDITOR.instances.content_description.updateElement(); }
    },
  },
  highlight: function (element) {
    //$(element).parent().addClass('error')
  },
  unhighlight: function (element) { $(element).parent().removeClass('error') }
});

$('#add_text').validate({
  ignore: [],
  debug: false,
  rules: {
    addtitle: { required: true },
    addstatus: { required: true },
    addlanguage: { required: true, },

    content_description_add: {
      required: function () { CKEDITOR.instances.content_description_add.updateElement(); }
    },
  },
  highlight: function (element) {
    //$(element).parent().addClass('error')
  },
  unhighlight: function (element) { $(element).parent().removeClass('error') }
});



$('#edit_doc').validate({
  ignore: [],
  debug: false,
  rules: {
    title: { required: true },
    doc: {
      extension: "pdf|rtf|doc|docx|txt|jpeg|png",
    },
    language: { required: true, },
    content_description: {
      required: function () { CKEDITOR.instances.content_description.updateElement(); }
    },
  },
  highlight: function (element) {
    //$(element).parent().addClass('error')
  },
  unhighlight: function (element) {
    $(element).parent().removeClass('error')
  }
});

$('#add_doc').validate({
  ignore: [],
  debug: false,
  rules: {
    title: { required: true },
    language: { required: true, },
    doc: {
      required: true,
      extension: "pdf|rtf|doc|docx|txt|jpeg|png",
    },
    content_description: {
      required: function () { CKEDITOR.instances.content_description.updateElement(); }
    },
  },
  highlight: function (element) {
    //$(element).parent().addClass('error')
  },
  unhighlight: function (element) {
    $(element).parent().removeClass('error')
  }
});


$('#change_pattern').validate({
  ignore: [],
  debug: false,
  rules: {
    con_password: { required: true },
    // new_pattern: { required: true },
    // old_pattern: { required: true },
  },
  highlight: function (element) {
    //$(element).parent().addClass('error')
  },
  unhighlight: function (element) {
    $(element).parent().removeClass('error')
  }
});



$('#add_user').validate({
  rules: {
    contactid: {
      required: true,
      number: true
    },
    refferalid: {
      required: true,
      number: true
    },
    addstatus: {
      required: true,
    },

  },

  submitHandler: function (form) {

    $('#modalcontract').text($('#contactid').val());
    $('#modalrefferal').text($('#refferalid').val());
    var e = document.getElementById("addstatus");
    var result = e.options[e.selectedIndex].value;
    if (result == '1') {
      var val = 'Active';
    }
    else {
      var val = "Deactive";
    }
    $('#modalstatus').text(val);
    $("#default").modal("show");

    $('#savedata').click(function () {
      $("#default").modal("hide");
      $.ajax({
        url: $(form).action,
        method: 'POST',
        data: $(form).serialize(),
        success: function (data) {
          if (data == '1') {
            $('.alert alert-success').html('User Added Successfully');
            window.location.href = base_url + 'user';
          }
          else {
            window.location.href = base_url + 'user';
          }

        }
      })
    });


  },

  highlight: function (element) {
    //$(element).parent().addClass('error')
  },
  unhighlight: function (element) {
    $(element).parent().removeClass('error')
  }


});



$('#edit_ip').validate({
  rules: {
    ipaddress: {
      required: true,
    },
    status: {
      required: true,
    }
  },
  highlight: function (element) {
    //$(element).parent().addClass('error')
  },
  unhighlight: function (element) {
    $(element).parent().removeClass('error')
  }

});

$('#add_ip').validate({
  rules: {
    addipaddress: {
      required: true,
    },
    addstatus: {
      required: true,
    }
  },

  highlight: function (element) {
    //$(element).parent().addClass('error')
  },
  unhighlight: function (element) {
    $(element).parent().removeClass('error')
  }

});

$('#edit_why').validate({
  rules: {
    heading: {
      required: true,
    },
    icon: {

      extension: "gif|jpg|png|jpeg"
    }

  },
  highlight: function (element) {
    //$(element).parent().addClass('error')
  },
  unhighlight: function (element) {
    $(element).parent().removeClass('error')
  }


});



$('#add_review').validate({
  rules: {
    addtitle: {
      required: true,
    },

    addstatus: {
      required: true,
    },
    addreview_img: {
      required: true,
      extension: "gif|jpg|png|jpeg"
    },
    addlanguage: {
      required: true,
    },


  },
  highlight: function (element) {
    //$(element).parent().addClass('error')
  },
  unhighlight: function (element) {
    $(element).parent().removeClass('error')
  }


});

$('#edit_review').validate({
  rules: {
    title: {
      required: true,
    },
    url_value: {
      required: true,
    },
    language: {
      required: true,
    },
    status: {
      required: true,
    },

    review_img: {
      extension: "gif|jpg|png|jpeg"
    },



  },
  highlight: function (element) {
    //$(element).parent().addClass('error')
  },
  unhighlight: function (element) {
    $(element).parent().removeClass('error')
  }


});



$('#edit_plan').validate({
  rules: {
    plan_name: {
      required: true,
    },
    plan_type: {
      required: true,
    },
    receive: {
      required: true,
    },
    return_amt: {
      required: true,
    },
    days: {
      required: true,
    },
    min_deposit: {
      required: true,
    },
    max_withdraw: {
      required: true,
    },
    status: {
      required: true,
    },
    language: {
      required: true,
    },
    withdraw_happen: {
      required: true,
    }
  },

  highlight: function (element) {
    //$(element).parent().addClass('error')
  },
  unhighlight: function (element) {
    $(element).parent().removeClass('error')
  }

});

$('#edit_plana').validate({
  rules: {
    plan_name_a: {
      required: true,
    },
    language_a: {
      required: true,
    },
    plan_type_a: {
      required: true,
    },
    amount: {
      required: true,
    }
  },

  highlight: function (element) {
    //$(element).parent().addClass('error')
  },
  unhighlight: function (element) {
    $(element).parent().removeClass('error')
  }

});



$('#add_subadmin').validate({
  ignore: [],
  debug: false,
  rules: {
    name: {
      required: true
    },
    email: {
      required: true,
      email: true,
      customemail: true,
      remote: {
        url: base_url + "adduser_email_exists",
        type: "post",
        data: {
          email: function () {
            return $("#email").val();
          }
        }
      }
    },
    password: {
      required: true,
      checkpw: true
    },
    "access_options[][view]": {
      required: true
    },
    status: {
      required: true,
    },

    content_description: {
      required: function () {
        CKEDITOR.instances.content_description.updateElement();
      }
    },
  },
  highlight: function (element) {
    //$(element).parent().addClass('error')
  },
  unhighlight: function (element) {
    $(element).parent().removeClass('error')
  }


});

$('#edit_subadmin').validate({
  ignore: [],
  debug: false,
  rules: {
    name: {
      required: true
    },
    email: {
      required: true,
      email: true,
      customemail: true,
      remote: {
        url: base_url + "edituser_email_exists",
        type: "post",
        data: {
          email: function () {
            return $("#email").val();
          },
          id: function () {
            return $("#val").val();
          }
        }
      }
    },
    password: {
      required: true,
      checkpw: true
    },
    "access_options[][view]": {
      required: true
    },
    status: {
      required: true,
    },

    content_description: {
      required: function () {
        CKEDITOR.instances.content_description.updateElement();
      }
    },
  },
  highlight: function (element) {
    //$(element).parent().addClass('error')
  },
  unhighlight: function (element) {
    $(element).parent().removeClass('error')
  }


});