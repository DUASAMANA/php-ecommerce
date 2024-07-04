<?php
session_start();
// Connect to the database
$conn = new mysqli("localhost", "root", "", "websitedatabase");
// Check if the user is logged in
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve the user ID from the session.
    $user_id = $_SESSION["user_id"];

    // Get the review from the form.
    $review = $_POST["review"];

    // Database configuration
    $servername = "localhost"; // Your database host
    $username = "root"; // Your database username
    $password = ""; // Your database password
    $dbname = "websitedatabase"; // Your database name

    // Create a connection to the database
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check if the connection was successful
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Insert the review into the "users" table for the logged-in user.
    $sql = "UPDATE users SET review = CONCAT(IFNULL(review, ''), ' ', ?) WHERE user_id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $review, $user_id);

    if ($stmt->execute()) {
        echo "Review added successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close the database connection
    $stmt->close();
    $conn->close();
}
?>

