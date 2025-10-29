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
        Schema::create('weight_histories', function (Blueprint $table) {
            $table->id();
            $table->string('ternak_tag_number');
            $table->decimal('weight', 8, 2);
            $table->date('measurement_date');
            $table->timestamps();

            // Pastikan merujuk ke 'ternaks' (jamak)
            $table->foreign('ternak_tag_number')->references('tag_number')->on('ternaks')->onDelete('cascade'); // <<< PENTING: UBAH INI
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('weight_histories');
    }
};