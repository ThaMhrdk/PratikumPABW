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
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->string('title');
            $table->string('report_type')->comment('monthly, quarterly, annual');
            $table->date('period_start');
            $table->date('period_end');
            $table->integer('total_consultations')->default(0);
            $table->integer('total_users')->default(0);
            $table->integer('total_psikologs')->default(0);
            $table->json('statistics')->nullable();
            $table->text('summary')->nullable();
            $table->enum('status', ['draft', 'sent'])->default('draft');
            $table->timestamp('sent_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
