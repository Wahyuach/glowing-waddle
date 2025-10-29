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
        Schema::create('kandang', function (Blueprint $table) {
            $table->string('kandang_id')->primary(); // Primary Key sekarang adalah string
            $table->string('kavling_id');
            $table->foreign('kavling_id')->references('no_kavling')->on('kavling')->onDelete('cascade');
            $table->foreignId('tipe_kandang_id')->nullable()->constrained('tipe_kandang')->onDelete('set null');
            $table->integer('kapasitas')->default(0);
            $table->integer('current_population')->default(0);
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kandang');
    }
};
