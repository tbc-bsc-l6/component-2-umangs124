<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::query('users')->where('role_id', '=', 1)->filter(request(['user_search']))->paginate(4);
        return view('vendors.index', ['users' => $users]);
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
        return view('vendors.create', ['roleId' => $roleId]);
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

        return redirect('showAllVendors')->with('message', 'User created successfully');
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
        return view('vendors.edit', ['user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $user = User::find($request->id);

        $formFields = $request->validate([
            'name' => 'required',
            'email' => 'required|email'
        ]);
        if ($request->hasFile('image')) {
            $formFields['image'] = $request->file('image')->store('userImage', 'public');
        }
        $formFields['role_id'] = $request->roleId;
        $user->update($formFields);
        return redirect('showAllVendors')->with('message', 'User created successfully');
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
        return redirect('showAllVendors')->with('message', 'User deleted successfully');
    }

    public function showChangePasswordForm()
    {
        return view('vendors.changePasswordForm');
    }
    public function changePassword(Request $request)
    {
        $user = User::find(Auth::user()?->id);
        $formFields = $request->validate([
            'password' => 'required|confirmed|min:6',
        ]);
        $formFields['password'] = bcrypt($formFields['password']);
        $user->update($formFields);
        return redirect('showProductByVendorId')->with('message', 'Password changed succesfully');
    }

    public function sendVerificationCode(Request $request)
    {
        $code = random_int(100000, 999999);

        $data = ['code' => $code];
        $user['email'] = Auth::user()?->email;
        Mail::send('mail', $data, function ($messages) use ($user) {
            $messages->to($user['email']);
            $messages->subject('Verification Code');
        });

        $formFields['verification_token'] = $code;
        $user = User::find(Auth::user()?->id);
        $user->update($formFields);
        Session::put('changedPassword', $request->password);
        return redirect('verificationCodeForm')->with('message', 'Please Enter Verification Code');
    }

    public function verificationCodeForm()
    {
        return view('vendors.verificationCodeForm');
    }
    
    public function verifyVerificationCode(Request $request)
    {
        $getCode = $request->code;
        $actualCode = DB::table('users')->select('verification_token')
            ->where('id', '=', Auth::user()?->id)->first();
        if ($getCode != $actualCode->verification_token) {
            return back()->withErrors(['verification_token' => 'Invalid Token']);
        }
        $user = User::find(Auth::user()?->id);
        $formFields['password'] = bcrypt(Session::get('changedPassword'));
        $formFields['verification_token'] = null;
        $user->update($formFields);
        return redirect('showProductByVendorId')->with('message', 'Password Changed Successfully');
    }
}
