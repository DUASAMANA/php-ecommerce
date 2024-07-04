<?php
// Include your database connection code here
$servername = "localhost";
$username = "root";
$password = "";
$database = "websitedatabase";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


// Handle product form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $productName = $_POST["productName"];
    $description = $_POST["description"];
    $price = $_POST["price"];

    // Handle image upload (if needed)
    if ($_FILES["image"]["error"] === UPLOAD_ERR_OK) {
        $imageFileName = $_FILES["image"]["name"];
        $uploadDirectory = "uploads/"; // Specify your upload directory
        move_uploaded_file($_FILES["image"]["tmp_name"], $uploadDirectory . $imageFileName);
    }

    // Insert product data into the database (you should have a database connection established)
    // Use prepared statements to prevent SQL injection
    $stmt = $conn->prepare("INSERT INTO products (productName, description, price, image) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssds", $productName, $description, $price, $imageFileName);
    if ($stmt->execute()) {
        echo "Product added successfully.";
    } else {
        echo "Error adding product: " . $stmt->error;
    }

    $stmt->close();
}
?>
