<?php

namespace App\Http\Controllers\servers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\PermissionRole;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $PermissionRole = PermissionRole::getPermission('User', Auth::user()->role_id);
        if (empty($PermissionRole)) {
            abort(404);
        }

        $data['PermissionAdd'] = PermissionRole::getPermission('Add User', Auth::user()->role_id);
        $data['PermissionEdit'] = PermissionRole::getPermission('Edit User', Auth::user()->role_id);
        $data['PermissionDelete'] = PermissionRole::getPermission('Delete User', Auth::user()->role_id);
        
        $data['user'] = User::getRecords();
        return view('servers.user.index', [
            'page_title' => 'User List',
            'data' => $data
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $PermissionRole = PermissionRole::getPermission('Add User', Auth::user()->role_id);
        if (empty($PermissionRole)) {
            abort(404);
        }

        $data = Role::getRecords();
        return view('servers.user.create', [
            'page_title' => 'Add New User',
            'data' => $data
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $PermissionRole = PermissionRole::getPermission('Add User', Auth::user()->role_id);
        if (empty($PermissionRole)) {
            abort(404);
        }

        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'role_id' => 'required',
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

        return redirect('user')->with('success', 'User created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $PermissionRole = PermissionRole::getPermission('Edit User', Auth::user()->role_id);
        if (empty($PermissionRole)) {
            abort(404);
        }

        $data['user'] = User::getSingleRecord($id);
        $data['role'] = Role::getRecords();
        return view('servers.user.edit', [
            'page_title' => 'Edit User',
            'data' => $data
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $PermissionRole = PermissionRole::getPermission('Edit User', Auth::user()->role_id);
        if (empty($PermissionRole)) {
            abort(404);
        }

        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'nullable|min:8',
            'role_id' => 'required',
        ]);

        $user = User::getSingleRecord($id);
        if (empty($request->password)) {
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'role_id' => $request->role_id
            ]);
        } else {
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role_id' => $request->role_id
            ]);
        }

        return redirect('user')->with('success', 'User updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $PermissionRole = PermissionRole::getPermission('Delete User', Auth::user()->role_id);
        if (empty($PermissionRole)) {
            abort(404);
        }

        $user = User::getSingleRecord($id);
        $user->delete();

        return back()->with('success', 'User deleted successfully');
    }
}
