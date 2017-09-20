$(function() {
    $('[rel=popover]').popover({
        html: true,
        content: function() {
            return $('#popover_content_wrapper').html();
        }
    });
});
jQuery.expr[':'].regex = function(elem, index, match) {
    var regex = new RegExp(match[3]),
        $elem = $(elem);
    return regex.test($elem.attr('class')) || regex.test($elem.attr('id')); 
};
$(function() {
    $("#editClass").click(function() {
        $('#settings-popup').toggleClass('popup-box-on');
        //if ($(".popup-box-on")[0]) {
        //    $('#settings-popup').removeClass('popup-box-on');
        //} else {
        //    $('#settings-popup').addClass('popup-box-on');
        //}
    });

    $("#close-editClass").click(function() {
        if ($(".popup-box-on")[0]) {
            $('#settings-popup').removeClass('popup-box-on');
        }
    });


    $("#xmoshaver-popup").click(function() {
        $('#smoshaver-popup').toggleClass('popup-box-on');
        //if ($(".popup-box-on")[0]) {
        //    $('#smoshaver-popup').removeClass('popup-box-on');
        //} else {
        //    $('#smoshaver-popup').addClass('popup-box-on');
        //}
    });
    $("#close-smoshaverClass").click(function() {
        if ($(".popup-box-on")[0]) {
            $('#smoshaver-popup').removeClass('popup-box-on');
        }
    });


    $("#addClass").click(function() {
        try {
            $('#app-popup').removeClass('popup-box-on');
        } catch (err) {}
        try {
            $('#moshavere-popup').removeClass('popup-box-on');
        } catch (err) {}
        
        $('#chat-box-popup').toggleClass('popup-box-on');
        $('#chat-box-popup2').toggleClass('popup-box-on');
        //if ($(".popup-box-on")[0]) {
        //    $('#chat-box-popup').removeClass('popup-box-on');
        //    $('#chat-box-popup2').removeClass('popup-box-on');
        //} else {
        //    $('#chat-box-popup').addClass('popup-box-on');
        //    $('#chat-box-popup2').addClass('popup-box-on');
        //}
    });
    $("#appClass").click(function() {
        try {
            $('#moshavere-popup').removeClass('popup-box-on');
        } catch (err) {}
        try {
            $('#chat-box-popup2').removeClass('popup-box-on');
        } catch (err) {}
        try {
            $('#chat-box-popup').removeClass('popup-box-on');
        } catch (err) {}
        $('#app-popup').toggleClass('popup-box-on');
        //if ($(".popup-box-on")[0]) {
        //    $('#app-popup').removeClass('popup-box-on');
        //} else {
        //    $('#app-popup').addClass('popup-box-on');
        //}
    });
    $("#moshaClass").click(function() {
        try {
            $('#app-popup').removeClass('popup-box-on');
        } catch (err) {}
        try {
            $('#chat-box-popup2').removeClass('popup-box-on');
        } catch (err) {}
        try {
            $('#chat-box-popup').removeClass('popup-box-on');
        } catch (err) {}
        $('#moshavere-popup').toggleClass('popup-box-on');
        //if ($(".popup-box-on")[0]) {
        //    $('#moshavere-popup').removeClass('popup-box-on');
        //} else {
        //    $('#moshavere-popup').addClass('popup-box-on');
        //}
    });

    // $("#removeClass").click(function () {
    //
    // });
});

function formatAMPM(date) {
    var hours = date.getHours();
    var minutes = date.getMinutes();
    var ampm = hours >= 12 ? 'PM' : 'AM';
    hours = hours % 12;
    hours = hours ? hours : 12; // the hour '0' should be '12'
    minutes = minutes < 10 ? '0' + minutes : minutes;
    var strTime = hours + ':' + minutes + ' ' + ampm;
    return strTime;
}
 
function insertChat(who, text, time, pic) {
    var control = "";
    
    if (who == "me") {

        control = '<li style="width:100%">' +
            '<div class="msj macro">' +
            '<div class="avatar"><img class="img-circle" style="width:100%;" src="' + pic + '" /></div>' +
            '<div class="text text-l">' +
            '<p>' + text + '</p>' +
            '<p><small>' + time + '</small></p>' +
            '</div>' +
            '</div>' +
            '</li>';
    } else {
        control = '<li style="width:100%;">' +
            '<div class="msj-rta macro">' +
            '<div class="text text-r">' +
            '<p>' + text + '</p>' +
            '<p><small>' + time + '</small></p>' +
            '</div>' +
            '<div class="avatar" style="padding:0px 0px 0px 10px !important"><img class="img-circle" style="width:100%;" src="' + pic + '" /></div>' +
            '</li>';
    }

    $("#chat-msg").append(control);


}

function resetChat() {
    $("#chat-msg").empty();
}

$(".mytext").on("keyup", function(e) {
    if (e.which == 13) {
        var text = $(this).val();
        if (text !== "") {
            insertChat("me", text);
            $(this).val('');
        }
    }
});

//-- Clear Chat
// resetChat();
function updateContacts() {
    $.ajax({
        type: "POST",
        url: '/ajax/chat.php',
        data: {
            chat: 'true'
        },
        success: function(result) {
            $("#chat-contacts").html(result);
        }
    });
}
var cid = -1; 
function updateMsg(cid) {
    if (cid === -1) {
        $("#upper-avatar").attr("src","assets/images/users/no-image.jpg");
        $("#upper-chat").innerHtml = "";
        return;
    }
    try {
        cid = +cid.replace("c-", "");
    } catch (er) {
        
    }
    resetChat();
    $.ajax({
        type: "POST",
        url: '/ajax/chat.php',
        data: {
            msg: cid
        },
        success: function(result) {
            var msgs = JSON.parse(result);
            for (i = 0; i < msgs.length; ++i) {
                insertChat(msgs[i][0], msgs[i][1], msgs[i][2], msgs[i][3]);
                if (msgs[i][0] == 'you') {
                    $(".upper-avatar").attr("src", msgs[i][3]);
                    $(".upper-chat").text(msgs[i][4]);
                }
            }
        }
    });
}
function SendMsg(msg) {
    try {
        cid = +cid.replace("c-", "");
    } catch (er) {
        
    }
    if (this.value === "" || this.value === null) return;
    $.ajax({
        type: "POST",
        url: '/ajax/chat.php',
        data: {
            send: msg,
            cid: cid
        },
        success: function(result) {
            var msgs = JSON.parse(result);
            insertChat(msgs[i][0], msgs[i][1], msgs[i][2], msgs[i][3]);
        }
    });
}
//$('#send_message').change(function() {
//    SendMsg($(this).val);
//});
$(document).ready(function() {
    updateContacts();
    $('#send_message').keydown(function(event) {
        if (event.keyCode == 13 && cid !== -1) {
            SendMsg(event.target.value);
            event.preventDefault();
        }
    });
});
$("#send_message_btn").click(function() {
    $('#send_message').each(function() {SendMsg(this.value);
                                    });
});
$("#chat-contacts").on('click', '.c-contact', function () {
    $("#chat-contacts > a.selected").removeClass('selected');
    $(this).addClass('selected');
    cid = $(this).attr('id');
    updateMsg(cid);
}); 
//-- Print Messages
setInterval(function() {
    updateMsg(cid);
}, 30000);