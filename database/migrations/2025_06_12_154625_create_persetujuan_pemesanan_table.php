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
        Schema::create('persetujuan_pemesanan', function (Blueprint $table) {
            $table->id();
            // Foreign Key
            $table->foreignId('pemesanan_id')->constrained('pemesanan_kendaraan')->onDelete('cascade');
            $table->foreignId('persetujuan_id')->constrained('users')->onDelete('cascade');

            $table->integer('tingkat_persetujuan');
            $table->enum('status', ['menunggu', 'disetujui', 'ditolak']);
            $table->text('komentar')->nullable();
            $table->dateTime('tanggal_persetujuan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('persetujuan_pemesanan');
    }
};
