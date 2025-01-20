<?php

namespace App\Http\Controllers\servers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\PermissionRole;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Ambil izin berdasarkan role pengguna
        $PermissionRole = PermissionRole::getPermission('User', Auth::user()->role_id);
        if (empty($PermissionRole)) {
            return back();
        }

        // Cek masing-masing izin untuk Add, Edit, dan Delete
        $data['PermissionAdd'] = PermissionRole::getPermission('Add User', Auth::user()->role_id);
        $data['PermissionEdit'] = PermissionRole::getPermission('Edit User', Auth::user()->role_id);
        $data['PermissionDelete'] = PermissionRole::getPermission('Delete User', Auth::user()->role_id);

        // Jika request adalah Ajax untuk DataTables
        if (request()->ajax()) {
            $users = User::with('role')->where('role_id', '!=', '01j8kkd0j357ddxkdq75etr7q2')->get();

            return DataTables::of($users)
                ->addIndexColumn()
                ->addColumn('action', function ($user) use ($data) {
                    $buttons = '';

                    // Tambahkan tombol Edit jika izin Edit ada
                    if (!empty($data['PermissionEdit'])) {
                        $buttons .= '<a href="' . route('user.edit', $user->id) . '" class="btn btn-sm btn-warning m-1">
                                    <i class="fas fa-edit"></i>
                                 </a>';
                    }

                    // Tambahkan tombol Delete jika izin Delete ada
                    if (!empty($data['PermissionDelete']) && $user->id !== Auth::user()->id) {
                        $buttons .= '<button class="btn btn-sm btn-danger m-1" onclick="confirmDelete(\'' . route('user.destroy', $user->id) . '\', \'' . $user->name . '\')">
                                    <i class="fas fa-trash"></i>
                                 </button>';
                    } else if ($user->id === Auth::user()->id && !empty($data['PermissionDelete'])) {
                        $buttons .= '<button class="btn btn-sm btn-danger m-1" disabled onclick="confirmDelete(\'' . route('user.destroy', $user->id) . '\', \'' . $user->name . '\')">
                                    <i class="fas fa-trash"></i>
                                 </button>';
                    } 

                    return $buttons;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        
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
        // Ambil izin berdasarkan role pengguna
        $PermissionRole = PermissionRole::getPermission('Add User', Auth::user()->role_id);
        if (empty($PermissionRole)) {
            return back();
        }

        // Ambil data
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
        // Ambil izin berdasarkan role pengguna
        $PermissionRole = PermissionRole::getPermission('Add User', Auth::user()->role_id);
        if (empty($PermissionRole)) {
            return back();
        }

        // Validasi
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'role_id' => 'required',
        ]);

        // Cari user terakhir
        $user = User::latest()->first();
        $kodeUser = "US";

        if ($user == null) {
            // Jika user terakhir belum ada
            $id_user = $kodeUser . "001";
        } else {
            // Jika user terakhir sudah ada
            $id_user = $user->id_user;
            $urutan = (int) substr($id_user, 3, 3);
            $urutan++;
            $id_user = $kodeUser . sprintf("%03s", $urutan);
        }

        // Simpan data
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
        // Ambil izin berdasarkan role pengguna
        $PermissionRole = PermissionRole::getPermission('Edit User', Auth::user()->role_id);
        if (empty($PermissionRole)) {
            return back();
        }

        // Ambil data
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
        // Ambil izin berdasarkan role pengguna
        $PermissionRole = PermissionRole::getPermission('Edit User', Auth::user()->role_id);
        if (empty($PermissionRole)) {
            return back();
        }

        // Validasi
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'nullable|min:8',
            'role_id' => 'required',
        ]);

        // Update user
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
        // Ambil izin berdasarkan role pengguna
        $PermissionRole = PermissionRole::getPermission('Delete User', Auth::user()->role_id);
        if (empty($PermissionRole)) {
            return back();
        }

        // Hapus user
        $user = User::getSingleRecord($id);
        $user->delete();

        return back()->with('success', 'User deleted successfully');
    }
}