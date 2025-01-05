let cartItems = JSON.parse(localStorage.getItem("cart-items")) || [];
let cartContainer = document.querySelector("#cart-items");
let totalPriceElement = document.querySelector("#total-price");

// Function to display cart items
function displayCartItems() {
    cartContainer.innerHTML = ''; // Clear container before inserting new content
    let total = 0;

    cartItems.forEach(item => {
        cartContainer.innerHTML += `
            <div class="cart-item d-flex justify-content-between align-items-center">
                <img src="${item.imageUrl}" alt="${item.name}" class="cart-item-img" style="width: 50px; height: 50px;">
                <div class="item-info">
                    <h6>${item.name}</h6>
                    <p class="item-price">${item.price.toFixed(2)}</p> <!-- Price per unit -->
                    <span>${item.category}</span>
                </div>
                <div class="quantity-controls d-flex align-items-center">
                    <button class="decrease btn btn-sm btn-danger">-</button>
                    <span class="item-quantity mx-2">${item.quantity}</span>
                    <button class="increase btn btn-sm btn-success">+</button>
                </div>
                <button class="remove-btn btn btn-sm btn-danger">Remove</button>
            </div>
        `;
        total += item.price * item.quantity;
    });

    totalPriceElement.textContent = total.toFixed(2);
}

// Store the cart counter when a product is added to the cart
function updateCartCounter() {
    const cartCount = cartItems.reduce((acc, item) => acc + item.quantity, 0);
    localStorage.setItem('cartCount', cartCount);
    document.getElementById('cart-counter').innerText = cartCount;
}

// Function to update total price
function updateTotalPrice() {
    let total = 0;
    cartItems.forEach(item => {
        total += item.price * item.quantity;
    });
    document.getElementById('total-price').innerText = total.toFixed(2);
}

// Event listeners for increasing/decreasing quantity
function attachEventListeners() {
    document.querySelectorAll('.increase').forEach((button, index) => {
        button.addEventListener('click', () => {
            cartItems[index].quantity++;
            updateCart(cartItems);
        });
    });

    document.querySelectorAll('.decrease').forEach((button, index) => {
        button.addEventListener('click', () => {
            if (cartItems[index].quantity > 1) {
                cartItems[index].quantity--;
                updateCart(cartItems);
            }
        });
    });

    document.querySelectorAll('.remove-btn').forEach((button, index) => {
        button.addEventListener('click', () => {
            cartItems.splice(index, 1);
            updateCart(cartItems);
        });
    });
}

// Update cart in localStorage and refresh UI
function updateCart(updatedItems) {
    localStorage.setItem("cartItems", JSON.stringify(updatedItems));
    displayCartItems();
    updateTotalPrice();
    updateCartCounter();
    attachEventListeners(); // Reattach listeners after rendering new items
}

// Initialize cart on page load
document.addEventListener("DOMContentLoaded", () => {
    displayCartItems();
    updateTotalPrice();
    updateCartCounter();
    attachEventListeners();
});
