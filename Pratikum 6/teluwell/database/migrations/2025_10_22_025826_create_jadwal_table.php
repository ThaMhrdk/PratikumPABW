<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jadwal', function (Blueprint $table) {
            $table->char('Idjadwal', 5)->primary();
            $table->string('harij', 10);
            $table->time('jammulaij')->nullable();
            $table->time('jamselesaij')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jadwal');
    }
};