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
        Schema::create('logbooks', function (Blueprint $table) {
            $table->id(); // (Kolom 'A', Nomor Urut)
            
            // --- Kolom B sampai J (Data Umum) ---
            $table->dateTime('tanggal_kejadian'); // (Kolom B)
            
            // Ternak mana yang kejadian? (TAGGING)
            $table->string('ternak_tag_number'); // (Kolom C)
            $table->foreign('ternak_tag_number')
                  ->references('tag_number')
                  ->on('ternaks')
                  ->onDelete('cascade');

            // Kandang (D) 
            $table->string('kandang_id', 255)->nullable(); 
            $table->foreign('kandang_id')
                  ->references('kandang_id')
                  ->on('kandang')
                  ->onDelete('set null');

            $table->string('kategori_kandang')->nullable(); // (Kolom E)
            $table->string('jenis_ternak')->nullable(); // (Kolom F)
            $table->string('sex')->nullable(); // (Kolom G)
            $table->string('kejadian'); // (Kolom H)
            $table->string('abk')->nullable(); // (Kolom I)
            $table->string('tag_baru')->nullable(); // (Kolom J)
            
            // --- Kolom K sampai Z (Khusus Kelahiran) ---
            
            $table->string('induk_betina')->nullable(); // (Kolom K)
            $table->string('jenis_betina')->nullable(); // (Kolom L)
            $table->decimal('bb_betina', 8, 2)->nullable(); // (Kolom M)
            $table->integer('umur_betina')->nullable(); // (Kolom N)
            $table->string('foto_betina')->nullable(); // (Kolom O)
            
            $table->string('induk_jantan')->nullable(); // (Kolom P)
            $table->string('jenis_jantan')->nullable(); // (Kolom Q)
            $table->string('foto_jantan')->nullable(); // (Kolom R)
            
            $table->string('tipe_kelahiran')->nullable(); // (Kolom S)
            $table->integer('qty_anak')->nullable(); // (Kolom T)
            $table->string('nomor_cempe')->nullable(); // (Kolom U)
            $table->string('anak')->nullable(); // (Kolom V)
            $table->string('sex_anak')->nullable(); // (Kolom W)
            $table->decimal('bb_lahir', 8, 2)->nullable(); // (Kolom X)
            $table->string('foto_anak')->nullable(); // (Kolom Y)
            $table->string('jenis_anak')->nullable(); // (Kolom Z)

            // --- Kolom AA sampai AG (Penanganan dan Semen) ---
            $table->text('keterangan')->nullable(); // (Kolom AA)
            $table->string('kandang_baru')->nullable(); // (Kolom AB)
            $table->string('kategori_kandang_baru')->nullable(); // (Kolom AC)
            $table->string('penanganan')->nullable(); // (Kolom AD)
            $table->date('tanggal_sembuh')->nullable(); // (Kolom AE)
            $table->string('nomor_semen')->nullable(); // (Kolom AF)
            $table->string('jenis_semen')->nullable(); // (Kolom AG)

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('logbooks');
    }
};
