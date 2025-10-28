<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('feedback', function (Blueprint $table) {
            $table->char('Idfeed', 5)->primary();
            $table->string('hasilfeed', 255)->nullable();
            $table->date('tglfeed')->nullable();
            $table->char('Kodekslg', 5)->unique();

            $table->foreign('Kodekslg')->references('Kodekslg')->on('konseling');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('feedback');
    }
};