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

// Query to retrieve the user's address
$sql = "SELECT street_address, city, state, postal_code FROM user_addresses WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);

if ($stmt->execute()) {
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $address = $row["street_address"] . ", " . $row["city"] . ", " . $row["state"] . " " . $row["postal_code"];
        echo json_encode(["address" => $address]);
    } else {
        echo json_encode(["address" => ""]);
    }
} else {
    http_response_code(500);
    echo json_encode(["address" => ""]);
}

$stmt->close();
$conn->close();
?>
