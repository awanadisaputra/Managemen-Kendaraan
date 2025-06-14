<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\RiwayatAktivitas;
use Auth;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function landing()
    {
        return view('landing');
    }

    // Mengarahkan ke file login
    public function index()
    {
        return view('auth.login');
    }

    // Input email dan password untuk login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            RiwayatAktivitas::create([
                'user_id' => Auth::id(),
                'jenis_aktivitas' => 'Login',
                'deskripsi' => 'User melakukan login ke sistem',
                'alamat_ip' => $request->ip(),
                'user_agent' => $request->userAgent()
            ]);

            $user = Auth::user();

            if ($user->isAdmin()) {
                return redirect()->route('admin.dashboard');
            } elseif ($user->isSupervisor() || $user->isManager()) {
                return redirect()->route('sm.dashboard');
            } elseif ($user->isSupir()) {
                return redirect()->route('supir.dashboard'); // Tambahkan route untuk supir
            } else {
                Auth::logout();
                return redirect()->route('login')->withErrors([
                    'email' => 'Akses ditolak. Peran pengguna tidak dikenali.'
                ]);
            }
        }

        return back()->withErrors([
            'email' => 'Email atau Password salah'
        ])->onlyInput('email');
    }
    // Logout
    public function logout(Request $request)
    {
        // Membuat log aktivitas logout
        RiwayatAktivitas::create([
            'user_id' => Auth::id(),
            'jenis_aktivitas' => 'Logout',
            'deskripsi' => 'User melakukan logout dari sistem',
            'alamat_ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }

}
