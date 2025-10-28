<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('teleponmhs', function (Blueprint $table) {
            $table->string('telpmhs', 13);
            $table->char('nim', 12);

            $table->foreign('nim')->references('nim')->on('mahasiswa');
            $table->primary(['telpmhs', 'nim']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('teleponmhs');
    }
};