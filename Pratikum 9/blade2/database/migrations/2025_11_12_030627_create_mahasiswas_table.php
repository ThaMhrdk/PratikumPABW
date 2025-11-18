<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('mahasiswas', function (Blueprint $table) {
            $table->id(); // seting id biarkan seperti ini karena otomatis AI
            $table->string('nama'); //tipe string membuat varchar(255)
            $table->string('nim')->unique(); // dibuat unik di DB
            $table->string('prodi');
            $table->timestamps(); // waktu saat pengisian
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mahasiswas'); //jika sudah ada dan akan ada
                                           // pembaruan maka akan ditimpa migration yang baru.
    }
};
