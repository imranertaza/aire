<!-- Auth Modal Popup (Sign In / Sign Up / Forgot Password) -->
<div class="modal fade auth-modal" id="authModal" tabindex="-1" aria-labelledby="authModalLabel" aria-hidden="true"
    data-bs-backdrop="true" data-lenis-prevent>
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable auth-modal-dialog" data-lenis-prevent>
        <div class="modal-content auth-modal-content border-0" data-lenis-prevent>
            <!-- Close Button -->
            <button type="button" class="btn-close auth-modal-close position-absolute top-0 end-0 m-3"
                data-bs-dismiss="modal" aria-label="Close"></button>

            <div class="modal-body p-4 p-md-5" data-lenis-prevent>
                <!-- Header -->
                <div class="text-center mb-4">
                    <a href="{{ route('home') }}" class="d-inline-block mb-3 text-decoration-none">
                        <img src="{{ theme_asset('img/logo.png') }}" alt="AIRE Logo" class="auth-modal-logo"
                            style="max-height: 42px;">
                    </a>
                    <h2 class="auth-modal-title fs-20 fw-bold text-dark mb-1" id="authModalLabel">Systems Authentication
                    </h2>
                    <p class="fs-13 text-muted mb-0" id="authModalSubtitle">Secure access to environmental control
                        architecture.</p>
                </div>

                <!-- Navigation Tabs (Pill style) -->
                <div class="auth-tabs-wrapper mb-4" id="authNavTabsWrapper">
                    <ul class="nav nav-pills nav-fill auth-nav-pills p-1 bg-light rounded-pill border" id="authTab"
                        role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link auth-tab-pill active rounded-pill fw-semibold fs-13 py-2"
                                id="signin-tab" data-bs-toggle="pill" data-bs-target="#signinTabPane" type="button"
                                role="tab" aria-controls="signinTabPane" aria-selected="true"
                                onclick="switchAuthTab('signin')">
                                <i class="bi bi-box-arrow-in-right me-1"></i> Sign In
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link auth-tab-pill rounded-pill fw-semibold fs-13 py-2" id="signup-tab"
                                data-bs-toggle="pill" data-bs-target="#signupTabPane" type="button" role="tab"
                                aria-controls="signupTabPane" aria-selected="false" onclick="switchAuthTab('signup')">
                                <i class="bi bi-person-plus me-1"></i> Sign Up
                            </button>
                        </li>
                    </ul>
                </div>

                <!-- Tab Content -->
                <div class="tab-content" id="authTabContent">
                    <!-- ================= SIGN IN TAB ================= -->
                    <div class="tab-pane fade show active" id="signinTabPane" role="tabpanel"
                        aria-labelledby="signin-tab">
                        @if (session('status'))
                            <div
                                class="alert alert-success py-2 px-3 mb-3 rounded-3 fs-13 d-flex align-items-center gap-2">
                                <i class="bi bi-check-circle-fill text-success flex-shrink-0"></i>
                                <div>{{ session('status') }}</div>
                            </div>
                        @endif

                        <!-- Alert Box -->
                        <div class="auth-alert d-none alert alert-danger py-2 px-3 mb-3 rounded-3 fs-13"
                            id="signinAlert"></div>

                        <form action="{{ route('signin.post') }}" method="POST" class="auth-ajax-form"
                            id="signinAjaxForm">
                            @csrf
                            <input type="hidden" name="redirect" value="{{ url()->current() }}">

                            <!-- Email Field -->
                            <div class="auth-field-group mb-3">
                                <label for="modalSigninEmail" class="auth-label">EMAIL ADDRESS</label>
                                <div class="auth-input-wrap position-relative">
                                    <input type="email" id="modalSigninEmail" name="email"
                                        class="form-control auth-modal-input" placeholder="name@architecture.com"
                                        required autocomplete="email">
                                    <span
                                        class="auth-input-icon position-absolute top-50 end-0 translate-middle-y me-3 text-muted">@</span>
                                </div>
                                <div class="invalid-feedback d-block fs-12 field-error" data-field="email"></div>
                            </div>

                            <!-- Password Field -->
                            <div class="auth-field-group mb-3">
                                <div class="d-flex align-items-center justify-content-between mb-1">
                                    <label for="modalSigninPassword" class="auth-label mb-0">PASSWORD</label>
                                    <a href="javascript:void(0)"
                                        class="auth-forgot-link fs-12 text-decoration-none text-muted"
                                        onclick="switchAuthTab('forgot')">Forgot Password?</a>
                                </div>
                                <div class="auth-input-wrap position-relative">
                                    <input type="password" id="modalSigninPassword" name="password"
                                        class="form-control auth-modal-input" placeholder="••••••••" required
                                        autocomplete="current-password">
                                    <button type="button"
                                        class="btn border-0 auth-password-toggle position-absolute top-50 end-0 translate-middle-y me-2 text-muted shadow-none p-1"
                                        onclick="toggleModalPassword('modalSigninPassword', this)"
                                        aria-label="Toggle Password Visibility">
                                        <i class="bi bi-eye-slash"></i>
                                    </button>
                                </div>
                                <div class="invalid-feedback d-block fs-12 field-error" data-field="password"></div>
                            </div>

                            <!-- Remember Me -->
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <div class="form-check">
                                    <input class="form-check-input shadow-none" type="checkbox" name="remember"
                                        value="1" id="modalRememberMe">
                                    <label class="form-check-label fs-13 text-secondary" for="modalRememberMe">
                                        Remember this terminal
                                    </label>
                                </div>
                            </div>

                            <input type="hidden" name="g-recaptcha-response" class="g-recaptcha-response">

                            <!-- Action Button -->
                            <button type="submit"
                                class="btn btn-dark w-100 py-2 rounded-3 fw-bold fs-14 btn-auth-modal-submit d-flex align-items-center justify-content-center gap-2">
                                <span class="btn-text">Sign In <i class="bi bi-arrow-right ms-1"></i></span>
                                <span class="spinner-border spinner-border-sm d-none" role="status"
                                    aria-hidden="true"></span>
                            </button>
                        </form>

                        <div class="text-center mt-4">
                            <p class="fs-13 text-muted mb-0">
                                Don't have an account?
                                <a href="javascript:void(0)" class="text-primary fw-bold text-decoration-none ms-1"
                                    onclick="switchAuthTab('signup')">Sign Up</a>
                            </p>
                        </div>
                    </div>

                    <!-- ================= SIGN UP TAB ================= -->
                    <div class="tab-pane fade" id="signupTabPane" role="tabpanel" aria-labelledby="signup-tab">
                        <!-- Alert Box -->
                        <div class="auth-alert d-none alert alert-danger py-2 px-3 mb-3 rounded-3 fs-13"
                            id="signupAlert"></div>

                        <form action="{{ route('signup.post') }}" method="POST" class="auth-ajax-form"
                            id="signupAjaxForm">
                            @csrf
                            <input type="hidden" name="redirect" value="{{ url()->current() }}">
                            <div style="display:none !important; position:absolute; left:-9999px;">
                                <input type="text" name="b_extra_field" tabindex="-1" autocomplete="off">
                            </div>

                            <!-- Full Name Field -->
                            <div class="auth-field-group mb-3">
                                <label for="modalSignupName" class="auth-label">FULL NAME</label>
                                <div class="auth-input-wrap position-relative">
                                    <input type="text" id="modalSignupName" name="name"
                                        class="form-control auth-modal-input" placeholder="Syed Irfan" required
                                        autocomplete="name">
                                    <span
                                        class="auth-input-icon position-absolute top-50 end-0 translate-middle-y me-3 text-muted"><i
                                            class="bi bi-person"></i></span>
                                </div>
                                <div class="invalid-feedback d-block fs-12 field-error" data-field="name"></div>
                            </div>

                            <!-- Email Field -->
                            <div class="auth-field-group mb-3">
                                <label for="modalSignupEmail" class="auth-label">EMAIL ADDRESS</label>
                                <div class="auth-input-wrap position-relative">
                                    <input type="email" id="modalSignupEmail" name="email"
                                        class="form-control auth-modal-input" placeholder="name@architecture.com"
                                        required autocomplete="email">
                                    <span
                                        class="auth-input-icon position-absolute top-50 end-0 translate-middle-y me-3 text-muted">@</span>
                                </div>
                                <div class="invalid-feedback d-block fs-12 field-error" data-field="email"></div>
                            </div>

                            <!-- Password Field -->
                            <div class="auth-field-group mb-3">
                                <label for="modalSignupPassword" class="auth-label">PASSWORD</label>
                                <div class="auth-input-wrap position-relative">
                                    <input type="password" id="modalSignupPassword" name="password"
                                        class="form-control auth-modal-input" placeholder="Minimum 6 characters"
                                        required autocomplete="new-password">
                                    <button type="button"
                                        class="btn border-0 auth-password-toggle position-absolute top-50 end-0 translate-middle-y me-2 text-muted shadow-none p-1"
                                        onclick="toggleModalPassword('modalSignupPassword', this)"
                                        aria-label="Toggle Password Visibility">
                                        <i class="bi bi-eye-slash"></i>
                                    </button>
                                </div>
                                <div class="invalid-feedback d-block fs-12 field-error" data-field="password"></div>
                            </div>

                            <!-- Phone Field (Optional) -->
                            <div class="auth-field-group mb-3">
                                <label for="modalSignupPhone" class="auth-label">PHONE NUMBER (OPTIONAL)</label>
                                <div class="auth-input-wrap position-relative">
                                    <input type="tel" id="modalSignupPhone" name="phone"
                                        class="form-control auth-modal-input" placeholder="+1 (555) 000-0000"
                                        autocomplete="tel">
                                    <span
                                        class="auth-input-icon position-absolute top-50 end-0 translate-middle-y me-3 text-muted"><i
                                            class="bi bi-telephone"></i></span>
                                </div>
                                <div class="invalid-feedback d-block fs-12 field-error" data-field="phone"></div>
                            </div>

                            <input type="hidden" name="g-recaptcha-response" class="g-recaptcha-response">

                            <!-- Action Button -->
                            <button type="submit"
                                class="btn btn-dark w-100 py-2 rounded-3 fw-bold fs-14 btn-auth-modal-submit d-flex align-items-center justify-content-center gap-2 mt-4">
                                <span class="btn-text">Create Account <i class="bi bi-arrow-right ms-1"></i></span>
                                <span class="spinner-border spinner-border-sm d-none" role="status"
                                    aria-hidden="true"></span>
                            </button>
                        </form>

                        <div class="text-center mt-4">
                            <p class="fs-13 text-muted mb-0">
                                Already have an account?
                                <a href="javascript:void(0)" class="text-primary fw-bold text-decoration-none ms-1"
                                    onclick="switchAuthTab('signin')">Sign In</a>
                            </p>
                        </div>
                    </div>

                    <!-- ================= FORGOT PASSWORD TAB ================= -->
                    <div class="tab-pane fade" id="forgotTabPane" role="tabpanel">
                        <!-- Alert Box -->
                        <div class="auth-alert d-none alert alert-danger py-2 px-3 mb-3 rounded-3 fs-13"
                            id="forgotAlert"></div>

                        <form action="{{ route('password.email') }}" method="POST" class="auth-ajax-form"
                            id="forgotAjaxForm" data-no-redirect="true">
                            @csrf

                            <!-- Email Field -->
                            <div class="auth-field-group mb-3">
                                <label for="modalForgotEmail" class="auth-label">EMAIL ADDRESS</label>
                                <div class="auth-input-wrap position-relative">
                                    <input type="email" id="modalForgotEmail" name="email"
                                        class="form-control auth-modal-input" placeholder="name@architecture.com"
                                        required autocomplete="email">
                                    <span
                                        class="auth-input-icon position-absolute top-50 end-0 translate-middle-y me-3 text-muted">@</span>
                                </div>
                                <div class="invalid-feedback d-block fs-12 field-error" data-field="email"></div>
                            </div>

                            <input type="hidden" name="g-recaptcha-response" class="g-recaptcha-response">

                            <!-- Action Button -->
                            <button type="submit"
                                class="btn btn-dark w-100 py-2 rounded-3 fw-bold fs-14 btn-auth-modal-submit d-flex align-items-center justify-content-center gap-2 mt-3">
                                <span class="btn-text">Send Reset Link <i class="bi bi-send ms-1"></i></span>
                                <span class="spinner-border spinner-border-sm d-none" role="status"
                                    aria-hidden="true"></span>
                            </button>
                        </form>

                        <div class="text-center mt-4">
                            <p class="fs-13 text-muted mb-0">
                                Remembered your password?
                                <a href="javascript:void(0)" class="text-primary fw-bold text-decoration-none ms-1"
                                    onclick="switchAuthTab('signin')">Sign In</a>
                            </p>
                        </div>
                    </div>

                    <!-- ================= RESET PASSWORD TAB ================= -->
                    <div class="tab-pane fade" id="resetTabPane" role="tabpanel">
                        <!-- Alert Box -->
                        <div class="auth-alert d-none alert alert-danger py-2 px-3 mb-3 rounded-3 fs-13"
                            id="resetAlert"></div>

                        <form action="{{ route('password.update') }}" method="POST" class="auth-ajax-form"
                            id="resetAjaxForm">
                            @csrf
                            <input type="hidden" name="token" id="modalResetToken" value="">

                            <!-- Email Field -->
                            <div class="auth-field-group mb-3">
                                <label for="modalResetEmail" class="auth-label">EMAIL ADDRESS</label>
                                <div class="auth-input-wrap position-relative">
                                    <input type="email" id="modalResetEmail" name="email"
                                        class="form-control auth-modal-input" placeholder="name@architecture.com"
                                        required autocomplete="email">
                                    <span
                                        class="auth-input-icon position-absolute top-50 end-0 translate-middle-y me-3 text-muted">@</span>
                                </div>
                                <div class="invalid-feedback d-block fs-12 field-error" data-field="email"></div>
                            </div>

                            <!-- New Password Field -->
                            <div class="auth-field-group mb-3">
                                <label for="modalResetPassword" class="auth-label">NEW PASSWORD</label>
                                <div class="auth-input-wrap position-relative">
                                    <input type="password" id="modalResetPassword" name="password"
                                        class="form-control auth-modal-input" placeholder="Minimum 6 characters"
                                        required autocomplete="new-password" minlength="6">
                                    <button type="button"
                                        class="btn border-0 auth-password-toggle position-absolute top-50 end-0 translate-middle-y me-2 text-muted shadow-none p-1"
                                        onclick="toggleModalPassword('modalResetPassword', this)"
                                        aria-label="Toggle Password Visibility">
                                        <i class="bi bi-eye-slash"></i>
                                    </button>
                                </div>
                                <div class="invalid-feedback d-block fs-12 field-error" data-field="password"></div>
                            </div>

                            <!-- Confirm Password Field -->
                            <div class="auth-field-group mb-3">
                                <label for="modalResetPasswordConfirmation" class="auth-label">CONFIRM NEW
                                    PASSWORD</label>
                                <div class="auth-input-wrap position-relative">
                                    <input type="password" id="modalResetPasswordConfirmation"
                                        name="password_confirmation" class="form-control auth-modal-input"
                                        placeholder="••••••••" required autocomplete="new-password" minlength="6">
                                    <button type="button"
                                        class="btn border-0 auth-password-toggle position-absolute top-50 end-0 translate-middle-y me-2 text-muted shadow-none p-1"
                                        onclick="toggleModalPassword('modalResetPasswordConfirmation', this)"
                                        aria-label="Toggle Password Visibility">
                                        <i class="bi bi-eye-slash"></i>
                                    </button>
                                </div>
                                <div class="invalid-feedback d-block fs-12 field-error"
                                    data-field="password_confirmation"></div>
                            </div>

                            <!-- Action Button -->
                            <button type="submit"
                                class="btn btn-dark w-100 py-2 rounded-3 fw-bold fs-14 btn-auth-modal-submit d-flex align-items-center justify-content-center gap-2 mt-4">
                                <span class="btn-text">Reset Password <i class="bi bi-shield-check ms-1"></i></span>
                                <span class="spinner-border spinner-border-sm d-none" role="status"
                                    aria-hidden="true"></span>
                            </button>
                        </form>

                        <div class="text-center mt-4">
                            <p class="fs-13 text-muted mb-0">
                                Remembered your password?
                                <a href="javascript:void(0)" class="text-primary fw-bold text-decoration-none ms-1"
                                    onclick="switchAuthTab('signin')">Sign In</a>
                            </p>
                        </div>
                    </div>
                </div>

                @if (config('services.use_recaptcha') && config('services.sitekey'))
                    <!-- Google reCAPTCHA Compliance Notice (Rendered only when reCAPTCHA is active) -->
                    <div class="text-center mt-3 pt-3 border-top border-light-subtle">
                        <p class="text-muted mb-0" style="font-size: 11px; line-height: 1.4;">
                            This site is protected by reCAPTCHA and the Google
                            <a href="https://policies.google.com/privacy" target="_blank"
                                class="text-secondary text-decoration-underline">Privacy Policy</a> and
                            <a href="https://policies.google.com/terms" target="_blank"
                                class="text-secondary text-decoration-underline">Terms of Service</a> apply.
                        </p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
    // Helper to toggle password visibility
    function toggleModalPassword(inputId, btn) {
        const input = document.getElementById(inputId);
        const icon = btn.querySelector('i');
        if (!input || !icon) return;

        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.remove('bi-eye-slash');
            icon.classList.add('bi-eye');
        } else {
            input.type = 'password';
            icon.classList.remove('bi-eye');
            icon.classList.add('bi-eye-slash');
        }
    }

    // Helper to switch between modal tabs (signin / signup / forgot / reset)
    function switchAuthTab(tab) {
        const signinTab = document.getElementById('signin-tab');
        const signupTab = document.getElementById('signup-tab');
        const signinPane = document.getElementById('signinTabPane');
        const signupPane = document.getElementById('signupTabPane');
        const forgotPane = document.getElementById('forgotTabPane');
        const resetPane = document.getElementById('resetTabPane');
        const navTabsWrapper = document.getElementById('authNavTabsWrapper');
        const modalTitle = document.getElementById('authModalLabel');
        const modalSubtitle = document.getElementById('authModalSubtitle');

        // Clear all active panes
        [signinPane, signupPane, forgotPane, resetPane].forEach(p => {
            if (p) {
                p.classList.remove('show', 'active');
            }
        });

        if (tab === 'signup') {
            if (navTabsWrapper) navTabsWrapper.classList.remove('d-none');
            if (signinTab) signinTab.classList.remove('active');
            if (signupTab) signupTab.classList.add('active');
            if (signupPane) signupPane.classList.add('show', 'active');
            if (modalTitle) modalTitle.textContent = 'Create an Account';
            if (modalSubtitle) modalSubtitle.textContent = 'Join Aire environmental architecture network.';
        } else if (tab === 'forgot') {
            if (navTabsWrapper) navTabsWrapper.classList.add('d-none');
            if (signinTab) signinTab.classList.remove('active');
            if (signupTab) signupTab.classList.remove('active');
            if (forgotPane) forgotPane.classList.add('show', 'active');
            if (modalTitle) modalTitle.textContent = 'Recover Access';
            if (modalSubtitle) modalSubtitle.textContent = 'Enter your email to receive a password reset link.';
        } else if (tab === 'reset') {
            if (navTabsWrapper) navTabsWrapper.classList.add('d-none');
            if (signinTab) signinTab.classList.remove('active');
            if (signupTab) signupTab.classList.remove('active');
            if (resetPane) resetPane.classList.add('show', 'active');
            if (modalTitle) modalTitle.textContent = 'Create New Password';
            if (modalSubtitle) modalSubtitle.textContent = 'Ensure your new password contains at least 6 characters.';
        } else {
            if (navTabsWrapper) navTabsWrapper.classList.remove('d-none');
            if (signupTab) signupTab.classList.remove('active');
            if (signinTab) signinTab.classList.add('active');
            if (signinPane) signinPane.classList.add('show', 'active');
            if (modalTitle) modalTitle.textContent = 'Systems Authentication';
            if (modalSubtitle) modalSubtitle.textContent = 'Secure access to environmental control architecture.';
        }
    }

    // Initialize Modal AJAX Forms
    document.addEventListener('DOMContentLoaded', function() {
        const authModal = document.getElementById('authModal');
        if (authModal) {
            authModal.addEventListener('show.bs.modal', function(event) {
                const triggerBtn = event.relatedTarget;
                if (triggerBtn && triggerBtn.dataset.authTab) {
                    switchAuthTab(triggerBtn.dataset.authTab);
                }
            });
        }

        // Auto-open modal if URL has ?auth=signin / signup / forgot / reset or if session status is flashed
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.has('auth')) {
            const requestedTab = urlParams.get('auth');
            if (authModal && typeof bootstrap !== 'undefined') {
                const modalInstance = new bootstrap.Modal(authModal);
                modalInstance.show();

                if (requestedTab === 'reset') {
                    const resetTokenInput = document.getElementById('modalResetToken');
                    const resetEmailInput = document.getElementById('modalResetEmail');
                    if (resetTokenInput && urlParams.get('token')) {
                        resetTokenInput.value = urlParams.get('token');
                    }
                    if (resetEmailInput && urlParams.get('email')) {
                        resetEmailInput.value = urlParams.get('email');
                    }
                }

                switchAuthTab(requestedTab);
            }
        }
        @if (session('status'))
            if (authModal && typeof bootstrap !== 'undefined') {
                const modalInstance = new bootstrap.Modal(authModal);
                modalInstance.show();
                switchAuthTab('signin');
            }
        @endif

        // Handle AJAX Form Submissions for all auth modal forms
        const authForms = document.querySelectorAll('.auth-ajax-form');
        authForms.forEach(function(form) {
            form.addEventListener('submit', function(e) {
                e.preventDefault();

                const submitBtn = form.querySelector('.btn-auth-modal-submit');
                const btnText = submitBtn ? submitBtn.querySelector('.btn-text') : null;
                const spinner = submitBtn ? submitBtn.querySelector('.spinner-border') : null;
                const alertBox = form.closest('.tab-pane').querySelector('.auth-alert');
                const noRedirect = form.dataset.noRedirect === 'true';

                // Clear previous errors
                form.querySelectorAll('.field-error').forEach(el => el.textContent = '');
                form.querySelectorAll('.auth-modal-input').forEach(el => el.classList.remove(
                    'is-invalid'));
                if (alertBox) {
                    alertBox.classList.add('d-none');
                    alertBox.textContent = '';
                }

                // Loading State
                if (submitBtn) submitBtn.disabled = true;
                if (btnText) btnText.classList.add('opacity-50');
                if (spinner) spinner.classList.remove('d-none');

                const performSubmit = function(token) {
                    const formData = new FormData(form);
                    if (token) {
                        formData.set('g-recaptcha-response', token);
                    }

                    fetch(form.action, {
                            method: 'POST',
                            body: formData,
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'Accept': 'application/json'
                            }
                        })
                        .then(async response => {
                            const data = await response.json();
                            if (!response.ok) {
                                throw data;
                            }
                            return data;
                        })
                        .then(data => {
                            if (submitBtn) submitBtn.disabled = false;
                            if (btnText) btnText.classList.remove('opacity-50');
                            if (spinner) spinner.classList.add('d-none');

                            if (data.status) {
                                if (alertBox) {
                                    alertBox.classList.remove('d-none', 'alert-danger');
                                    alertBox.classList.add('alert-success');
                                    alertBox.innerHTML =
                                        '<i class="bi bi-check-circle-fill me-1"></i> ' +
                                        (data.message || 'Success!');
                                }

                                if (!noRedirect) {
                                    setTimeout(function() {
                                        window.location.href = data.redirect ||
                                            window.location.href;
                                    }, 600);
                                } else {
                                    form.reset();
                                }
                            } else {
                                throw data;
                            }
                        })
                        .catch(err => {
                            if (submitBtn) submitBtn.disabled = false;
                            if (btnText) btnText.classList.remove('opacity-50');
                            if (spinner) spinner.classList.add('d-none');

                            if (err && err.errors) {
                                Object.keys(err.errors).forEach(key => {
                                    const errEl = form.querySelector(
                                        `.field-error[data-field="${key}"]`);
                                    const inputEl = form.querySelector(
                                        `[name="${key}"]`);
                                    if (errEl) errEl.textContent = err.errors[
                                        key][0];
                                    if (inputEl) inputEl.classList.add(
                                        'is-invalid');
                                });
                            }

                            if (alertBox) {
                                alertBox.classList.remove('d-none', 'alert-success');
                                alertBox.classList.add('alert-danger');
                                alertBox.innerHTML =
                                    '<i class="bi bi-exclamation-triangle-fill me-1"></i> ' +
                                    (
                                        err.message ||
                                        'Action failed. Please check your inputs and try again.'
                                    );
                            }
                        });
                };

                const siteKey = "{{ config('services.sitekey') }}";
                const useRecaptcha = {{ config('services.use_recaptcha') ? 'true' : 'false' }};

                if (useRecaptcha && siteKey && typeof grecaptcha !== 'undefined') {
                    grecaptcha.ready(function() {
                        grecaptcha.execute(siteKey, {
                                action: 'auth_submit'
                            })
                            .then(function(token) {
                                performSubmit(token);
                            })
                            .catch(function(recaptchaErr) {
                                console.warn('reCAPTCHA v3 error:', recaptchaErr);
                                performSubmit('');
                            });
                    });
                } else {
                    performSubmit('');
                }
            });
        });
    });
</script>

@if (config('services.use_recaptcha') && config('services.sitekey'))
    <style>
        .grecaptcha-badge {
            visibility: hidden !important;
        }
    </style>
    <script src="https://www.google.com/recaptcha/api.js?render={{ config('services.sitekey') }}" async defer></script>
@endif
