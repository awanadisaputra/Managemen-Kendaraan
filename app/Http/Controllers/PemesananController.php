<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Kendaraan;
use Illuminate\Http\Request;
use App\Models\RiwayatAktivitas;
use App\Models\PemesananKendaraan;
use Illuminate\Support\Facades\DB;
use App\Models\PersetujuanPemesanan;

class PemesananController extends Controller
{
    public function index()
    {
        $pemesanan = PemesananKendaraan::with(['kendaraan', 'user', 'supir'])->get();

        // Log aktivitas
        RiwayatAktivitas::create([
            'user_id' => auth()->id(),
            'jenis_aktivitas' => 'Melihat Daftar Pemesanan',
            'deskripsi' => 'User melihat daftar pemesanan kendaraan',
            'alamat_ip' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        return view('admin.pemesanan.index', compact('pemesanan'));
    }

    public function create()
    {
        $kendaraans = Kendaraan::where('status', 'tersedia')->get();
        $supirs = User::where('peran', 'supir')->get();
        $approvers = User::whereIn('peran', ['supervisor', 'manager'])->get();

        return view('admin.pemesanan.create', compact('kendaraans', 'supirs', 'approvers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kendaraan_id' => 'required|exists:kendaraan,id',
            'supir_id' => 'required|exists:users,id',
            'tanggal_mulai' => 'required|date|after_or_equal:today',
            'tanggal_selesai' => 'required|date|after:tanggal_mulai',
            'tujuan_penggunaan' => 'required|string',
            'tujuan_perjalanan' => 'required|string',
        ]);

        DB::transaction(function () use ($validated) {
            $admin = auth()->user(); // Admin yang login
            $supir = User::findOrFail($validated['supir_id']); // Supir yang dipilih
            $supervisor = $supir->atasan;
            $manager = $supervisor?->atasan;

            // Validasi relasi atasan
            if (!$supervisor) {
                abort(400, 'Supir yang dipilih belum memiliki atasan Supervisor. Silakan atur terlebih dahulu.');
            }

            if (!$manager) {
                abort(400, 'Supervisor dari supir ini belum memiliki atasan Manager. Silakan atur terlebih dahulu.');
            }

            // Buat pemesanan kendaraan
            $pemesanan = PemesananKendaraan::create([
                'user_id' => $admin->id, // Tetap simpan user pembuat (admin)
                'kendaraan_id' => $validated['kendaraan_id'],
                'supir_id' => $validated['supir_id'],
                'tanggal_mulai' => $validated['tanggal_mulai'],
                'tanggal_selesai' => $validated['tanggal_selesai'],
                'tujuan_penggunaan' => $validated['tujuan_penggunaan'],
                'tujuan_perjalanan' => $validated['tujuan_perjalanan'],
                'status' => 'menunggu_persetujuan_supervisor',
            ]);

            // Update status kendaraan
            $kendaraan = Kendaraan::find($validated['kendaraan_id']);
            $kendaraan->status = 'dipesan';
            $kendaraan->save();

            // Buat persetujuan supervisor
            PersetujuanPemesanan::create([
                'pemesanan_id' => $pemesanan->id,
                'persetujuan_id' => $supervisor->id,
                'tingkat_persetujuan' => 1,
                'status' => 'menunggu',
            ]);

            // Buat persetujuan manager
            PersetujuanPemesanan::create([
                'pemesanan_id' => $pemesanan->id,
                'persetujuan_id' => $manager->id,
                'tingkat_persetujuan' => 2,
                'status' => 'menunggu',
            ]);

            // Catat aktivitas
            RiwayatAktivitas::create([
                'user_id' => $admin->id,
                'jenis_aktivitas' => 'Membuat Pemesanan',
                'deskripsi' => 'Admin membuat pemesanan kendaraan baru dengan ID: ' . $pemesanan->id,
                'alamat_ip' => request()->ip(),
                'user_agent' => request()->userAgent(),
            ]);
        });

        return redirect()->route('admin.pemesanan.index')->with('success', 'Pemesanan berhasil dibuat dan menunggu persetujuan');
    }


    public function show(PemesananKendaraan $pemesanan)
    {
        $pemesanan->load(['kendaraan', 'user', 'supir', 'persetujuan.persetujuan']);

        // Log aktivitas
        RiwayatAktivitas::create([
            'user_id' => auth()->id(),
            'jenis_aktivitas' => 'Melihat Detail Pemesanan',
            'deskripsi' => 'User melihat detail pemesanan dengan ID: ' . $pemesanan->id,
            'alamat_ip' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        return view('admin.pemesanan.show', compact('pemesanan'));
    }

    public function edit(PemesananKendaraan $pemesanan)
    {
        if ($pemesanan->status !== 'menunggu_persetujuan_supervisor') {
            return redirect()->back()->with('error', 'Pemesanan tidak dapat diubah karena sudah diproses');
        }

        $kendaraans = Kendaraan::where('status', 'tersedia')->orWhere('id', $pemesanan->kendaraan_id)->get();
        $supirs = User::where('peran', 'supir')->get();
        $approvers = User::whereIn('peran', ['supervisor', 'manager'])->get();

        return view('admin.pemesanan.edit', compact('pemesanan', 'kendaraans', 'supirs', 'approvers'));
    }

    public function update(Request $request, PemesananKendaraan $pemesanan)
    {
        if ($pemesanan->status !== 'menunggu_persetujuan_supervisor') {
            return redirect()->back()->with('error', 'Pemesanan tidak dapat diubah karena sudah diproses');
        }

        $validated = $request->validate([
            'kendaraan_id' => 'required|exists:kendaraan,id',
            'supir_id' => 'required|exists:users,id',
            'tanggal_mulai' => 'required|date|after_or_equal:today',
            'tanggal_selesai' => 'required|date|after:tanggal_mulai',
            'tujuan_penggunaan' => 'required|string',
            'tujuan_perjalanan' => 'required|string',
            'approvers' => 'required|array|min:2',
            'approvers.*' => 'exists:users,id',
        ]);

        DB::transaction(function () use ($validated, $request, $pemesanan) {
            // Update pemesanan
            $pemesanan->update([
                'kendaraan_id' => $validated['kendaraan_id'],
                'supir_id' => $validated['supir_id'],
                'tanggal_mulai' => $validated['tanggal_mulai'],
                'tanggal_selesai' => $validated['tanggal_selesai'],
                'tujuan_penggunaan' => $validated['tujuan_penggunaan'],
                'tujuan_perjalanan' => $validated['tujuan_perjalanan'],
            ]);

            // Hapus persetujuan lama
            $pemesanan->persetujuans()->delete();

            // Buat persetujuan baru
            foreach ($validated['approvers'] as $index => $approverId) {
                $tingkat = $index + 1;
                $status = $tingkat === 1 ? 'menunggu' : 'menunggu';

                PersetujuanPemesanan::create([
                    'pemesanan_id' => $pemesanan->id,
                    'persetujuan_id' => $approverId,
                    'tingkat_persetujuan' => $tingkat,
                    'status' => $status,
                ]);
            }

            // Log aktivitas
            RiwayatAktivitas::create([
                'user_id' => auth()->id(),
                'jenis_aktivitas' => 'Mengupdate Pemesanan',
                'deskripsi' => 'User mengupdate pemesanan dengan ID: ' . $pemesanan->id,
                'alamat_ip' => request()->ip(),
                'user_agent' => request()->userAgent(),
            ]);
        });

        return redirect()->route('admin.pemesanan.index')->with('success', 'Pemesanan berhasil diperbarui');
    }

    public function selesai(Request $request, PemesananKendaraan $pemesanan)
    {
        $validated = $request->validate([
            'bbm_digunakan' => 'required|numeric|min:0',
            'km_akhir' => 'required|integer|gte:km_awal',
        ]);

        DB::transaction(function () use ($validated, $pemesanan) {
            // Update pemesanan
            $pemesanan->update([
                'status' => 'selesai',
                'bbm_digunakan' => $validated['bbm_digunakan'],
                'km_akhir' => $validated['km_akhir'],
                'tanggal_selesai' => now(),
            ]);

            // Update kendaraan
            $kendaraan = $pemesanan->kendaraan;
            $kendaraan->status = 'tersedia';
            $kendaraan->km_terakhir = $validated['km_akhir'];
            $kendaraan->save();

            // Log aktivitas
            RiwayatAktivitas::create([
                'user_id' => auth()->id(),
                'jenis_aktivitas' => 'Menyelesaikan Pemesanan',
                'deskripsi' => 'User menyelesaikan pemesanan dengan ID: ' . $pemesanan->id,
                'alamat_ip' => request()->ip(),
                'user_agent' => request()->userAgent(),
            ]);
        });

        return redirect()->route('admin.pemesanan.index')->with('success', 'Pemesanan telah diselesaikan');
    }
}
