<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            if (Auth::user()->isAdmin()) {
                return redirect()->route('admin.dashboard');
            }
            return redirect()->intended(route('home'));
        }

        return back()->withErrors(['email' => 'Invalid email or password.'])->withInput();
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name'  => 'required|string|max:100',
            'email'      => 'required|email|unique:users',
            'password'   => 'required|min:6|confirmed',
            'telephone'  => 'nullable|string|max:20',
            'province'   => 'nullable|string|max:100',
            'district'   => 'nullable|string|max:100',
        ]);

        User::create([
            'first_name' => $request->first_name,
            'last_name'  => $request->last_name,
            'email'      => $request->email,
            'password'   => Hash::make($request->password),
            'telephone'  => $request->telephone,
            'province'   => $request->province,
            'district'   => $request->district,
            'user_type'  => 'user',
        ]);

        return redirect()->route('login')->with('success', 'Registration successful. Please login.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home');
    }

    public function showForgotPassword()
    {
        return view('auth.forgot-password');
    }

    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return back()->withErrors(['email' => 'No account found with that email.']);
        }

        $token = Str::random(64);
        $user->update([
            'reset_token'        => $token,
            'reset_token_expiry' => now()->addHour(),
        ]);

        $resetUrl = url('/reset-password?token=' . $token . '&email=' . urlencode($user->email));

        Mail::raw("Click the link below to reset your BusGoes password:\n\n$resetUrl\n\nThis link expires in 1 hour.", function ($message) use ($user) {
            $message->to($user->email)->subject('BusGoes – Password Reset');
        });

        return back()->with('success', 'Password reset link sent to your email.');
    }

    public function showResetPassword(Request $request)
    {
        return view('auth.reset-password', [
            'token' => $request->token,
            'email' => $request->email,
        ]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'token'    => 'required',
            'password' => 'required|min:6|confirmed',
        ]);

        $user = User::where('email', $request->email)
                    ->where('reset_token', $request->token)
                    ->where('reset_token_expiry', '>', now())
                    ->first();

        if (!$user) {
            return back()->withErrors(['token' => 'Invalid or expired reset link.']);
        }

        $user->update([
            'password'           => Hash::make($request->password),
            'reset_token'        => null,
            'reset_token_expiry' => null,
        ]);

        return redirect()->route('login')->with('success', 'Password reset successfully. Please login.');
    }
}
