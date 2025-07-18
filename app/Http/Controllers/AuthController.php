<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\LogService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use PragmaRX\Google2FA\Google2FA;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user && $user->isLocked()) {
            LogService::log('login_locked', 'Login attempt on locked account', ['email' => $request->email], $user->id);
            return back()->withErrors(['email' => 'Account is locked. Try again later.']);
        }

        if (Auth::attempt($request->only('email', 'password'))) {
            $user = Auth::user();
            if ($user instanceof User) {
                $user->failed_attempts = 0;
                $user->save();
            }
            
            LogService::log('login_success', 'User logged in successfully', ['email' => $user->email]);
            
            if ($user->two_factor_enabled) {
                Auth::logout();
                session(['2fa_user_id' => $user->id]);
                return redirect()->route('2fa.verify');
            }

            // Check if email is verified
            if (!$user->hasVerifiedEmail()) {
                return redirect()->route('verification.notice');
            }

            return redirect()->intended('/dashboard');
        }

        if ($user) {
            $user->increment('failed_attempts');
            LogService::log('login_failed', 'Failed login attempt', ['email' => $request->email], $user->id);
            
            if ($user->failed_attempts >= 3) {
                $user->update(['locked_until' => now()->addMinutes(30)]);
                LogService::log('account_locked', 'Account locked due to multiple failed attempts', ['email' => $request->email], $user->id);
            }
        }

        return back()->withErrors(['email' => 'Invalid credentials']);
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Send email verification
        $user->sendEmailVerificationNotification();
        LogService::log('user_registered', 'New user registered', ['email' => $user->email], $user->id);

        // Log the user in so they can access the verification page
        Auth::login($user);

        return redirect()->route('verification.notice')
            ->with('success', 'Registration successful! Please check your email to verify your account.');
    }

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            
            $user = User::where('google_id', $googleUser->id)->first();
            
            if (!$user) {
                $user = User::where('email', $googleUser->email)->first();
                
                if ($user) {
                    $user->update([
                        'google_id' => $googleUser->id,
                        'email_verified_at' => now(), // Auto-verify Google users
                    ]);
                    LogService::log('google_linked', 'Google account linked to existing user', ['email' => $user->email], $user->id);
                } else {
                    $user = User::create([
                        'name' => $googleUser->name,
                        'email' => $googleUser->email,
                        'google_id' => $googleUser->id,
                        'avatar' => $googleUser->avatar,
                        'email_verified_at' => now(), // Auto-verify Google users
                    ]);
                    LogService::log('google_registered', 'User registered via Google', ['email' => $user->email], $user->id);
                }
            }

            Auth::login($user);
            LogService::log('google_login', 'User logged in via Google', ['email' => $user->email]);

            return redirect('/dashboard');
        } catch (\Exception $e) {
            LogService::log('google_login_failed', 'Google login failed', ['error' => $e->getMessage()]);
            return redirect()->route('login')->with('error', 'Google login failed');
        }
    }

    public function logout()
    {
        LogService::log('logout', 'User logged out', ['email' => Auth::user()->email]);
        Auth::logout();
        return redirect()->route('login');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function show2FAForm()
    {
        return view('auth.2fa');
    }

    public function verify2FA(Request $request)
    {
        $request->validate(['code' => 'required']);

        $userId = session('2fa_user_id');
        $user = User::findOrFail($userId);

        $google2fa = new Google2FA();
        $valid = $google2fa->verifyKey($user->two_factor_secret, $request->code);

        if ($valid) {
            Auth::login($user);
            session()->forget('2fa_user_id');
            LogService::log('2fa_success', 'Two-factor authentication successful', ['email' => $user->email]);
            
            // Check if email is verified after 2FA
            if (!$user->hasVerifiedEmail()) {
                return redirect()->route('verification.notice');
            }
            
            return redirect('/dashboard');
        }

        LogService::log('2fa_failed', 'Two-factor authentication failed', ['email' => $user->email], $userId);
        return back()->withErrors(['code' => 'Invalid code']);
    }

    // Password Reset Methods
    public function showForgotPasswordForm()
    {
        return view('auth.forgot-password');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $user = User::where('email', $request->email)->first();

        // Check if user exists and doesn't have a Google ID (only for manual registrations)
        if (!$user) {
            return back()->withErrors(['email' => 'We cannot find a user with that email address.']);
        }

        if ($user->google_id) {
            return back()->withErrors(['email' => 'This account was created with Google. Please use "Sign in with Google" option.']);
        }

        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status === Password::RESET_LINK_SENT) {
            LogService::log('password_reset_requested', 'Password reset link sent', ['email' => $request->email], $user->id);
            return back()->with('status', 'Password reset link sent to your email.');
        }

        return back()->withErrors(['email' => 'Unable to send password reset link.']);
    }

    public function showResetPasswordForm(Request $request, $token)
    {
        return view('auth.reset-password', ['token' => $token, 'email' => $request->email]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user && $user->google_id) {
            return back()->withErrors(['email' => 'This account was created with Google. Password reset is not available.']);
        }

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                    'remember_token' => Str::random(60),
                    'failed_attempts' => 0, // Reset failed attempts on successful password reset
                    'locked_until' => null, // Unlock account if it was locked
                ])->save();

                LogService::log('password_reset', 'Password reset successfully', ['email' => $user->email], $user->id);
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return redirect()->route('login')->with('status', 'Your password has been reset successfully!');
        }

        return back()->withErrors(['email' => 'Unable to reset password. Please try again.']);
    }
}