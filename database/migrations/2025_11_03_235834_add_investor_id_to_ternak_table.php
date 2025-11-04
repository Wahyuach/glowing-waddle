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
        Schema::table('ternaks', function (Blueprint $table) {
            $table->foreignId('investor_id')
                  ->nullable()
                  ->after('tag_number') // Posisikan setelah tag_number
                  ->constrained('investors') // Sambungkan ke tabel 'investor'
                  ->onDelete('set null'); // Kalau investor dihapus, kolom ini jadi NULL
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ternaks', function (Blueprint $table) {
            // Hapus foreign key dulu
            $table->dropForeign(['investor_id']);
            // Hapus kolomnya
            $table->dropColumn('investor_id');
        });
    }
};
