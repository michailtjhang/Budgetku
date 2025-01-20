<?php

namespace App\Http\Controllers\servers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\PermissionRole;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $PermissionRole = PermissionRole::getPermission('Category', Auth::user()->role_id);
        if (empty($PermissionRole)) {
            return redirect()->route('dashboard')->with('error', 'You do not have permission to view this page.');
        }

        $data['PermissionAdd'] = PermissionRole::getPermission('Add Category', Auth::user()->role_id);
        $data['PermissionEdit'] = PermissionRole::getPermission('Edit Category', Auth::user()->role_id);
        $data['PermissionDelete'] = PermissionRole::getPermission('Delete Category', Auth::user()->role_id);

        // Ambil data kategori
        $data['category'] = Category::all();

        if (request()->ajax()) {
            $category = Category::latest()->get();

            return DataTables::of($category)
                ->addIndexColumn()
                ->addColumn('action', function ($category) use ($data) {
                    $buttons = '';

                    if (!empty($data['PermissionEdit'])) {
                        $buttons .= '<button type="button" class="btn btn-sm btn-warning m-1" data-toggle="modal" 
                            data-target="#modalUpdate' . $category->id . '">
                                <i class="fas fa-fw fa-edit"></i>
                            </button>';
                    }

                    if (!empty($data['PermissionDelete'])) {
                        $buttons .= '<button class="btn btn-sm btn-danger m-1" onclick="confirmDelete(\'' . route('category.destroy', $category->id) . '\', \'' . $category->name . '\')">
                                <i class="fas fa-trash"></i>
                             </button>';
                    }

                    return $buttons;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('servers.category.index', [
            'data' => $data,
            'page_title' => 'Category List',
        ]);
    }

    public function store(Request $request)
    {
        // Validasi
        $request->validate([
            'name' => 'required|unique:categories|min:3',
            'type' => 'required|in:0,1',
            'icon' => 'required|string',
        ], [
            'name.required' => 'Name is required.',
            'name.unique' => 'The category name must be unique.',
            'name.min' => 'Name must be at least 3 characters.',
            'type.required' => 'Category type is required.',
            'type.in' => 'Invalid category type selected.',
            'icon.required' => 'Icon class is required.',
            'icon.string' => 'Icon class must be a valid string.',
        ]);

        try {
            // Ambil jenis kategori
            if ($request->input('type') == 0) {
                $type = 'expense';
            } elseif ($request->input('type') == 1) {
                $type = 'income';
            }

            // Buat kategori
            Category::create([
                'name' => $request->input('name'),
                'type' => $type,
                'icon' => $request->input('icon'),
            ]);

            return back()->with('success', 'Category created successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to create category: ' . $e->getMessage());
        }
    }

    public function update(Request $request, string $id)
    {
        // Validasi
        $request->validate([
            'name' => [
                'required',
                'min:3',
                Rule::unique('categories', 'name')->ignore($id),
            ],
            'type' => 'required|in:0,1',
            'icon' => 'required|string',
        ], [
            'name.required' => 'Name is required.',
            'name.min' => 'Name must be at least 3 characters.',
            'name.unique' => 'The category name must be unique.',
            'type.required' => 'Category type is required.',
            'type.in' => 'Invalid category type selected.',
            'icon.required' => 'Icon class is required.',
            'icon.string' => 'Icon class must be a valid string.',
        ]);

        // Cari kategori berdasarkan ID
        $category = Category::findOrFail($id);

        try {
            // Ambil jenis kategori
            if ($request->input('type') == 0) {
                $type = 'expense';
            } elseif ($request->input('type') == 1) {
                $type = 'income';
            }

            // Update kategori
            $category->update([
                'name' => $request->input('name'),
                'type' => $type,
                'icon' => $request->input('icon'),
            ]);

            return back()->with('success', 'Category updated successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to update category: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Hapus kategori
        $category = Category::findOrFail($id);
        $category->delete();

        return response()->json([
            'message' => 'Category deleted successfully!'
        ], 200);
    }
}
