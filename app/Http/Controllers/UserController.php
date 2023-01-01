<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Cache::has("getAllUsersWithRoleIdOne")) {
            $users = Cache::get(("getAllUsersWithRoleIdOne"));
            return view('users.index', ['users' => $users]);
        }       
        $users = User::query('users')->where('role_id', '=', 1)->get();
        Cache::put("getAllUsersWithRoleIdOne", $users, now()->addminutes(10));
        return view('users.index', ['users' => $users]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Cache::has("getRoleIdOne")) {
            $roleId = Cache::get(("getRoleIdOne"));
            return view('users.create', ['roleId' => $roleId]);
        }   
        $roleId = DB::table('roles')->select('id')->where('id', '=', 1)->get();
        Cache::put("getRoleIdOne", $roleId, now()->addminutes(10));
        return view('users.create', ['roleId' => $roleId]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
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
        Cache::forget('getAllUsersWithRoleIdOne');
        return redirect('/users')->with('success_message', 'User created successfully');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = DB::table('users')->where('id', '=', $id)->first();
        return view('users.edit', ['user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id);

        $formFields = $request->validate([
            'name' => 'required',
            'email' => 'required|email'
        ]);
        if ($request->hasFile('image')) {
            $formFields['image'] = $request->file('image')->store('userImage', 'public');
        }
        $formFields['role_id'] = $request->roleId;
        $user->update($formFields);

        Cache::forget('getAllUsersWithRoleIdOne');
        return redirect('/users')->with('success_message', 'User created successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();
        Cache::forget('getAllUsersWithRoleIdOne');
        return redirect('/users')->with('deleteUser_message', 'User deleted successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }
}
