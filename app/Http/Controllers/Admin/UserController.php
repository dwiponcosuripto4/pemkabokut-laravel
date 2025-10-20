<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Post;
use App\Models\Document;
use App\Models\Icon;
use App\Models\Business;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class UserController extends Controller
{
    // ...existing code...
    public function index()
    {
        $users = User::orderBy('created_at', 'desc')->get();
        
        return view('admin.user', compact('users'));
    }

    public function show(User $user)
    {
        return view('admin.user.show', compact('user'));
    }

    public function deactivate(User $user)
    {
        try {
            $user->update(['is_verified' => false]);
            return response()->json([
                'success' => true,
                'message' => 'User berhasil dinonaktifkan (verifikasi dicabut)'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menonaktifkan user'
            ], 500);
        }
    }

    public function activate(User $user)
    {
        try {
            $user->update(['is_active' => true]);
            
            return response()->json([
                'success' => true,
                'message' => 'User berhasil diaktifkan'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengaktifkan user'
            ], 500);
        }
    }
    public function verify(User $user)
    {
        if (auth()->id() !== 1) {
            return response()->json([
                'success' => false,
                'message' => 'Hanya admin yang dapat memverifikasi user.'
            ], 403);
        }
        try {
            $user->update(['is_verified' => true]);
            return response()->json([
                'success' => true,
                'message' => 'User berhasil diverifikasi.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memverifikasi user.'
            ], 500);
        }
    }
    public function destroy(User $user)
    {
        if (auth()->id() !== 1 || $user->id == 1) {
            return redirect()->back()->with('error', 'Hanya admin dengan ID 1 yang dapat menghapus user lain.');
        }
        try {
            // Update related models' user_id to 1
            \App\Models\Post::where('user_id', $user->id)->update(['user_id' => 1]);
            \App\Models\Document::where('user_id', $user->id)->update(['user_id' => 1]);
            \App\Models\Icon::where('user_id', $user->id)->update(['user_id' => 1]);
            \App\Models\Business::where('user_id', $user->id)->update(['user_id' => 1]);
            // Hapus user
            $user->delete();
            return redirect()->back()->with('success', 'User berhasil dihapus. Semua data terkait dialihkan ke user ID 1.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus user.');
        }
    }
    /**
     * Reset password user (hanya admin id 1)
     */
    public function resetPassword(Request $request, User $user)
    {
        if (auth()->id() !== 1) {
            return redirect()->back()->with('error', 'Hanya admin dengan ID 1 yang dapat mereset password.');
        }
        $request->validate([
            'new_password' => 'required|string|min:6',
        ]);
        $user->password = bcrypt($request->new_password);
        $user->save();
        return redirect()->back()->with('success', 'Password berhasil direset.');
    }

    /**
     * Download laporan user PDF
     */
    public function downloadReport()
    {
        // Get current month users
        $currentMonth = Carbon::now()->startOfMonth();
        $usersThisMonth = User::where('created_at', '>=', $currentMonth)->get();
        
        // Get all users for statistics
        $allUsers = User::all();
        
        // Calculate statistics
        $totalUsers = $allUsers->count();
        $usersPerUnit = $allUsers->groupBy('unit')->map->count();
        
        // Get user activities
        $userActivities = $usersThisMonth->map(function ($user) {
            return [
                'user' => $user,
                'posts_count' => Post::where('user_id', $user->id)->count(),
                'documents_count' => Document::where('user_id', $user->id)->count(),
                'portals_count' => Icon::where('user_id', $user->id)->count(), // Icons sebagai portal
                'umkm_approved_count' => Business::where('user_id', $user->id)->where('status', 1)->count(), // UMKM yang dibuat user dan sudah approved
            ];
        });
        
        $data = [
            'report_date' => Carbon::now()->format('d F Y'),
            'current_month' => Carbon::now()->format('F Y'),
            'total_users' => $totalUsers,
            'users_per_unit' => $usersPerUnit,
            'users_this_month' => $usersThisMonth,
            'user_activities' => $userActivities
        ];
        
        $pdf = PDF::loadView('admin.user.report', $data);
        $pdf->setPaper('A4', 'portrait');
        
        $filename = 'Laporan_User_' . Carbon::now()->format('Y_m_d') . '.pdf';
        
        return $pdf->download($filename);
    }
}
