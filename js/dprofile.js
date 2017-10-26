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
