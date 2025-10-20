<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules;
use App\Http\Requests\Admin\UpdateProfileRequest;

class AdminProfileController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }
    /**
     * Show the profile page.
     */
    public function show()
    {
        return view('admin.profile', [
            'user' => Auth::user()
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'unit' => ['required', 'string'],
            'foto' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ], [
            'name.required' => 'Nama wajib diisi.',
            'name.max' => 'Nama tidak boleh lebih dari 255 karakter.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan oleh pengguna lain.',
            'unit.required' => 'Unit wajib dipilih.',
            'foto.image' => 'File harus berupa gambar.',
            'foto.mimes' => 'Format foto harus: jpeg, png, jpg, atau gif.',
            'foto.max' => 'Ukuran foto tidak boleh lebih dari 2MB.',
        ]);

        try {
            // Update basic info
            $user->name = $request->name;
            $user->email = $request->email;
            $user->unit = $request->unit;

            // Handle photo upload
            if ($request->hasFile('foto')) {
                // Delete old photo if exists
                if ($user->foto && Storage::disk('public')->exists('users/' . $user->foto)) {
                    Storage::disk('public')->delete('users/' . $user->foto);
                }

                // Store new photo
                $file = $request->file('foto');
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('users', $filename, 'public');
                
                if ($path) {
                    $user->foto = $filename;
                } else {
                    return back()->withErrors(['foto' => 'Gagal mengupload foto. Silakan coba lagi.']);
                }
            }

            $user->save();

            return back()->with('success', 'Profile berhasil diupdate!');
            
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Terjadi kesalahan saat mengupdate profile. Silakan coba lagi.']);
        }
    }

    /**
     * Update the user's password.
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        /** @var User $user */
        $user = Auth::user();
        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success', 'Password berhasil diupdate!');
    }

    /**
     * Delete user's photo
     */
    public function deletePhoto()
    {
        /** @var User $user */
        $user = Auth::user();
        
        if ($user->foto && Storage::disk('public')->exists('users/' . $user->foto)) {
            Storage::disk('public')->delete('users/' . $user->foto);
        }
        
        $user->foto = null;
        $user->save();

        return back()->with('success', 'Foto berhasil dihapus!');
    }
}
