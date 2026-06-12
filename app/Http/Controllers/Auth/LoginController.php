<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\ActivityLogService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Inertia\Inertia;

class LoginController extends Controller
{
    
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        }
        return Inertia::render('Auth/Login');
    }

    
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string', 
            'password' => 'required|string',
        ]);

        $email = $request->input('username');
        $throttleKey = Str::transliterate(Str::lower($email) . '|' . $request->ip());

        
        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            return back()->withErrors([
                'username' => "Terlalu banyak percobaan masuk. Silakan coba lagi dalam {$seconds} detik.",
            ])->withInput($request->only('username'));
        }

        $credentials = [
            'email' => $email,
            'password' => $request->input('password'),
        ];

        if (!Auth::attempt($credentials, $request->boolean('remember'))) {
            RateLimiter::hit($throttleKey, 300); 
            return back()->withErrors([
                'username' => 'Nama pengguna atau kata sandi tidak cocok dengan data kami.',
            ])->withInput($request->only('username'));
        }

        RateLimiter::clear($throttleKey);

        
        ActivityLogService::log('Berhasil masuk ke portal admin');

        return redirect()->intended(route('admin.dashboard'));
    }

    
    public function logout(Request $request)
    {
        if (Auth::check()) {
            ActivityLogService::log('Berhasil keluar dari portal admin');
            Auth::logout();
        }

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
