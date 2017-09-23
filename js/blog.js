$(document).load(function() {
        $("#comment-submit").click(function(event) {
                event.preventDefault();
                $.ajax({
                    type: "POST",
                    url: '/ajax/blog.php',
                    data: {
                        token: 0,
                        comment: $("#comment-text").val
                    },
                    success: function(result) {
                        $("#er").html(result);
                    },
                    error: function (request, status, error) {
                    }
                });
            });
    });