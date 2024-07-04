<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION["user_id"])) {
    http_response_code(401);
    exit;
}

// Connect to the database
$conn = new mysqli("localhost", "root", "", "websitedatabase");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$user_id = $_SESSION["user_id"];

// Delete the user's account and associated data (you need to define the table and key appropriately)
$sql = "DELETE FROM users WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);

if ($stmt->execute()) {
    // Logout the user after deleting the account
    session_destroy();
    echo "Account deleted successfully.";
} else {
    http_response_code(500);
    echo "Error deleting account.";
}

$stmt->close();
$conn->close();
?>
