<?php
session_start();
// Connect to the database
$conn = new mysqli("localhost", "root", "", "websitedatabase");
// Check if the user is logged in
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}
// Get the user's ID
$user_id = $_SESSION["user_id"];
// Get the user's order history
$sql = "SELECT * FROM orders WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

// Handle saving and retrieving addresses
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Check if the form was submitted for saving an address
    if (isset($_POST["save-address"])) {
        $street_address = $_POST["street"];
        $city = $_POST["city"];
        $state = $_POST["state"];
        $postal_code = $_POST["postal-code"];
        
        // Insert the address into the user_addresses table
        $insertSql = "INSERT INTO user_addresses (user_id, street_address, city, state, postal_code)
                      VALUES (?, ?, ?, ?, ?)";
        
        $insertStmt = $conn->prepare($insertSql);
        $insertStmt->bind_param("issss", $user_id, $street_address, $city, $state, $postal_code);
        
        if ($insertStmt->execute()) {
            // Address successfully added to the database
            echo "Address saved successfully.";
        } else {
            // Handle the error
            echo "Error saving address: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="skin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
    <script defer src="skin.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <title>Order History</title>
</head>
<body>
    <header>
        <div class="menu-icon">
            <i class="fas fa-bars"></i>
        </div>
        <div class="logo">
            Order History
        </div>
      
        </div>
        <div class="sidebar cart-sidebar">
            <i class="fas fa-times close-icon"></i>
            <!-- Cart sidebar content will be loaded dynamically -->
            <h2>Cart</h2>
            <div id="cart-container">
                <ul id="cart-items">
                    <div class="cart-item-details">
                        <div class="cart-item-info">
                            <img src="${item.image}" alt="${item.name}" width="50">
                            <span>${item.name}</span>
                        </div>
                        <div class="cart-item-actions">
                            <input type="number" class="item-quantity" value="${item.quantity}" min="1">
                            <button class="remove-item" data-product-id="${item.id}">Remove</button>
                        </div>
                    </div>
                </ul>
                <p>Total: ksh<span id="cart-total">0.00</span></p>
            </div>
        </div>

        <div class="cart-icon">
            <i class="fas fa-shopping-cart"></i>
        </div>
    </header>

    <!-- Display the order history in a separate section -->
    <section class="parallax-background">
        <div class="parallax-content">
            <section class="order-history container">
                <div class="row">
                    <div class="col-2"><strong>Order ID</strong></div>
                    <div class="col-2"><strong>Order Date</strong></div>
                    <div class="col-2"><strong>Total Amount</strong></div>
                    <div class="col-2"><strong>Status</strong></div>
                    <div class="col-4"><strong>Product Names</strong></div>
                </div>

                <?php
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="row">';
                    echo "<div class='col-2'>{$row["order_id"]}</div>";
                    echo "<div class='col-2'>{$row["order_date"]}</div>";
                    echo "<div class='col-2'>{$row["total_amount"]}</div>";
                    echo "<div class='col-2'>{$row["status"]}</div>";
                    echo "<div class='col-4'>{$row["product_names"]}</div>";
                    echo '</div>';
                }
                ?>
            </section>
       
    
    </section>
    

    <div class="sidebar menu-sidebar">
        <i class="fas fa-times close-icon"></i>
        <ul class="nav-links">
            <li><a href="project.html">Home</a></li>
            <li><a href="skin.html">Skin</a></li>
            <li><a href="gym.html">Gym Equipments</a></li>
            <li><a href="supplements.html">Supplements</a></li>
            <li><a href="contact.html">Contact</a></li>
            <li><a href="account.html">My Account</a></li>
        </ul>
 
    <div class="content"></div>

    <!-- JavaScript for handling user interactions -->
    <script>
     

       
                });
            }
        });
    </script>
</body>
</html>