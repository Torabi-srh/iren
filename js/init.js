var everythingLoaded = setInterval(function() {
  if (/loaded|complete/.test(document.readyState)) {
    clearInterval(everythingLoaded);

  }
}, 10);
String.prototype.format = function () {
    var args = [].slice.call(arguments);
    return this.replace(/(\{\d+\})/g, function (a){
        return args[+(a.substr(1,a.length-2))||0];
    });
};
function encode_utf8(s) {
  return unescape(encodeURIComponent(s));
}

function decode_utf8(s) {
  return decodeURIComponent(escape(s));
}

function toEnglishDate(str) {
    var charCodeZero = '۰'.charCodeAt(0);
    var otp = str.replace(/[۰-۹]/g, function (w) {
        return w.charCodeAt(0) - charCodeZero;
    });
    return otp;
}

function validateDate(strDate) {
  var t = /^(?=.+([\/.-])..\1)(?=.{10}$)(?:(\d{4}).|)(\d\d).(\d\d)(?:.(\d{4})|)$/;
  strDate.replace(t, function($, _, y, m, d, y2) {
    $ = new Date(y = y || y2, m, d);
    t = $.getFullYear() != y || $.getMonth() != m || $.getDate() != d;
  });
  return !t;
}
$(document).ajaxStart(function(){
    $.LoadingOverlay("show");
});
$(document).ajaxStop(function(){
    $.LoadingOverlay("hide");
});
