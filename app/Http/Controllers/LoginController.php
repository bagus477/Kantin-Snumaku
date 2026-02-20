<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function chooseRole()
    {
        return view('auth.choose-role');
    }

    public function showPembeliLogin()
    {
        return view('auth.login-buyer');
    }

    public function showPenjualLogin()
    {
        return view('auth.login-seller');
    }

    public function showPembeliRegister()
    {
        return view('auth.register-buyer');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
            'role' => ['required', 'in:penjual,pembeli'],
        ]);

        if (Auth::attempt([
            'email' => $credentials['email'],
            'password' => $credentials['password'],
            'role' => $credentials['role'],
        ], $request->boolean('remember'))) {
            $request->session()->regenerate();

            if ($credentials['role'] === 'penjual') {
                return redirect()->intended('/penjual/dashboard');
            }

            return redirect()->intended('/pembeli/dashboard');
        }

        return back()->withErrors([
            'email' => 'Email, password, atau role tidak sesuai.',
        ])->onlyInput('email');
    }

    public function registerPembeli(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'role' => 'pembeli',
        ]);

        Auth::login($user);

        $request->session()->regenerate();

        return redirect()->route('pembeli.dashboard');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
