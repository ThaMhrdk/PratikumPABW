<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('konselor', function (Blueprint $table) {
            $table->char('Idkonselor', 5)->primary();
            $table->string('jdwlkonf', 100)->nullable();
            $table->string('emailkons', 25)->nullable()->unique();
            $table->string('nmkonselor', 100);
            $table->string('spesialisasi', 50)->nullable();
            $table->string('password');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('konselor');
    }
};