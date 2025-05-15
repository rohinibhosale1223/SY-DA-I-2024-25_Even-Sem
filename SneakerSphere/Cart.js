document.addEventListener("DOMContentLoaded", () => {
    if (sessionStorage.getItem("isLoggedIn") !== "true") {
        alert("Please log in to access your cart.");
        window.location.href = "login.html";
        return;
    }

    const userEmail = sessionStorage.getItem("userEmail");
    const cartContainer = document.querySelector(".cart-items");
    const cartTotal = document.querySelector(".cart-total");
    const cartCount = document.querySelector(".cart-count");

    function getCart() {
        return JSON.parse(localStorage.getItem(`cart_${userEmail}`)) || [];
    }

    function saveCart(cart) {
        localStorage.setItem(`cart_${userEmail}`, JSON.stringify(cart));
    }

document.addEventListener("DOMContentLoaded", () => {
    const cartContainer = document.querySelector(".cart-items");
    const cartTotal = document.querySelector(".cart-total");
    const cartCount = document.querySelector(".cart-count");
    
    function getCart() {
        return JSON.parse(localStorage.getItem("cart")) || [];
    }

    function saveCart(cart) {
        localStorage.setItem("cart", JSON.stringify(cart));
    }

    function updateCartDisplay() {
        const cart = getCart();
        cartContainer.innerHTML = "";
        let total = 0;
        
        if (cart.length === 0) {
            cartContainer.innerHTML = "<p>Your cart is empty.</p>";
        } else {
            cart.forEach((item, index) => {
                total += item.price * item.quantity;
                cartContainer.innerHTML += `
                    <div class="cart-item">
                        <img src="${item.image}" alt="${item.name}">
                        <h3>${item.name}</h3>
                        <p>Price: ${item.price}/-</p>
                        <input type="number" value="${item.quantity}" min="1" data-index="${index}" class="quantity-input">
                        <button class="remove-btn" data-index="${index}">Remove</button>
                    </div>
                `;
            });
        }

        cartTotal.textContent = `${total}/-`;
        cartCount.textContent = `(${cart.length})`;
        saveCart(cart);
    }

    cartContainer.addEventListener("change", (e) => {
        if (e.target.classList.contains("quantity-input")) {
            const cart = getCart();
            const index = e.target.getAttribute("data-index");
            cart[index].quantity = parseInt(e.target.value);
            saveCart(cart);
            updateCartDisplay();
        }
    });

    cartContainer.addEventListener("click", (e) => {
        if (e.target.classList.contains("remove-btn")) {
            const cart = getCart();
            const index = e.target.getAttribute("data-index");
            cart.splice(index, 1);
            saveCart(cart);
            updateCartDisplay();
        }
    });

    function addProduct(prodDetails) {
        let cart = getCart();
        let existingItem = cart.find(item => item.name === prodDetails.name);
        
        if (existingItem) {
            existingItem.quantity++;
        } else {
            cart.push({...prodDetails, quantity: 1});
        }
        
        saveCart(cart);
        cartCount.textContent = `(${cart.length})`;
    }

    window.addProduct = addProduct;
    updateCartDisplay();
});
});
