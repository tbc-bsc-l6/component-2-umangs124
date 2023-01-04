<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login()
    {           
        return view('users.login');
    }

    public function authenticate(Request $request)
    {   
        dd($request);
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
        return redirect('/')->with('message', 'You are now logged in');
    }

    public function register()
    {
        $roleId = DB::table('roles')->select('id')->where('id', '=', 1)->get();
        return view('users.register', ['roleId' => $roleId]); 
    }
    public function store(Request $request)
    {
        $formFields = $request->validate([
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);
        if ($request->hasFile('image')) {
            $formFields['image'] = $request->file('image')->store('userImage', 'public');
        }
        $roleId = json_decode($request->roleId);

        $formFields['role_id'] = $roleId[0]->id;

        $formFields['password'] = bcrypt($formFields['password']);

        $user = User::create($formFields);
        auth()->login($user);

        return redirect('/')->with('message', 'User created successfully');
    }
    

    public function logout()
    {
        auth()->logout();
        return redirect('/')->with('message', 'You have been logged out!');
    }
}
