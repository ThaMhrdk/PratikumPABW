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
        Schema::create('psikologs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('str_number')->unique()->comment('Nomor STR Psikolog');
            $table->string('specialization')->nullable();
            $table->text('bio')->nullable();
            $table->text('education')->nullable();
            $table->text('certifications')->nullable();
            $table->integer('experience_years')->default(0);
            $table->decimal('consultation_fee', 12, 2)->default(0);
            $table->enum('verification_status', ['pending', 'verified', 'rejected'])->default('pending');
            $table->timestamp('verified_at')->nullable();
            $table->string('str_document')->nullable();
            $table->string('certificate_document')->nullable();
            $table->decimal('average_rating', 3, 2)->default(0);
            $table->integer('total_reviews')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('psikologs');
    }
};
