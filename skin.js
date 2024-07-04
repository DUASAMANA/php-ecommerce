const menuIcon = document.querySelector('.menu-icon');
const cartIcon = document.querySelector('.cart-icon');
const menuSidebar = document.querySelector('.menu-sidebar');
const cartSidebar = document.querySelector('.cart-sidebar');
const content = document.querySelector('.content');


menuIcon.addEventListener('click', () => {
    console.log('Menu icon clicked');
    menuSidebar.classList.toggle('active');
    cartSidebar.classList.remove('active');
});



content.addEventListener('click', () => {
    menuSidebar.classList.remove('active');
    cartSidebar.classList.remove('active');
});


cartIcon.addEventListener('click', () => {
    cartSidebar.classList.toggle('active');
    menuSidebar.classList.remove('active');
});



const closeIcon = document.querySelector('.close-icon');

// Get the close icons within both sidebars
const menuCloseIcon = menuSidebar.querySelector('.close-icon');
const cartCloseIcon = cartSidebar.querySelector('.close-icon');

// Add a click event listener to the menu close icon
menuCloseIcon.addEventListener('click', () => {
    menuSidebar.classList.remove('active'); // Close the menu sidebar
});

// Add a click event listener to the cart close icon
cartCloseIcon.addEventListener('click', () => {
    cartSidebar.classList.remove('active'); // Close the cart sidebar
});


// Close both sidebars when clicking outside them
content.addEventListener('click', () => {
    menuSidebar.classList.remove('active');
    cartSidebar.classList.remove('active');
});




// Define an array to store cart items
let cart = [];

// Function to add an item to the cart
function addToCart(name, price, image) {
    const quantity = 1; // You can change this as needed

    // Check if the item is already in the cart
    const existingItem = cart.find(item => item.name === name);

    if (existingItem) {
        // If item already exists, increase the quantity
        existingItem.quantity += quantity;
    } else {
        // If item doesn't exist, add it to the cart
        cart.push({ name, price, image, quantity });
    }




 // Save the updated cart to local storage
 saveCartToLocalStorage(cart);






    // Update the cart UI
    updateCartUI();
}

// Function to remove an item from the cart
function removeFromCart(name) {
    cart = cart.filter(item => item.name !== name);




 // Save the updated cart to local storage
 saveCartToLocalStorage(cart);




    // Update the cart UI
    updateCartUI();
}



// Function to retrieve the cart from local storage
function getCartFromLocalStorage() {
    const cartJSON = localStorage.getItem('cart');
    return JSON.parse(cartJSON) || [];
}

// Function to save the cart to local storage
function saveCartToLocalStorage(cart) {
    const cartJSON = JSON.stringify(cart);
    localStorage.setItem('cart', cartJSON);
}

// Initialize the cart from local storage
cart = getCartFromLocalStorage();

// Add an event listener to ensure that the cart is saved to local storage before leaving the page
window.addEventListener('beforeunload', () => {
    saveCartToLocalStorage(cart);
});







// Function to update the cart UI
function updateCartUI() {
    const cartItems = document.getElementById('cart-items');
    const cartTotal = document.getElementById('cart-total');

    // Clear the cart UI
    cartItems.innerHTML = '';

    // Iterate through cart items and display them
    let total = 0;
    cart.forEach(item => {
        const itemTotal = item.price * item.quantity;
        total += itemTotal;

        const cartItem = document.createElement('div');
        cartItem.classList.add('cart-item');
        cartItem.innerHTML = `
            <img src="${item.image}" alt="${item.name}" width="50">
            <span>${item.name}</span>
            <span>Ksh${item.price.toFixed(2)}</span>
            <input type="number" class="item-quantity" value="${item.quantity}" min="1">
            <button class="remove-item" data-product-name="${item.name}">Remove</button>
        `;

        // Add event listener to the remove button
        const removeButton = cartItem.querySelector('.remove-item');
        removeButton.addEventListener('click', () => {
            removeFromCart(item.name);
        });

        cartItems.appendChild(cartItem);
    });

    // Update the total amount
    cartTotal.textContent = total.toFixed(2);
}

// Add event listener to checkout button
const checkoutButton = document.getElementById('checkout-button');
checkoutButton.addEventListener('click', () => {
    // Redirect the user to the checkout page
    window.location.href = 'checkout.html';
});



//checkout page 

