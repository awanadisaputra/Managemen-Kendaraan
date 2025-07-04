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
        Schema::create('riwayat_bbm', function (Blueprint $table) {
            $table->id();
            // Foreign Key
            $table->foreignId('kendaraan_id')->constrained('kendaraan')->onDelete('cascade');
            $table->foreignId('dicatat_oleh')->constrained('users')->onDelete('cascade');

            $table->date('tanggal');
            $table->float('jumlah');
            $table->decimal('biaya', 12, 2);
            $table->integer('km_tercatat');
            $table->foreignId('dibuat_oleh')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('riwayat_bbm');
    }
};
