String.format = function() {
    var s = arguments[0];
    for (var i = 0; i < arguments.length - 1; i += 1) {
        var reg = new RegExp('\\{' + i + '\\}', 'gm');
        s = s.replace(reg, arguments[i + 1]);
    }
    return s;
};
$(document).ready(function() {
    /* Doctor */
    $('#dfm').validate({
        rules: {
            dusername: {
                remote: {
                    url: /*location.protocol + '//' + */ location.host + '/ajax/register.php',
                    type: "post",
                    data: {
                        check: true,
                        username: $("#dusername").val() /*return*/
                    },
                    dataType: 'json',
                    success: function(data) {
                        if (data.responseText != "success") {
                            alert(data.responseText);
                            //handle failed validation
                        }
                        alert(1);
                        if (data.username === true) {
                            message: {
                                dusername: 'The username is already in use!'
                            }
                        }
                    }
                }
                /*,
                required: true*/
            },
            demail: {
                required: true,
                email: true
            },
            dpassword: {
                required: true,
                minlength: 7,
                equalTo: "#dcpassword"
            },
            dcpassword: {
                required: true,
                minlength: 7,
                equalTo: "#dpassword"
            },
            dqavanin: {
                required: true
            },
            dsnr: {
                required: true,
                number: true,
                minlength: 5,
                maxlength: 5
            }
        },
        messages: {
            dusername: "نام کاربری خود را وارد کنید",
            demail: "لطفا پست‌الکترونیکی خود را وارد کنید",
            dsnr: "لطفا شماره نظام روانشناسی خود را وارد کنید",
            dpassword: {
                required: "رمز عبور خود را وارد کنید",
                minlength: String.format("رمز عبور باید بیشتر از {0} رقم باشد"),
                equalTo: "رمز عبور و تکرار آن مطابقت ندارد"
            },
            dcpassword: {
                required: "تکرار رمز عبور خود را وارد کنید",
                minlength: String.format("رمز عبور باید بیشتر از {0} رقم باشد"),
                equalTo: "رمز عبور و تکرار آن مطابقت ندارد"
            },
            dqavanin: "لطفا قوانین را مطالعه کنید"
        }
    });
    $("#drubm").click(function() {
        $.ajax({
            type: "POST",
            url: '/ajax/register.php',
            data: {
                email: $("input[name=demail]").val(),
                username: $("input[name=dusername]").val(),
                password: $("input[name=dpassword]").val(),
                cpassword: $("input[name=dcpassword]").val(),
                snr: $("input[name=dsnr]").val(),
                qavanin: $("input[name=dqavanin]").val()
            },
            success: function(result) {
                $("#er").html(result);
            },
            error: function (request, status, error) {
            }
        });
    });
    /* Doctor */
    /* User */
    $('#fm').validate({
        rules: {
            username: {
                required: true
                /*,
                remote: {
                    url: "check-email.php",
                    type: "post",
                    data: {
                      username: function() {
                        return $("#username").val();
                      }
                    }
                }*/
            },
            email: {
                required: true,
                email: true
            },
            password: {
                required: true,
                minlength: 7,
                equalTo: "#cpassword"
            },
            cpassword: {
                required: true,
                minlength: 7,
                equalTo: "#password"
            },
            qavanin: {
                required: true
            }
        },
        messages: {
            username: "نام کاربری خود را وارد کنید",
            email: "لطفا پست‌الکترونیکی خود را وارد کنید",
            password: {
                required: "رمز عبور خود را وارد کنید",
                minlength: String.format("رمز عبور باید بیشتر از {0} رقم باشد"),
                equalTo: "رمز عبور و تکرار آن مطابقت ندارد"
            },
            cpassword: {
                required: "تکرار رمز عبور خود را وارد کنید",
                minlength: String.format("رمز عبور باید بیشتر از {0} رقم باشد"),
                equalTo: "رمز عبور و تکرار آن مطابقت ندارد"
            },
            qavanin: "لطفا قوانین را مطالعه کنید"
        }
    });
    $("input[name=usubm]").click(function() {
        $.ajax({
            url: '/ajax/register.php',
            type: "POST",
            data: {
                isdr: 0,
                email: $("input[name=email]").val(),
                username: $("input[name=username]").val(),
                password: $("input[name=password]").val(),
                cpassword: $("input[name=cpassword]").val(),
                qavanin: $("input[name=qavanin]").val()
            },
            success: function(result) {
                $("#er").html(result);
            }
        });
    });
    /* User */
});