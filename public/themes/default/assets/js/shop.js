/* Shop / Category Filter Page Interactivity */

document.addEventListener('DOMContentLoaded', () => {
    const categoryRadios = document.querySelectorAll('input[name="categoryFilter"]');
    const typeCheckboxes = document.querySelectorAll('.type-filter');
    const productCards = document.querySelectorAll('.product-item-col');
    const clearBtn = document.querySelector('.btn-clear-filters');
    const sortSelect = document.getElementById('sortProductsSelect');

    // Filter Logic
    function filterProducts() {
        let selectedCategory = 'all';
        categoryRadios.forEach(radio => {
            if (radio.checked) {
                selectedCategory = radio.value;
            }
        });

        const selectedTypes = [];
        typeCheckboxes.forEach(cb => {
            if (cb.checked) {
                selectedTypes.push(cb.value);
            }
        });

        productCards.forEach(card => {
            const cardCategory = card.getAttribute('data-category');
            const cardType = card.getAttribute('data-type');

            const categoryMatch = (selectedCategory === 'all' || cardCategory === selectedCategory);
            const typeMatch = (selectedTypes.length === 0 || selectedTypes.includes(cardType));

            if (categoryMatch && typeMatch) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });
    }

    // Event Listeners for Filters
    categoryRadios.forEach(radio => {
        radio.addEventListener('change', filterProducts);
    });
    typeCheckboxes.forEach(cb => {
        cb.addEventListener('change', filterProducts);
    });

    if (clearBtn) {
        clearBtn.addEventListener('click', () => {
            categoryRadios.forEach((radio, index) => {
                radio.checked = (index === 0);
            });
            const allCheckboxes = document.querySelectorAll('.aire-checkbox, .type-filter');
            allCheckboxes.forEach(cb => {
                cb.checked = false;
            });
            filterProducts();
        });
    }

    // Sort Logic
    if (sortSelect) {
        sortSelect.addEventListener('change', (e) => {
            const val = e.target.value;
            const container = document.getElementById('productGridContainer');
            if (!container) return;

            const cardsArr = Array.from(productCards);
            cardsArr.sort((a, b) => {
                const priceA = parseFloat(a.getAttribute('data-price') || 0);
                const priceB = parseFloat(b.getAttribute('data-price') || 0);

                if (val === 'price-low') {
                    return priceA - priceB;
                } else if (val === 'price-high') {
                    return priceB - priceA;
                }
                return 0;
            });

            cardsArr.forEach(card => container.appendChild(card));
        });
    }

    // Collapsible Filter Groups & Accordions
    const filterGroupHeaders = document.querySelectorAll('.filter-group-header');
    filterGroupHeaders.forEach(header => {
        header.addEventListener('click', () => {
            const groupItem = header.closest('.filter-group-item');
            const optionList = groupItem.querySelector('.filter-option-list');
            const icon = header.querySelector('i');

            if (optionList) {
                if (optionList.style.display === 'none') {
                    optionList.style.display = 'flex';
                    if (icon) {
                        icon.classList.remove('bi-chevron-down');
                        icon.classList.add('bi-chevron-up');
                    }
                } else {
                    optionList.style.display = 'none';
                    if (icon) {
                        icon.classList.remove('bi-chevron-up');
                        icon.classList.add('bi-chevron-down');
                    }
                }
            }
        });
    });

    const roomAccordions = document.querySelectorAll('.room-accordion-item');
    roomAccordions.forEach(item => {
        item.addEventListener('click', () => {
            const icon = item.querySelector('i');
            let subContent = item.querySelector('.accordion-sub-content');

            if (!subContent) {
                // Create dummy sub-content if not present
                subContent = document.createElement('div');
                subContent.className = 'accordion-sub-content text-muted small ps-2 pt-2 pb-1';
                subContent.style.fontSize = '12px';
                subContent.style.textTransform = 'none';
                subContent.style.fontWeight = 'normal';
                subContent.innerHTML = '<div>• Option 1</div><div>• Option 2</div><div>• Option 3</div>';
                item.appendChild(subContent);
            } else {
                if (subContent.style.display === 'none') {
                    subContent.style.display = 'block';
                    if (icon) {
                        icon.classList.remove('bi-chevron-down');
                        icon.classList.add('bi-chevron-up');
                    }
                } else {
                    subContent.style.display = 'none';
                    if (icon) {
                        icon.classList.remove('bi-chevron-up');
                        icon.classList.add('bi-chevron-down');
                    }
                }
            }
        });
    });

    // GSAP ScrollTrigger Pinned Deck Animation (Bottom to Top Reveal)
    if (typeof gsap !== 'undefined' && typeof ScrollTrigger !== 'undefined') {
        gsap.registerPlugin(ScrollTrigger);

        const stackedWrapper = document.getElementById('whyChooseWrapper') || document.getElementById('whyChooseStackedWrapper');
        if (stackedWrapper && window.innerWidth >= 992) {
            const tl = gsap.timeline({
                scrollTrigger: {
                    trigger: stackedWrapper,
                    start: "top 90px",
                    end: "+=1200",
                    scrub: 1,
                    pin: true,
                    anticipatePin: 1
                }
            });

            tl.to("#whyChooseWrapper .card-layer-2", { y: "0%", ease: "power1.out", duration: 1 })
              .to("#whyChooseWrapper .card-layer-3", { y: "0%", ease: "power1.out", duration: 1 })
              .to("#whyChooseWrapper .card-layer-4", { y: "0%", ease: "power1.out", duration: 1 });
        }
    }
});
