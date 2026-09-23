/**
 * AIRE Solutions Page Script
 */
document.addEventListener('DOMContentLoaded', () => {
    // Initialize Swiper for featured solutions sidebar card
    const swiper = new Swiper('.featured-swiper', {
        loop: true,
        autoplay: {
            delay: 5000,
            disableOnInteraction: false,
        },
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        effect: 'fade',
        fadeEffect: {
            crossFade: true
        }
    });

    // Intersection Observer for scrollspy left menu & mobile horizontal pills
    const sections = document.querySelectorAll('.content-section');
    const menuItems = document.querySelectorAll('.sidebar-menu .menu-item, .mobile-cat-pill');

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
                const activeLinks = document.querySelectorAll(`.sidebar-menu .menu-item[href="#${id}"], .mobile-cat-pill[href="#${id}"]`);
                activeLinks.forEach(link => {
                    link.classList.add('active');
                    if (link.classList.contains('mobile-cat-pill')) {
                        link.scrollIntoView({ behavior: 'smooth', inline: 'center', block: 'nearest' });
                    }
                });
            }
        });
    }, observerOptions);

    sections.forEach(section => observer.observe(section));
});
