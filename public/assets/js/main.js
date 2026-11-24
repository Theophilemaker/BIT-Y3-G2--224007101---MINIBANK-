// public/assets/js/main.js
document.addEventListener('DOMContentLoaded', () => {
    // Add active class highlighting for sidebar
    const currentPath = window.location.pathname;
    const menuItems = document.querySelectorAll('.sidebar-menu a');
    
    menuItems.forEach(item => {
        if(item.getAttribute('href') && currentPath.includes(item.getAttribute('href'))) {
            item.parentElement.classList.add('active');
        }
    });
});