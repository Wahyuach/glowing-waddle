<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kavling', function (Blueprint $table) {
            $table->string('no_kavling')->primary(); // Nomor kavling sebagai ID unik
            $table->integer('kapasitas')->default(0);
            $table->string('status_kepemilikan')->default('Tersedia');
            $table->foreignId('investor_id')->nullable()->constrained('investors')->onDelete('set null');
            $table->foreignId('abk_id')->nullable()->constrained('abk')->onDelete('set null');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kavling');
    }
};
