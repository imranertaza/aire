<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Customer;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class CustomerAuthController extends Controller
{
    /**
     * Display signin page.
     */
    public function signin()
    {
        return \theme_view('auth.signin');
    }

    /**
     * Handle customer signin.
     */
    public function postSignin(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email|max:96',
            'password' => 'required|string',
        ]);

        if (Auth::guard('customer')->attempt($credentials)) {
            $request->session()->regenerate();
            
            $customer = Auth::guard('customer')->user();
            session()->put('customer_id', $customer->id);
            session()->put('customer_name', $customer->firstname . ' ' . $customer->lastname);
            session()->put('customer_email', $customer->email);
            session()->put('customer_pic', $customer->pic);

            return redirect()->route('home')->with('success', 'Logged in successfully!');
        }

        return back()->withErrors(['email' => 'Invalid email or password.'])->withInput();
    }

    /**
     * Display signup page.
     */
    public function signup()
    {
        return \theme_view('auth.signup');
    }

    /**
     * Handle customer signup.
     */
    public function postSignup(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:64',
            'email' => 'required|email|max:96|unique:customers,email',
            'password' => 'required|string|min:6',
        ]);

        $parts = explode(' ', trim($validated['name']), 2);
        $firstname = $parts[0];
        $lastname = isset($parts[1]) ? $parts[1] : '';

        $customer = Customer::create([
            'firstname' => $firstname,
            'lastname' => $lastname,
            'email' => $validated['email'],
            'phone' => $request->phone ?? '',
            'password' => Hash::make($validated['password']),
            'salt' => Str::random(9),
            'ip' => $request->ip(),
            'status' => 1,
        ]);

        Auth::guard('customer')->login($customer);
        $request->session()->regenerate();

        session()->put('customer_id', $customer->id);
        session()->put('customer_name', $customer->firstname . ' ' . $customer->lastname);
        session()->put('customer_email', $customer->email);
        session()->put('customer_pic', $customer->pic);

        return redirect()->route('home')->with('success', 'Registered and logged in successfully!');
    }

    /**
     * Handle customer logout.
     */
    public function logout(Request $request)
    {
        Auth::guard('customer')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        session()->forget(['customer_id', 'customer_name', 'customer_email', 'customer_pic']);

        return redirect()->route('home')->with('success', 'Logged out successfully!');
    }
}
