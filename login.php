<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "websitedatabase";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($username === 'admin' && $password === 'admin123') {
        // If the username and password match, set user_type to 'manager'
        $user_type = 'manager';
    } else {
        // For other usernames and passwords, set user_type to 'user'
        $user_type = 'user';
    }

    $sql = "SELECT user_id FROM users WHERE username = ? AND password = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $user_id = $row['user_id'];

        // Set the session variables
        $_SESSION['user_id'] = $user_id;
        $_SESSION['user_type'] = $user_type;

        // Redirect the user to the appropriate dashboard
        if ($user_type == 'manager') {
            header("Location: manager_dashboard.php");
        } else {
            header("Location: user_dashboard.php");
        }
    } else {
        echo "Invalid email or password.";
    }
}
?>
