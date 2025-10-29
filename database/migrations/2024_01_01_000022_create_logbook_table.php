<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Pastikan nama tabelnya 'ternaks' (jamak)
        Schema::create('logbooks', function (Blueprint $table) {
            $table->string('logbook')->primary();

            // --- RELASI (FOREIGN KEYS) ---
            $table->string('tag_number')->nullable();
            $table->foreign('tag_number')->references('tag_number')->on('ternaks')->onDelete('set null');

            // --- DATA UTAMA ---
            $table->date('tanggal_kejadian')->nullable();
            $table->string('tag_lama')->nullable();
            $table->string('kandang')->nullable();
            $table->string('kategori_kandang')->nullable();
            $table->string('jenis_ternak')->nullable();
            $table->string('sex')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ternaks'); // Pastikan nama tabelnya 'ternaks' (jamak)
    }
};
