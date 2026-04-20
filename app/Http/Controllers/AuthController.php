<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use Illuminate\Http\Request;

class AuthController extends Controller
{
     
    public function showRegister()
    {
        return view('auth.register');
    }

    
    public function register(Request $request)
    {
        
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6'
        ]);

        
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        
        Auth::login($user);

    
        return redirect('/tasks');
    }

    
    public function showLogin()
    {
        return view('auth.login');
    }

    
    public function login(Request $request)
    {
    
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

    
        if (Auth::attempt($request->only('email', 'password'))) {
            return redirect('/tasks');
        }

        return back()->with('error', 'Email ou mot de passe incorrect');
    }

    
    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
}
