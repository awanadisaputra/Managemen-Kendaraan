<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PemesananKendaraan extends Model
{
    use HasFactory;

    protected $table = 'pemesanan_kendaraan';

    protected $fillable = [
        'user_id',
        'kendaraan_id',
        'supir_id',
        'tanggal_mulai',
        'tanggal_selesai',
        'tujuan_penggunaan',
        'tujuan_perjalanan',
        'status',
        'bbm_digunakan',
        'km_awal',
        'km_akhir',
    ];

    protected $casts = [
        'tanggal_mulai' => 'datetime',
        'tanggal_selesai' => 'datetime',
    ];

    // Relasi ke pemesan (user)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke kendaraan
    public function kendaraan()
    {
        return $this->belongsTo(Kendaraan::class, 'kendaraan_id');
    }

    // Relasi ke supir
    public function supir()
    {
        return $this->belongsTo(User::class, 'supir_id');
    }

    // Relasi ke persetujuan pemesanan
    public function persetujuan()
    {
        return $this->hasMany(PersetujuanPemesanan::class, 'pemesanan_id');
    }

    // Cek status
    public function isMenunggu()
    {
        return in_array($this->status, [
            'menunggu_persetujuan_supervisor',
            'menunggu_persetujuan_manager'
        ]);
    }

    public function isDisetujui()
    {
        return $this->status === 'disetujui';
    }

    public function isDitolak()
    {
        return $this->status === 'ditolak';
    }

    public function isSelesai()
    {
        return $this->status === 'selesai';
    }
}
