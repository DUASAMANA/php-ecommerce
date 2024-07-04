<?php
session_start();
// Connect to the database
$conn = new mysqli("localhost", "root", "", "websitedatabase");
// Get the user's information from the form
$fname = $_POST['fname'];
$lname = $_POST['lname'];
$phone = $_POST['phone'];
$address = $_POST['address'];
// Generate a unique order ID
$order_id = uniqid();
// Insert the order into the database
$sql = "INSERT INTO orders (order_id, customer_name, customer_phone, customer_address, total_price) VALUES ('$order_id', '$fname $lname', '$phone', '$address', '{$_SESSION['total']}')";
$conn->query($sql);
// Get the items from the cart
$items = $_SESSION['cart'];
// Insert the order