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
        Schema::create('kendaraan', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_plat')->unique();
            $table->enum('jenis_kendaraan', ['angkutan-orang', 'angkutan_barang']);
            $table->enum('status_kepemilikan', ['milik_perusahaan', 'sewaan']);
            $table->float('konsumsi_bbm');
            $table->date('terakhir_service');
            $table->integer('km_service_berikutnya');
            $table->integer('km_terakhir');
            $table->enum('status', ['tersedia', 'diservice', 'dipesan']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kendaraan');
    }
};
