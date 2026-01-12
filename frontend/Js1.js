document.addEventListener("DOMContentLoaded", function() {
    const bulletin = document.getElementById('bulletin');
    const ul = bulletin.querySelector('ul');
    const items = ul.children;
    let currentIndex = 0;

    function updateBulletin() {
        ul.style.top = `-${currentIndex * 60}px`; // Change 60px based on height
        currentIndex = (currentIndex + 1) % items.length;
    }

    setInterval(updateBulletin, 3000); // Change item every 3 seconds
});
