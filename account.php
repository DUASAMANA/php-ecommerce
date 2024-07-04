<?php
// Create a connection to the database.
$connection = mysqli_connect("localhost", "root", "", "websitedatabase");
// Check if the connection was successful.
if (!$connection) {
  die("Connection failed: " . mysqli_connect_error());
}
// Create a table to store the user information.
$sql = "CREATE TABLE IF NOT EXISTS users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(255),
  password VARCHAR(255),
  email VARCHAR(255)
)";
// Execute the query.
mysqli_query($connection, $sql);
// Get the username, password, and email address from the user.
$username = $_POST['username'];
$password = $_POST['password'];
$email = $_POST['email'];
// Check if the user already exists in the database.
$sql = "SELECT * FROM users WHERE username = '$username'";
$result = mysqli_query($connection, $sql);
// If the user does not exist, create a new user.
if (mysqli_num_rows($result) == 0) {
  $sql = "INSERT INTO users (username, password, email) VALUES ('$username', '$password', '$email')";
  mysqli_query($connection, $sql);
}
// Close the connection to the database.
mysqli_close($connection);
?>