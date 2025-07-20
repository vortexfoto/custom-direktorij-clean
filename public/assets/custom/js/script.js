
// Custom JS za direktorij.eu

document.addEventListener('DOMContentLoaded', function() {
    const cards = document.querySelectorAll('.card');
    cards.forEach(card => {
        card.addEventListener('click', () => {
            card.classList.toggle('active');
        });
    });
});
