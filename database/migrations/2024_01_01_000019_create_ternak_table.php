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
        Schema::create('ternaks', function (Blueprint $table) {
            $table->string('tag_number')->primary();
            $table->string('tag_lama')->nullable();
            // --- RELASI (FOREIGN KEYS) ---
            $table->foreignId('species_id')->nullable()->constrained('species')->onDelete('cascade');
            $table->foreignId('kategori_id')->nullable()->constrained('kategori')->onDelete('cascade');
            $table->foreignId('sub_kategori_id')->nullable()->constrained('sub_kategori')->onDelete('cascade');
            $table->foreignId('tipe_domba_id')->nullable()->constrained('tipe_domba')->onDelete('cascade');
            $table->foreignId('jenis_domba_id')->nullable()->constrained('jenis_domba')->onDelete('cascade');
            
            $table->foreignId('kondisi_id')->nullable()->constrained('kondisi')->onDelete('cascade');
            $table->foreignId('status_id')->nullable()->constrained('status')->onDelete('cascade');
            $table->string('kandang_id')->nullable(); // Tipe data harus string
            $table->foreign('kandang_id')->references('kandang_id')->on('kandang')->onDelete('set null');

            // --- DATA UTAMA ---
            $table->enum('gender', ['Jantan', 'Betina']);
            $table->date('date_of_birth')->nullable();
            $table->date('date_of_entry')->nullable();
            $table->integer('usia_masuk_dalam_bulan')->nullable();
            $table->integer('umur_hari')->nullable();
            $table->integer('hari_di_peternakan')->nullable();
            $table->decimal('entry_weight', 8, 2)->nullable();
            $table->decimal('current_weight', 8, 2)->nullable();
            $table->date('last_weight_date')->nullable();
            $table->decimal('upweight', 8, 2)->nullable(); // <<< TAMBAHKAN BARIS INI
            $table->text('notes')->nullable();
            $table->string('photo_path')->nullable();

            // --- RELASI SILSILAH (SELF-REFERENCING) ---
            $table->string('dam_tag_number')->nullable();
            $table->string('sire_tag_number')->nullable();

            // Referensikan ke 'ternaks' (jamak)
            $table->foreign('dam_tag_number')->references('tag_number')->on('ternaks')->onDelete('set null');
            $table->foreign('sire_tag_number')->references('tag_number')->on('ternaks')->onDelete('set null');

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