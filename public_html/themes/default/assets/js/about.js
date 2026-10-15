/**
 * AIRE About Page Script
 * 100% Synced with Category Index & Products Navigation Pattern
 */
document.addEventListener('DOMContentLoaded', () => {
    const sections = document.querySelectorAll('.content-section');
    const menuItems = document.querySelectorAll('.sidebar-menu .menu-item, .mobile-cat-pill');
    let isClickScrolling = false;
    let scrollTimeout = null;

    function setActiveCategory(targetId) {
        if (!targetId) return;
        const hashId = targetId.startsWith('#') ? targetId : '#' + targetId;

        // Remove active from all hash-based sidebar items and mobile pills
        document.querySelectorAll('.sidebar-menu .menu-item[href^="#"], .mobile-cat-pill[href^="#"]').forEach(item => {
            item.classList.remove('active');
        });

        // Add active to matching links
        const activeLinks = document.querySelectorAll(`.sidebar-menu .menu-item[href="${hashId}"], .mobile-cat-pill[href="${hashId}"]`);
        activeLinks.forEach(link => {
            link.classList.add('active');
            if (link.classList.contains('mobile-cat-pill')) {
                link.scrollIntoView({ behavior: 'smooth', inline: 'center', block: 'nearest' });
            }
        });
    }

    function scrollToSection(targetElement, targetId) {
        if (!targetElement) return;

        isClickScrolling = true;
        clearTimeout(scrollTimeout);
        scrollTimeout = setTimeout(() => {
            isClickScrolling = false;
        }, 800);

        setActiveCategory(targetId);

        // Auto-open child accordions in target section
        targetElement.querySelectorAll('.about-accordion-item').forEach(acc => {
            acc.classList.add('is-open');
        });

        const headerOffset = 90;
        const elementPosition = targetElement.getBoundingClientRect().top;
        const offsetPosition = elementPosition + window.pageYOffset - headerOffset;

        if (window.lenisInstance && typeof window.lenisInstance.scrollTo === 'function') {
            window.lenisInstance.scrollTo(targetElement, {
                offset: -headerOffset,
                duration: 1.0,
                easing: (t) => Math.min(1, 1.001 - Math.pow(2, -10 * t))
            });
        } else {
            window.scrollTo({
                top: offsetPosition,
                behavior: 'smooth'
            });
        }

        if (history.pushState) {
            history.pushState(null, null, targetId);
        }
    }

    // Handle Click Navigation with smooth scroll and header offset
    document.querySelectorAll('.sidebar-menu .menu-item[href^="#"], .mobile-cat-pill[href^="#"], .about-hero-link[href^="#"]').forEach(link => {
        link.addEventListener('click', function (e) {
            const targetId = this.getAttribute('href');
            if (targetId && targetId !== '#' && targetId.length > 1) {
                const targetElement = document.querySelector(targetId);
                if (targetElement) {
                    e.preventDefault();
                    scrollToSection(targetElement, targetId);
                }
            }
        });
    });

    // Intersection Observer for Scrollspy
    if (sections.length && menuItems.length) {
        const observerOptions = {
            root: null,
            rootMargin: '-15% 0px -65% 0px',
            threshold: 0
        };

        const observer = new IntersectionObserver((entries) => {
            if (isClickScrolling) return;

            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const id = entry.target.getAttribute('id');
                    if (id) {
                        setActiveCategory('#' + id);
                    }
                }
            });
        }, observerOptions);

        sections.forEach(section => observer.observe(section));
    }

    // Auto-scroll on initial load with URL hash
    if (window.location.hash) {
        const target = document.querySelector(window.location.hash);
        if (target) {
            setTimeout(() => {
                scrollToSection(target, window.location.hash);
            }, 300);
        }
    }
});
