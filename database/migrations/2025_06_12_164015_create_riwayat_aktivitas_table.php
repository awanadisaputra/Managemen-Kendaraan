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
        Schema::create('riwayat_aktivitas', function (Blueprint $table) {
            $table->id();
            // Foreign Key
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');

            $table->text('jenis_aktivitas');
            $table->text('deskripsi');
            $table->string('alamat_ip');
            $table->text('user_agent');
            $table->timestamp('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('riwayat_aktivitas');
    }
};
