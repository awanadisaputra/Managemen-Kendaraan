<?php

namespace App\Http\Controllers;

use App\Models\Kendaraan;
use App\Models\PersetujuanPemesanan;
use Illuminate\Http\Request;
use App\Models\RiwayatAktivitas;
use App\Models\PemesananKendaraan;

class DashboardController extends Controller
{
    // Untuk Admin
    public function indexAdmin(Request $request)
    {
        $totalKendaraan = Kendaraan::count();
        $totalPemesanan = PemesananKendaraan::count();
        $pemesananAktif = PemesananKendaraan::where('status', 'disetujui')->count();
        $aktivitasTerakhir = RiwayatAktivitas::latest()->take(5)->get();

        $pemakaianBulanan = PemesananKendaraan::selectRaw('MONTH(tanggal_mulai) as bulan, COUNT(*) as total')
            ->whereYear('tanggal_mulai', date('Y'))
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->pluck('total', 'bulan')
            ->toArray();

        $tahun = $request->get('tahun', date('Y'));

        $dataPemakaian = [];
        for ($i = 1; $i <= 12; $i++) {
            $dataPemakaian[] = $pemakaianBulanan[$i] ?? 0;
        }

        RiwayatAktivitas::create([
            'user_id' => auth()->id(),
            'jenis_aktivitas' => 'Akses Dashboard Admin',
            'deskripsi' => 'User mengakses dashboard admin',
            'alamat_ip' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        return view('admin.dashboard', compact('totalKendaraan', 'tahun', 'totalPemesanan', 'pemesananAktif', 'dataPemakaian', 'aktivitasTerakhir'));
    }

    // Untuk Supervisor & Manager
    public function indexSM()
    {
        $user = auth()->user();

        // Tentukan tingkat persetujuan berdasarkan peran user login
        // Misal kamu punya peran 'supervisor' dan 'manager'
        $tingkatPersetujuan = null;
        if ($user->peran == 'supervisor') {
            $tingkatPersetujuan = 1;
        } elseif ($user->peran == 'manager') {
            $tingkatPersetujuan = 2;
        } else {
            // Jika ada peran lain, atur sesuai kebutuhan atau default
            $tingkatPersetujuan = 0; // atau return error/redirect
        }

        $pemesananDisetujui = PersetujuanPemesanan::where('status', 'disetujui')
            ->where('tingkat_persetujuan', $tingkatPersetujuan)
            ->count();

        $pemesananMenunggu = PersetujuanPemesanan::where('status', 'menunggu')
            ->where('tingkat_persetujuan', $tingkatPersetujuan)
            ->count();

        $pemesananDitolak = PersetujuanPemesanan::where('status', 'ditolak')
            ->where('tingkat_persetujuan', $tingkatPersetujuan)
            ->count();

        // Logging aktivitas
        RiwayatAktivitas::create([
            'user_id' => $user->id,
            'jenis_aktivitas' => 'Akses Dashboard SM',
            'deskripsi' => "User dengan peran {$user->peran} mengakses dashboard",
            'alamat_ip' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        $recentPemesanan = PersetujuanPemesanan::whereIn('status', ['disetujui', 'menunggu'])
            ->where('tingkat_persetujuan', $tingkatPersetujuan)
            ->latest()
            ->with('pemesanan.user', 'pemesanan.kendaraan')
            ->take(5)
            ->get();

        $pemakaianDisetujui = PersetujuanPemesanan::selectRaw('MONTH(tanggal_persetujuan) as bulan, COUNT(*) as total')
            ->whereYear('tanggal_persetujuan', date('Y'))
            ->where('tingkat_persetujuan', $tingkatPersetujuan)
            ->where('status', 'disetujui')
            ->groupBy('bulan')
            ->pluck('total', 'bulan')
            ->toArray();

        $pemakaianDitolak = PersetujuanPemesanan::selectRaw('MONTH(tanggal_persetujuan) as bulan, COUNT(*) as total')
            ->whereYear('tanggal_persetujuan', date('Y'))
            ->where('tingkat_persetujuan', $tingkatPersetujuan)
            ->where('status', 'ditolak')
            ->groupBy('bulan')
            ->pluck('total', 'bulan')
            ->toArray();

        $dataDisetujui = [];
        $dataDitolak = [];
        for ($i = 1; $i <= 12; $i++) {
            $dataDisetujui[] = $pemakaianDisetujui[$i] ?? 0;
            $dataDitolak[] = $pemakaianDitolak[$i] ?? 0;
        }


        return view('sm.dashboard', compact(
            'pemesananDisetujui',
            'pemesananMenunggu',
            'pemesananDitolak',
            'recentPemesanan',
            'dataDisetujui',
            'dataDitolak'
        ));
    }

}
