<?php

namespace App\Http\Controllers;

use App\Models\Kendaraan;
use Illuminate\Http\Request;
use App\Models\RiwayatAktivitas;

class KendaraanController extends Controller
{
    public function index()
    {
        $kendaraans = Kendaraan::all();

        // Log aktivitas 
        RiwayatAktivitas::create([
            'user_id' => auth()->id(),
            'jenis_aktivitas' => 'Melihat Daftar Kendaraan',
            'deskripsi' => 'User melihat daftar kendaraan',
            'alamat_ip' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        return view('admin.kendaraan.index', compact('kendaraans'));
    }

    public function create()
    {
        return view('admin.kendaraan.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nomor_plat' => 'required|unique:kendaraan',
            'jenis_kendaraan' => 'required|in:angkutan-orang,angkutan_barang',
            'status_kepemilikan' => 'required|in:milik_perusahaan,sewaan',
            'konsumsi_bbm' => 'required|numeric|min:0',
            'terakhir_service' => 'required|date',
            'km_service_berikutnya' => 'required|integer|min:0',
            'km_terakhir' => 'required|integer|min:0',
            'status' => 'required|in:tersedia,diservice,dipesan',
        ]);

        Kendaraan::create($validated);

        // Log aktivitas
        RiwayatAktivitas::create([
            'user_id' => auth()->id(),
            'jenis_aktivitas' => 'Menambah Kendaraan',
            'deskripsi' => 'User menambahkan kendaraan baru: ' . $validated['nomor_plat'],
            'alamat_ip' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        return redirect()->route('admin.kendaraan.index')->with('success', 'Kendaraan berhasil ditambahkan');
    }

    public function show(Kendaraan $kendaraan)
    {
        // Log aktivitas
        RiwayatAktivitas::create([
            'user_id' => auth()->id(),
            'jenis_aktivitas' => 'Melihat Detail Kendaraan',
            'deskripsi' => 'User melihat detail kendaraan: ' . $kendaraan->nomor_plat,
            'alamat_ip' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        return view('admin.kendaraan.show', compact('kendaraan'));
    }

    public function edit(Kendaraan $kendaraan)
    {
        return view('admin.kendaraan.edit', compact('kendaraan'));
    }

    public function update(Request $request, Kendaraan $kendaraan)
    {
        $validated = $request->validate([
            'nomor_plat' => 'required|unique:kendaraan,nomor_plat,' . $kendaraan->id,
            'jenis_kendaraan' => 'required|in:angkutan-orang,angkutan_barang',
            'status_kepemilikan' => 'required|in:milik_perusahaan,sewaan',
            'konsumsi_bbm' => 'required|numeric|min:0',
            'terakhir_service' => 'required|date',
            'km_service_berikutnya' => 'required|integer|min:0',
            'km_terakhir' => 'required|integer|min:0',
            'status' => 'required|in:tersedia,diservice,dipesan',
        ]);

        $kendaraan->update($validated);

        // Log aktivitas
        RiwayatAktivitas::create([
            'user_id' => auth()->id(),
            'jenis_aktivitas' => 'Mengupdate Kendaraan',
            'deskripsi' => 'User mengupdate data kendaraan: ' . $kendaraan->nomor_plat,
            'alamat_ip' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        return redirect()->route('admin.kendaraan.index')->with('success', 'Kendaraan berhasil diperbarui');
    }

    public function destroy(Kendaraan $kendaraan)
    {
        $kendaraan->delete();

        // Log aktivitas
        RiwayatAktivitas::create([
            'user_id' => auth()->id(),
            'jenis_aktivitas' => 'Menghapus Kendaraan',
            'deskripsi' => 'User menghapus kendaraan: ' . $kendaraan->nomor_plat,
            'alamat_ip' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        return redirect()->route('admin.kendaraan.index')->with('success', 'Kendaraan berhasil dihapus');
    }
}
