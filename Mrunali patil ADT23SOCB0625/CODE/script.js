// Function to open booking form
function openBookingForm() {
    document.getElementById("booking-form").style.display = "flex";
}

// Function to close booking form
function closeBookingForm() {
    document.getElementById("booking-form").style.display = "none";
}

// Function to close confirmation popup
function closePopup() {
    document.getElementById("popup").style.display = "none";
    document.getElementById("appointmentForm").reset(); // Clear form
    closeBookingForm(); // Close booking form after confirmation
}

// Show popup when form is submitted
document.getElementById("appointmentForm").addEventListener("submit", function(event) {
    event.preventDefault(); // Prevent form from submitting
    document.getElementById("popup").style.display = "flex"; // Show popup
});

// Array of background images
const bgImages = [
    "image/img4.jpg",
   "image/img5.jpg",
   "image/img6.jpg",
   "image/img7.jpg",
   "image/img8.jpg",
];

let currentIndex = 0;
const heroSection = document.querySelector(".hero");

// Function to change background image
function changeBackground() {
    heroSection.style.backgroundImage = `url(${bgImages[currentIndex]})`;
    currentIndex = (currentIndex + 1) % bgImages.length;
}

// Change image every 5 seconds
setInterval(changeBackground, 5000);

// Set initial background image
changeBackground();

document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("appointmentForm");
    const popup = document.getElementById("popup");
    const overlay = document.getElementById("form-overlay");
    const bookingForm = document.getElementById("booking-form");

    form.addEventListener("submit", function (event) {
        event.preventDefault(); // Prevent default form submission
        
        // Hide the booking form and overlay
        bookingForm.style.display = "none";
        overlay.style.display = "none";

        // Show the confirmation popup
        popup.style.display = "flex";
    });

    function closePopup() {
        popup.style.display = "none";
        form.reset(); // Clear form fields
    }

    document.getElementById("closePopup").addEventListener("click", closePopup);
});
