<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RiwayatAktivitas;
use Illuminate\Support\Facades\DB;
use App\Models\PersetujuanPemesanan;

class PersetujuanController extends Controller
{
    public function index()
    {
        $persetujuans = PersetujuanPemesanan::with(['pemesanan.kendaraan', 'pemesanan.user'])
            ->where('persetujuan_id', auth()->id())
            ->where('status', 'menunggu')
            ->orderBy('tingkat_persetujuan')
            ->get();

        // Log aktivitas
        RiwayatAktivitas::create([
            'user_id' => auth()->id(),
            'jenis_aktivitas' => 'Melihat Daftar Persetujuan',
            'deskripsi' => 'User melihat daftar persetujuan yang menunggu',
            'alamat_ip' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        return view('sm.persetujuan', compact('persetujuans'));
    }

    public function disetujui(PersetujuanPemesanan $persetujuan)
    {
        if ($persetujuan->persetujuan_id !== auth()->id() || $persetujuan->status !== 'menunggu') {
            return redirect()->back()->with('error', 'Anda tidak dapat menyetujui persetujuan ini');
        }

        DB::transaction(function () use ($persetujuan) {
            // Update persetujuan
            $persetujuan->update([
                'status' => 'disetujui',
                'tanggal_persetujuan' => now(),
            ]);

            $pemesanan = $persetujuan->pemesanan;
            $totalPersetujuan = $pemesanan->persetujuan->count();
            $currentLevel = $persetujuan->tingkat_persetujuan;

            // Jika ini adalah persetujuan terakhir
            if ($currentLevel === $totalPersetujuan) {
                $pemesanan->status = 'disetujui';
                $pemesanan->save();
            } else {
                // Update status pemesanan untuk menunggu persetujuan berikutnya
                $nextLevel = $currentLevel + 1;
                $pemesanan->status = 'menunggu_persetujuan_manager'; // atau status sesuai level
                $pemesanan->save();

                // Aktifkan persetujuan berikutnya
                $nextApproval = PersetujuanPemesanan::where('pemesanan_id', $pemesanan->id)
                    ->where('tingkat_persetujuan', $nextLevel)
                    ->first();

                if ($nextApproval) {
                    $nextApproval->status = 'menunggu';
                    $nextApproval->save();
                }
            }

            // Log aktivitas
            RiwayatAktivitas::create([
                'user_id' => auth()->id(),
                'jenis_aktivitas' => 'Menyetujui Pemesanan',
                'deskripsi' => 'User menyetujui pemesanan dengan ID: ' . $pemesanan->id . ' pada tingkat ' . $currentLevel,
                'alamat_ip' => request()->ip(),
                'user_agent' => request()->userAgent(),
            ]);
        });

        return redirect()->route('sm.persetujuan.index')->with('success', 'Pemesanan berhasil disetujui');
    }

    public function ditolak(PersetujuanPemesanan $persetujuan)
    {
        if ($persetujuan->persetujuan_id !== auth()->id() || $persetujuan->status !== 'menunggu') {
            return redirect()->back()->with('error', 'Anda tidak dapat menolak persetujuan ini');
        }

        DB::transaction(function () use ($persetujuan) {
            // Update persetujuan
            $persetujuan->update([
                'status' => 'ditolak',
                'tanggal_persetujuan' => now(),
            ]);

            $pemesanan = $persetujuan->pemesanan;

            // Update status pemesanan
            $pemesanan->status = 'ditolak';
            $pemesanan->save();

            // Kembalikan status kendaraan
            $kendaraan = $pemesanan->kendaraan;
            $kendaraan->status = 'tersedia';
            $kendaraan->save();

            // Log aktivitas
            RiwayatAktivitas::create([
                'user_id' => auth()->id(),
                'jenis_aktivitas' => 'Menolak Pemesanan',
                'deskripsi' => 'User menolak pemesanan dengan ID: ' . $pemesanan->id,
                'alamat_ip' => request()->ip(),
                'user_agent' => request()->userAgent(),
            ]);
        });

        return redirect()->route('sm.persetujuan.index')->with('success', 'Pemesanan berhasil ditolak');
    }
}
