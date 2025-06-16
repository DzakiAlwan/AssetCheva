<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function handleLogin(Request $request)
    {
        // Jika user sudah login, redirect ke dashboard sesuai role
        if (Auth::check()) {
            return $this->redirectBasedOnRole();
        }

        // Jika request method GET, tampilkan halaman login
        if ($request->isMethod('get')) {
            return view('pages.auth.login');
        }

        // Jika request method POST, proses login
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return $this->redirectBasedOnRole();
        }

        // Jika login gagal
        return back()->withErrors([
            'email' => 'Email/Password yang diberikan tidak sesuai.',
        ])->onlyInput('email');
    }

    // Fungsi untuk redirect berdasarkan role
    private function redirectBasedOnRole()
    {
        if (Auth::user()->role === 'Mahasiswa') {
            return redirect()->intended('/dashboard-users');
        } elseif (in_array(Auth::user()->role, ['Dosen', 'Admin'])) {
            return redirect()->intended('/dashboard');
        }

        // Default redirect jika role tidak dikenali
        return redirect()->intended('/');
    }
    public function registerView()
    {

        return view('pages.auth.register');
    }

    function register(Request $request)
    {
        $request->validate([
            'name' => 'required|max:50',
            'email' => 'required|email|max:50',
            'role' => 'required|max:50|min:8',
            'password' => 'required|max:50|min:8',
            'confirm_password' => 'required|max:50|min:8|same:password',
        ]);

        $request['status'] = "active";
        $user = User::create($request->all());
        Auth::login($user);

        // Redirect berdasarkan role user
        if ($user->role === 'admin' || $user->role === 'dosen') {
            return redirect('/dashboard');
        } else {
            return redirect('/dashboard-users');
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
