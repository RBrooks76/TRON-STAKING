
$.validator.addMethod("customemail", 
    function(value, element) {
        return /^\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/.test(value);
    }, 
    "Valid email is required"
);

$.validator.addMethod("pwcheck", function(value) {
  return /^[A-Za-z0-9\d=!\-@._*]*$/.test(value) && /[a-z]/.test(value) && /\d/.test(value) && /[A-Z]/.test(value);
},'Password Must contain One uppercase, One Lowercase, One Symbol , One number');


$.validator.addMethod("checkpw", 
    function(value, element) {
        return /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!#%*?&]{8,20}$/.test(value);
    }, 
    "Password Must Contain Atleast Oneuppercase, Atleast Onelowercase, ATleast Onenumber, Atleast One Special Character and Min Length of 8"
);

$('.login_form').validate({
    errorElement: 'label', //default input error message container
    errorClass: 'help-inline', // default input error message class
    focusInvalid: false, // do not focus the last invalid input
    rules: {
        email: {
            required: true
        },
        password: {
            required: true
        },
        remember: {
            required: false
        },
        pattern: {
            required: true,
        }, 
    },
    messages: {
        email: {
            required: "Email is required"
        },
        password: {
            required: "Password is required"
        },
    },
    submitHandler: function(form)
    {
        var chk_pattern = $('#pattern').val().length;

        if(chk_pattern==0)
        {
            $('#pattern-error').css('display','block');
            $('#pattern-error').show();
        }
        else
        {
            var data    =   $("#login_form").serialize();
            //alert(data);
            //$('#login_button').css('cursor', 'pointer');
            //$("#login_button").html('<span class="fa fa-spinner fa-spin"></span> Please wait...');
            //$('.preloader').show();

            form.reset();

            $.ajax({
                type : "POST",
                url  :  base_url+'authenticate',
                data :  data,
                dataType :  "json",
                success: function(response)
                {
                    if(response.status==0)
                    {
                        $('#show_msg').addClass("alert alert-danger");

                        $('#show_msg').html(response.message);

                        //$("#login_button").html('Login');
                    }
                    else if(response.status==1)
                    {
                        location.href = base_url+response.link;
                    }
                }
            })
        }
    }
});

$(".login_form").submit(function(){

    var chk_pattern = $('#pattern').val().length;

    if(chk_pattern==0)
    {
        $('#pattern-error').show();
        $('#pattern-error').html('Pattern is required');
    }
    else
    {
       // $(".login_form").submit();
    }
})

$('.forget-form').validate({
    errorElement: 'label', //default input error message container
    errorClass: 'help-inline', // default input error message class
    focusInvalid: false, // do not focus the last invalid input
    rules: {
        email: {
            required: true,
            email:true
        },
    },
    messages: {
        email: {
            required: "Email is required"
        },
    },
    submitHandler: function(form)
    {
        var chk_pattern = $('#pattern').val().length;

        if(chk_pattern==0)
        {
            $('#pattern-error').show();
        }
        else
        {
            form.submit();
        }
    }
})

$('.pattern-form').validate({
    errorElement: 'label', //default input error message container
    errorClass: 'help-inline', // default input error message class
    focusInvalid: false, // do not focus the last invalid input
    rules: {
        password: {
            required: true,
        },
    },
    submitHandler: function(form)
    {
        var chk_pattern = $('#pattern').val().length;

        if(chk_pattern==0)
        {
            $('#pattern-error').show();
        }
        else
        {
            form.submit();
        }
    }
})

$(".pattern-form").submit(function(){

    var chk_pattern = $('#pattern').val().length;

    if(chk_pattern==0)
    {
        $('#pattern-error').show();
    }
    else
    {
        form.submit();
    }
})
           

 $('#forgot-pass').validate({
     errorElement: 'label', //default input error message container
    errorClass: 'help-inline', // default input error message class
    focusInvalid: false, // do not focus the last invalid input
  rules: {
    email: {
      required: true,
      email:true,
      customemail:true
    },

  },
    highlight: function (element) {
//$(element).parent().addClass('error')
},
unhighlight: function (element) {
  $(element).parent().removeClass('error')
}


});

 $('#reset-password').validate({
 
  rules: {
    newpass: {
      required: true,
      checkpw:true
      
    },
    confirmpass: {
      required: true,
      equalTo: '#newpass'
      
    },

  },
  messages: {
        confirmpass: {
            equalTo: "Confirm Password Should be same to New password"
        },
    },
    highlight: function (element) {
//$(element).parent().addClass('error')
},
unhighlight: function (element) {
  $(element).parent().removeClass('error')
}


});