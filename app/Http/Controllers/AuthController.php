<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function redirect()
    {
        return redirect()->route('login');
    }

    public function login()
    {
        if (Auth::check()) {
            if (Auth::user()->hasRole('admin')) {
                return redirect()->intended('/admin');
            } elseif (Auth::user()->hasRole('registrar')) {
                return redirect()->intended('/registrar');
            } elseif (Auth::user()->hasRole('cashier')) {
                return redirect()->intended('/cashier');
            } elseif (Auth::user()->hasRole('doctor')) {
                return redirect()->intended('/doctor');
            } else {
                return redirect()->intended('/');
            }
        } else {
            return view('auth.login');
        }
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'login' => ['required'],
            'password' => ['required'],
        ]);
        $user = User::where('login', $credentials['login'])->first();
        if ($user && $user->password === $credentials['password']) {
            Auth::login($user);
            $request->session()->regenerate();
            if ($user->hasRole('admin')) {
                return redirect()->intended('/admin');
            } elseif ($user->hasRole('registrar')) {
                return redirect()->intended('/registrar');
            } elseif ($user->hasRole('cashier')) {
                return redirect()->intended('/cashier');
            } elseif ($user->hasRole('doctor')) {
                return redirect()->intended('/doctor');
            } else {
                return redirect()->intended('/');
            }
        }

        return back()->withErrors([
            'login' => 'The provided credentials do not match our records.',
        ])->onlyInput('login');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
