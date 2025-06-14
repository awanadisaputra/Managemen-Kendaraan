<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PersetujuanPemesanan extends Model
{
    use HasFactory;

    // Deklarasi nama karena memakai nama table tanpa s
    protected $table = 'persetujuan_pemesanan';

    protected $fillable = [
        'pemesanan_id',
        'persetujuan_id',
        'tingkat_persetujuan',
        'status',
        'komentar',
        'tanggal_persetujuan',
    ];

    protected $casts = [
        'tanggal_persetujuan' => 'datetime',
    ];

    // Menghubunkan dengan table pemesanan
    public function pemesanan()
    {
        return $this->belongsTo(PemesananKendaraan::class, 'pemesanan_id');
    }

    // Menghubungkan persetujuan dengan user. one to many (Setiap baris data di tabel persetujuan_pemesanan berelasi dengan satu user (sebagai persetujuan) berdasarkan kolom persetujuan_id.)
    public function persetujuan()
    {
        return $this->belongsTo(User::class, 'persetujuan_id');
    }

    // Mengecek apakah persetujuan masih menunggu
    public function isMenunggu()
    {
        return $this->status === 'menunggu';
    }

    // Mengecek apakah persetujuan disetujui
    public function isDisetujui()
    {
        return $this->status === 'disetujui';
    }

    // Menunggu apakah persetujuan ditolak
    public function isDitolak()
    {
        return $this->status === 'ditolak';
    }

}
