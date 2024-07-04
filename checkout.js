const menuIcon = document.querySelector('.menu-icon');
const menuSidebar = document.querySelector('.menu-sidebar');
const content = document.querySelector('.content');


menuIcon.addEventListener('click', () => {
    console.log('Menu icon clicked');
    menuSidebar.classList.toggle('active');
    
});



content.addEventListener('click', () => {
    menuSidebar.classList.remove('active');
    
});




const closeIcon = document.querySelector('.close-icon');

// Get the close icons within both sidebars
const menuCloseIcon = menuSidebar.querySelector('.close-icon');

// Add a click event listener to the menu close icon
menuCloseIcon.addEventListener('click', () => {
    menuSidebar.classList.remove('active'); // Close the menu sidebar
});


// Close both sidebars when clicking outside them
content.addEventListener('click', () => {
    menuSidebar.classList.remove('active');
    
});







const cart = JSON.parse(localStorage.getItem('cart')) || [];
  
// Function to calculate and update total price
function updateTotalPrice() {
let totalPrice = 0;
cart.forEach(product => {
    totalPrice += product.price * product.quantity;
});
document.getElementById("totalPrice").textContent = `Ksh${totalPrice.toFixed(2)}`;
}

// Function to display products in the summary section
function displayProducts() {
const productContainer = document.getElementById("productList");
cart.forEach(product => {
    const productItem = document.createElement("div");
    productItem.classList.add("product-item");

// Use the corrected image URL
const imageUrl = `https://localhost/mywebsite/html-css/${product.image}`;

productItem.innerHTML = `
  <div class="product-details">
      <img src="${imageUrl}" alt="${product.name}" class="product-image">
      <h6 class="product-name">${product.name}</h6>
      <p class="product-price">Ksh${product.price.toFixed(2)}</p>
      <p class="product-quantity">Quantity: ${product.quantity}</p>
  </div>
    `;
    productContainer.appendChild(productItem);
});
}





document.addEventListener("DOMContentLoaded", function() {
    // Define the completeOrderButton
    const completeOrderButton = document.getElementById("complete-order");

    // Function to populate form fields with user address data
    function populateUserAddress(userAddressData) {
        if (userAddressData) {
            document.getElementById("typeTextFirstName").value = userAddressData.first_name;
            document.getElementById("typeTextLastName").value = userAddressData.last_name;
            document.getElementById("typePhone").value = userAddressData.phone;
            document.getElementById("typeEmail").value = userAddressData.email;
            document.getElementById("typeTextAddress").value = userAddressData.street_address;
            document.getElementById("selectCity").value = userAddressData.city;
            document.getElementById("typeTextHouse").value = userAddressData.house;
            document.getElementById("typeTextPostalCode").value = userAddressData.postal_code;
            document.getElementById("typeTextZip").value = userAddressData.zip;
            // ... and other address fields
        }
    }

    // Function to save the user's address to the server
    function saveUserAddress(userAddress) {
        // Send a request to save the user's address
        fetch('saveaddress.php', {
            method: 'POST',
            body: JSON.stringify(userAddress),
            headers: {
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            
            alert("Address saved successfully.");

        })
        .catch(error => {
            console.error('Error saving user address:', error);
        });
    }




    // Function to fetch the user's address and populate the form
    function fetchUserAddressAndPopulateForm() {
        // Fetch the user's address data from the server
        fetch('getuseraddress.php')
            .then(response => response.json())
            .then(data => {
                // Populate the user address form with the data
                populateUserAddress(data.userAddressData);
            })
            .catch(error => {
                console.error('Error fetching user address:', error);
            });
    }

    // Call the function to fetch and populate the user's address when the page loads
    window.addEventListener('load', fetchUserAddressAndPopulateForm);

    const saveAddressButton = document.getElementById("save-address-button");

    // Attach a click event listener to the Save Address button
    saveAddressButton.addEventListener("click", function() {
        // Construct the user address object and save it to the server when the button is clicked

          
                const userAddress = {
                    firstName: document.getElementById("typeTextFirstName").value,
                    lastName: document.getElementById("typeTextLastName").value,
                    phone: document.getElementById("typePhone").value,
                    email: document.getElementById("typeEmail").value,
                    streetAddress: document.getElementById("typeTextAddress").value,
                    city: document.getElementById("selectCity").value,
                    house: document.getElementById("typeTextHouse").value,
                    postalCode: document.getElementById("typeTextPostalCode").value,
                    zip: document.getElementById("typeTextZip").value,
                };
                
            

            saveUserAddress(userAddress);
        });
    

// Function to handle the "Complete Order" button click
completeOrderButton.addEventListener('click', () => {
    // Retrieve cart items from local storage
    const cartItems = JSON.parse(localStorage.getItem('cart'));
    // Send a request to the server to complete the order
    fetch('complete_order.php', {
        method: 'POST',
        body: JSON.stringify(cartItems),
        headers: {
            'Content-Type': 'application/json'
        }
    })


    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.text();
    })
    .then(data => {
        try {
            const jsonData = JSON.parse(data); // Try to parse the response as JSON
            if (jsonData.message) {
                const orderId = jsonData.orderID;
                alert(`Your order has been placed order ID: ${orderId}`);
            } else {
                console.error('Error:', jsonData);
            }
        } catch (error) {
            console.error('Error parsing JSON:', error);
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
});

   
    // Initial setup
    displayProducts();
    updateTotalPrice();
});
