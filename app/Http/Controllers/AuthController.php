<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Services\LogService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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

        $user->sendEmailVerificationNotification();
        LogService::log('user_registered', 'New user registered', ['email' => $user->email], $user->id);

        return redirect()->route('login')->with('success', 'Registration successful! Please verify your email.');
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
                    $user->update(['google_id' => $googleUser->id]);
                    LogService::log('google_linked', 'Google account linked to existing user', ['email' => $user->email], $user->id);
                } else {
                    $user = User::create([
                        'name' => $googleUser->name,
                        'email' => $googleUser->email,
                        'google_id' => $googleUser->id,
                        'avatar' => $googleUser->avatar,
                        'email_verified_at' => now(),
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
            return redirect('/dashboard');
        }

        LogService::log('2fa_failed', 'Two-factor authentication failed', ['email' => $user->email], $userId);
        return back()->withErrors(['code' => 'Invalid code']);
    }
}