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



    // Retrieve the JSON data (cart items) from the request body and decode it
    $cartItems = json_decode(file_get_contents("php://input"), true);

    if ($cartItems && is_array($cartItems)) {
        // Calculate the total amount based on the cart items
        $totalAmount = 0;
        foreach ($cartItems as $item) {
            $totalAmount += $item['price'] * $item['quantity'];
            $productIds[] = $item['product_id'];
        }

        // Set the order status to 'PROCESSING'
        $status = 'PROCESSING';

        // Prepare and execute an SQL query to insert the order
        $sql = "INSERT INTO orders (user_id, total_amount, status, order_date, product_id) VALUES (?, ?, ?, NOW())";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ids", $user_id, $totalAmount, $status);
        if ($stmt->execute()) {
            // The order was successfully inserted
            $orderId = $stmt->insert_id; // Get the auto-generated order ID
            echo json_encode(array("message" => "Order placed successfully with ID: $orderId"));
        } else {
            // An error occurred while inserting the order
            echo json_encode(array("message" => "Error placing the order: " . $stmt->error));
        }
        $stmt->close();
        $conn->close();
    } else {
        echo json_encode(array("message" => "Invalid or empty cart items."));
    }
