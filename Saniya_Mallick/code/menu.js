// menu.js

// Function to redirect based on mood
function goToMoodPage(mood) {
  const moodPage = mood.toLowerCase() + ".php"; // e.g., relax.html, study.html
  window.location.href = moodPage;
}

// Attach event listeners to each mood button
document.querySelectorAll('.mood-button').forEach(button => {
  button.addEventListener('click', function () {
    const mood = this.textContent.trim(); // Get button text (e.g., "Relax")
    goToMoodPage(mood);
  });
});

