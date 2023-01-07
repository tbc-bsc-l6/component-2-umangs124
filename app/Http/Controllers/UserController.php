<?php

namespace App\Http\Controllers;

use App\Interfaces\UserRepositoryInterface;
use App\Models\User;
use App\Repositories\UserRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
        $users = $this->userRepository->getAllUsers();
        return view('vendors.index', ['users' => $users]);
    }

    public function create()
    {
        $roleId = $this->userRepository->getRoleIdWithIdOne();
        return view('vendors.create', ['roleId' => $roleId]);
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
        $this->userRepository->addUser($formFields);

        return redirect('showAllVendors')->with('message', 'User created successfully');
    }

    public function edit($id)
    {
        $user = $this->userRepository->getUserById($id);
        return view('vendors.edit', ['user' => $user]);
    }

    public function update(Request $request)
    {
        
        $formFields = $request->validate([
            'name' => 'required',
            'email' => 'required|email'
        ]);
        if ($request->hasFile('image')) {
            $formFields['image'] = $request->file('image')->store('userImage', 'public');
        }
      
        $this->userRepository->updateUser($request->userId, $formFields);
        
        return redirect('showAllVendors')->with('message', 'User created successfully');
    }

    public function destroy($id)
    {
        $this->userRepository->deleteUser($id);
        return redirect('showAllVendors')->with('message', 'User deleted successfully');
    }

    public function showChangePasswordForm()
    {
        return view('vendors.changePasswordForm');
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

        $this->userRepository->updateVerificationCode(Auth::user()?->id, $formFields);
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
        $formFields['password'] = bcrypt(Session::get('changedPassword'));
        $formFields['verification_token'] = null;
        $this->userRepository->updatePassword(Auth::user()?->id, $formFields);
        return redirect('showProductByVendorId')->with('message', 'Password Changed Successfully');
    }
}
