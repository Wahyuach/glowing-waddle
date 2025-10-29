// database/migrations/xxxx_xx_xx_xxxxxx_create_jenis_domba_table.php
<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kejadian', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('kejadian');
    }
};