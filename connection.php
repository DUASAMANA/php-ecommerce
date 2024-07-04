<?php
$host = 'localhost'; // Database host
$dbname = 'websitedatabase'; // Database name
$username = 'root'; // Database username
$password = ''; // Database password

// Create a database connection
$connection = mysqli_connect($host, $username, $password, $dbname);

// Check if the connection was successful
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
