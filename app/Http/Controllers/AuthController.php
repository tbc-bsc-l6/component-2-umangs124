<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login()
    {
        return view('users.login');
    }
    public function authenticate(Request $request)
    {
        // dd($request);
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        $user = User::where('email', '=', $request->email)->first();
        if (!$user) {
            return back()->withErrors(['email' => 'Invalid email address']);
        }
        if (!Hash::check($request->password, $user->password)) {
            return back()->withErrors(['password' => 'Invalid password']);
        }
        auth()->login($user);
        if (Auth::user()?->role_id == 2) {
            return redirect('/showAllVendors')->with('message', 'You are now logged in');
        }
        if (Auth::user()?->role_id == 1) {
            return redirect('/showProductByVendorId')->with('message', 'You are now logged in');
        }
    }
    public function register()
    {
        $roles = Role::all();
        return view('users.register', ['roles' => $roles]);
    }
    public function store(Request $request)
    {
       // dd($request);
        $formFields = $request->validate([
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);
        if ($request->hasFile('image')) {
            $formFields['image'] = $request->file('image')->store('userImage', 'public');
        }

        $formFields['role_id'] = $request->roleId;

        $formFields['password'] = bcrypt($formFields['password']);

        $user = User::create($formFields);
        auth()->login($user);

        if (Auth::user()?->role_id == 2) {
            return redirect('/showAllVendors')->with('message', 'You are now logged in');
        }
        if (Auth::user()?->role_id == 1) {
            return redirect('/showProductByVendorId')->with('message', 'You are now logged in');
        }
    }
    public function logout()
    {
        auth()->logout();
        session()->flush();
        return redirect('/')->with('message', 'You have been logged out!');
    }
}
