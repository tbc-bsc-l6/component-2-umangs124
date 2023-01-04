<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::query('users')->where('role_id', '=', 1)->filter(request(['user_search']))->paginate(4);
        return view('admin.index', ['users' => $users]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // if (Cache::has("getRoleIdOne")) {
        //     $roleId = Cache::get(("getRoleIdOne"));
        //     return view('admin.create', ['roleId' => $roleId]);
        // }
        $roleId = DB::table('roles')->select('id')->where('id', '=', 1)->get();
        // Cache::put("getRoleIdOne", $roleId, now()->addminutes(10));
        return view('admin.create', ['roleId' => $roleId]);
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

        User::create($formFields);

        return redirect('/')->with('message', 'User created successfully');
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
        return view('admin.edit', ['user' => $user]);
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


        return redirect('/')->with('message', 'User created successfully');
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

        return redirect('/admin/vendors')->with('message', 'User deleted successfully');
    }
}
