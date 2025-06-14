<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RiwayatBbm extends Model
{
    use HasFactory;

    // Deklarasi nama karena memakai nama table tanpa s
    protected $table = 'riwayat_bbm';

    protected $fillable = [
        'kendaraan_id',
        'dicatat_oleh',
        'tanggal',
        'jumlah',
        'biaya',
        'km_tercatat',
        'dibuat_oleh',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'biaya' => 'decimal:2',
    ];


    // Menghubungkan dengan table kendaraan
    public function kendaraan()
    {
        return $this->belongsTo(Kendaraan::class, 'kendaraan_id');
    }

    // Menghubungkan dengan user dengan kosep 
    // Berisi user_id yang user yang mencatat
    public function dicatatOleh()
    {
        return $this->belongsTo(User::class, 'dicatat_oleh');
    }

    // Menghubungkan dengan user dan hampir sama dengan yang atas
    public function dibuatOleh()
    {
        return $this->belongsTo(User::class, 'dibuat_oleh');
    }
}
