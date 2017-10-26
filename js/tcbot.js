$(document).ready(function(){
  $.ajax({
    type: "POST",
    url: '/ajax/tcbot.php',
    success: function(result) {
      $(".tcbot-body").html(result);
    }
  });
  $(".tcbot-body").on("click", "", function(){
      $.ajax({
        type: "POST",
        data: {
          aq: ''
        },
        url: '/ajax/tcbot.php',
        success: function(result) {
          $(".tcbot-body").html(result);
        }
      });
  }); 

});
