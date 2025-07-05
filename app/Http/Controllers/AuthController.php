<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $user = DB::table('users')->where('name', $credentials['username'])->first();

        if ($user && Hash::check($credentials['password'], $user->password)) {
            Auth::loginUsingId($user->id);

            DB::table('log_activity')->insert([
                'user_id'     => $user->id,
                'action'      => 'login',
                'module'      => 'auth',
                'description' => 'User login',
                'ip_address'  => request()->ip(),
                'user_agent'  => request()->userAgent(),
                'created_at'  => now(),
                'updated_at'  => now(),
            ]);

            return redirect()->route('dashboard');
        }

        return back()->withErrors(['login' => 'Username atau password salah']);
    }

    public function logout()
    {
        if (Auth::check()) {
            DB::table('log_activity')->insert([
                'user_id'     => Auth::id(),
                'action'      => 'logout',
                'module'      => 'auth',
                'description' => 'User logout',
                'ip_address'  => request()->ip(),
                'user_agent'  => request()->userAgent(),
                'created_at'  => now(),
                'updated_at'  => now(),
            ]);
        }
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect()->route('login');
    }
}
