/**
 * Pre-built Professional Section Templates Library for AIRE Section Builder
 * 
 * Each template provides:
 * - metadata: id, name, category, description, icon, badge
 * - sectionDefaults: optional background, header title, badge, etc.
 * - generateBlocks(): factory function generating fresh block trees with unique IDs.
 */

function generateId(prefix = 'blk') {
  return `${prefix}_${Date.now()}_${Math.random().toString(36).substr(2, 5)}`;
}

export const SECTION_TEMPLATES = [
  // 1. HERO SHOWCASE (SPLIT VIEW)
  {
    id: 'hero_split_clean',
    name: 'Hero Showcase (Split Screen)',
    category: 'Hero',
    badge: 'Popular',
    icon: 'fas fa-tv',
    description: 'High-impact hero banner with eyebrow badge, large title, lead description, dual CTA buttons, and hero product image.',
    sectionDefaults: {
      title: 'Hero Product Showcase',
      header_title: '',
      badge: '',
      subtitle: '',
      background_color: '#ffffff',
      is_transparent_bg: false,
      padding_mode: 'preset',
      padding_y: { desktop: 'py-6', mobile: 'py-4' }
    },
    generateBlocks() {
      return [
        {
          id: generateId('container'),
          type: 'container',
          settings: {
            layout: { desktop: 'col-lg-6', tablet: 'col-md-6', mobile: 'col-12' },
            gap: { desktop: 'g-5', mobile: 'g-3' },
            verticalAlign: 'align-items-center',
            stackOrderMobile: 'default',
            padding: 'p-0',
            marginBottom: 'mb-0'
          },
          columns: [
            // Col 1: Hero Text & CTA
            [
              {
                id: generateId('heading'),
                type: 'heading',
                settings: {
                  badge: 'NEXT-GEN CLEAN AIR',
                  text: 'Breathe Pure Innovation Anywhere In Your Home',
                  tag: 'h1',
                  fontSize: 'display-4 font-weight-bold',
                  fontWeight: '800',
                  letterSpacing: '-1px',
                  color: '#0d1b2a',
                  align: { desktop: 'text-start', mobile: 'text-center' },
                  marginBottom: 'mb-3'
                }
              },
              {
                id: generateId('paragraph'),
                type: 'paragraph',
                settings: {
                  text: 'Combining medical-grade HEPA filtration with intelligent laser air quality sensing for an effortless, whisper-quiet clean living environment.',
                  isLead: true,
                  color: '#64748b',
                  lineHeight: '1.6',
                  align: { desktop: 'text-start', mobile: 'text-center' },
                  marginBottom: 'mb-4'
                }
              },
              {
                id: generateId('button'),
                type: 'button',
                settings: {
                  text: 'Explore Products',
                  url: '/shop',
                  variant: 'btn-primary',
                  size: 'btn-lg',
                  rounded: 'rounded-pill',
                  shadow: 'shadow',
                  icon: 'fas fa-arrow-right',
                  iconPos: 'right',
                  align: { desktop: 'text-start', mobile: 'text-center' },
                  marginBottom: 'mb-0'
                }
              }
            ],
            // Col 2: Hero Visual Image
            [
              {
                id: generateId('image'),
                type: 'image',
                settings: {
                  url: 'themes/default/assets/img/photograph.webp',
                  alt: 'AIRE Pure Air Purifier Showcase',
                  rounded: 'rounded-4',
                  shadow: 'shadow-lg',
                  fullWidth: true,
                  objectFit: 'cover',
                  hoverEffect: 'hover-lift',
                  align: 'text-center',
                  marginBottom: 'mb-0'
                }
              }
            ]
          ]
        }
      ];
    }
  },

  // 2. FEATURES GRID (3 COLUMNS)
  {
    id: 'features_3_cols',
    name: 'Features Grid (3 Cards)',
    category: 'Features',
    badge: 'Standard',
    icon: 'fas fa-th-large',
    description: '3 structured feature cards with icons, bold titles, and descriptions over an elegant section header.',
    sectionDefaults: {
      title: 'Groundbreaking Features',
      header_title: 'Engineered for Complete Atmospheric Health',
      badge: 'GROUNDBREAKING TECH',
      subtitle: 'Every layer of filtration and aerodynamics is precision-crafted to ensure uncompromised protection for your family.',
      header_align: 'text-center',
      header_badge_style: 'pill',
      background_color: '#f8fafc',
      is_transparent_bg: false,
      padding_mode: 'preset',
      padding_y: { desktop: 'py-6', mobile: 'py-4' }
    },
    generateBlocks() {
      return [
        {
          id: generateId('container'),
          type: 'container',
          settings: {
            layout: { desktop: 'col-lg-4', tablet: 'col-md-6', mobile: 'col-12' },
            gap: { desktop: 'g-4', mobile: 'g-3' },
            verticalAlign: 'align-items-stretch',
            stackOrderMobile: 'default',
            padding: 'p-0',
            marginBottom: 'mb-0'
          },
          columns: [
            [
              {
                id: generateId('card'),
                type: 'card',
                settings: {
                  accentType: 'icon',
                  icon: 'fas fa-shield-alt',
                  title: 'Medical-Grade HEPA',
                  description: 'Traps 99.97% of airborne particulates down to 0.1 microns, including dust, pollen, pet dander, and viruses.',
                  cardStylePreset: 'white',
                  rounded: 'rounded-4',
                  padding: 'p-4',
                  shadow: 'shadow-sm',
                  hoverEffect: 'hover-lift'
                }
              }
            ],
            [
              {
                id: generateId('card'),
                type: 'card',
                settings: {
                  accentType: 'icon',
                  icon: 'fas fa-wind',
                  title: 'Whisper-Quiet Aerodynamics',
                  description: 'Acoustically tuned turbine blades circulate refreshed air below 24dB for undisturbed, restful sleep.',
                  cardStylePreset: 'white',
                  rounded: 'rounded-4',
                  padding: 'p-4',
                  shadow: 'shadow-sm',
                  hoverEffect: 'hover-lift'
                }
              }
            ],
            [
              {
                id: generateId('card'),
                type: 'card',
                settings: {
                  accentType: 'icon',
                  icon: 'fas fa-bolt',
                  title: 'Active Smart Monitoring',
                  description: 'Real-time laser sensors continuously track PM2.5 levels and instantly auto-accelerate airflow when needed.',
                  cardStylePreset: 'white',
                  rounded: 'rounded-4',
                  padding: 'p-4',
                  shadow: 'shadow-sm',
                  hoverEffect: 'hover-lift'
                }
              }
            ]
          ]
        }
      ];
    }
  },

  // 3. STEP-BY-STEP WORKFLOW (4 COLUMNS)
  {
    id: 'features_4_steps',
    name: '4-Stage Purification Process',
    category: 'Features',
    badge: 'Numbered',
    icon: 'fas fa-list-ol',
    description: '4 sequential cards with step numbers (01, 02, 03, 04) showing technology workflow or product steps.',
    sectionDefaults: {
      title: 'Purification Process',
      header_title: 'How Our 4-Stage Defense System Works',
      badge: 'INTELLIGENT DEFENSE',
      subtitle: 'Air passes through four complementary filtration phases to achieve certified clinical cleanliness.',
      header_align: 'text-center',
      header_badge_style: 'soft',
      background_color: '#ffffff',
      is_transparent_bg: false,
      padding_mode: 'preset',
      padding_y: { desktop: 'py-6', mobile: 'py-4' }
    },
    generateBlocks() {
      return [
        {
          id: generateId('container'),
          type: 'container',
          settings: {
            layout: { desktop: 'col-lg-3', tablet: 'col-md-6', mobile: 'col-12' },
            gap: { desktop: 'g-3', mobile: 'g-3' },
            verticalAlign: 'align-items-stretch',
            stackOrderMobile: 'default',
            padding: 'p-0',
            marginBottom: 'mb-0'
          },
          columns: [
            [
              {
                id: generateId('card'),
                type: 'card',
                settings: {
                  accentType: 'number',
                  number: '01',
                  title: 'Pre-Filter Mesh',
                  description: 'Stops coarse particles like pet hair, lint, and floating fibers before they reach internal layers.',
                  cardStylePreset: 'light',
                  rounded: 'rounded-3',
                  padding: 'p-3',
                  hoverEffect: 'hover-lift'
                }
              }
            ],
            [
              {
                id: generateId('card'),
                type: 'card',
                settings: {
                  accentType: 'number',
                  number: '02',
                  title: 'True HEPA Layer',
                  description: 'Eliminates microscopic allergens, bacteria, and invisible PM2.5 particles with high retention.',
                  cardStylePreset: 'light',
                  rounded: 'rounded-3',
                  padding: 'p-3',
                  hoverEffect: 'hover-lift'
                }
              }
            ],
            [
              {
                id: generateId('card'),
                type: 'card',
                settings: {
                  accentType: 'number',
                  number: '03',
                  title: 'Carbon Adsorption',
                  description: 'Porous activated carbon adsorbs volatile organic compounds (VOCs) and kitchen odors.',
                  cardStylePreset: 'light',
                  rounded: 'rounded-3',
                  padding: 'p-3',
                  hoverEffect: 'hover-lift'
                }
              }
            ],
            [
              {
                id: generateId('card'),
                type: 'card',
                settings: {
                  accentType: 'number',
                  number: '04',
                  title: 'Ionized Refresh',
                  description: 'Circulates energized, purified air throughout every corner of the room 360-degrees.',
                  cardStylePreset: 'light',
                  rounded: 'rounded-3',
                  padding: 'p-3',
                  hoverEffect: 'hover-lift'
                }
              }
            ]
          ]
        }
      ];
    }
  },

  // 4. STATS & METRICS COUNTER (4 COLUMNS)
  {
    id: 'stats_trust_counters',
    name: 'Stats & Trust Metrics',
    category: 'Stats',
    badge: 'Social Proof',
    icon: 'fas fa-chart-line',
    description: 'High-credibility social proof banner featuring 4 bold metric statistics and third-party laboratory validations.',
    sectionDefaults: {
      title: 'Our Impact In Numbers',
      header_title: 'Proven Standards, Certified Protection',
      badge: 'BY THE NUMBERS',
      subtitle: 'Independently tested and verified by leading environmental quality institutes.',
      header_align: 'text-center',
      header_badge_style: 'pill',
      background_color: '#f8fafc',
      is_transparent_bg: false,
      padding_mode: 'preset',
      padding_y: { desktop: 'py-5', mobile: 'py-4' }
    },
    generateBlocks() {
      return [
        {
          id: generateId('container'),
          type: 'container',
          settings: {
            layout: { desktop: 'col-lg-3', tablet: 'col-md-6', mobile: 'col-12' },
            gap: { desktop: 'g-3', mobile: 'g-3' },
            verticalAlign: 'align-items-stretch',
            padding: 'p-0',
            marginBottom: 'mb-0'
          },
          columns: [
            [
              {
                id: generateId('card'),
                type: 'card',
                settings: {
                  accentType: 'number',
                  number: '99.97%',
                  title: 'Filtration Efficiency',
                  description: 'Certified to capture particles down to 0.1 microns.',
                  cardStylePreset: 'white',
                  rounded: 'rounded-4',
                  padding: 'p-4',
                  shadow: 'shadow-sm',
                  hoverEffect: 'hover-lift'
                }
              }
            ],
            [
              {
                id: generateId('card'),
                type: 'card',
                settings: {
                  accentType: 'number',
                  number: '50K+',
                  title: 'Clean Homes',
                  description: 'Safeguarding indoor wellness across 20+ countries.',
                  cardStylePreset: 'white',
                  rounded: 'rounded-4',
                  padding: 'p-4',
                  shadow: 'shadow-sm',
                  hoverEffect: 'hover-lift'
                }
              }
            ],
            [
              {
                id: generateId('card'),
                type: 'card',
                settings: {
                  accentType: 'number',
                  number: '24 dB',
                  title: 'Whisper-Quiet',
                  description: 'Ultra-low acoustic signature for sleep and work.',
                  cardStylePreset: 'white',
                  rounded: 'rounded-4',
                  padding: 'p-4',
                  shadow: 'shadow-sm',
                  hoverEffect: 'hover-lift'
                }
              }
            ],
            [
              {
                id: generateId('card'),
                type: 'card',
                settings: {
                  accentType: 'number',
                  number: '2 Years',
                  title: 'Official Warranty',
                  description: 'Full hardware guarantee with express parts support.',
                  cardStylePreset: 'white',
                  rounded: 'rounded-4',
                  padding: 'p-4',
                  shadow: 'shadow-sm',
                  hoverEffect: 'hover-lift'
                }
              }
            ]
          ]
        }
      ];
    }
  },

  // 5. CALL TO ACTION (CTA BANNER)
  {
    id: 'cta_highlight_banner',
    name: 'High-Conversion CTA Banner',
    category: 'CTA',
    badge: 'Conversion',
    icon: 'fas fa-bullhorn',
    description: 'Focused call-to-action banner with dark or branded background, bold headline, supporting text, and action buttons.',
    sectionDefaults: {
      title: 'Call to Action Banner',
      header_title: 'Ready to Experience Truly Clean Living?',
      badge: 'LIMITED TIME OFFER',
      header_badge_style: 'pill',
      header_title_color: '#ffffff',
      subtitle: 'Join over 50,000 satisfied families enjoying fresh, pure indoor air. Free shipping & 30-day money-back guarantee.',
      header_align: 'text-center',
      background_color: '#0f172a',
      is_transparent_bg: false,
      padding_mode: 'preset',
      padding_y: { desktop: 'py-6', mobile: 'py-5' }
    },
    generateBlocks() {
      return [
        {
          id: generateId('button'),
          type: 'button',
          settings: {
            text: 'Shop The Collection Today',
            url: '/shop',
            variant: 'btn-primary',
            size: 'btn-lg',
            rounded: 'rounded-pill',
            shadow: 'shadow-lg',
            icon: 'fas fa-arrow-right',
            iconPos: 'right',
            align: { desktop: 'text-center', mobile: 'text-center' },
            marginBottom: 'mb-3'
          }
        },
        {
          id: generateId('paragraph'),
          type: 'paragraph',
          settings: {
            text: '★ 4.9/5 Average Rating from verified buyers • 2-Year Official Warranty Included',
            color: '#94a3b8',
            fontSize: 'small',
            align: { desktop: 'text-center', mobile: 'text-center' },
            marginBottom: 'mb-0'
          }
        }
      ];
    }
  },

  // 6. SPLIT STORY / ABOUT MISSION
  {
    id: 'split_story_about',
    name: 'Brand Story & Mission Split',
    category: 'Story',
    badge: 'Narrative',
    icon: 'fas fa-book-open',
    description: 'Detailed narrative block featuring a product visual on the left and rich copy with mission statement on the right.',
    sectionDefaults: {
      title: 'Our Mission',
      header_title: '',
      badge: '',
      subtitle: '',
      background_color: '#ffffff',
      is_transparent_bg: false,
      padding_mode: 'preset',
      padding_y: { desktop: 'py-6', mobile: 'py-4' }
    },
    generateBlocks() {
      return [
        {
          id: generateId('container'),
          type: 'container',
          settings: {
            layout: { desktop: 'col-lg-6', tablet: 'col-md-6', mobile: 'col-12' },
            gap: { desktop: 'g-5', mobile: 'g-4' },
            verticalAlign: 'align-items-center',
            stackOrderMobile: 'default',
            padding: 'p-0',
            marginBottom: 'mb-0'
          },
          columns: [
            // Col 1: Visual Image
            [
              {
                id: generateId('image'),
                type: 'image',
                settings: {
                  url: 'themes/default/assets/img/photograph.webp',
                  alt: 'Our Craftsmanship and Engineering',
                  rounded: 'rounded-4',
                  shadow: 'shadow-sm',
                  fullWidth: true,
                  objectFit: 'cover',
                  hoverEffect: 'hover-lift',
                  marginBottom: 'mb-0'
                }
              }
            ],
            // Col 2: Brand Story Copy
            [
              {
                id: generateId('heading'),
                type: 'heading',
                settings: {
                  badge: 'OUR MISSION',
                  text: 'Crafted with Passion for Everyday Atmospheric Wellness',
                  tag: 'h2',
                  fontSize: 'title-2',
                  fontWeight: '700',
                  color: '#0d1b2a',
                  align: { desktop: 'text-start', mobile: 'text-center' },
                  marginBottom: 'mb-3'
                }
              },
              {
                id: generateId('paragraph'),
                type: 'paragraph',
                settings: {
                  text: 'We founded AIRE with a singular vision: to create clean air systems that integrate seamlessly into modern architectural spaces without sacrificing clinical-grade filtration performance.',
                  color: '#475569',
                  lineHeight: '1.6',
                  align: { desktop: 'text-start', mobile: 'text-center' },
                  marginBottom: 'mb-3'
                }
              },
              {
                id: generateId('paragraph'),
                type: 'paragraph',
                settings: {
                  text: 'Every filter mesh, motor coil, and laser optical sensor is rigorously calibrated against global clean-room standards, giving your family true peace of mind.',
                  color: '#64748b',
                  lineHeight: '1.6',
                  align: { desktop: 'text-start', mobile: 'text-center' },
                  marginBottom: 'mb-4'
                }
              },
              {
                id: generateId('button'),
                type: 'button',
                settings: {
                  text: 'Read Our Story',
                  url: '/about',
                  variant: 'btn-outline-primary',
                  size: 'btn-md',
                  rounded: 'rounded-2',
                  icon: 'fas fa-arrow-right',
                  iconPos: 'right',
                  align: { desktop: 'text-start', mobile: 'text-center' },
                  marginBottom: 'mb-0'
                }
              }
            ]
          ]
        }
      ];
    }
  },

  // --------------------------------------------------------------------------
  // 7. FEATURED PRODUCTS SHOWCASE
  // --------------------------------------------------------------------------
  {
    id: 'products-featured-grid',
    name: 'Featured Products Showcase',
    category: 'Products',
    badge: 'Dynamic DB',
    icon: 'fas fa-shopping-bag',
    description: 'Dynamic 4-column product catalog grid connected directly to your store database with live prices, promotional tags, and direct cart actions.',
    sectionDefaults: {
      title: 'Our Clean Air Lineup',
      header_title: 'Precision Engineered Purifiers & Filters',
      badge: 'AIRLINE CATALOG',
      header_badge_style: 'pill',
      subtitle: 'Discover clinical-grade indoor purification technology tailored for homes, medical suites, and commercial architecture.',
      header_align: 'text-center',
      header_title_tag: 'h2',
      bg_color: '#f8fafc',
      padding_mode: 'preset',
      padding_y: { desktop: 'py-6', mobile: 'py-4' },
      min_height: ''
    },
    generateBlocks() {
      return [
        {
          id: generateId('products'),
          type: 'products',
          settings: {
            source: 'featured',
            category_id: null,
            limit: 4,
            columns_desktop: 'col-lg-3',
            columns_mobile: 'col-6',
            show_badge: true,
            show_price: true,
            show_action_buttons: true,
            marginBottom: 'mb-4',
            visibility: { hideOnMobile: false, hideOnDesktop: false }
          }
        },
        {
          id: generateId('button'),
          type: 'button',
          settings: {
            text: 'View Entire Catalog',
            url: '/category/products',
            variant: 'btn-outline-primary',
            size: 'btn-md',
            rounded: 'rounded-pill',
            icon: 'fas fa-th-large',
            iconPos: 'left',
            align: { desktop: 'text-center', mobile: 'text-center' },
            marginBottom: 'mb-0',
            visibility: { hideOnMobile: false, hideOnDesktop: false }
          }
        }
      ];
    }
  },

  // --------------------------------------------------------------------------
  // 8. CUSTOMER FAQ ACCORDION
  // --------------------------------------------------------------------------
  {
    id: 'faq-customer-accordion',
    name: 'Frequently Asked Questions',
    category: 'FAQ',
    badge: 'Interactive',
    icon: 'fas fa-question-circle',
    description: 'Interactive collapsible accordion with questions, detailed answers, and smooth animations. Perfect for support and confidence building.',
    sectionDefaults: {
      title: 'Common Questions',
      header_title: 'Frequently Asked Questions',
      badge: 'HELP & SUPPORT',
      header_badge_style: 'soft',
      subtitle: 'Everything you need to know about our air purification systems, warranty terms, and filter replacements.',
      header_align: 'text-center',
      header_title_tag: 'h2',
      bg_color: '#ffffff',
      padding_mode: 'preset',
      padding_y: { desktop: 'py-6', mobile: 'py-4' },
      min_height: ''
    },
    generateBlocks() {
      return [
        {
          id: generateId('accordion'),
          type: 'accordion',
          settings: {
            style: 'separated',
            icon_type: 'chevron',
            first_open: true,
            allow_multiple: false,
            items: [
              {
                id: 'faq_1',
                title: 'How frequently do the HEPA filters need replacement?',
                content: 'Under normal residential usage (8-12 hours daily), the True HEPA filter lasts between 9 to 12 months. The integrated smart sensor alerts you on the LED panel and app when replacement is due.'
              },
              {
                id: 'faq_2',
                title: 'Does the system capture ultra-fine PM2.5 and virus particles?',
                content: 'Yes. Our clinical-grade H13 True HEPA filter captures 99.97% of microscopic airborne particles down to 0.1 microns, including pollen, smoke, bacteria, and airborne droplets.'
              },
              {
                id: 'faq_3',
                title: 'How quiet is the unit during overnight sleep mode?',
                content: 'In ultra-quiet Sleep Mode, the precision brushless DC motor runs at only 22 dB—quieter than a whisper—with all panel indicator lights dimmed automatically.'
              },
              {
                id: 'faq_4',
                title: 'What warranty and customer support is included?',
                content: 'Every AIRE purifier includes a comprehensive 2-year manufacturer warranty, 30-day money-back guarantee, and access to our 24/7 dedicated customer support team.'
              }
            ],
            marginBottom: 'mb-0',
            visibility: { hideOnMobile: false, hideOnDesktop: false }
          }
        }
      ];
    }
  },

  // --------------------------------------------------------------------------
  // 9. LATEST NEWS & EDITORIAL SHOWCASE
  // --------------------------------------------------------------------------
  {
    id: 'news-editorial-showcase',
    name: 'Latest News & Articles',
    category: 'News',
    badge: 'Editorial',
    icon: 'fas fa-newspaper',
    description: 'High-converting editorial card grid with thumbnail previews, publishing dates, article excerpts, and direct read more links.',
    sectionDefaults: {
      title: 'Latest News & Editorial Hub',
      header_title: 'Insights & Health Innovations',
      badge: 'AIR QUALITY UPDATES',
      header_badge_style: 'soft',
      subtitle: 'Stay up to date with research studies, clean air innovations, and indoor atmosphere best practices.',
      header_align: 'text-center',
      header_title_tag: 'h2',
      bg_color: '#f8fafc',
      padding_mode: 'preset',
      padding_y: { desktop: 'py-6', mobile: 'py-4' },
      min_height: ''
    },
    generateBlocks() {
      return [
        {
          id: generateId('news'),
          type: 'news',
          settings: {
            limit: 3,
            columns_desktop: 'col-lg-4',
            columns_mobile: 'col-12',
            category_id: null,
            marginBottom: 'mb-4',
            visibility: { hideOnMobile: false, hideOnDesktop: false }
          }
        },
        {
          id: generateId('button'),
          type: 'button',
          settings: {
            text: 'View All News & Updates',
            url: '/news',
            variant: 'btn-outline-primary',
            size: 'btn-md',
            rounded: 'rounded-pill',
            icon: 'fas fa-arrow-right',
            iconPos: 'right',
            align: { desktop: 'text-center', mobile: 'text-center' },
            marginBottom: 'mb-0',
            visibility: { hideOnMobile: false, hideOnDesktop: false }
          }
        }
      ];
    }
  },

  // --------------------------------------------------------------------------
  // 10. SHOP BY PRODUCT CATEGORY SHOWCASE
  // --------------------------------------------------------------------------
  {
    id: 'categories-grid-showcase',
    name: 'Shop by Category Grid',
    category: 'Categories',
    badge: 'Catalog',
    icon: 'fas fa-th-large',
    description: 'Interactive category tiles with circular icon badges, category titles, active product counts, and smooth hover lift animations.',
    sectionDefaults: {
      title: 'Shop by Category',
      header_title: 'Explore Our Product Categories',
      badge: 'CATEGORIES',
      header_badge_style: 'soft',
      subtitle: 'Browse by category to find the ideal clean air solution tailored for your specific space and lifestyle.',
      header_align: 'text-center',
      header_title_tag: 'h2',
      bg_color: '#ffffff',
      padding_mode: 'preset',
      padding_y: { desktop: 'py-6', mobile: 'py-4' },
      min_height: ''
    },
    generateBlocks() {
      return [
        {
          id: generateId('categories'),
          type: 'categories',
          settings: {
            limit: 6,
            columns_desktop: 'col-lg-2',
            columns_mobile: 'col-6',
            show_count: true,
            marginBottom: 'mb-0',
            visibility: { hideOnMobile: false, hideOnDesktop: false }
          }
        }
      ];
    }
  },

  // --------------------------------------------------------------------------
  // 11. TRUSTED BRAND PARTNERS & CERTIFICATIONS
  // --------------------------------------------------------------------------
  {
    id: 'brand-partners-showcase',
    name: 'Brand Partners & Certifications',
    category: 'Brands',
    badge: 'Social Proof',
    icon: 'fas fa-certificate',
    description: 'Monochrome partner logos and certifications grid that highlights trusted technology alliances with sleek hover transition.',
    sectionDefaults: {
      title: 'Trusted Brand Partners',
      header_title: 'Trusted by Industry Leaders & Global Brands',
      badge: 'OFFICIAL PARTNERS',
      header_badge_style: 'soft',
      subtitle: 'Our systems integrate world-class components certified by the most rigorous environmental health authorities.',
      header_align: 'text-center',
      header_title_tag: 'h2',
      bg_color: '#f8fafc',
      padding_mode: 'preset',
      padding_y: { desktop: 'py-5', mobile: 'py-4' },
      min_height: ''
    },
    generateBlocks() {
      return [
        {
          id: generateId('brands'),
          type: 'brands',
          settings: {
            limit: 6,
            columns_desktop: 'col-lg-2',
            columns_mobile: 'col-4',
            grayscale: true,
            boxed: true,
            marginBottom: 'mb-0',
            visibility: { hideOnMobile: false, hideOnDesktop: false }
          }
        }
      ];
    }
  }
];

