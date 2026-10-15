
document.addEventListener('DOMContentLoaded', function () {
    if (window.__legalJsInitialized) return;
    window.__legalJsInitialized = true;

    // 1. Accordion Toggle Behavior
    const accordionItems = document.querySelectorAll('.legal-accordion-item');
    accordionItems.forEach(item => {
        const header = item.querySelector('.legal-accordion-header');
        if (!header) return;

        header.addEventListener('click', function (e) {
            e.preventDefault();
            const isOpen = item.classList.contains('is-open');

            // Optional: Close others if single-open mode is desired, or let users keep multiple open
            // In our legal viewer, keeping open on demand is user friendly
            if (isOpen) {
                item.classList.remove('is-open');
            } else {
                item.classList.add('is-open');
            }
        });
    });

    // 2. Print Page Button
    const printBtn = document.getElementById('legalPrintBtn');
    if (printBtn) {
        printBtn.addEventListener('click', function (e) {
            e.preventDefault();
            // Open all accordions before printing
            accordionItems.forEach(i => i.classList.add('is-open'));
            window.print();
        });
    }

    // 3. Save Cookie Preferences Button
    const saveCookieBtn = document.getElementById('saveCookiePreferencesBtn');
    if (saveCookieBtn) {
        saveCookieBtn.addEventListener('click', function (e) {
            e.preventDefault();
            const analytics = document.getElementById('cookie_analytics')?.checked ?? false;
            const functional = document.getElementById('cookie_functional')?.checked ?? false;
            const marketing = document.getElementById('cookie_marketing')?.checked ?? false;

            const consentData = {
                essential: true,
                analytics: analytics,
                functional: functional,
                marketing: marketing,
                timestamp: new Date().toISOString()
            };

            try {
                localStorage.setItem('aire_cookie_preferences', JSON.stringify(consentData));
            } catch (err) {
                console.warn('Could not store preferences in localStorage', err);
            }

            // Visual feedback
            const originalText = saveCookieBtn.innerHTML;
            saveCookieBtn.innerHTML = '<i class="bi bi-check2 me-1"></i> Preferences Saved!';
            saveCookieBtn.classList.add('btn-success');
            saveCookieBtn.classList.remove('btn-primary');

            setTimeout(() => {
                saveCookieBtn.innerHTML = originalText;
                saveCookieBtn.classList.remove('btn-success');
                saveCookieBtn.classList.add('btn-primary');
            }, 2500);

            if (typeof window.showNewsletterToast === 'function') {
                window.showNewsletterToast('Your cookie preferences have been updated.', true);
            } else if (window.AireToast) {
                window.AireToast.success('Your cookie preferences have been updated.');
            }
        });
    }

    // 4. Download PDF / Export simulation or handler
    const downloadPdfBtn = document.getElementById('legalPdfBtn');
    if (downloadPdfBtn) {
        downloadPdfBtn.addEventListener('click', function (e) {
            e.preventDefault();
            accordionItems.forEach(i => i.classList.add('is-open'));
            window.print();
        });
    }
});
