/**
 * AIRE About Page Script
 */
document.addEventListener('DOMContentLoaded', () => {
    // Intersection Observer for scrollspy left sidebar menu
    const sections = document.querySelectorAll('.content-section');
    const menuItems = document.querySelectorAll('.sidebar-menu .menu-item');

    if (sections.length && menuItems.length) {
        const observerOptions = {
            root: null,
            rootMargin: '-20% 0px -80% 0px',
            threshold: 0
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    menuItems.forEach(item => item.classList.remove('active'));
                    const id = entry.target.getAttribute('id');
                    const activeLinks = document.querySelectorAll(`.sidebar-menu .menu-item[href="#${id}"]`);
                    activeLinks.forEach(link => {
                        link.classList.add('active');
                    });
                }
            });
        }, observerOptions);

        sections.forEach(section => observer.observe(section));
    }
});
