<?php

namespace App\Http\Controllers\servers;

use App\Models\User;
use App\Models\Donation;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\EventRegistration;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Ambil data pengguna
        $profile = User::findOrFail(Auth::user()->id);

        return view('servers.profile', [
            'profile' => $profile,
            'page_title' => 'Profile',
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate(
            [
                'name' => 'nullable | min:6',
                'email' => [
                    'nullable',
                    'email',
                    Rule::unique('users')->ignore(Auth::user()->id), // Abaikan email milik user yang sedang login
                ],
                'password' => 'nullable | required_with:old_password | string  | min:8',
                'profile_image' => 'nullable | image | mimes:jpg,jpeg,png | max:2048',
            ],
            [
                'profile_image.max' => 'Maksimal 2 MB',
                'profile_image.image' => 'File ekstensi harus jpg, jpeg, png',
            ]
        );

        dd($request->all());
        $users = User::find($id);

        try {
            if ($request->hasFile('profile_image')) {

                $file = $request->file('profile_image');

                // Simpan informasi gambar baru ke database
                $users->media()->updateOrCreate(
                    ['user_id' => $users->id],
                    [
                        // 'cloudinary_public_id' => $publicId,
                        // 'cloudinary_url' => $cloudinaryUrl,
                        'type' => 'image',
                    ]
                );

                return response()->json(['message' => 'Profile image updated successfully.']);
            } else {
                $users->update([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                ]);

                return back()->with('success', 'Profile Update!');
            }
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if ($user->media && $user->media->cloudinary_public_id) {
            // Hapus file dari Cloudinary
            // cloudinary()->destroy($user->media->cloudinary_public_id);

            // Hapus data media dari database
            $user->media()->delete();

            return response()->json(['message' => 'Profile picture removed successfully.']);
        } else {
            return response()->json(['error' => 'No profile picture found.'], 404);
        }
    }
}