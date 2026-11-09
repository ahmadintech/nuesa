<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('student_albums', function (Blueprint $table) {
            $table->id();
            $table->string('student_name');
            $table->string('student_id_number')->nullable();
            $table->foreignId('department_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('academic_class')->default('Class of 2025 (500L)');
            $table->string('position_role')->default('Engineering Student');
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('state_of_origin')->nullable();
            $table->string('joined_date')->nullable();
            $table->string('verification_status')->default('verified'); // verified, to_be_verified
            $table->string('filter_tag')->default('civil'); // civil, electrical, mechanical, computer, class2025, class2024, archives
            $table->string('image_path');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('student_albums');
    }
};
