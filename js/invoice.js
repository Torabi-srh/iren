$(document).ready(function(){
  function loaddr() {
    $.ajax({
        type: "POST",
        url: '/ajax/invoice.php',
        data: {
            token: '',
            p: $('#pagination li.active a').attr('id')
        },
        success: function(result) {
            $("#inv").html(result);
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
