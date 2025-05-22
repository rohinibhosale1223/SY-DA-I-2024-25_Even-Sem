// Store all products info here for image mapping and details
const productsInfo = {
  "Rose Elegance": {
    price: 49.99,
    img: "img/perfume1.jpg",
  },
  "Ocean Breeze": {
    price: 59.99,
    img: "img/perfume2.jpg",
  },
  "Night Charm": {
    price: 69.99,
    img: "img/perfume3.jpg",
  },
  "Amber Gold": {
    price: 74.99,
    img: "img/perfume4.jpg",
  },
  "Citrus Spark": {
    price: 44.99,
    img: "img/perfume5.jpg",
  },
  "Mystic Oud": {
    price: 89.99,
    img: "img/perfume6.jpg",
  },
};

// Update cart count in header
function updateCartCount() {
  const cart = JSON.parse(localStorage.getItem("cart")) || {};
  let count = 0;
  for (let key in cart) {
    count += cart[key];
  }
  document.getElementById("cart-count").textContent = count;
}

// Add product to cart
function addToCart(name, price) {
  let cart = JSON.parse(localStorage.getItem("cart")) || {};
  if (cart[name]) {
    cart[name]++;
  } else {
    cart[name] = 1;
  }
  localStorage.setItem("cart", JSON.stringify(cart));
  updateCartCount();
  alert(name + " added to cart!");
}

// Display cart items on cart page
function displayCart() {
  const cart = JSON.parse(localStorage.getItem("cart")) || {};
  const cartItemsDiv = document.getElementById("cart-items");
  const cartTotalDiv = document.getElementById("cart-total");

  if (!cartItemsDiv) return; // Not on cart page

  if (Object.keys(cart).length === 0) {
    cartItemsDiv.innerHTML = "<p>Your cart is empty.</p>";
    cartTotalDiv.textContent = "";
    return;
  }

  let html = `<table>
    <thead>
      <tr>
        <th>Product</th>
        <th>Image</th>
        <th>Price</th>
        <th>Quantity</th>
        <th>Subtotal</th>
        <th>Remove</th>
      </tr>
    </thead>
    <tbody>`;

  let total = 0;
  for (const [name, qty] of Object.entries(cart)) {
    const price = productsInfo[name].price;
    const img = productsInfo[name].img;
    const subtotal = price * qty;
    total += subtotal;

    html += `
      <tr>
        <td>${name}</td>
        <td><img src="${img}" alt="${name}"></td>
        <td>$${price.toFixed(2)}</td>
        <td><input type="number" min="1" value="${qty}" onchange="updateQuantity('${name}', this.value)"></td>
        <td>$${subtotal.toFixed(2)}</td>
        <td><button onclick="removeItem('${name}')">Remove</button></td>
      </tr>
    `;
  }
  html += "</tbody></table>";
  cartItemsDiv.innerHTML = html;
  cartTotalDiv.textContent = "Total: $" + total.toFixed(2);
}

// Update quantity of an item in cart
function updateQuantity(name, qty) {
  qty = parseInt(qty);
  if (qty <= 0 || isNaN(qty)) {
    alert("Quantity must be at least 1");
    displayCart();
    return;
  }
  const cart = JSON.parse(localStorage.getItem("cart")) || {};
  cart[name] = qty;
  localStorage.setItem("cart", JSON.stringify(cart));
  updateCartCount();
  displayCart();
}

// Remove an item completely
function removeItem(name) {
  const cart = JSON.parse(localStorage.getItem("cart")) || {};
  delete cart[name];
  localStorage.setItem("cart", JSON.stringify(cart));
  updateCartCount();
  displayCart();
}

// Clear entire cart
function clearCart() {
  if (confirm("Are you sure you want to clear the entire cart?")) {
    localStorage.removeItem("cart");
    updateCartCount();
    displayCart();
  }
}

// Run on page load
window.onload = () => {
  updateCartCount();
  displayCart();
};
