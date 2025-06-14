<?php

namespace App\Http\Controllers\Log;

use App\Models\Kendaraan;
use App\Models\RiwayatBbm;
use Illuminate\Http\Request;
use App\Models\RiwayatAktivitas;
use App\Http\Controllers\Controller;

class RiwayatBbmController extends Controller
{

    public function indexSM()
    {
        $riwayatBbms = RiwayatBbm::with(['kendaraan', 'dicatatOleh', 'dibuatOleh'])
            ->orderBy('tanggal', 'desc')
            ->paginate(20);

        // Log aktivitas
        RiwayatAktivitas::create([
            'user_id' => auth()->id(),
            'jenis_aktivitas' => 'Melihat Riwayat BBM',
            'deskripsi' => 'User melihat riwayat pengisian BBM',
            'alamat_ip' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        return view('sm.bbm', compact('riwayatBbms'));
    }
    public function indexAdmin()
    {
        $riwayatBbms = RiwayatBbm::with(['kendaraan', 'dicatatOleh', 'dibuatOleh'])
            ->orderBy('tanggal', 'desc')
            ->paginate(20);

        // Log aktivitas
        RiwayatAktivitas::create([
            'user_id' => auth()->id(),
            'jenis_aktivitas' => 'Melihat Riwayat BBM',
            'deskripsi' => 'User melihat riwayat pengisian BBM',
            'alamat_ip' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        return view('admin.bbm.index', compact('riwayatBbms'));
    }

    public function create()
    {
        $kendaraans = Kendaraan::all();
        return view('admin.bbm.create', compact('kendaraans'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kendaraan_id' => 'required|exists:kendaraan,id',
            'tanggal' => 'required|date',
            'jumlah' => 'required|numeric|min:0',
            'biaya' => 'required|numeric|min:0',
            'km_tercatat' => 'required|integer|min:0',
        ]);

        $validated['dicatat_oleh'] = auth()->id();
        $validated['dibuat_oleh'] = auth()->id();

        RiwayatBbm::create($validated);

        // Update km terakhir kendaraan
        $kendaraan = Kendaraan::find($validated['kendaraan_id']);
        $kendaraan->km_terakhir = $validated['km_tercatat'];
        $kendaraan->save();

        // Log aktivitas
        RiwayatAktivitas::create([
            'user_id' => auth()->id(),
            'jenis_aktivitas' => 'Menambah Riwayat BBM',
            'deskripsi' => 'User menambahkan riwayat pengisian BBM untuk kendaraan: ' . $kendaraan->nomor_plat,
            'alamat_ip' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        return redirect()->route('admin.bbm.index')->with('success', 'Riwayat BBM berhasil ditambahkan');
    }
}
