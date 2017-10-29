$(document).ready(function(){
  function loaddr() {
    $.ajax({
        type: "POST",
        url: '/ajax/dprofile.php',
        data: {
            token: '',
            p: $('#pagination li.active a').attr('id')
        },
        success: function(result) {
            $("#p-show").html(result);
        }
    });
  }
  loaddr();
  $("#pagination").on('click', 'a', function(e) {
    e.preventDefault();
    $('#pagination li.active').removeClass('active');
    $(this).parent().addClass('active');
    loaddr();
  });

  dialog = $( "#settings-popup" ).dialog({
    autoOpen: false,
    height: "auto",
    width: "auto",
    dialogClass: "alert",
    modal: true  ,
    open: function(event, ui) {
      $(".ui-dialog-titlebar-close").hide();
    }
  });
  $('#step1-form').on('click', 'button', function (e) {
      e.preventDefault();
      var dataf = $('#step1-form').serializeArray();
      dataf.push({name: 'token', value: ""});
      dataf.push({name: 'w', value: "1"});
      $.ajax({
          type: "POST",
          dataType : 'json',
          url: '/ajax/dprofile.php',
          data: dataf,
          success: function(result) {
              if (result.a === "success") {
                var $elm = $("<div class=\"alert alert-"+ result.a +"\"><strong>"+ result.b +"</strong></div><br />");
                $("#could_pass").html($elm);
                setTimeout(function() {
                            $elm.remove();
                        }, 5000);
                dialog.dialog( "close" );
              } else {
                  var $elm = $("<div class=\"alert alert-"+ result.a +"\"><strong>"+ result.b +"</strong></div><br />");
                  $("#could_pass").html($elm);
                  setTimeout(function() {
                              $elm.remove();
                          }, 5000);
              }
          }
      });
  });
  $('#step2-form').on('click', 'button', function (e) {
      e.preventDefault();
      var dataf = $('#step2-form').serializeArray();
      dataf.push({name: 'token', value: ""});
      dataf.push({name: 'w', value: "2"});
      $.ajax({
          type: "POST",
          dataType : 'json',
          url: '/ajax/dprofile.php',
          data: dataf,
          success: function(result) {
              if (result.a === "success") {
                var $elm = $("<div class=\"alert alert-"+ result.a +"\"><strong>"+ result.b +"</strong></div><br />");
                $("#could_pass").html($elm);
                setTimeout(function() {
                            $elm.remove();
                        }, 5000);
                dialog.dialog( "close" );
              } else {
                  var $elm = $("<div class=\"alert alert-"+ result.a +"\"><strong>"+ result.b +"</strong></div><br />");
                  $("#could_pass").html($elm);
                  setTimeout(function() {
                              $elm.remove();
                          }, 5000);
              }
          }

      });
  });
  $('#step3-form').on('click', 'button', function (e) {
      e.preventDefault();
      var dataf = $('#step3-form').serializeArray();
      dataf.push({name: 'token', value: ""});
      dataf.push({name: 'w', value: "3"});
      var datad = { 'token': "", 'w': "3",'takhasos[]' : [], 'roykard[]': [], 'drcode': $("#drcode")[0].value, 's3f2': $("#s3f2")[0].value};
      $(".takhasos:checked").each(function() {
        datad['takhasos[]'].push($(this).val());
      });
      $(".roykard:checked").each(function() {
        datad['roykard[]'].push($(this).val());
      });
      $.ajax({
          type: "POST",
          dataType : 'json',
          url: '/ajax/dprofile.php',
          data: datad,
          success: function(result) {
              if (result.a === "success") {
                var $elm = $("<div class=\"alert alert-"+ result.a +"\"><strong>"+ result.b +"</strong></div><br />");
                $("#could_pass").html($elm);
                setTimeout(function() {
                            $elm.remove();
                        }, 5000);
                dialog.dialog( "close" );
              } else {
                  var $elm = $("<div class=\"alert alert-"+ result.a +"\"><strong>"+ result.b +"</strong></div><br />");
                  $("#could_pass").html($elm);
                  setTimeout(function() {
                              $elm.remove();
                          }, 5000);
              }
          }
      });
  });

  $('#step4-form').on('click', 'button', function (e) {
      e.preventDefault();
      if ($("#step4-form").valid()) {
          var fd = new FormData($("#step4-form").get(0));
          $.ajax({
              type: "POST",
              contentType: false,
              processData: false,
              data: fd,
              url: '/ajax/dprofile.php',
              success: function(result) {
                result = JSON.parse(result);
                  if (result.a === "success") {
                    var $elm = $("<div class=\"alert alert-"+ result.a +"\"><strong>"+ result.b +"</strong></div><br />");
                    $("#could_pass").html($elm);
                    setTimeout(function() {
                                $elm.remove();
                            }, 5000);
                    dialog.dialog( "close" );
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

  $( "body").on("click", '.ui-widget-overlay', function() {
      dialog.dialog( "close" );
  });
  $( "#editClass" ).button().on( "click", function() {
    dialog.dialog( "open" );
  });

  $("#close-editClass").click(function() {
      if ($(".popup-box-on")[0]) {
          $('#settings-popup').removeClass('popup-box-on');
      }
  });
});
