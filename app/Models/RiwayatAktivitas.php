<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RiwayatAktivitas extends Model
{
    use HasFactory;

    // Deklarasi nama karena memakai nama table tanpa s
    protected $table = 'riwayat_aktivitas';

    // Mematikan  timestamps
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'jenis_aktivitas',
        'deskripsi',
        'alamat_ip',
        'user_agent',
    ];

    // Menghubungkan dengan table user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Untuk mengambil data aktivitas yang nanti akan diambil
    // Contohnya adalah RiwayatAktivitas::ofType('login')->get();
    // Dimana ini code untuk meminta semua data pada aktivitas login
    public function scopeOfType($query, $type)
    {
        return $query->where('jenis_aktivitas', $type);
    }

    // Ini juga sama tapi yang diambil adalah data user
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }
}
