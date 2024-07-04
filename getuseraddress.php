<?php
// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "websitedatabase";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Implement your user authentication logic here to get the logged-in user's ID
session_start();
if (isset($_SESSION['user_id'])) {
    // The user is logged in, so you can retrieve their user ID
    $userID = $_SESSION['user_id'];

    // Set a PHP variable to indicate that the user is logged in
    $isLoggedIn = true;
} else {
    // If not logged in, handle the case (e.g., redirect to a login page)
    header("Location: login.php");
    exit(); // Stop script execution
}

// Query to retrieve the user's address from the user_address table
$sql = "SELECT * FROM user_addresses WHERE user_id = ? LIMIT 1";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $userID);

if ($stmt->execute()) {
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        // Fetch the user's address data
        $userAddressData = $result->fetch_assoc();

        // Set response header to indicate JSON
        header('Content-Type: application/json');

        // Return the user address data as JSON
        echo json_encode(array("userAddressData" => $userAddressData));
    } else {
        // Set response header to indicate JSON
        header('Content-Type: application/json');

        echo json_encode(array("message" => "User address not found."));
    }
} else {
    // Set response header to indicate JSON
    header('Content-Type: application/json');

    echo json_encode(array("message" => "Error fetching user address: " . $stmt->error));
}

$stmt->close();
$conn->close();
