$(document).ready(function() {
$("html, body").animate({ scrollTop: 0 }, "slow");
// init
$('.datepicker').persianDatepicker({
            persianDigit: false,
            initialValue: false,
            format: 'YYYY/MM/DD'
        });
jQuery.validator.addMethod("isValidIranianNationalCode", function (input) {
    if (!/^\d{10}$/.test(input))
        return false;
    var check = parseInt(input[9]);
    var sum = 0;
    var i;
    for (i = 0; i < 9; ++i) {
        sum += parseInt(input[i]) * (10 - i);
    }
    sum %= 11;
    return (sum < 2 && check == sum) || (sum >= 2 && check + sum == 11);
}, "شماره ملی شما معتبر نمی باشد");
jQuery.validator.addMethod("isDJalali", function (value, element, param) {
    var r = toEnglishDate(value);
    r = validateDate(toEnglishDate(value));
    return (r);
}, "a");
//    validation
    //step 1
    $('#step1-form').validate({
        rules: {
            s1email: {
                required: true,
                email: true
            },
            s1fname: {
                required: true
            },
            s1name: {
                required: true
            },
            s1bday: {
                required: true,
                isDJalali: true
            },
            s1cid: {
                required: true
            },
            s1nid: {
                required: true,
                minlength: 10,
                maxlength: 10,
                isValidIranianNationalCode: true
            },
            s1gen: {
                required: true
            },
            s1user: {
                required: true
            }
        },
        messages: {
            s1name: "نام خود را وارد کنید",
            s1fname: "نام‌خانوادگی خود را وارد کنید",
            s1gen: "لطفا جنسیت خود را مشخص کنید",
            s1nid: "لطفا کد ملی خود را وارد کنید",
            s1cid: "لطفا شماره شناسنامه را وارد کنید",
            s1bday: "لطفا تاریخ تولد خود را وارد کنید"
        }
});
    $('#s1btn').on('click', function (e) {
        e.preventDefault();
        if ($("#step1-form").valid()) {
            $("html, body").animate({ scrollTop: 0 }, "slow");
            var dataf = $('#step1-form').serializeArray();
            dataf.push({name: 'token', value: ""});
            dataf.push({name: 'w', value: "1"});
            $.ajax({
                type: "POST",
                dataType : 'json',
                url: '/ajax/wizard.php',
                data: dataf,
                success: function(result) {
                    if (result.a === "success") {
                        var $active = $('.wizard .nav-tabs li.active');
                        $active.next().removeClass('disabled');
                        nextTab($active);
                    } else {
                        var $elm = $("<div class=\"alert alert-"+ result.a +"\"><strong>"+ result.b +"</strong></div><br />");
                        $("#could_pass").html($elm);
                        setTimeout(function() {
                                    $elm.remove();
                                }, 5000);
                    }
                }
            });
        }
    });
        //step 2
    $('#step2-form').validate({
        rules: {
            s2f1mal: {
                required: true
            },
            s2f2mal: {
                required: true
            }
        },
        messages: {
            s2f1mal: "لطفا تمام فیلدها را پرکنید",
            s2f2mal: "لطفا تمام فیلدها را پرکنید"
        }
});
    $('#s2btn').on('click', function (e) {
        e.preventDefault();
        if ($("#step2-form").valid()) {
            $("html, body").animate({ scrollTop: 0 }, "slow");
            var dataf = $('#step2-form').serializeArray();
            dataf.push({name: 'token', value: ""});
            dataf.push({name: 'w', value: "2"});
            $.ajax({
                type: "POST",
                dataType : 'json',
                url: '/ajax/wizard.php',
                data: dataf,
                success: function(result) {
                    if (result.a === "success") {
                        var $active = $('.wizard .nav-tabs li.active');
                        $active.next().removeClass('disabled');
                        nextTab($active);

                    } else {
                        var $elm = $("<div class=\"alert alert-"+ result.a +"\"><strong>"+ result.b +"</strong></div><br />");
                        $("#could_pass").html($elm);
                        setTimeout(function() {
                                    $elm.remove();
                                }, 5000);
                    }
                }

            });
        }
    });
        //step 3
    $('#step3-form').validate({
        rules: {
            s3f1u: {
                required: true
            }
        },
        messages: {
            s3f1u: "لطفا تحصیلات خود را وارد کنید"
        }
});
    $('#s3btn').on('click', function (e) {
        e.preventDefault();
        if ($("#step3-form").valid()) {
            $("html, body").animate({ scrollTop: 0 }, "slow");
            var dataf = $('#step3-form').serializeArray();
            dataf.push({name: 'token', value: ""});
            dataf.push({name: 'w', value: "3"});
            $.ajax({
                type: "POST",
                dataType : 'json',
                url: '/ajax/wizard.php',
                data: dataf,
                success: function(result) {
                    if (result.a === "success") {
                        var $active = $('.wizard .nav-tabs li.active');
                        $active.next().removeClass('disabled');
                        nextTab($active);
                    } else {
                        var $elm = $("<div class=\"alert alert-"+ result.a +"\"><strong>"+ result.b +"</strong></div><br />");
                        $("#could_pass").html($elm);
                        setTimeout(function() {
                                    $elm.remove();
                                }, 5000);
                    }
                }
            });
        }
    });


    //step 4
    $.validator.addMethod('filesize', function (value, element, param) {
        return this.optional(element) || (element.files[0].size <= param)
    }, 'حجم فایل باید کمتر از {0}kb باشد.');
    jQuery.validator.addMethod("phoneValid", function(value, element, param) {
      var re = /\(?([0-9]{3})\)?([ .-]?)([0-9]{3})\2([0-9]{4})/;
      return this.optional( element ) || re.test( value );
    }, "لطفا شماره خود را بررسی کنید");
$('#step4-form').validate({
    rules: {
        fileupload: {
            required: true,
            extension: "jpg,jpeg",
            filesize: 200000,
        },
        s4phone: {
            required: true,
            phoneValid: true,
            minlength:11,
            maxlength:11
        },
        s4province: {
            required: true
        },
        s4city: {
            required: true
        },
        s4addr: {
            required: true
        },
        s4post: {
            required: true
        }
    },
    messages: {
      fileupload: "لطفا عکس خود را وارد کنید",
      s4phone: "لطفا شماره خود را وارد کنید",
      s4province: "لطفا استان خود را وارد کنید",
      s4city: "لطفا شهر خود را وارد کنید",
      s4addr: "لطفا آدرس خود را وارد کنید",
      s4post: "لطفا کدپستی خود را وارد کنید",
    }
});
$('#s4btn').on('click', function (e) {
    e.preventDefault();
    if ($("#step4-form").valid()) {
        $("html, body").animate({ scrollTop: 0 }, "slow");
        var fd = new FormData($("#step4-form").get(0));
        $.ajax({
            type: "POST",
            data: fd,
            processData: false,
            contentType: false,
            url: '/ajax/wizard.php',
            success: function(result) {
                result = JSON.parse(result);
                if (result.a === "success") {
                    var $active = $('.wizard .nav-tabs li.active');
                    $active.next().removeClass('disabled');
                    nextTab($active);
                } else {
                    var $elm = $("<div class=\"alert alert-"+ result.a +"\"><strong>"+ result.b +"</strong></div><br />");
                    $("#could_pass").html($elm);
                    setTimeout(function() {
                                $elm.remove();
                            }, 5000);
                }
            }
        });
    }
});
    // $('input:checkbox:checked').val()
//    wizard
    //Initialize tooltips
    $('.nav-tabs > li a[title]').tooltip();

    //Wizard
    $('a[data-toggle="tab"]').on('show.bs.tab', function (e) {
        var $target = $(e.target);
        if ($target.parent().hasClass('disabled')) {
            return false;
        }
    });

    $(".prev-step").click(function (e) {
        var $active = $('.wizard .nav-tabs li.active');
        prevTab($active);
    });
    $("form").each(function(){
       if ($(this).valid()) {
         var $active = $('.wizard .nav-tabs li.active');
         $active.next().removeClass('disabled');
         nextTab($active);
       } else {
         return false;
       };
    });
function gotoTab(p) {
    for (var i = 0; i < 5; i++) {
      var $active = $('.wizard .nav-tabs li.active');
      prevTab($active);
    }
    for (var i = 1; i <= p; i++) {
      var $active = $('.wizard .nav-tabs li.active');
      $active.next().removeClass('disabled');
      nextTab($active);
    }
}
function nextTab(elem) {
    $(elem).next().find('a[data-toggle="tab"]').click();
}
function prevTab(elem) {
    $(elem).prev().find('a[data-toggle="tab"]').click();
}
//    agreement
    var agreed = false;
    $("#agreed").click(function() {
      $( "#dialog" ).dialog({
        resizable: false,
        height: "auto",
        width: 400,
        dialogClass: "alert",
        modal: true,
        closeOnEscape: false,
        open: function(event, ui) { $(".ui-dialog-titlebar-close").hide(); },
        buttons: {
          "قبول میکنم": function() {
            $("html, body").animate({ scrollTop: 0 }, "slow");
            $.ajax({
                type: "POST",
                dataType : 'json',
                url: '/ajax/wizard.php',
                data: {
                    token : "",
                    w: "5"
                },
                success: function(result) {
                    if (result.a === "success") {
                        var $elm = $("<div class=\"alert alert-success\"><strong>باتشکر</strong></div><br />");
                        $("#could_pass").html($elm);
                        setTimeout(function(){ window.location = "."; }, 1000);
                    } else {
                        var $elm = $("<div class=\"alert alert-"+ result.a +"\"><strong>"+ result.b +"</strong></div><br />");
                        $("#could_pass").html($elm);
                        setTimeout(function() {
                                    $elm.remove();
                                }, 5000);
                    }
                }
            });
            agreed = true;
            $(this).dialog("close");
          },
          "قبول نمی‌کنم!": function() {
            $( this ).dialog( "close" );
          }
        },
        beforeClose: function () {
            return agreed;
        }
      });
    });
    $("#fileupload").change(function () {
        var reader = new FileReader();

        reader.onload = function (e) {
            // get loaded data and render thumbnail.
            document.getElementById("outputimg").src = e.target.result;
        };

        // read the image file as a data URL.
        reader.readAsDataURL(this.files[0]);
    });


    $("#p-b").click(function() {
        var v = $("#p-n")[0].value.trim();
        if (v == "") return;
        var id = $("#p- label:last-child").attr("for").replace("p-", "");
        var p = '<label for="p-' + id+1 + '" class="btn btn-default child">' + v + ' <input type="checkbox" checked="checked" id="p-' + id+1 + '" class="badgebox takhasos" name="takhasos" value="' + v + '"><span class="badge">&check;</span></label>';
        $("#p- label:last-child").after(p);
	});
    $("#m-b").click(function() {
        var v = $("#m-n")[0].value.trim();
        if (v == "") return;
        var id = $("#m- label:last-child").attr("for").replace("m-", "");
        var p = '<label for="m-' + id+1 + '" class="btn btn-default child">' + v + ' <input type="checkbox" checked="checked" id="m-' + id+1 + '" class="badgebox roykard" name="roykard" value="' + v + '"><span class="badge">&check;</span></label>';
        $("#m- label:last-child").after(p);
	});

    //province
    loadprovince();
    $(".province").change(function(){
        $('.city').addClass( "pvc" );
        loadCity($(this).val());
    });


function loadprovince() {
    selectValues = {"":"","آذربایجان‌شرقی":"آذربایجان شرقی","آذربایجان‌غربی":"آذربایجان غربی","اردبیل":"اردبیل","اصفهان":"اصفهان","البرز":"البرز","ایلام":"ایلام",
        "بوشهر":"بوشهر","تهران":"تهران","چهارمحال‌و‌بختیاری":"چهارمحال و بختیاری","خراسان‌جنوبی":"خراسان جنوبی","خراسان‌رضوی":"خراسان رضوی","خراسان‌شمالی":"خراسان شمالی","خوزستان":"خوزستان",
        "زنجان":"زنجان","سمنان":"سمنان","سیستان‌و‌بلوچستان":"سیستان و بلوچستان","فارس":"فارس","قزوین":"قزوین","قم":"قم","کردستان":"کردستان",
        "کرمان":"کرمان","کرمانشاه":"کرمانشاه","کهکیلویه‌و‌بویراحمد":"کهگیلویه و بویراحمد","گلستان":"گلستان","گیلان":"گیلان","لرستان":"لرستان","مازندران":"مازندران",
        "مرکزی":"مرکزی","هرمزگان":"هرمزگان","همدان":"همدان","یزد":"یزد"};

    $.each(selectValues, function (key, value) {
        $('.province')
            .append($("<option></option>")
                .attr("value", key)
                .text(value));
    });
}

//Load city for selete
function loadCity(province){
    $(".pvc").find('option').remove();

    switch (province) {
        case "آذربایجان‌شرقی":
            var selectValues = {"آذرشهر":"آذرشهر","اسکو":"اسکو","اهر":"اهر","بستان‌آباد":"بستان‌آباد","بناب":"بناب","تبریز":"تبریز","جلفا":"جلفا","چاراویماق":"چاراویماق","سراب":"سراب","شبستر":"شبستر","عجب‌شیر":"عجب‌شیر","کلیبر":"کلیبر","مراغه":"مراغه","مرند":"مرند","ملکان":"ملکان","میانه":"میانه","ورزقان":"ورزقان","هریس":"هریس","هشترود":"هشترود"};
            break;
        case "آذربایجان‌غربی":
            var selectValues = {"ارومیه":"ارومیه","اشنویه":"اشنویه","بوکان":"بوکان","پیرانشهر":"پیرانشهر","تکاب":"تکاب","چالدران":"چالدران","خوی":"خوی","سردشت":"سردشت","سلماس":"سلماس","شاهین‌دژ":"شاهین‌دژ","ماکو":"ماکو","مهاباد":"مهاباد","میاندوآب":"میاندوآب","نقده":"نقده"};
            break;
        case "اردبیل":
            var selectValues = {"اردبیل":"اردبیل","بیله‌سوار":"بیله‌سوار","پارس‌آباد":"پارس‌آباد","خلخال":"خلخال","کوثر":"کوثر","گرمی":"گرمی","مشگین شهر":"مشگین شهر","نمین":"نمین","نیر":"نیر"};
            break;
        case "اصفهان":
            var selectValues = {"آران و بیدگل":"آران و بیدگل","اردستان":"اردستان","اصفهان":"اصفهان","برخوردار و میمه":"برخوردار و میمه","تیران و کرون":"تیران و کرون","چادگان":"چادگان","خمینی‌شهر":"خمینی‌شهر","خوانسار":"خوانسار","سمیرم":"سمیرم","شهرضا":"شهرضا","سمیرم سفلی":"سمیرم سفلی","فریدن":"فریدن","فریدون‌شهر":"فریدون‌شهر","فلاورجان":"فلاورجان","کاشان":"کاشان","گلپایگان":"گلپایگان","لنجان":"لنجان","مبارکه":"مبارکه","نائین":"نائین","نجف‌آباد":"نجف‌آباد","نطنز":"نطنز"};
            break;
        case "البرز":
            var selectValues = {"ساوجبلاغ":"ساوجبلاغ","طالقان":"طالقان","کرج":"کرج","نظرآباد":"نظرآباد"};
            break;
        case "ایلام":
            var selectValues = {"آبدانان":"آبدانان","ایلام":"ایلام","ایوان":"ایوان","دره‌شهر":"دره‌شهر","دهلران":"دهلران","شیروان و چرداول":"شیروان و چرداول","مهران":"مهران"};
            break;
        case "بوشهر":
            var selectValues = {"بوشهر":"بوشهر","تنگستان":"تنگستان","جم":"جم","دشتستان":"دشتستان","دشتی":"دشتی","دیر":"دیر","دیلم":"دیلم","کنگان":"کنگان","گناوه":"گناوه"};
            break;
        case "تهران":
            var selectValues = {"ورامین":"ورامین","فیروزکوه":"فیروزکوه","شهریار":"شهریار","شمیرانات":"شمیرانات","ری":"ری","رباط‌کریم":"رباط‌کریم","دماوند":"دماوند","تهران":"تهران","پاکدشت":"پاکدشت","اسلام‌شهر":"اسلام‌شهر"};
            break;
        case "چهارمحال‌و‌بختیاری":
            var selectValues = {"اردل":"اردل","بروجن":"بروجن","شهرکرد":"شهرکرد","فارسان":"فارسان","کوهرنگ":"کوهرنگ","لردگان":"لردگان"};
            break;
        case "خراسان‌جنوبی":
            var selectValues = {"بیرجند":"بیرجند","درمیان":"درمیان","سرایان":"سرایان","سربیشه":"سربیشه","فردوس":"فردوس","قائنات":"قائنات","نهبندان":"نهبندان"};
            break;
        case "خراسان‌رضوی":
            var selectValues = {"بردسکن":"بردسکن","تایباد":"تایباد","تربت جام":"تربت جام","تربت حیدریه":"تربت حیدریه","چناران":"چناران","خلیل‌آباد":"خلیل‌آباد","خواف":"خواف","درگز":"درگز","رشتخوار":"رشتخوار","سبزوار":"سبزوار","سرخس":"سرخس","فریمان":"فریمان","قوچان":"قوچان","کاشمر":"کاشمر","کلات":"کلات","گناباد":"گناباد","مشهد":"مشهد","مه ولات":"مه ولات","نیشابور":"نیشابور"};
            break;
        case "خراسان‌شمالی":
            var selectValues = {"اسفراین":"اسفراین","بجنورد":"بجنورد","جاجرم":"جاجرم","شیروان":"شیروان","فاروج":"فاروج","مانه و سملقان":"مانه و سملقان"};
            break;
        case "خوزستان":
            var selectValues = {"آبادان":"آبادان","امیدیه":"امیدیه","اندیمشک":"اندیمشک","اهواز":"اهواز","ایذه":"ایذه","باغ‌ملک":"باغ‌ملک","بندر ماهشهر":"بندر ماهشهر","بهبهان":"بهبهان","خرمشهر":"خرمشهر","دزفول":"دزفول","دشت آزادگان":"دشت آزادگان","رامشیر":"رامشیر","رامهرمز":"رامهرمز","شادگان":"شادگان","شوش":"شوش","شوشتر":"شوشتر","گتوند":"گتوند","لالی":"لالی","مسجد سلیمان":"مسجد سلیمان","هندیجان":"هندیجان"};
            break;
        case "زنجان":
            var selectValues = {"ابهر":"ابهر","ایجرود":"ایجرود","خدابنده":"خدابنده","خرمدره":"خرمدره","زنجان":"زنجان","طارم":"طارم","ماه‌نشان":"ماه‌نشان"};
            break;
        case "سمنان":
            var selectValues = {"دامغان":"دامغان","سمنان":"سمنان","شاهرود":"شاهرود","گرمسار":"گرمسار","مهدی‌شهر":"مهدی‌شهر"};
            break;
        case "سیستان‌و‌بلوچستان":
            var selectValues = {"ایرانشهر":"ایرانشهر","چابهار":"چابهار","خاش":"خاش","دلگان":"دلگان","زابل":"زابل","زاهدان":"زاهدان","زهک":"زهک","سراوان":"سراوان","سرباز":"سرباز","کنارک":"کنارک","نیک‌شهر":"نیک‌شهر"};
            break;
        case "فارس":
            var selectValues = {"آباده":"آباده","ارسنجان":"ارسنجان","استهبان":"استهبان","اقلید":"اقلید","بوانات":"بوانات","پاسارگاد":"پاسارگاد","جهرم":"جهرم","خرم‌بید":"خرم‌بید","خنج":"خنج","داراب":"داراب","زرین‌دشت":"زرین‌دشت","سپیدان":"سپیدان","شیراز":"شیراز","فراشبند":"فراشبند","فسا":"فسا","فیروزآباد":"فیروزآباد","قیر و کارزین":"قیر و کارزین","کازرون":"کازرون","لارستان":"لارستان","لامرد":"لامرد","مرودشت":"مرودشت","ممسنی":"ممسنی","مهر":"مهر","نی‌ریز":"نی‌ریز"};
            break;
        case "قزوین":
            var selectValues = {"آبیک":"آبیک","البرز":"البرز","بوئین‌زهرا":"بوئین‌زهرا","تاکستان":"تاکستان","قزوین":"قزوین"};
            break;
        case "قم":
            var selectValues = {"قم":"قم"};
            break;
        case "کردستان":
            var selectValues = {"بانه":"بانه","بیجار":"بیجار","دیواندره":"دیواندره","سروآباد":"سروآباد","سقز":"سقز","سنندج":"سنندج","قروه":"قروه","کامیاران":"کامیاران","مریوان":"مریوان"};
            break;
        case "کرمان":
            var selectValues = {"بافت":"بافت","بردسیر":"بردسیر","بم":"بم","جیرفت":"جیرفت","راور":"راور","رفسنجان":"رفسنجان","رودبار جنوب":"رودبار جنوب","زرند":"زرند","سیرجان":"سیرجان","شهر بابک":"شهر بابک","عنبرآباد":"عنبرآباد","قلعه گنج":"قلعه گنج","کرمان":"کرمان","کوهبنان":"کوهبنان","کهنوج":"کهنوج","منوجان":"منوجان"};
            break;
        case "کرمانشاه":
            var selectValues = {"اسلام‌آباد غرب":"اسلام‌آباد غرب","پاوه":"پاوه","ثلاث باباجانی":"ثلاث باباجانی","جوانرود":"جوانرود","دالاهو":"دالاهو","روانسر":"روانسر","سرپل ذهاب":"سرپل ذهاب","سنقر":"سنقر","صحنه":"صحنه","قصر شیرین":"قصر شیرین","کرمانشاه":"کرمانشاه","کنگاور":"کنگاور","گیلان غرب":"گیلان غرب","هرسین":"هرسین"};
            break;
        case "کهکیلویه‌و‌بویراحمد":
            var selectValues = {"بویراحمد":"بویراحمد","بهمئی":"بهمئی","دنا":"دنا","کهگیلویه":"کهگیلویه","گچساران":"گچساران"};
            break;
        case "گلستان":
            var selectValues = {"آزادشهر":"آزادشهر","آق‌قلا":"آق‌قلا","بندر گز":"بندر گز","ترکمن":"ترکمن","رامیان":"رامیان","علی‌آباد":"علی‌آباد","کردکوی":"کردکوی","کلاله":"کلاله","گرگان":"گرگان","گنبد کاووس":"گنبد کاووس","مراوه‌تپه":"مراوه‌تپه","مینودشت":"مینودشت"};
            break;
        case "گیلان":
            var selectValues = {"آستارا":"آستارا","آستانه":"آستانه","اشرفیه":"اشرفیه","املش":"املش","بندر انزلی":"بندر انزلی","رشت":"رشت","رضوانشهر":"رضوانشهر","رودبار":"رودبار","رودسر":"رودسر","سیاهکل":"سیاهکل","شفت":"شفت","صومعه‌سرا":"صومعه‌سرا","طوالش":"طوالش","فومن":"فومن","لاهیجان":"لاهیجان","لنگرود":"لنگرود","ماسال":"ماسال"};
            break;
        case "لرستان":
            var selectValues = {"ازنا":"ازنا","الیگودرز":"الیگودرز","بروجرد":"بروجرد","پل‌دختر":"پل‌دختر","خرم‌آباد":"خرم‌آباد","دورود":"دورود","دلفان":"دلفان","سلسله":"سلسله","کوهدشت":"کوهدشت"};
            break;
        case "مازندران":
            var selectValues = {"آمل":"آمل","بابل":"بابل","بابلسر":"بابلسر","بهشهر":"بهشهر","تنکابن":"تنکابن","جویبار":"جویبار","چالوس":"چالوس","رامسر":"رامسر","ساری":"ساری","سوادکوه":"سوادکوه","قائم‌شهر":"قائم‌شهر","گلوگاه":"گلوگاه","محمودآباد":"محمودآباد","نکا":"نکا","نور":"نور","نوشهر":"نوشهر"};
            break;
        case "مرکزی":
            var selectValues = {"آشتیان":"آشتیان","اراک":"اراک","تفرش":"تفرش","خمین":"خمین","دلیجان":"دلیجان","زرندیه":"زرندیه","ساوه":"ساوه","شازند":"شازند","کمیجان":"کمیجان","محلات":"محلات"};
            break;
        case "هرمزگان":
            var selectValues = {"ابوموسی":"ابوموسی","بستک":"بستک","بندر عباس":"بندر عباس","بندر لنگه":"بندر لنگه","جاسک":"جاسک","حاجی‌آباد":"حاجی‌آباد","خمیر":"خمیر","رودان":"رودان","قشم":"قشم","گاوبندی":"گاوبندی","میناب":"میناب"};
            break;
        case "همدان":
            var selectValues = {"اسدآباد":"اسدآباد","بهار":"بهار","تویسرکان":"تویسرکان","رزن":"رزن","کبودرآهنگ":"کبودرآهنگ","ملایر":"ملایر","نهاوند":"نهاوند","همدان":"همدان"};
            break;
        case "یزد":
            var selectValues = {"ابرکوه":"ابرکوه","اردکان":"اردکان","بافق":"بافق","تفت":"تفت","خاتم":"خاتم","صدوق":"صدوق","طبس":"طبس","مهریز":"مهریز","میبد":"میبد","یزد":"یزد"};
            break;
        case "":
            var selectValues = {"":""}

    }


    $.each( selectValues , function (key, value) {
        $(".pvc")
            .append($("<option></option>")
                .attr("value", key)
                .text(value));
    });
    $(".pvc").removeClass("pvc");
}

});
