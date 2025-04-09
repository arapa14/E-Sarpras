<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public function index()
    {
        return view('superadmin.user');
    }

    public function getUser()
    {
        $users = User::orderBy('created_at', 'asc')->get();
        try {
            return DataTables::of($users)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btnEdit = '<button type="button" class="action-icon btn-edit p-2" data-id="' . $row->id . '" data-name="' . htmlspecialchars($row->name, ENT_QUOTES) . '" data-email="' . htmlspecialchars($row->email, ENT_QUOTES) . '" data-whatsapp="' . htmlspecialchars($row->whatsapp, ENT_QUOTES) . '" data-role="' . $row->role . '" title="Edit Pengguna">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </button>';
                    $btnDelete = '<button type="button" class="action-icon btn-delete p-2" data-id="' . $row->id . '" title="Hapus Pengguna">
                                    <i class="fa-solid fa-trash"></i>
                                </button>';
                    $btnSwitch = '<button type="button" class="action-icon btn-switch p-2" 
                                data-id="' . $row->id . '" 
                                data-name="' . htmlspecialchars($row->name, ENT_QUOTES) . '" 
                                data-email="' . htmlspecialchars($row->email, ENT_QUOTES) . '" 
                                data-role="' . $row->role . '" 
                                title="Switch Account">
                                    <i class="fa-solid fa-user-secret"></i>
                                </button>';

                    return '<div class="flex justify-center space-x-2">' . $btnEdit . $btnDelete . $btnSwitch . '</div>';
                })
                ->rawColumns(['action'])
                ->make(true);
        } catch (\Exception $e) {
            \Log::error($e);
            return response()->json(['error' => 'Terjadi kesalahan pada server.'], 500);
        }
    }

    // Simpan pengguna baru
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string',
            'email'    => 'required|email|unique:users,email',
            'whatsapp' => 'required|string',
            'role'     => 'required|in:superAdmin,admin,user',
            'password' => 'required|string|min:6|confirmed',
        ]);

        try {
            $user = new User();
            $user->name     = $request->name;
            $user->email    = $request->email;
            $user->whatsapp = $request->whatsapp;
            $user->role     = $request->role;
            $user->password = bcrypt($request->password);
            $user->save();

            return response()->json(['message' => 'Pengguna berhasil disimpan.'], 200);
        } catch (\Exception $e) {
            \Log::error($e);
            return response()->json(['message' => 'Gagal menyimpan pengguna.'], 500);
        }
    }

    // Update pengguna
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'     => 'required|string',
            'email'    => 'required|email|unique:users,email,' . $user->id,
            'whatsapp' => 'required|string',
            'role'     => 'required|in:superAdmin,admin,user',
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        try {
            $user->name     = $request->name;
            $user->email    = $request->email;
            $user->whatsapp = $request->whatsapp;
            $user->role     = $request->role;
            if ($request->filled('password')) {
                $user->password = bcrypt($request->password);
            }
            $user->save();

            return response()->json(['message' => 'Pengguna berhasil diperbarui.'], 200);
        } catch (\Exception $e) {
            \Log::error($e);
            return response()->json(['message' => 'Gagal memperbarui pengguna.'], 500);
        }
    }

    // Hapus pengguna
    public function destroy(User $user)
    {
        // Cegah pengguna menghapus diri sendiri
        if ($user->id === auth()->id()) {
            return response()->json(['message' => 'Anda tidak dapat menghapus akun sendiri.'], 403);
        }

        try {
            $user->delete();
            return response()->json(['message' => 'Pengguna berhasil dihapus.'], 200);
        } catch (\Exception $e) {
            \Log::error($e);
            return response()->json(['message' => 'Gagal menghapus pengguna.'], 500);
        }
    }


    // Switch account (login sebagai pengguna lain)
    public function switchAccount(Request $request, $id)
    {
        // Cegah switch account ke akun yang sedang aktif
        if (auth()->id() == $id) {
            return response()->json(['message' => 'Anda tidak dapat switch ke akun yang sama.'], 403);
        }

        $currentUser = Auth::user();
        // Hanya admin atau superAdmin yang diperbolehkan melakukan switch
        if ($currentUser && in_array($currentUser->role, ['admin', 'superAdmin'])) {
            // Simpan ID pengguna asli di session sebelum switch
            session(['original_user_id' => $currentUser->id]);

            // Login sebagai user target
            auth()->guard('web')->loginUsingId($id);

            // Redirect ke halaman dashboard atau halaman lainnya
            return redirect()->route('dashboard');
        }

        abort(403);
    }


    // Switch back (kembali ke akun asli)
    public function switchBack()
    {
        if (session()->has('original_user_id')) {
            $originalUserId = session('original_user_id');
            auth()->guard('web')->loginUsingId($originalUserId);
            session()->forget('original_user_id');

            // Redirect ke halaman user (ubah sesuai kebutuhan)
            return redirect()->route('user.index');
        }

        abort(403);
    }

    /**
     * Menampilkan halaman edit profil.
     */
    public function editProfile()
    {
        $user = Auth::user();
        return view('user.profile', compact('user'));
    }

    /**
     * Memproses update data profil.
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        // Validasi input
        $validated = $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => [
                'required',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
            'whatsapp'  => 'required|string|max:20',
            'password'  => 'nullable|confirmed|min:8',
        ]);

        // Update data pengguna
        $user->name     = $validated['name'];
        $user->email    = $validated['email'];
        $user->whatsapp = $validated['whatsapp'];

        // Jika pengguna mengubah password, maka update juga
        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return redirect()->route('dashboard')->with('success', 'Profil berhasil diperbarui');
    }
}
