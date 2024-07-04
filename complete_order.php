<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "websitedatabase";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_SESSION['user_id'])) {
    $userID = $_SESSION['user_id'];
    $cartItems = json_decode(file_get_contents("php://input"), true);

    if ($cartItems && is_array($cartItems)) {
        $totalAmount = 0;
        $products = array();

        foreach ($cartItems as $item) {
            $totalAmount += $item['price'] * $item['quantity'];
            $products[] = $item['name'];
        }

        $productNamesJson = json_encode($products);

        $status = 'PROCESSING';

        $sql = "INSERT INTO orders (user_id, total_amount, status, order_date, product_names) VALUES (?, ?, ?, NOW(), ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("idss", $userID, $totalAmount, $status, $productNamesJson);

        if ($stmt->execute()) {
            // The order was successfully inserted
            $orderId = $stmt->insert_id;
            // Return the order ID in the response
            echo json_encode(array("orderID" => $orderId, "message" => "Order placed successfully with ID: $orderId"));
        } else {
            // Handle the error
            http_response_code(500); // Set an appropriate HTTP status code
            echo json_encode(array("message" => "Error placing the order: " . $stmt->error));
        }
        
        $stmt->close();
    } else {
        echo json_encode(array("message" => "Invalid or empty cart items."));
    }
} else {
    echo json_encode(array("message" => "User is not logged in."));
}

$conn->close();
?>
