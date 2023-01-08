<?php

namespace App\Http\Controllers;

use App\Interfaces\UserRepositoryInterface;
use App\Models\User;
use App\Repositories\UserRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    private UserRepositoryInterface $userRepository;
    public function __construct()
    {
        $this->userRepository = new UserRepository();
    }
    public function index()
    {
        // if (Auth::user()?->id != 2) {
        //     abort(403, 'Unauthorized Action');
        // }
        $users = $this->userRepository->getAllUsers();
        return view('vendors.index', ['users' => $users]);
    }

    public function create()
    {
        // if (Auth::user()?->id != 2) {
        //     abort(403, 'Unauthorized Action');
        // }
        $roleId = DB::table('roles')->select('id')->where('id', '=', 1)->get();
        return view('vendors.create', ['roleId' => $roleId]);
    }

    public function store(Request $request)
    {
        // if (Auth::user()?->id != 2) {
        //     abort(403, 'Unauthorized Action');
        // }
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
        $this->userRepository->addUser($formFields);

        return redirect('showAllVendors')->with('message', 'User created successfully');
    }

    public function edit($id)
    {
        // if (Auth::user()?->id != 2) {
        //     abort(403, 'Unauthorized Action');
        // }
        $user = $this->userRepository->getUserById($id);
        return view('vendors.edit', ['user' => $user]);
    }

    public function update(Request $request)
    {
        // if (Auth::user()?->id != 2) {
        //     abort(403, 'Unauthorized Action');
        // }
        $formFields = $request->validate([
            'name' => 'required',
            'email' => 'required|email'
        ]);
        if ($request->hasFile('image')) {
            $formFields['image'] = $request->file('image')->store('userImage', 'public');
        }

        $user = $this->userRepository->getUserById($request->userId);
        // if (File::exists(public_path('storage/' . $user->image))) {
        //     File::delete(public_path('storage/' . $user->image));
        // }
        $this->userRepository->updateUser($request->userId, $formFields);

        return redirect('showAllVendors')->with('message', 'User updated successfully');
    }

    public function destroy($id)
    {
        // if (Auth::user()?->id != 2) {
        //     abort(403, 'Unauthorized Action');
        // }

        $user = $this->userRepository->getUserById($id);
        // if (File::exists(public_path('storage/' . $user->image))) {
        //     File::delete(public_path('storage/' . $user->image));
        // }
        $this->userRepository->deleteUser($id);
        return redirect('showAllVendors')->with('message', 'User deleted successfully');
    }

    public function showChangePasswordForm()
    {
        // if (Auth::user()?->id != 1) {
        //     abort(403, 'Unauthorized Action');
        // }
        return view('vendors.changePasswordForm');
    }

    public function sendVerificationCode(Request $request)
    {
        // if (Auth::user()?->id != 1) {
        //     abort(403, 'Unauthorized Action');
        // }
        $code = random_int(100000, 999999);
        $data = ['code' => $code];
        $user['email'] = Auth::user()?->email;
        Mail::send('mail', $data, function ($messages) use ($user) {
            $messages->to($user['email']);
            $messages->subject('Verification Code');
        });

        $formFields['verification_token'] = $code;

        $this->userRepository->updateVerificationCode(Auth::user()?->id, $formFields);
        Session::put('changedPassword', $request->password);
        return redirect('verificationCodeForm')->with('message', 'Please Enter Verification Code');
    }

    public function verificationCodeForm()
    {
        // if (Auth::user()?->id != 1) {
        //     abort(403, 'Unauthorized Action');
        // }
        return view('vendors.verificationCodeForm');
    }

    public function verifyVerificationCode(Request $request)
    {
        // if (Auth::user()?->id != 1) {
        //     abort(403, 'Unauthorized Action');
        // }
        $getCode = $request->code;
        $actualCode = $this->userRepository->getVerificationToken(Auth::user()?->id);
        if ($getCode != $actualCode->verification_token) {
            return back()->withErrors(['verification_token' => 'Invalid Token']);
        }
        $formFields['password'] = bcrypt(Session::get('changedPassword'));
        $formFields['verification_token'] = null;
        $this->userRepository->updatePassword(Auth::user()?->id, $formFields);
        return redirect('showProductByVendorId/' . Auth::user()?->id)->with('message', 'Password Changed Successfully');
    }
}
