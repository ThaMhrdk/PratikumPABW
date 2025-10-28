<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('booking', function (Blueprint $table) {
            $table->char('Idbooking', 5)->primary();
            $table->date('tglbooking')->nullable();
            $table->time('jammulaib')->nullable();
            $table->time('jamselesaib')->nullable();
            $table->string('metode', 10)->nullable();
            $table->char('nim', 12);
            $table->char('Idjadwal', 5);
            $table->char('Kodekslg', 5)->unique();

            $table->enum('status', ['ACTIVE','COMPLETED','CANCELLED'])->default('ACTIVE');
            $table->timestamp('cancelled_at')->nullable();
            $table->timestamp('completed_at')->nullable();

            $table->foreign('nim')->references('nim')->on('mahasiswa');
            $table->foreign('Idjadwal')->references('Idjadwal')->on('jadwal');
            $table->foreign('Kodekslg')->references('Kodekslg')->on('konseling');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('booking');
    }
};