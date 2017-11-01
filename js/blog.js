$(document).ready(function() {
        $(".status-upload").on('click', '#comment-submit', function(e) {
                e.preventDefault();
                var dataf = $('#f1').serializeArray();
                dataf.push({name: 'token', value: ""});
                $.ajax({
                    type: "POST",
                    url: '/ajax/blog.php',
                    data: dataf,
                    dataType : 'json',
                    success: function(result) {
                        var $elm = $("<div class=\"alert alert-"+ result.a +"\"><strong>"+ result.b +"</strong></div><br />");
                        $("#could_pass").html($elm);
                        setTimeout(function() {
                                    $elm.remove();
                                }, 5000);
                        $(".comment-list").prepend(result.c);
                    }
                });
            });
    });
