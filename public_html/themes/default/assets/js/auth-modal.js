/**
 * AIRE Theme - Authentication Modal Scripts
 * Handles modal tab switching, password toggles, and AJAX authentication flows
 */
(function () {
    'use strict';

    // Helper to toggle password visibility
    window.toggleModalPassword = function (inputId, btn) {
        const input = document.getElementById(inputId);
        const icon = btn ? btn.querySelector('i') : null;
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
    };

    // Helper to switch between modal tabs (signin / signup / forgot / reset)
    window.switchAuthTab = function (tab) {
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
        [signinPane, signupPane, forgotPane, resetPane].forEach(function (p) {
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
    };

    document.addEventListener('DOMContentLoaded', function () {
        const authModal = document.getElementById('authModal');
        if (!authModal) return;

        authModal.addEventListener('show.bs.modal', function (event) {
            const triggerBtn = event.relatedTarget;
            if (triggerBtn && triggerBtn.dataset.authTab) {
                window.switchAuthTab(triggerBtn.dataset.authTab);
            }
        });

        // Auto-open modal if URL has ?auth=signin / signup / forgot / reset
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.has('auth')) {
            const requestedTab = urlParams.get('auth');
            if (typeof bootstrap !== 'undefined') {
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

                window.switchAuthTab(requestedTab);
            }
        }

        // Handle AJAX Form Submissions for all auth modal forms
        const authForms = document.querySelectorAll('.auth-ajax-form');
        authForms.forEach(function (form) {
            form.addEventListener('submit', function (e) {
                e.preventDefault();

                const submitBtn = form.querySelector('.btn-auth-modal-submit');
                const btnText = submitBtn ? submitBtn.querySelector('.btn-text') : null;
                const spinner = submitBtn ? submitBtn.querySelector('.spinner-border') : null;
                const alertBox = form.closest('.tab-pane').querySelector('.auth-alert');
                const noRedirect = form.dataset.noRedirect === 'true';

                // Clear previous errors
                form.querySelectorAll('.field-error').forEach(function (el) { el.textContent = ''; });
                form.querySelectorAll('.auth-modal-input').forEach(function (el) { el.classList.remove('is-invalid'); });
                if (alertBox) {
                    alertBox.classList.add('d-none');
                    alertBox.textContent = '';
                }

                // Loading State
                if (submitBtn) submitBtn.disabled = true;
                if (btnText) btnText.classList.add('opacity-50');
                if (spinner) spinner.classList.remove('d-none');

                const performSubmit = function (token) {
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
                        .then(async function (response) {
                            const data = await response.json();
                            if (!response.ok) {
                                throw data;
                            }
                            return data;
                        })
                        .then(function (data) {
                            if (submitBtn) submitBtn.disabled = false;
                            if (btnText) btnText.classList.remove('opacity-50');
                            if (spinner) spinner.classList.add('d-none');

                            if (data.status) {
                                if (alertBox) {
                                    alertBox.classList.remove('d-none', 'alert-danger');
                                    alertBox.classList.add('alert-success');
                                    alertBox.innerHTML = '<i class="bi bi-check-circle-fill me-1"></i> ' + (data.message || 'Success!');
                                }

                                if (!noRedirect) {
                                    setTimeout(function () {
                                        window.location.href = data.redirect || window.location.href;
                                    }, 600);
                                } else {
                                    form.reset();
                                }
                            } else {
                                throw data;
                            }
                        })
                        .catch(function (err) {
                            if (submitBtn) submitBtn.disabled = false;
                            if (btnText) btnText.classList.remove('opacity-50');
                            if (spinner) spinner.classList.add('d-none');

                            if (err && err.errors) {
                                Object.keys(err.errors).forEach(function (key) {
                                    const errEl = form.querySelector(`.field-error[data-field="${key}"]`);
                                    const inputEl = form.querySelector(`[name="${key}"]`);
                                    if (errEl) errEl.textContent = err.errors[key][0];
                                    if (inputEl) inputEl.classList.add('is-invalid');
                                });
                            }

                            if (alertBox) {
                                alertBox.classList.remove('d-none', 'alert-success');
                                alertBox.classList.add('alert-danger');
                                alertBox.innerHTML = '<i class="bi bi-exclamation-triangle-fill me-1"></i> ' + (err.message || 'Action failed. Please check your inputs and try again.');
                            }
                        });
                };

                const siteKey = authModal.dataset.sitekey || '';
                const useRecaptcha = authModal.dataset.useRecaptcha === '1';

                if (useRecaptcha && siteKey) {
                    const executeAuthRecaptcha = function () {
                        if (typeof grecaptcha !== 'undefined' && grecaptcha.execute) {
                            grecaptcha.ready(function () {
                                grecaptcha.execute(siteKey, { action: 'auth_submit' })
                                    .then(function (token) {
                                        performSubmit(token);
                                    })
                                    .catch(function (recaptchaErr) {
                                        console.warn('reCAPTCHA v3 error:', recaptchaErr);
                                        performSubmit('');
                                    });
                            });
                        } else {
                            performSubmit('');
                        }
                    };

                    if (typeof grecaptcha === 'undefined' && typeof window.loadRecaptcha === 'function') {
                        window.loadRecaptcha(executeAuthRecaptcha);
                    } else {
                        executeAuthRecaptcha();
                    }
                } else {
                    performSubmit('');
                }
            });
        });
    });
})();
