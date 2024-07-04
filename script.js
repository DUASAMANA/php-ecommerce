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






