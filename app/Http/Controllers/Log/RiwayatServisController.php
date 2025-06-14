<?php

namespace App\Http\Controllers\Log;

use App\Models\Kendaraan;
use Illuminate\Http\Request;
use App\Models\RiwayatServis;
use App\Models\RiwayatAktivitas;
use App\Http\Controllers\Controller;

class RiwayatServisController extends Controller
{
    public function indexSM()
    {
        $riwayatServis = RiwayatServis::with(['kendaraan', 'dibuatOleh'])
            ->orderBy('tanggal_service', 'desc')
            ->paginate(20);

        // Log aktivitas
        RiwayatAktivitas::create([
            'user_id' => auth()->id(),
            'jenis_aktivitas' => 'Melihat Riwayat Servis',
            'deskripsi' => 'User melihat riwayat servis kendaraan',
            'alamat_ip' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        return view('sm.servis', compact('riwayatServis'));
    }

    public function indexAdmin()
    {
        $riwayatServis = RiwayatServis::with(['kendaraan', 'dibuatOleh'])
            ->orderBy('tanggal_service', 'desc')
            ->paginate(20);

        // Log aktivitas
        RiwayatAktivitas::create([
            'user_id' => auth()->id(),
            'jenis_aktivitas' => 'Melihat Riwayat Servis',
            'deskripsi' => 'User melihat riwayat servis kendaraan',
            'alamat_ip' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        return view('admin.servis.index', compact('riwayatServis'));
    }

    public function create()
    {
        $kendaraans = Kendaraan::all();
        return view('admin.servis.create', compact('kendaraans'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kendaraan_id' => 'required|exists:kendaraan,id',
            'tanggal_service' => 'required|date',
            'biaya' => 'required|numeric|min:0',
            'catatan' => 'nullable|string',
            'km_servis_berikutnya' => 'required|integer|min:0',
        ]);

        $validated['dibuat_oleh'] = auth()->id();

        $riwayatServis = RiwayatServis::create($validated);

        // Update data kendaraan
        $kendaraan = Kendaraan::find($validated['kendaraan_id']);
        $kendaraan->terakhir_service = $validated['tanggal_service'];
        $kendaraan->km_service_berikutnya = $validated['km_servis_berikutnya'];
        $kendaraan->save();

        // Log aktivitas
        RiwayatAktivitas::create([
            'user_id' => auth()->id(),
            'jenis_aktivitas' => 'Menambah Riwayat Servis',
            'deskripsi' => 'User menambahkan riwayat servis untuk kendaraan: ' . $kendaraan->nomor_plat,
            'alamat_ip' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        return redirect()->route('admin.servis.index')->with('success', 'Riwayat servis berhasil ditambahkan');
    }
}
