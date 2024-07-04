<?php
// Database connection information
$host = "localhost";
$username = "root";
$password = "";
$database = "websitedatabase";
// Connect to the database
$conn = new mysqli($host, $username, $password, $database);
// Check if the connection was successful
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
// Execute a SQL query
$sql = "SELECT * FROM users";
$result = $conn->query($sql);
// Close the connection
$conn->close();
?>