<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Validation\Rule;

class UserController extends Controller
{
    // Show registration form
    public function register(){
        return view('users.register');
    }

    // Create new user and do login
    public function store(Request $request){
        $formData = $request->validate([
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:6',
        ]);

        // Hash Password
        $formData['password'] = bcrypt($formData['password']);

        $user = User::create($formData);

        // Login new user
        auth()->login($user);

        return redirect('/')->with('message', 'User created and logged in!');
    }

    // Logout user and invalidate session
    public function logout(Request $request){
        auth()->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('message', 'You have been logged out!');
    }

    // Show login form
    public function login(){             
        return view('users.login');
    }

    public function authenticate(Request $request){
        $formData = $request->validate([            
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if(auth()->attempt($formData)){
            $request->session()->regenerate();

            return redirect('/')->with('message', 'You are logged in!');
        }
        return back()->withErrors(['email'=>'Invalid credentials'])->onlyInput('email');
    }
}
