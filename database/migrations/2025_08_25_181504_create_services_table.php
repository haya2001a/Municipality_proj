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
         Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->foreignId('department_id')->constrained('departments')->onDelete('cascade');
            $table->text('description')->nullable();
            $table->decimal('price', 10,2)->default(0);
            $table->integer('processing_time_min')->nullable();
            $table->integer('processing_time_max')->nullable();
            $table->json('required_documents')->nullable();
            $table->text('terms_conditions')->nullable();
            $table->text('notes')->nullable();
            $table->enum('status', ['فعّالة','غير فعّالة'])->default('فعّالة');
            $table->enum('priority', ['غير عاجل','متوسط','عاجل']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
