// Dark Mode Toggle
const darkModeToggle = document.createElement("button");
darkModeToggle.textContent = "🌙";
darkModeToggle.classList.add("dark-mode-toggle");
document.body.prepend(darkModeToggle);

darkModeToggle.addEventListener("click", function () {
    document.body.classList.toggle("dark-mode");
    darkModeToggle.textContent = document.body.classList.contains("dark-mode") ? "☀️" : "🌙";
    localStorage.setItem("dark-mode", document.body.classList.contains("dark-mode"));
});

// Load dark mode preference
if (localStorage.getItem("dark-mode") === "true") {
    document.body.classList.add("dark-mode");
    darkModeToggle.textContent = "☀️";
}

// Favorite Blogs - Add & Display
function getFavorites() {
    const storedFavorites = localStorage.getItem("favorites");
    return storedFavorites ? JSON.parse(storedFavorites) : [];
}

function saveFavorites(favorites) {
    localStorage.setItem("favorites", JSON.stringify(favorites));
    updateFavoritesCount();
}

function updateFavoritesCount() {
    const count = getFavorites().length;
    document.querySelectorAll("#favorites-count").forEach(el => {
        el.textContent = count;
    });
}

function updateFavButtonUI(button, isFavorite) {
    if (button) {
        button.classList.toggle('active', isFavorite);
        button.textContent = isFavorite ? 'Added' : 'Add';
    }
}

function addToFavorites(title, link, buttonElement) {
    let favorites = getFavorites();
    const existingIndex = favorites.findIndex(item => item.title === title);
    if (existingIndex === -1) {
        favorites.push({ title, link });
        saveFavorites(favorites);
        updateFavButtonUI(buttonElement, true);
        alert("Added to favorites!");
    } else {
        favorites.splice(existingIndex, 1);
        saveFavorites(favorites);
        updateFavButtonUI(buttonElement, false);
        alert("Removed from favorites!");
    }
    displayFavorites();
}

// Event listener for favorite buttons
document.addEventListener('click', function (event) {
    if (event.target.classList.contains('fav-button')) {
        const button = event.target;
        const title = button.dataset.title;
        const link = button.dataset.link;
        addToFavorites(title, link, button);
    }
});

// Initialize favorite buttons on page load
document.querySelectorAll(".fav-button").forEach(button => {
    const title = button.dataset.title;
    updateFavButtonUI(button, getFavorites().some(item => item.title === title));
});
function displayFavorites() {
    const favoritesList = document.getElementById("favorites-list");
    const emptyMessage = document.getElementById("empty-message");
    const isFavouritePage = window.location.pathname.includes("favourite.html"); // Check if it's the 'blogs read' page

    if (!favoritesList) return console.log("favorites-list element not found!");

    favoritesList.innerHTML = "";
    const favorites = getFavorites();
    
    console.log("Favorites retrieved:", favorites);

    if (favorites.length === 0) {
        emptyMessage.style.display = 'block';
        favoritesList.style.display = 'none';
        return;
    } else {
        emptyMessage.style.display = 'none';
        favoritesList.style.display = 'block';
    }

    favorites.forEach((item) => {
        const li = document.createElement("li");
        li.innerHTML = `
            <a href="${item.link || "#"}" target="_blank">${item.title || "Untitled"}</a>
            ${!isFavouritePage ? `<button class="remove-btn" data-title="${item.title}">Remove</button>` : ""}
        `;
        favoritesList.appendChild(li);
    });
}


// Event listener for removing from favorites
document.addEventListener('click', function (event) {
    if (event.target.classList.contains('remove-btn')) {
        removeFromFavorites(event.target.dataset.title);
    }
});

function removeFromFavorites(title) {
    saveFavorites(getFavorites().filter(item => item.title !== title));
    displayFavorites();
}

// Ensure favorites count updates when the page loads
updateFavoritesCount();

// Display favorites if on the view_favourites.html page
if (window.location.pathname.includes('view_favourites.html')) {
    document.addEventListener("DOMContentLoaded", displayFavorites);
}
// Display favorites if on the view_favourites.html page
if (window.location.pathname.includes('favourite.html')) {
    document.addEventListener("DOMContentLoaded", displayFavorites);
}
document.getElementById("contact-form").addEventListener("submit", function (event) {
    event.preventDefault();

    const formData = new FormData(this);

    fetch("save-form.php", {
        method: "POST",
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.getElementById("success-message").style.display = "block";
            this.reset(); // Clear form after successful submission
        } else {
            alert("❌ Failed to submit. Please try again.");
        }
    })
    .catch(error => console.error("Error:", error));
});
