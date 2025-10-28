<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('teleponkons', function (Blueprint $table) {
            $table->string('telpkons', 13);
            $table->char('Idkonselor', 5);

            $table->foreign('Idkonselor')->references('Idkonselor')->on('konselor');
            $table->primary(['telpkons', 'Idkonselor']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('teleponkons');
    }
};