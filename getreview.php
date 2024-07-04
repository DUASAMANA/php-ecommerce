<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "websitedatabase";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT user_id, username, email, review FROM users"; // Select 'user_id' and 'review' columns from 'users' table

$result = $conn->query($sql);

$data = array(); // Create an array to store the results

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Add each 'user_id' and 'review' to the data array
        $data[] = array('user_id' => $row['user_id'], 'username' => $row['username'],  'email' => $row['email'], 'review' => $row['review']);
    }
} else {
    echo "0 results";
}

// Encode the data as JSON and echo it
echo json_encode($data);

$conn->close();
?>
