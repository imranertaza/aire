<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\CustomerForgotPasswordRequest;
use App\Http\Requests\Auth\CustomerResetPasswordRequest;
use App\Http\Requests\Auth\CustomerSigninRequest;
use App\Http\Requests\Auth\CustomerSignupRequest;
use App\Services\Auth\CustomerAuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class CustomerAuthController extends Controller
{
    /**
     * CustomerAuthController constructor.
     */
    public function __construct(
        protected CustomerAuthService $authService
    ) {}

    /**
     * Display the customer signin modal / redirect to home.
     */
    public function signin(): RedirectResponse
    {
        return Redirect::route('home', ['auth' => 'signin']);
    }

    /**
     * Handle customer signin authentication with brute-force throttling and active status validation.
     */
    public function postSignin(CustomerSigninRequest $request): JsonResponse|RedirectResponse
    {
        $request->ensureIsNotRateLimited();

        $credentials = $request->only('email', 'password');
        $remember = $request->boolean('remember', false);

        if ($this->authService->attemptLogin($credentials, $remember)) {
            $request->clearRateLimiter();
            $request->session()->regenerate();

            /** @var \App\Models\Customer $customer */
            $customer = auth('customer')->user();
            $redirectUrl = $this->getSafeRedirectUrl($request);

            return $this->respondSuccess(
                message: 'Logged in successfully!',
                redirectUrl: $redirectUrl,
                extraData: [
                    'user' => [
                        'name'  => $customer->full_name,
                        'email' => $customer->email,
                    ],
                ]
            );
        }

        $request->hitRateLimiter();

        $isDeactivated = $this->authService->isAccountDeactivated($credentials['email']);
        $errorMessage = $isDeactivated
            ? 'Your account has been deactivated. Please contact customer support.'
            : 'Invalid email or password.';

        throw ValidationException::withMessages([
            'email' => $errorMessage,
        ]);
    }

    /**
     * Display the customer signup modal / redirect to home.
     */
    public function signup(): RedirectResponse
    {
        return Redirect::route('home', ['auth' => 'signup']);
    }

    /**
     * Handle customer registration with rate limiting and auto login.
     */
    public function postSignup(CustomerSignupRequest $request): JsonResponse|RedirectResponse
    {
        $request->ensureIsNotRateLimited();

        // Honeypot check for spam bots
        if ($request->filled('b_extra_field')) {
            return $this->respondSuccess(
                message: 'Registered and logged in successfully!',
                redirectUrl: $this->getSafeRedirectUrl($request),
            );
        }

        $request->hitRateLimiter();
        $request->session()->regenerate();

        $customer = $this->authService->register($request->validated(), $request->ip());

        $redirectUrl = $this->getSafeRedirectUrl($request);

        return $this->respondSuccess(
            message: 'Registered and logged in successfully!',
            redirectUrl: $redirectUrl,
            extraData: [
                'user' => [
                    'name'  => $customer->full_name,
                    'email' => $customer->email,
                ],
            ]
        );
    }

    /**
     * Handle customer logout.
     */
    public function logout(Request $request): JsonResponse|RedirectResponse
    {
        $this->authService->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return $this->respondSuccess(
            message: 'Logged out successfully!',
            redirectUrl: route('home')
        );
    }

    /**
     * Display the forgot password modal / redirect to home.
     */
    public function forgotPassword(): RedirectResponse
    {
        return Redirect::route('home', ['auth' => 'forgot']);
    }

    /**
     * Send a password reset link to the given user.
     */
    public function sendResetLinkEmail(CustomerForgotPasswordRequest $request): JsonResponse|RedirectResponse
    {
        $request->ensureIsNotRateLimited();
        $request->hitRateLimiter();

        try {
            $this->authService->sendResetLink($request->validated('email'));
        } catch (\Throwable $e) {
            Log::error('CustomerAuthController: Failed to send password reset email.', [
                'email' => $request->validated('email'),
                'error' => $e->getMessage(),
            ]);

            return $this->respondError(
                message: 'Unable to send password reset email. Please try again later.',
                status: 500
            );
        }

        return $this->respondSuccess('We have sent password reset instructions to your email address.');
    }

    /**
     * Display the password reset view / open reset password modal.
     */
    public function resetPassword(Request $request, ?string $token = null): RedirectResponse
    {
        return Redirect::route('home', [
            'auth'  => 'reset',
            'token' => $token,
            'email' => $request->query('email', old('email')),
        ]);
    }

    /**
     * Reset the given user's password.
     */
    public function updatePassword(CustomerResetPasswordRequest $request): JsonResponse|RedirectResponse
    {
        $status = $this->authService->resetPassword($request->validated());

        if ($status === Password::PASSWORD_RESET) {
            return $this->respondSuccess(
                message: 'Your password has been successfully reset! You may now sign in with your new password.',
                redirectUrl: route('home', ['auth' => 'signin'])
            );
        }

        $errorMessage = __($status);
        if ($errorMessage === $status) {
            $errorMessage = 'This password reset link is invalid or has expired.';
        }

        throw ValidationException::withMessages([
            'email' => $errorMessage,
        ]);
    }

    /**
     * Unified response handler for AJAX and standard Browser requests.
     */
    protected function respondSuccess(string $message, ?string $redirectUrl = null, array $extraData = []): JsonResponse|RedirectResponse
    {
        if (request()->expectsJson() || request()->ajax()) {
            return response()->json(array_merge([
                'status'   => true,
                'message'  => $message,
                'redirect' => $redirectUrl,
            ], $extraData));
        }

        if ($redirectUrl) {
            return Redirect::to($redirectUrl)->with('status', $message)->with('success', $message);
        }

        return Redirect::back()->with('status', $message)->with('success', $message);
    }

    /**
     * Unified error response handler for unexpected runtime exceptions.
     */
    protected function respondError(string $message, int $status = 422, array $errors = []): JsonResponse|RedirectResponse
    {
        if (request()->expectsJson() || request()->ajax()) {
            return response()->json([
                'status'  => false,
                'message' => $message,
                'errors'  => $errors,
            ], $status);
        }

        return Redirect::back()->withErrors(['email' => $message])->withInput();
    }

    /**
     * Resolve a safe internal redirect URL to protect against Open Redirect vulnerabilities.
     */
    protected function getSafeRedirectUrl(Request $request, string $fallbackRoute = 'home'): string
    {
        $redirect = $request->input('redirect');
        $appHost  = parse_url(config('app.url', url('/')), PHP_URL_HOST);

        if ($redirect && is_string($redirect)) {
            if (Str::startsWith($redirect, '/') && !Str::startsWith($redirect, '//') && !Str::startsWith($redirect, '/\\')) {
                return url($redirect);
            }

            $redirectHost = parse_url($redirect, PHP_URL_HOST);
            if ($redirectHost && $appHost && strtolower($redirectHost) === strtolower($appHost)) {
                return $redirect;
            }
        }

        $previous = url()->previous();
        $excludedAuthUrls = [route('signin'), route('signup'), route('login')];

        if ($previous && !in_array($previous, $excludedAuthUrls)) {
            $prevHost = parse_url($previous, PHP_URL_HOST);
            if ($prevHost && $appHost && strtolower($prevHost) === strtolower($appHost)) {
                return $previous;
            }
        }

        return route($fallbackRoute);
    }
}
