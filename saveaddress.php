<?php
// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "websitedatabase";

$conn = new mysqli($servername, $username, $password, $dbname);
// Check the connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
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

// Retrieve the JSON data from the request body and decode it
$data = json_decode(file_get_contents("php://input"), true);

if ($data) {
    // You can add additional validation and sanitization here
    $user_id = $_SESSION['user_id']; // Retrieve the user's ID from the session
    $firstName = $data['firstName'];
    $lastName = $data['lastName'];
    $phone = $data['phone'];
    $email = $data['email'];
    $streetAddress = $data['streetAddress'];
    $city = $data['city'];
    $house = $data['house'];
    $postalCode = $data['postalCode'];
    $zip = $data['zip'];

    // Example SQL query to insert the address into the user_address table
    $sql = "INSERT INTO user_addresses (user_id, first_name, last_name, phone, email, street_address, city, house, postal_code, zip) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);

    // Bind parameters and execute the query
    $stmt->bind_param("ssssssssss", $user_id, $firstName, $lastName, $phone, $email, $streetAddress, $city, $house, $postalCode, $zip);

    if ($stmt->execute()) {
        echo json_encode(array("message" => "Address saved successfully."));
    } else {
        echo json_encode(array("message" => "Error saving address: " . $stmt->error));
    }

    $stmt->close();
} else {
    echo json_encode(array("message" => "Invalid or missing data."));
}

// Close the database connection
$conn->close();
?>
