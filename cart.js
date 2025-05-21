// cart.js 
document.addEventListener('DOMContentLoaded', function() {  const cartItems = document.getElementById('cart-items');  const addButton = document.getElementById('add-product');   
    addButton.addEventListener('click', function() {  const productName = prompt('Enter product name:');  if (productName) { 
    addProductToCart(productName); 
    } 
    }); 
     
    function addProductToCart(productName) { 
    const listItem = document.createElement('li');  listItem.textContent = productName; 
     
    const removeButton = document.createElement('button');  removeButton.textContent = 'Remove'; 
    removeButton.addEventListener('click', function() {  cartItems.removeChild(listItem); 
    }); 
     
    listItem.appendChild(removeButton); 
    cartItems.appendChild(listItem); 
    } 
    });
   