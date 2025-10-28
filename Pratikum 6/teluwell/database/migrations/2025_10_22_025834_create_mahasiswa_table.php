<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mahasiswa', function (Blueprint $table) {
            $table->char('nim', 12)->primary();
            $table->string('email', 255)->nullable()->unique();
            $table->string('nmdepan', 25);
            $table->string('nmbelakang', 25)->nullable();
            $table->string('jk', 10)->nullable();
            $table->char('Idprodi', 5);
            $table->string('password');

            $table->foreign('Idprodi')->references('Idprodi')->on('prodi');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mahasiswa');
    }
};