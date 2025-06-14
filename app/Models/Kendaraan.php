<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kendaraan extends Model
{
    use HasFactory;

    // Tambahkan ini karena table adalah kendaraan karena jika tidak maka laravel akan membaca table ini menjadi kendaraans(jamak)
    protected $table = 'kendaraan';

    protected $fillable = [
        'nomor_plat',
        'jenis_kendaraan',
        'status_kepemilikan',
        'konsumsi_bbm',
        'terakhir_service',
        'km_service_berikutnya',
        'km_terakhir',
        'status',
    ];

    // untuk secara otomatis mengubah tipe data kolom terakhir_service menjadi objek Carbon (kelas untuk manipulasi tanggal/waktu di Laravel) saat kamu mengaksesnya dari model Eloquent.
    protected $casts = [
        'terakhir_service' => 'date',
    ];

    // Menghubungkan dengan peminjaman
    public function peminjaman()
    {
        return $this->hasMany(PemesananKendaraan::class);
    }

    // Menghubungkan dengan riwayat servis
    public function riwayatServis()
    {
        // Fungsi dari bagian ->orderBy('tanggal', 'desc') adalah untuk perintah pengurutan berdasarkan kolom tanggal secara menurun (desc), artinya data terbaru muncul lebih dulu.
        return $this->hasMany(RiwayatServis::class)->orderBy('tanggal', 'desc');
    }

    // Menghubungkan dengan riwayat bbm
    public function riwayatBbm()
    {
        return $this->hasMany(RiwayatBbm::class)->orderBy('tanggal', 'desc');
    }

    // Untuk coloum terakhir_servis dan hanya memiliki 1 (one to one) yang diambil dari table riwayat servis yang diambil pada data terbaru
    public function terakhirServis()
    {
        return $this->hasOne(RiwayatServis::class)->latestOfMany('tanggal_servis');
    }

    // Untuk coloum konsumsi_bbm dan hanya memiliki 1 (one to one) yang diambil riwayat bbm yang diambil dari database terbaru
    public function konsumsiBbm()
    {
        return $this->hasOne(RiwayatBbm::class)->latestOfMany('tanggal');
    }

    // Mengecek apakah kendaraan memiliki status 'tersedia'
    public function isTersedia()
    {
        return $this->status === 'tersedia';
    }
}
