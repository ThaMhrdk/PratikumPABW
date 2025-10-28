<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jadwalkons', function (Blueprint $table) {
            $table->char('Idjadwal_kons', 5)->primary();
            $table->char('Idjadwal', 5);
            $table->char('Idkonselor', 5);

            $table->foreign('Idjadwal')->references('Idjadwal')->on('jadwal');
            $table->foreign('Idkonselor')->references('Idkonselor')->on('konselor');

            $table->unique(['Idjadwal', 'Idkonselor']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jadwalkons');
    }
};