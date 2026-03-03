<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'username' => ['required','string'],
            'password' => ['required','string'],
        ]);

        // Fixed admin credentials check
        $fixedUser = 'admin';
        $fixedPass = 'eco21';

        if ($data['username'] === $fixedUser && $data['password'] === $fixedPass) {
            // Ensure an admin user exists, create if missing
            $user = User::firstOrCreate(
                ['name' => $fixedUser],
                ['email' => 'admin@local', 'password' => Hash::make($fixedPass), 'is_admin' => true]
            );

            Auth::login($user);
            $request->session()->regenerate();
            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors(['username' => 'Invalid credentials']);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.login');
    }
}
