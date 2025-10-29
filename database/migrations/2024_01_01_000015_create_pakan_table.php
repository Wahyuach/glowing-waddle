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
            Schema::create('pakan', function (Blueprint $table) {
                $table->id(); // ID unik untuk setiap jenis pakan
                $table->string('name'); // Nama pakan, contoh: "Konsentrat Sapi Perah"
                $table->foreignId('tipe_pakan_id')->nullable()->constrained('tipe_pakan')->onDelete('set null'); 
                $table->decimal('stock', 10, 2)->default(0); // Jumlah stok pakan
                $table->string('unit')->default('kg'); // Satuan stok dalam kg, diatur default
                $table->decimal('price_per_unit', 15, 2)->nullable(); // Harga per kilo (opsional)
                $table->text('description')->nullable(); // Deskripsi atau catatan tambahan (opsional)
                $table->timestamps(); // Kolom created_at dan updated_at
            });
        }

        /**
         * Reverse the migrations.
         */
        public function down(): void
        {
            Schema::dropIfExists('pakan');

        }
    };
