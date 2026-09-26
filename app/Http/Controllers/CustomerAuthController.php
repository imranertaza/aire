<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CustomerAuthController extends Controller
{
    /**
     * Display the customer signin view.
     */
    public function signin()
    {
        return \theme_view('auth.signin');
    }

    /**
     * Handle customer signin authentication with brute-force throttling and active status validation.
     */
    public function postSignin(Request $request)
    {
        // Normalize email input to lowercase and trim whitespace
        $request->merge([
            'email' => Str::lower(trim((string) $request->input('email', ''))),
        ]);

        $validator = Validator::make($request->all(), [
            'email'    => 'required|email|max:96',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'status'  => false,
                    'message' => $validator->errors()->first(),
                    'errors'  => $validator->errors(),
                ], 422);
            }

            return Redirect::back()->withErrors($validator)->withInput($request->except('password'));
        }

        // Throttle key based on normalized email and client IP
        $throttleKey = Str::transliterate($request->input('email') . '|' . $request->ip());

        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            $message = "Too many failed login attempts. Please try again in {$seconds} seconds.";

            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'status'  => false,
                    'message' => $message,
                    'errors'  => ['email' => [$message]],
                ], 429);
            }

            return Redirect::back()->withErrors(['email' => $message])->withInput($request->except('password'));
        }

        $credentials = [
            'email'    => $request->input('email'),
            'password' => $request->input('password'),
            'status'   => 1, // Only active/non-suspended accounts can authenticate
        ];

        if (Auth::guard('customer')->attempt($credentials, $request->boolean('remember', false))) {
            RateLimiter::clear($throttleKey);
            $request->session()->regenerate();

            /** @var Customer $customer */
            $customer = Auth::guard('customer')->user();
            $fullName = $customer->full_name;

            $redirectUrl = $this->getSafeRedirectUrl($request);

            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'status'   => true,
                    'message'  => 'Logged in successfully!',
                    'redirect' => $redirectUrl,
                    'user'     => [
                        'name'  => $fullName,
                        'email' => $customer->email,
                    ],
                ]);
            }

            return Redirect::intended($redirectUrl)->with('success', 'Logged in successfully!');
        }

        // Register failed attempt in rate limiter
        RateLimiter::hit($throttleKey, 60);

        // Determine if account exists but is suspended for clear user feedback
        $inactiveCustomer = Customer::where('email', $request->input('email'))
            ->where('status', 0)
            ->first();

        $errorMessage = $inactiveCustomer
            ? 'Your account has been deactivated. Please contact customer support.'
            : 'Invalid email or password.';

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'status'  => false,
                'message' => $errorMessage,
                'errors'  => ['email' => [$errorMessage]],
            ], 422);
        }

        return Redirect::back()->withErrors(['email' => $errorMessage])->withInput($request->except('password'));
    }

    /**
     * Display the customer signup view.
     */
    public function signup()
    {
        return \theme_view('auth.signup');
    }

    /**
     * Handle customer registration with rate limiting, safe string boundaries, and event dispatching.
     */
    public function postSignup(Request $request)
    {
        // Rate limit registrations to prevent automated bot flooding (5 registrations / hour per IP)
        $regThrottleKey = 'signup|' . $request->ip();

        if (RateLimiter::tooManyAttempts($regThrottleKey, 5)) {
            $seconds = RateLimiter::availableIn($regThrottleKey);
            $minutes = (int) ceil($seconds / 60);
            $message = "Too many registration attempts. Please try again in {$minutes} minute(s).";

            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'status'  => false,
                    'message' => $message,
                    'errors'  => ['email' => [$message]],
                ], 429);
            }

            return Redirect::back()->withErrors(['email' => $message])->withInput($request->except('password'));
        }

        // Normalize email input
        $request->merge([
            'email' => Str::lower(trim((string) $request->input('email', ''))),
        ]);

        $validator = Validator::make($request->all(), [
            'name'     => 'required|string|max:64',
            'email'    => 'required|email|max:96|unique:customers,email',
            'password' => 'required|string|min:6',
            'phone'    => 'nullable|string|max:32',
        ]);

        if ($validator->fails()) {
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'status'  => false,
                    'message' => $validator->errors()->first(),
                    'errors'  => $validator->errors(),
                ], 422);
            }

            return Redirect::back()->withErrors($validator)->withInput($request->except('password'));
        }

        RateLimiter::hit($regThrottleKey, 3600);
        $validated = $validator->validated();

        // Safely parse name and clamp to 32 characters to prevent MySQL varchar(32) truncation errors
        $parts = preg_split('/\s+/', trim((string) $validated['name']), 2);
        $firstname = Str::substr($parts[0] ?? '', 0, 32);
        $lastname  = Str::substr($parts[1] ?? '', 0, 32);

        $customer = Customer::create([
            'firstname' => $firstname,
            'lastname'  => $lastname,
            'email'     => $validated['email'],
            'phone'     => $validated['phone'] ?? '',
            'password'  => Hash::make($validated['password']),
            'salt'      => Str::random(9),
            'ip'        => $request->ip(),
            'status'    => 1,
        ]);

        event(new Registered($customer));

        Auth::guard('customer')->login($customer);
        $request->session()->regenerate();

        $fullName = $customer->full_name;

        $redirectUrl = $this->getSafeRedirectUrl($request);

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'status'   => true,
                'message'  => 'Registered and logged in successfully!',
                'redirect' => $redirectUrl,
                'user'     => [
                    'name'  => $fullName,
                    'email' => $customer->email,
                ],
            ]);
        }

        return Redirect::intended($redirectUrl)->with('success', 'Registered and logged in successfully!');
    }

    /**
     * Handle customer logout.
     */
    public function logout(Request $request)
    {
        Auth::guard('customer')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'status'   => true,
                'message'  => 'Logged out successfully!',
                'redirect' => route('home'),
            ]);
        }

        return Redirect::route('home')->with('success', 'Logged out successfully!');
    }

    /**
     * Resolve a safe internal redirect URL to protect against Open Redirect vulnerabilities.
     */
    protected function getSafeRedirectUrl(Request $request, string $fallbackRoute = 'home'): string
    {
        $redirect = $request->input('redirect');
        $appHost  = parse_url(config('app.url', url('/')), PHP_URL_HOST);

        if ($redirect && is_string($redirect)) {
            // Permit relative paths while rejecting protocol-relative (//evil.com) and backslash payloads
            if (Str::startsWith($redirect, '/') && !Str::startsWith($redirect, '//') && !Str::startsWith($redirect, '/\\')) {
                return url($redirect);
            }

            // Permit explicit matches where host strictly matches the application host
            $redirectHost = parse_url($redirect, PHP_URL_HOST);
            if ($redirectHost && $appHost && strtolower($redirectHost) === strtolower($appHost)) {
                return $redirect;
            }
        }

        $previous = url()->previous();
        $excludedAuthUrls = [route('signin'), route('signup'), route('login')];

        // Ensure previous URL is internal and not an authentication form
        if ($previous && !in_array($previous, $excludedAuthUrls)) {
            $prevHost = parse_url($previous, PHP_URL_HOST);
            if ($prevHost && $appHost && strtolower($prevHost) === strtolower($appHost)) {
                return $previous;
            }
        }

        return route($fallbackRoute);
    }
}
