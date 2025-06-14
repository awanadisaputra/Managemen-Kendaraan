<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RiwayatServis extends Model
{
    use HasFactory;

    // Deklarasi nama karena memakai nama table tanpa s
    protected $table = 'riwayat_servis';

    protected $fillable = [
        'kendaraan_id',
        'dibuat_oleh',
        'tanggal_service',
        'biaya',
        'catatan',
        'km_servis_berikutnya',
    ];

    protected $casts = [
        'tanggal_service' => 'date',
        'biaya' => 'decimal:2',
    ];


    // Menghubungkan dengan table kendaraan
    public function kendaraan()
    {
        return $this->belongsTo(Kendaraan::class, 'kendaraan_id');
    }

    // Konsepnya adalah Satu RiwayatServis dimiliki oleh satu user, yaitu user yang ID-nya sama dengan nilai pada kolom dibuat_oleh di tabel riwayat_servis
    // Jadi maksudnya coloum dibuat_oleh itu berisi id yang diperoleh dari table user
    public function dibuatOleh()
    {
        return $this->belongsTo(User::class, 'dibuat_oleh');
    }
}
