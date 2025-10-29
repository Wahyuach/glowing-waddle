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
        Schema::create('abk', function (Blueprint $table) {
            $table->id(); // ID unik untuk setiap abk
            $table->string('name'); // Nama lengkap abk
            $table->string('phone_number')->nullable(); // Nomor telepon (opsional)
            $table->text('address')->nullable(); // Alamat (opsional)
            // Kolom untuk menyimpan path foto. Opsional karena data ABK bisa dibuat dulu baru foto di-upload.
            $table->string('photo_path')->nullable(); 
            $table->timestamps(); // Kolom created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(table: 'abk');
    }
};
