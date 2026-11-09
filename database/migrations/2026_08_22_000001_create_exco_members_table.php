<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('exco_members', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('office_position'); // e.g. President, Vice President, Secretary General
            $table->foreignId('department_id')->nullable()->constrained('departments')->nullOnDelete();
            $table->string('academic_session')->default('2025/2026');
            $table->string('twitter_handle')->nullable();
            $table->string('linkedin_url')->nullable();
            $table->string('photo_path')->nullable();
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('exco_members');
    }
};
