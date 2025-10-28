<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('prodi', function (Blueprint $table) {
            $table->char('Idprodi', 5)->primary();
            $table->string('nmprodi', 50)->unique();
            $table->string('jenjang', 10)->nullable();
            $table->string('kdprodi', 10)->unique();
            $table->char('Idfakultas', 5);

            // Membuat Foreign Key
            $table->foreign('Idfakultas')->references('Idfakultas')->on('fakultas');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('prodi');
    }
};