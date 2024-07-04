$(document).ready(function() {
    $.ajax({
        url: "getreview.php",
        type: "POST",
        dataType: "json", // Specify that the response is JSON
        success: function(data) {
            // Separate user IDs and reviews and append them to their respective columns
            data.forEach(function(item) {
                $("#userIds").append('<div class="user-id">' + item.user_id + '</div>');
                $("#usernames").append('<div class="username">' + item.username + '</div>');
                $("#emails").append('<div class="email">' + item.email + '</div>');
                $("#reviews").append('<div>' + item.review + '</div>');
            });
        }
    });
});
