<?php
// Start a session to work with session variables.
session_start();

// Check if the user is logged in by verifying the presence of 'user_id' in the session.
if (isset($_SESSION['user_id'])) {
    // User is logged in. You can retrieve the user's ID and display content.
    $user_id = $_SESSION['user_id'];
    echo "Welcome to the dashboard, User ID: $user_id";
} else {
    // User is not logged in. Redirect to the login page.
    header('Location: project.html'); // Redirect to your home page
    exit();
}


?>



<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="manager.css">
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="manager.js"></script>
    <title>Manager Dashboard</title>
</head>
<body>
    <h1>Manager Dashboard</h1>
    <!-- Create two columns for user IDs and reviews -->
    <div class="container">
        <div class="row">
        <div class="col-md-2">
                <div class="column">
                    <h2>User ID</h2>
                    <div id="userIds"></div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="column">
                    <h2>Username</h2>
                    <div id="usernames"></div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="column">
                    <h2>Email</h2>
                    <div id="emails"></div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="column">
                    <h2>Reviews</h2>
                    <div id="reviews"></div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>





