<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fakultas', function (Blueprint $table) {
            $table->char('Idfakultas', 5)->primary();
            $table->string('nmfakultas', 50);
            $table->string('kdfakultas', 10)->nullable()->unique();
            // Laravel tidak butuh $table->timestamps(); karena tidak ada di SQL asli
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fakultas');
    }
};