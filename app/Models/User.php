<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens, LogsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'nama',
        'email',
        'password',
        'peran',
        'atasan_id'
    ];

    // Foreng key untuk atasan memiliki banyak bawahan(supir) 
    public function bawahan()
    {
        return $this->hasMany(User::class, 'atasan_id');
    }

    // Foreng key untuk bahwa bawahan memiliki 1 atasan
    public function atasan()
    {
        return $this->belongsTo(User::class, 'atasan_id');
    }

    // Foreing key untuk menghubungkan table pemesanan dengan user
    public function pemesanan()
    {
        return $this->hasMany(PemesananKendaraan::class, 'user_id');
    }

    // foreign key untuk menghubungkan peminjaman dan hanya supir yang bisa meminjam
    public function peminjamanKendaraan()
    {
        return $this->hasMany(PemesananKendaraan::class, 'supir_id');
    }

    // Foreign key untuk user memberikan persetujuan
    public function persetujuan()
    {
        return $this->hasMany(PersetujuanPemesanan::class, 'persetujuan_id');
    }

    // Mengecek apakah user admin
    public function isAdmin()
    {
        return $this->peran === 'admin';
    }

    // Mengecek apakah user supervisor
    public function isSupervisor()
    {
        return $this->peran === 'supervisor';
    }

    // Mengecek apakah user manager
    public function isManager()
    {
        return $this->peran === 'manager';
    }

    // Mengecek apakah user supir
    public function isSupir()
    {
        return $this->peran === 'supir';
    }

    // Method untuk method abstrack
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['nama', 'email', 'peran'])
            ->useLogName('user')
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
