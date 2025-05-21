// ===== Cart System =====
let cart = JSON.parse(localStorage.getItem('cart')) || [];

// Add to Cart Functionality
document.addEventListener('DOMContentLoaded', function() {
  // Add to Cart Buttons
  document.querySelectorAll('.add-to-cart').forEach(button => {
    button.addEventListener('click', function(e) {
      const productCard = e.target.closest('.product-card');
      const product = {
        id: productCard.dataset.id,
        name: productCard.querySelector('h3').textContent,
        price: productCard.querySelector('.price').textContent,
        quantity: 1
      };

      addToCart(product);
      updateCartCount();
      showCartNotification(product.name);
    });
  });

  // Update Cart Display if on Cart Page
  if (document.querySelector('.cart-items')) {
    renderCartItems();
    setupCartControls();
  }

  // Theme Toggle
  const themeToggle = document.getElementById('themeToggle');
  if (themeToggle) {
    themeToggle.addEventListener('click', () => {
      document.body.setAttribute('data-theme', 
        document.body.getAttribute('data-theme') === 'light' ? 'dark' : 'light'
      );
    });
  }
});

// Cart Functions
function addToCart(product) {
  const existingItem = cart.find(item => item.id === product.id);
  
  if (existingItem) {
    existingItem.quantity += 1;
  } else {
    cart.push(product);
  }
  
  saveCart();
}

function removeFromCart(productId) {
  cart = cart.filter(item => item.id !== productId);
  saveCart();
  renderCartItems();
}

function updateQuantity(productId, newQuantity) {
  const item = cart.find(item => item.id === productId);
  if (item) {
    item.quantity = parseInt(newQuantity);
    if (item.quantity <= 0) {
      removeFromCart(productId);
    } else {
      saveCart();
      renderCartItems();
    }
  }
}

function saveCart() {
  localStorage.setItem('cart', JSON.stringify(cart));
}

function getCartTotal() {
  return cart.reduce((total, item) => {
    return total + (parseFloat(item.price.replace(/[^0-9.]/g, '')) * item.quantity);
  }, 0);
}

// UI Updates
function renderCartItems() {
  const cartItemsContainer = document.querySelector('.cart-items');
  const cartSummary = document.querySelector('.cart-summary');
  
  if (!cartItemsContainer) return;

  cartItemsContainer.innerHTML = '';
  
  if (cart.length === 0) {
    cartItemsContainer.innerHTML = '<p class="empty-cart">Your cart is empty</p>';
    cartSummary.innerHTML = '<p>Subtotal: $0.00</p>';
    return;
  }

  cart.forEach(item => {
    const cartItem = document.createElement('div');
    cartItem.className = 'cart-item';
    cartItem.innerHTML = `
      <div class="item-info">
        <h4>${item.name}</h4>
        <p>${item.price}</p>
      </div>
      <div class="item-controls">
        <input type="number" min="1" value="${item.quantity}" 
               data-id="${item.id}" class="quantity-input">
        <button class="remove-item" data-id="${item.id}">×</button>
      </div>
    `;
    cartItemsContainer.appendChild(cartItem);
  });

  cartSummary.innerHTML = `
    <p>Subtotal: ${getCartTotal().toFixed(2)}</p>
    <button class="checkout-btn">Proceed to Checkout</button>
  `;
}

function setupCartControls() {
  // Quantity changes
  document.querySelectorAll('.quantity-input').forEach(input => {
    input.addEventListener('change', (e) => {
      updateQuantity(e.target.dataset.id, e.target.value);
    });
  });

  // Remove buttons
  document.querySelectorAll('.remove-item').forEach(button => {
    button.addEventListener('click', (e) => {
      removeFromCart(e.target.dataset.id);
    });
  });
}

function updateCartCount() {
  const cartCount = document.getElementById('cart-count');
  if (cartCount) {
    const totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);
    cartCount.textContent = totalItems;
    cartCount.style.display = totalItems > 0 ? 'flex' : 'none';
  }
}

function showCartNotification(productName) {
  const notification = document.createElement('div');
  notification.className = 'cart-notification';
  notification.innerHTML = `
    <p>${productName} added to cart!</p>
  `;
  document.body.appendChild(notification);
  
  setTimeout(() => {
    notification.classList.add('show');
  }, 10);
  
  setTimeout(() => {
    notification.classList.remove('show');
    setTimeout(() => {
      notification.remove();
    }, 300);
  }, 3000);
}

// Form Submissions
document.getElementById('contact-form')?.addEventListener('submit', (e) => {
  e.preventDefault();
  alert('Message sent!');
  e.target.reset();
});

document.getElementById('register-form')?.addEventListener('submit', (e) => {
  e.preventDefault();
  alert('Registration successful!');
  window.location.href = 'login.html';
});

document.getElementById('login-form')?.addEventListener('submit', (e) => {
  e.preventDefault();
  alert('Login successful!');
  window.location.href = 'index.html';
});
// Add this at the end of the DOMContentLoaded event listener
document.addEventListener('DOMContentLoaded', function() {
    // ... existing code ...
    
    // Initialize cart count
    updateCartCount();
  });