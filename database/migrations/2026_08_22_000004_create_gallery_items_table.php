<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('gallery_items', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('category')->default('events'); // civil, electrical, mechanical, computer, class2025, class2024, events, siwes
            $table->foreignId('department_id')->nullable()->constrained('departments')->nullOnDelete();
            $table->string('academic_set')->nullable(); // e.g. Class of 2025 (500L), Class of 2024 (Alumni)
            $table->string('student_role')->nullable();
            $table->string('student_id_number')->nullable();
            $table->enum('verification_status', ['verified', 'pending'])->default('verified');
            $table->string('image_path');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('gallery_items');
    }
};
