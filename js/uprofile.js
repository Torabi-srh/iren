$(document).ready(function(){
  $("#smoshaver-popup").on('mouseover', '.ratings_stars', function(e) {
        $(".ratings_stars").removeClass('rated');
        $(this).nextAll().andSelf().toggleClass('rated');
  });
  $("#smoshaver-popup").on('click', '.ratings_stars', function(e) {
    var rt = 0;
    $('.ratings_stars').each(function(i) {
      if ($(this).hasClass("rated")) rt++;
    });
    var duid = $("#sdid").val();
    $.ajax({
        type: "POST",
        data: {
          token: '',
          uid: duid,
          rate: rt
        },
        url: '/ajax/uprofile.php',
        success: function(result) {
        }
    });
  });
  dialog2 = $( "#smoshaver-popup" ).dialog({
    autoOpen: false,
    height: "auto",
    width: "auto",
    dialogClass: "alert",
    modal: true,
    open: function(event, ui) {
      $(".ui-dialog-titlebar-close").hide();
    }
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
  form = dialog.find( "form" ).on( "submit", function( event ) {
    event.preventDefault();
    //addUser();
  });
  function updateU() {
      var fd = new FormData(form.get(0));
      $.ajax({
          type: "POST",
          contentType: false,
          processData: false,
          data: fd,
          url: '/ajax/uprofile.php',
          success: function(result) {
            dialog.dialog( "close" );
          }
      });
  }

  $( "body").on("click", '.ui-widget-overlay', function() {
      dialog.dialog( "close" );
      dialog2.dialog( "close" );
  });
  $( "#editClass" ).button().on( "click", function() {
    dialog.dialog( "open" );
  });
  $( "#show-dr" ).on("click", '#dr-item', function() {
    var uidi = $(this).attr("v");
    $.ajax({
        type: "POST",
        data: {
          mdialog: uidi
        },
        url: '/ajax/uprofile.php',
        success: function(result) {
          $("#smoshaver-popup").html(result);
          dialog2.dialog( "open" );
        }
    });
  });
  $( "#smoshaver-popup" ).on("click", '#close-smoshaverClass', function() {
    dialog2.dialog( "close" );
  });
  $("#close-editClass").click(function() {
      if ($(".popup-box-on")[0]) {
          $('#settings-popup').removeClass('popup-box-on');
      }
  });

  function loaddr() {
    $.ajax({
        type: "POST",
        url: '/ajax/uprofile.php',
        data: {
            token: '',
            p: $('#pagination li.active a').attr('id')
        },
        success: function(result) {
            $("#show-dr").html(result);
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
});
