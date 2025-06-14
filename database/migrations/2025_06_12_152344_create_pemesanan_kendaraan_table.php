<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pemesanan_kendaraan', function (Blueprint $table) {
            $table->id();
            // Foreign Key
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('kendaraan_id')->constrained('kendaraan')->onDelete('cascade');
            $table->foreignId('supir_id')->constrained('users')->onDelete('cascade');

            $table->dateTime('tanggal_mulai');
            $table->dateTime('tanggal_selesai')->nullable();
            $table->text('tujuan_penggunaan');
            $table->text('tujuan_perjalanan');
            $table->enum('status', ['menunggu_persetujuan_supervisor', 'menunggu_persetujuan_manager', 'disetujui', 'ditolak', 'selesai']);
            $table->float('bbm_digunakan')->nullable();
            $table->integer('km_awal')->nullable();
            $table->integer('km_akhir')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemesanan_kendaraan');
    }
};
