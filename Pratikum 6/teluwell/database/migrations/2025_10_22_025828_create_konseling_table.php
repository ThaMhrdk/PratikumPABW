<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('konseling', function (Blueprint $table) {
            $table->char('Kodekslg', 5)->primary();
            $table->string('ruangan', 20)->nullable();
            $table->date('tglkslg')->nullable();
            $table->time('jammulai')->nullable();
            $table->time('jamselesai')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('konseling');
    }
};