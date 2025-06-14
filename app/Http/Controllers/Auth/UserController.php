<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\RiwayatAktivitas;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();

        // Log aktivitas
        RiwayatAktivitas::create([
            'user_id' => auth()->id(),
            'jenis_aktivitas' => 'Melihat Daftar User',
            'deskripsi' => 'User melihat daftar pengguna sistem',
            'alamat_ip' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        return view('admin.user.index', compact('users'));
    }

    public function create()
    {
        $atasanOptions = User::whereIn('peran', ['supervisor', 'manager'])->get();
        return view('admin.user.create', compact('atasanOptions'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'peran' => 'required|in:admin,supervisor,manager,supir',
            'atasan_id' => 'nullable|exists:users,id',
        ]);

        $validated['password'] = Hash::make($validated['password']);

        $user = User::create($validated);

        // Log aktivitas
        RiwayatAktivitas::create([
            'user_id' => auth()->id(),
            'jenis_aktivitas' => 'Menambah User',
            'deskripsi' => 'User menambahkan pengguna baru: ' . $user->nama,
            'alamat_ip' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        return redirect()->route('admin.user.index')->with('success', 'User berhasil ditambahkan');
    }

    public function show(User $user)
    {
        // Log aktivitas
        RiwayatAktivitas::create([
            'user_id' => auth()->id(),
            'jenis_aktivitas' => 'Melihat Detail User',
            'deskripsi' => 'User melihat detail pengguna: ' . $user->nama,
            'alamat_ip' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        return view('admin.user.show', compact('user'));
    }

    public function edit(User $user)
    {
        $atasanOptions = User::whereIn('peran', ['supervisor', 'manager'])->get();
        return view('admin.user.edit', compact('user', 'atasanOptions'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'peran' => 'required|in:admin,supervisor,manager,supir',
            'atasan_id' => 'nullable|exists:users,id',
        ]);

        if ($request->filled('password')) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        // Log aktivitas
        RiwayatAktivitas::create([
            'user_id' => auth()->id(),
            'jenis_aktivitas' => 'Mengupdate User',
            'deskripsi' => 'User mengupdate data pengguna: ' . $user->nama,
            'alamat_ip' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        return redirect()->route('admin.user.index')->with('success', 'User berhasil diperbarui');
    }

    public function destroy(User $user)
    {
        $user->delete();

        // Log aktivitas
        RiwayatAktivitas::create([
            'user_id' => auth()->id(),
            'jenis_aktivitas' => 'Menghapus User',
            'deskripsi' => 'User menghapus pengguna: ' . $user->nama,
            'alamat_ip' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        return redirect()->route('admin.user.index')->with('success', 'User berhasil dihapus');
    }
}
