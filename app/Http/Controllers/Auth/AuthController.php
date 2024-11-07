<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    public function login()
    {
        if (!empty(Auth::check())) {
            return redirect()->intended('admin/dashboard');
        }
        return view('auth.login');
    }

    public function auth_login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $remember = $request->has('remember') ? true : false;

        $user = User::where('email', $request->email)->first();

        if ($user) {
            if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $remember)) {
                return redirect()->intended('dashboard');
            } else {
                return redirect()->back()->with('error', 'Incorrect password. Please try again.');
            }
        } else {
            return redirect()->back()->with('error', 'Email not found. Please register first.');
        }
    }

    public function register()
    {
        return view('auth.register');
    }

    public function auth_register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
        ], [
            'name.required' => 'Name is required',
            'email.required' => 'Email is required',
            'email.email' => 'Email is invalid',
            'email.unique' => 'Email already exists',
            'password.required' => 'Password is required',
            'password.min' => 'Password must be at least 8 characters',
        ]);

        $user = User::latest()->first();
        $kodeUser = "US";

        if ($user == null) {
            $id_user = $kodeUser . "001";
        } else {
            $id_user = $user->id_user;
            $urutan = (int) substr($id_user, 3, 3);
            $urutan++;
            $id_user = $kodeUser . sprintf("%03s", $urutan);
        }

        $data = $request->all();
        $data['password'] = Hash::make($data['password']);
        $data['id_user'] = $id_user;
        $user = User::create($data);

        if ($user) {
            return redirect()->intended('/');
        } else {
            return redirect()->back()->with('error', 'Something went wrong');
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
