@extends('themes.default.layouts.master')

@section('title', 'Solutions | Aire Indoor Air Quality')

@section('content')
<main class="container main-container">
    <h1 class="d-none">Your Main Page Title</h1>

    <div class="row g-0">

        <!-- Left Sidebar Navigation -->
        <aside class="col-lg-3 d-none d-lg-block border-right1px pe-lg-4">
            <nav class="sidebar-menu sticky-sidebar" data-lenis-prevent>
                <a href="#health" class="menu-item active">
                    <div class="icon-box"><i class="bi bi-shield-check"></i></div>
                    <div class="text-box">
                        <h2 class="mb-0">Health & Wellbeing</h2>
                        <small class="d-block mt-1">Breathe cleaner, healthier air</small>
                    </div>
                    <i class="bi bi-chevron-right ms-auto chevron"></i>
                </a>

                <a href="#energy" class="menu-item">
                    <div class="icon-box"><i class="bi bi-lightning-charge"></i></div>
                    <div class="text-box">
                        <h2 class="mb-0">Energy Efficiency</h2>
                        <small class="d-block mt-1">Save energy, optimal air</small>
                    </div>
                    <i class="bi bi-chevron-right ms-auto chevron"></i>
                </a>

                <a href="#sick-building" class="menu-item">
                    <div class="icon-box"><i class="bi bi-building-exclamation"></i></div>
                    <div class="text-box">
                        <h2 class="mb-0">Sick Building Prevention</h2>
                        <small class="d-block mt-1">Healthier indoor environments</small>
                    </div>
                    <i class="bi bi-chevron-right ms-auto chevron"></i>
                </a>

                <a href="#infection" class="menu-item">
                    <div class="icon-box"><i class="bi bi-virus"></i></div>
                    <div class="text-box">
                        <h2 class="mb-0">Infection Control</h2>
                        <small class="d-block mt-1">Reduce airborne pathogens</small>
                    </div>
                    <i class="bi bi-chevron-right ms-auto chevron"></i>
                </a>

                <a href="#compliance" class="menu-item">
                    <div class="icon-box"><i class="bi bi-clipboard-check"></i></div>
                    <div class="text-box">
                        <h2 class="mb-0">Air Quality Compliance</h2>
                        <small class="d-block mt-1">Meet IAQ standards</small>
                    </div>
                    <i class="bi bi-chevron-right ms-auto chevron"></i>
                </a>

                <a href="#smart" class="menu-item">
                    <div class="icon-box"><i class="bi bi-cpu"></i></div>
                    <div class="text-box">
                        <h2 class="mb-0">Smart Building Solutions</h2>
                        <small class="d-block mt-1">Integrate and optimize</small>
                    </div>
                    <i class="bi bi-chevron-right ms-auto chevron"></i>
                </a>
            </nav>
        </aside>

        <!-- Center Content Column -->
        <div class="col-lg-9 col-xl-6 center-feed px-lg-4">

            <!-- 1. Health & Wellbeing Solutions -->
            <div id="health" class="content-section mb-5 pb-4">
                <h2 class="section-title title-1">Health & Wellbeing Solutions</h2>
                <p class="section-subtitle mb-4 pb-2">Our solutions improve indoor air quality by removing
                    pollutants, reducing allergens and ensuring a continuous supply of fresh air.</p>

                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="solution-card">
                            <img class="card-img-bg" src="{{ theme_asset('img/apartments.jpg') }}" alt="Air Filter">
                            <div class="card-gradient-overlay"></div>
                            <div class="card-content">
                                <div class="card-icon-wrapper"><i class="bi bi-snow"></i></div>
                                <h3 class="card-title fs-20">Remove PM2.5 & Pollutants</h3>
                                <span class="badge-custom">RESIDENTIAL IAQ</span>
                                <p class="card-desc">Advanced filtration that captures 99.9% of PM2.5 and airborne
                                    pollutants.</p>
                                <a href="#" class="card-link fs-12 mt-auto">VIEW DETAILS <i
                                        class="bi bi-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="solution-card">
                            <img class="card-img-bg" src="{{ theme_asset('img/apartments.jpg') }}" alt="Clean Air">
                            <div class="card-gradient-overlay"></div>
                            <div class="card-content">
                                <div class="card-icon-wrapper"><i class="bi bi-shield-check"></i></div>
                                <h3 class="card-title fs-20">Virus & Bacteria Protection</h3>
                                <span class="badge-custom">RESIDENTIAL IAQ</span>
                                <p class="card-desc">Electrostatic technology kills viruses and bacteria for a safer
                                    environment.</p>
                                <a href="#" class="card-link fs-12 mt-auto">VIEW DETAILS <i
                                        class="bi bi-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="solution-card">
                            <img class="card-img-bg" src="{{ theme_asset('img/apartments.jpg') }}" alt="Living Room">
                            <div class="card-gradient-overlay"></div>
                            <div class="card-content">
                                <div class="card-icon-wrapper"><i class="bi bi-flower1"></i></div>
                                <h3 class="card-title fs-20">Reduce Allergens</h3>
                                <span class="badge-custom">RESIDENTIAL IAQ</span>
                                <p class="card-desc">Eliminate pollen, dust mites and other common allergens from
                                    indoor air.</p>
                                <a href="#" class="card-link fs-12 mt-auto">VIEW DETAILS <i
                                        class="bi bi-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="solution-card">
                            <img class="card-img-bg" src="{{ theme_asset('img/apartments.jpg') }}" alt="Bedroom">
                            <div class="card-gradient-overlay"></div>
                            <div class="card-content">
                                <div class="card-icon-wrapper"><i class="bi bi-cloud"></i></div>
                                <h3 class="card-title fs-20">Oxygen & CO2 Balance</h3>
                                <span class="badge-custom">RESIDENTIAL IAQ</span>
                                <p class="card-desc">Maintain optimal oxygen levels and reduce CO2 for better
                                    comfort and focus.</p>
                                <a href="#" class="card-link fs-12 mt-auto">VIEW DETAILS <i
                                        class="bi bi-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="solution-card">
                            <img class="card-img-bg" src="{{ theme_asset('img/apartments.jpg') }}" alt="Open Window">
                            <div class="card-gradient-overlay"></div>
                            <div class="card-content">
                                <div class="card-icon-wrapper"><i class="bi bi-wind"></i></div>
                                <h3 class="card-title fs-20">Ventilation & Fresh Air</h3>
                                <span class="badge-custom">RESIDENTIAL IAQ</span>
                                <p class="card-desc">Bring in 100% fresh air and improve overall air circulation.
                                </p>
                                <a href="#" class="card-link fs-12 mt-auto">VIEW DETAILS <i
                                        class="bi bi-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="solution-card">
                            <img class="card-img-bg" src="{{ theme_asset('img/apartments.jpg') }}" alt="Relaxing">
                            <div class="card-gradient-overlay"></div>
                            <div class="card-content">
                                <div class="card-icon-wrapper"><i class="bi bi-house"></i></div>
                                <h3 class="card-title fs-20">Comfort & Wellbeing</h3>
                                <span class="badge-custom">RESIDENTIAL IAQ</span>
                                <p class="card-desc">Consistent, clean air for better sleep, health and
                                    productivity.</p>
                                <a href="#" class="card-link fs-12 mt-auto">VIEW DETAILS <i
                                        class="bi bi-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 2. Energy Efficiency Solutions -->
            <div id="energy" class="content-section mb-5 pb-4">
                <h2 class="section-title title-1">Energy Efficiency Solutions</h2>
                <p class="section-subtitle mb-4 pb-2">Optimize indoor air quality while minimizing energy
                    consumption with smart, demand-driven systems.</p>

                <!-- Feature Icons -->
                <div class="row g-4 mb-5 mt-2">
                    <div class="col-6 col-md-3">
                        <div class="feature-icon-item">
                            <div class="feature-icon-wrapper"><i class="bi bi-cash-stack"></i></div>
                            <h3>Cost Savings</h3>
                            <p>Lower utility bills and operational costs.</p>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="feature-icon-item">
                            <div class="feature-icon-wrapper"><i class="bi bi-tree"></i></div>
                            <h3>Sustainable Solutions</h3>
                            <p>Reduce carbon footprint and environmental impact.</p>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="feature-icon-item">
                            <div class="feature-icon-wrapper"><i class="bi bi-cpu"></i></div>
                            <h3>Intelligent Sensors</h3>
                            <p>Real-time optimization based on occupancy.</p>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="feature-icon-item">
                            <div class="feature-icon-wrapper"><i class="bi bi-thermometer-half"></i></div>
                            <h3>Heat Recovery Tech</h3>
                            <p>Retain indoor temperatures while ventilating.</p>
                        </div>
                    </div>
                </div>

                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="solution-card">
                            <img class="card-img-bg" src="{{ theme_asset('img/apartments.jpg') }}" alt="HVAC System">
                            <div class="card-gradient-overlay"></div>
                            <div class="card-content">
                                <div class="card-icon-wrapper"><i class="bi bi-wind"></i></div>
                                <h3 class="card-title fs-20">High Efficiency Ventilation</h3>
                                <span class="badge-custom">COMMERCIAL IAQ</span>
                                <p class="card-desc">Low-energy EC fans and optimized aerodynamics for minimal power
                                    usage.</p>
                                <a href="#" class="card-link fs-12 mt-auto">VIEW DETAILS <i
                                        class="bi bi-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="solution-card">
                            <img class="card-img-bg" src="{{ theme_asset('img/apartments.jpg') }}"
                                alt="Smart Thermostat">
                            <div class="card-gradient-overlay"></div>
                            <div class="card-content">
                                <div class="card-icon-wrapper"><i class="bi bi-cpu"></i></div>
                                <h3 class="card-title fs-20">Smart Controls & Auto</h3>
                                <span class="badge-custom">COMMERCIAL IAQ</span>
                                <p class="card-desc">AI-driven systems that adjust automatically to occupancy and
                                    air quality.</p>
                                <a href="#" class="card-link fs-12 mt-auto">VIEW DETAILS <i
                                        class="bi bi-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="solution-card">
                            <img class="card-img-bg" src="{{ theme_asset('img/apartments.jpg') }}" alt="Office Meeting">
                            <div class="card-gradient-overlay"></div>
                            <div class="card-content">
                                <div class="card-icon-wrapper"><i class="bi bi-graph-up-arrow"></i></div>
                                <h3 class="card-title fs-20">Demand Controlled Vent</h3>
                                <span class="badge-custom">COMMERCIAL IAQ</span>
                                <p class="card-desc">Supply exactly the right amount of fresh air, exactly when and
                                    where needed.</p>
                                <a href="#" class="card-link fs-12 mt-auto">VIEW DETAILS <i
                                        class="bi bi-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="solution-card">
                            <img class="card-img-bg" src="{{ theme_asset('img/apartments.jpg') }}"
                                alt="Building Exterior">
                            <div class="card-gradient-overlay"></div>
                            <div class="card-content">
                                <div class="card-icon-wrapper"><i class="bi bi-arrow-repeat"></i></div>
                                <h3 class="card-title fs-20">Energy Recovery</h3>
                                <span class="badge-custom">COMMERCIAL IAQ</span>
                                <p class="card-desc">Recover heat and cooling from exhaust air to dramatically
                                    reduce energy costs.</p>
                                <a href="#" class="card-link fs-12 mt-auto">VIEW DETAILS <i
                                        class="bi bi-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 3. Sick Building Prevention Solutions -->
            <div id="sick-building" class="content-section mb-5 pb-4">
                <h2 class="section-title title-1">Sick Building Prevention</h2>
                <p class="section-subtitle mb-4 pb-2">Combat Sick Building Syndrome with comprehensive solutions
                    that eliminate VOCs, mold, and stagnant air to create healthy indoor environments.</p>

                <!-- Feature Icons -->
                <div class="row g-4 mb-5 mt-2">
                    <div class="col-6 col-md-3">
                        <div class="feature-icon-item">
                            <div class="feature-icon-wrapper"><i class="bi bi-shield-x"></i></div>
                            <h3>VOC Elimination</h3>
                            <p>Neutralize harmful off-gassing and chemicals.</p>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="feature-icon-item">
                            <div class="feature-icon-wrapper"><i class="bi bi-moisture"></i></div>
                            <h3>Mold Prevention</h3>
                            <p>Control humidity to stop mold and mildew growth.</p>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="feature-icon-item">
                            <div class="feature-icon-wrapper"><i class="bi bi-speedometer2"></i></div>
                            <h3>CO2 Monitoring</h3>
                            <p>Ensure optimal oxygen levels for alertness.</p>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="feature-icon-item">
                            <div class="feature-icon-wrapper"><i class="bi bi-wind"></i></div>
                            <h3>Odor Control</h3>
                            <p>Eliminate unpleasant smells at their source.</p>
                        </div>
                    </div>
                </div>

                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="solution-card">
                            <img class="card-img-bg" src="{{ theme_asset('img/apartments.jpg') }}"
                                alt="Laboratory">
                            <div class="card-gradient-overlay"></div>
                            <div class="card-content">
                                <div class="card-icon-wrapper"><i class="bi bi-funnel"></i></div>
                                <h3 class="card-title fs-20">Advanced VOC Filtration</h3>
                                <span class="badge-custom">CLINICAL IAQ</span>
                                <p class="card-desc">Specialized carbon filters that remove harmful chemical
                                    off-gassing from furniture and materials.</p>
                                <a href="#" class="card-link fs-12 mt-auto">VIEW DETAILS <i
                                        class="bi bi-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="solution-card">
                            <img class="card-img-bg" src="{{ theme_asset('img/apartments.jpg') }}"
                                alt="Building Ventilation">
                            <div class="card-gradient-overlay"></div>
                            <div class="card-content">
                                <div class="card-icon-wrapper"><i class="bi bi-droplet-half"></i></div>
                                <h3 class="card-title fs-20">Humidity & Mold Control</h3>
                                <span class="badge-custom">CLINICAL IAQ</span>
                                <p class="card-desc">Maintain ideal 40-60% humidity levels to completely prevent
                                    mold and mildew growth.</p>
                                <a href="#" class="card-link fs-12 mt-auto">VIEW DETAILS <i
                                        class="bi bi-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="solution-card">
                            <img class="card-img-bg" src="{{ theme_asset('img/apartments.jpg') }}"
                                alt="Dashboard Tablet">
                            <div class="card-gradient-overlay"></div>
                            <div class="card-content">
                                <div class="card-icon-wrapper"><i class="bi bi-display"></i></div>
                                <h3 class="card-title fs-20">IAQ Monitoring</h3>
                                <span class="badge-custom">CLINICAL IAQ</span>
                                <p class="card-desc">Real-time dashboards that track pollutants, temperature and CO2
                                    to ensure a healthy environment.</p>
                                <a href="#" class="card-link fs-12 mt-auto">VIEW DETAILS <i
                                        class="bi bi-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="solution-card">
                            <img class="card-img-bg" src="{{ theme_asset('img/apartments.jpg') }}" alt="Fresh Interior">
                            <div class="card-gradient-overlay"></div>
                            <div class="card-content">
                                <div class="card-icon-wrapper"><i class="bi bi-wind"></i></div>
                                <h3 class="card-title fs-20">Active Odor Neutralization</h3>
                                <span class="badge-custom">CLINICAL IAQ</span>
                                <p class="card-desc">Eliminate persistent odors rather than masking them, creating a
                                    fresh, pleasant indoor atmosphere.</p>
                                <a href="#" class="card-link fs-12 mt-auto">VIEW DETAILS <i
                                        class="bi bi-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 4. Infection Control Solutions -->
            <div id="infection" class="content-section mb-5 pb-4">
                <h2 class="section-title title-1">Infection Control</h2>
                <p class="section-subtitle mb-4 pb-2">Reduce airborne pathogen transmission with AIRE's proven
                    clinical-grade air purification and UV sterilization systems, designed for healthcare, schools
                    and high-traffic public environments.</p>
                <div class="row g-4 mb-5 mt-2">
                    <div class="col-6 col-md-3">
                        <div class="feature-icon-item">
                            <div class="feature-icon-wrapper"><i class="bi bi-virus"></i></div>
                            <h3>Pathogen Removal</h3>
                            <p>HEPA H14 filtration captures 99.995% of airborne viruses.</p>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="feature-icon-item">
                            <div class="feature-icon-wrapper"><i class="bi bi-brightness-high"></i></div>
                            <h3>UV-C Sterilization</h3>
                            <p>Germicidal UV-C light inactivates bacteria and viruses.</p>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="feature-icon-item">
                            <div class="feature-icon-wrapper"><i class="bi bi-shield-check"></i></div>
                            <h3>Negative Pressure</h3>
                            <p>Isolate contaminated areas to prevent cross-infection.</p>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="feature-icon-item">
                            <div class="feature-icon-wrapper"><i class="bi bi-hospital"></i></div>
                            <h3>Clinical Grade</h3>
                            <p>Approved for use in surgical theatres and ICUs.</p>
                        </div>
                    </div>
                </div>
                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="solution-card">
                            <img class="card-img-bg" src="{{ theme_asset('img/apartments.jpg') }}"
                                alt="Hospital Infection Control">
                            <div class="card-gradient-overlay"></div>
                            <div class="card-content">
                                <div class="card-icon-wrapper"><i class="bi bi-virus2"></i></div>
                                <h3 class="card-title fs-20">Hospital-Grade Air Sterilizers</h3>
                                <span class="badge-custom">CLINICAL IAQ</span>
                                <p class="card-desc">Medical-grade portable air sterilizers using HEPA H14 and
                                    UV-C for surgical rooms and intensive care units.</p>
                                <a href="#" class="card-link fs-12 mt-auto">VIEW DETAILS <i
                                        class="bi bi-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="solution-card">
                            <img class="card-img-bg" src="{{ theme_asset('img/apartments.jpg') }}"
                                alt="School Air Purification">
                            <div class="card-gradient-overlay"></div>
                            <div class="card-content">
                                <div class="card-icon-wrapper"><i class="bi bi-people"></i></div>
                                <h3 class="card-title fs-20">School &amp; Public Space Solutions</h3>
                                <span class="badge-custom">EDUCATION IAQ</span>
                                <p class="card-desc">Ceiling-integrated HEPA systems that reduce viral load
                                    in classrooms, gyms, and public transport hubs.</p>
                                <a href="#" class="card-link fs-12 mt-auto">VIEW DETAILS <i
                                        class="bi bi-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 5. Air Quality Compliance Solutions -->
            <div id="compliance" class="content-section mb-5 pb-4">
                <h2 class="section-title title-1">Air Quality Compliance</h2>
                <p class="section-subtitle mb-4 pb-2">Stay ahead of indoor air quality regulations with AIRE's
                    comprehensive compliance monitoring and reporting solutions — meeting ASHRAE, WHO, EN 16798,
                    and local environmental standards.</p>
                <div class="row g-4 mb-5 mt-2">
                    <div class="col-6 col-md-3">
                        <div class="feature-icon-item">
                            <div class="feature-icon-wrapper"><i class="bi bi-clipboard-check"></i></div>
                            <h3>ASHRAE Compliance</h3>
                            <p>Meet Standard 62.1 ventilation requirements with ease.</p>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="feature-icon-item">
                            <div class="feature-icon-wrapper"><i class="bi bi-graph-up-arrow"></i></div>
                            <h3>Automated Reporting</h3>
                            <p>Generate compliance reports automatically for auditors.</p>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="feature-icon-item">
                            <div class="feature-icon-wrapper"><i class="bi bi-bell"></i></div>
                            <h3>Threshold Alerts</h3>
                            <p>Receive instant alerts when IAQ parameters go out of range.</p>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="feature-icon-item">
                            <div class="feature-icon-wrapper"><i class="bi bi-patch-check"></i></div>
                            <h3>Certified Sensors</h3>
                            <p>ISO-calibrated sensors for legally defensible data.</p>
                        </div>
                    </div>
                </div>
                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="solution-card">
                            <img class="card-img-bg" src="{{ theme_asset('img/apartments.jpg') }}"
                                alt="IAQ Compliance Platform">
                            <div class="card-gradient-overlay"></div>
                            <div class="card-content">
                                <div class="card-icon-wrapper"><i class="bi bi-file-earmark-text"></i></div>
                                <h3 class="card-title fs-20">IAQ Compliance Platform</h3>
                                <span class="badge-custom">REGULATORY</span>
                                <p class="card-desc">Cloud-based platform that tracks, logs, and exports air
                                    quality data in formats accepted by regulatory bodies worldwide.</p>
                                <a href="#" class="card-link fs-12 mt-auto">VIEW DETAILS <i
                                        class="bi bi-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="solution-card">
                            <img class="card-img-bg" src="{{ theme_asset('img/apartments.jpg') }}"
                                alt="Air Audit Service">
                            <div class="card-gradient-overlay"></div>
                            <div class="card-content">
                                <div class="card-icon-wrapper"><i class="bi bi-search"></i></div>
                                <h3 class="card-title fs-20">On-Site IAQ Audit Service</h3>
                                <span class="badge-custom">REGULATORY</span>
                                <p class="card-desc">Expert AIRE engineers assess your building's air quality
                                    and provide a comprehensive remediation roadmap.</p>
                                <a href="#" class="card-link fs-12 mt-auto">VIEW DETAILS <i
                                        class="bi bi-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 6. Smart Building Solutions -->
            <div id="smart" class="content-section mb-5 pb-4">
                <h2 class="section-title title-1">Smart Building Solutions</h2>
                <p class="section-subtitle mb-4 pb-2">Integrate AIRE's air quality systems with your building
                    management ecosystem for intelligent, automated air quality control that responds in real time
                    to occupancy and environmental conditions.</p>
                <div class="row g-4 mb-5 mt-2">
                    <div class="col-6 col-md-3">
                        <div class="feature-icon-item">
                            <div class="feature-icon-wrapper"><i class="bi bi-cpu"></i></div>
                            <h3>BMS Integration</h3>
                            <p>Connect to BACnet, Modbus, and KNX building systems.</p>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="feature-icon-item">
                            <div class="feature-icon-wrapper"><i class="bi bi-phone"></i></div>
                            <h3>App Control</h3>
                            <p>Manage every zone from iOS or Android in real time.</p>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="feature-icon-item">
                            <div class="feature-icon-wrapper"><i class="bi bi-robot"></i></div>
                            <h3>AI Automation</h3>
                            <p>Self-optimizing systems that learn occupancy patterns.</p>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="feature-icon-item">
                            <div class="feature-icon-wrapper"><i class="bi bi-cloud-check"></i></div>
                            <h3>Cloud Dashboard</h3>
                            <p>Centralised visibility across all your buildings globally.</p>
                        </div>
                    </div>
                </div>
                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="solution-card">
                            <img class="card-img-bg" src="{{ theme_asset('img/apartments.jpg') }}"
                                alt="Smart Building Integration">
                            <div class="card-gradient-overlay"></div>
                            <div class="card-content">
                                <div class="card-icon-wrapper"><i class="bi bi-building-gear"></i></div>
                                <h3 class="card-title fs-20">AIRE Building OS</h3>
                                <span class="badge-custom">SMART TECH</span>
                                <p class="card-desc">A complete operating system for building air quality —
                                    integrating sensors, purifiers, and ventilation into one intelligent platform.
                                </p>
                                <a href="#" class="card-link fs-12 mt-auto">VIEW DETAILS <i
                                        class="bi bi-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="solution-card">
                            <img class="card-img-bg" src="{{ theme_asset('img/apartments.jpg') }}" alt="IoT Sensor Network">
                            <div class="card-gradient-overlay"></div>
                            <div class="card-content">
                                <div class="card-icon-wrapper"><i class="bi bi-diagram-3"></i></div>
                                <h3 class="card-title fs-20">IoT Sensor Network</h3>
                                <span class="badge-custom">SMART TECH</span>
                                <p class="card-desc">Deploy a mesh network of wireless AIRE sensors throughout
                                    your building for granular, zone-level air quality intelligence.</p>
                                <a href="#" class="card-link fs-12 mt-auto">VIEW DETAILS <i
                                        class="bi bi-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Sidebar Feature -->
        <aside class="col-lg-12 col-xl-3 d-none d-xl-block border-left1px">
            <!-- Swiper Slider Implementation -->
            <div class="featured-card sticky-sidebar bg-white border border-light-subtle shadow-sm rounded-4 ms-3"
                data-lenis-prevent>
                <div class="swiper featured-swiper">
                    <div class="swiper-wrapper">
                        <!-- Slide 1 -->
                        <div class="swiper-slide">
                            <div class="featured-img position-relative">
                                <span
                                    class="badge bg-dark position-absolute top-0 start-0 m-3 rounded-0 px-3 py-2 text-uppercase text-white border-0 featured-badge">Featured
                                    Solution</span>
                                <img src="{{ theme_asset('img/featured/1.png') }}" class="img-fluid w-100"
                                    alt="Woman relaxing at home">
                            </div>
                            <div class="featured-content pb-5">
                                <h3 class="mb-2">The Future of Pure Living</h3>
                                <p class="text-muted mb-2 lh-base">Experience the pinnacle of air technology
                                    seamlessly integrated into your architectural vision. The AIRE Pro series</p>
                                <button class="btn btn-primary w-100 fw-bold shadow-sm featured-btn">VIEW
                                    PRODUCTS</button>
                            </div>
                        </div>
                        <!-- Slide 2 -->
                        <div class="swiper-slide">
                            <div class="featured-img position-relative">
                                <span
                                    class="badge bg-dark position-absolute top-0 start-0 m-3 rounded-0 px-3 py-2 text-uppercase text-white border-0 featured-badge">New
                                    Arrival</span>
                                <img src="{{ theme_asset('img/featured/2.png') }}" class="img-fluid w-100"
                                    alt="Modern interior">
                            </div>
                            <div class="featured-content pb-5">
                                <h3 class="mb-2">Smart Climate Control</h3>
                                <p class="text-muted mb-2 lh-base">Control your entire home's air quality directly
                                    from your smartphone with our new AIRE IoT integration. Pure air, instantly.</p>
                                <button class="btn btn-primary w-100 fw-bold shadow-sm featured-btn">LEARN
                                    MORE</button>
                            </div>
                        </div>
                        <!-- Slide 3 -->
                        <div class="swiper-slide">
                            <div class="featured-img position-relative">
                                <span
                                    class="badge bg-dark position-absolute top-0 start-0 m-3 rounded-0 px-3 py-2 text-uppercase text-white border-0 featured-badge">Commercial</span>
                                <img src="{{ theme_asset('img/featured/3.png') }}" class="img-fluid w-100"
                                    alt="Office lobby">
                            </div>
                            <div class="featured-content pb-5">
                                <h3 class="mb-2">Enterprise Grade Purity</h3>
                                <p class="text-muted mb-2 lh-base">Deploy industrial-grade filtration disguised in
                                    beautiful architectural units designed specifically for modern corporate
                                    lobbies.</p>
                                <button class="btn btn-primary w-100 fw-bold shadow-sm featured-btn">GET
                                    A QUOTE</button>
                            </div>
                        </div>
                    </div>
                    <!-- Add Pagination -->
                    <div class="swiper-pagination position-absolute bottom-2"></div>
                </div>
            </div>
        </aside>

    </div>
</main>
@endsection

@push('scripts')

@endpush