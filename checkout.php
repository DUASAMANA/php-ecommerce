<?php
session_start();
// Get the user's address from the user_dashboard.php page
$address = $_SESSION['address'];
// Display the user's address on the checkout page
echo "Your address is: $address";
// Give the user the option to use the address or write a new one
echo "<form action='checkout.php' method='post'>";
echo "<input type='radio' name='address' value='$address'> Use this address";
echo "<input type='radio' name='address' value='new'> Write a new address";
echo "<input type='submit' value='Continue'>";
echo "</form>";
// Get the total amount from the cart
$total = $_SESSION['total'];
// Display the total amount on the checkout page
echo "Your total is: $total";
?>