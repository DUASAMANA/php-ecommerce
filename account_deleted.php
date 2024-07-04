<?php
// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "websitedatabase";

// Initialize a session
session_start();

// Check if the user is logged in
if (isset($_SESSION['user_id'])) {
    $userID = $_SESSION['user_id'];

    // Create a database connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Define the SQL query to delete the user's account
    $sql = "DELETE FROM users WHERE user_id = ?";

    // Prepare the statement
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die("Error in SQL: " . $conn->error);
    }

    // Bind the user_id parameter
    $stmt->bind_param("i", $userID);

    // Execute the statement
    if ($stmt->execute()) {
        // Account deletion successful, log the user out and redirect to a confirmation page
        session_destroy(); // Destroy the session
        header("Location: account_deleted.php"); // Redirect to a confirmation page
        exit(); // Stop script execution
    } else {
        // Account deletion failed
        echo "Error deleting account: " . $stmt->error;
    }

    // Close the statement and database connection
    $stmt->close();
    $conn->close();
} else {
    // User is not logged in, handle the case (e.g., redirect to a login page)
    header("Location: login.php");
    exit(); // Stop script execution
}
?>
