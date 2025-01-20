<?php

namespace App\Http\Controllers\servers;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Http\Request;
use App\Models\PermissionRole;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Ambil izin berdasarkan role pengguna
        $PermissionRole = PermissionRole::getPermission('Role', Auth::user()->role_id);
        if (empty($PermissionRole)) {
            return back();
        }

        // Ambil izin Add
        $data['PermissionAdd'] = PermissionRole::getPermission('Add Role', Auth::user()->role_id);
        $data['PermissionEdit'] = PermissionRole::getPermission('Edit Role', Auth::user()->role_id);
        $data['PermissionDelete'] = PermissionRole::getPermission('Delete Role', Auth::user()->role_id);

        // Ambil data
        $data['role'] = Role::getRecords();

        return view('servers.role.index', [
            'page_title' => 'Role List',
            'data' => $data
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Ambil izin berdasarkan role pengguna
        $PermissionRole = PermissionRole::getPermission('Add Role', Auth::user()->role_id);
        if (empty($PermissionRole)) {
            return back();
        }

        // Ambil data
        $data = Permission::getRecords();

        return view('servers.role.create', [
            'page_title' => 'Add New Role',
            'data' => $data
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Ambil izin berdasarkan role pengguna
        $PermissionRole = PermissionRole::getPermission('Add Role', Auth::user()->role_id);
        if (empty($PermissionRole)) {
            return back();
        }

        // Validasi
        $request->validate([
            'name' => 'required',
        ], [
            'name.required' => 'Role name is required',
        ]);

        // Buat role
        $role = Role::create([
            'name' => $request->name,
        ]);

        // Insert Permission
        PermissionRole::InsertUpdateRecord($request->permission_id, $role->id);

        return redirect('role')->with('success', 'Role created successfully');
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
        // Ambil izin berdasarkan role pengguna
        $PermissionRole = PermissionRole::getPermission('Edit Role', Auth::user()->role_id);
        if (empty($PermissionRole)) {
            return back();
        }

        // Ambil data
        $data['role'] = Role::getRecord($id);
        $data['permission'] = Permission::getRecords();
        $data['permissionRole'] = PermissionRole::getRolePermission($id);

        return view('servers.role.edit', [
            'page_title' => 'Role Detail',
            'data' => $data
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Ambil izin berdasarkan role pengguna
        $PermissionRole = PermissionRole::getPermission('Edit Role', Auth::user()->role_id);
        if (empty($PermissionRole)) {
            abort(404);
        }

        // Validasi
        $request->validate([
            'name' => 'required',
        ],
        [
            'name.required' => 'Role name is required',
        ]);

        // Update role
        Role::getRecord($id)->update([
            'name' => $request->name,
        ]);

        // Insert Permission
        PermissionRole::InsertUpdateRecord($request->permission_id, $id);

        return redirect('role')->with('success', 'Role updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Ambil izin berdasarkan role pengguna
        $PermissionRole = PermissionRole::getPermission('Delete Role', Auth::user()->role_id);
        if (empty($PermissionRole)) {
            abort(404);
        }

        // Hapus role
        Role::getRecord($id)->delete();

        return redirect('role')->with('success', 'Role deleted successfully');
    }
}