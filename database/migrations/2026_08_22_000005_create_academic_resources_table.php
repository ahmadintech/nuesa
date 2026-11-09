<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('academic_resources', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('category')->default('Course Vault'); // Course Vault, Alumni Network, Video Tutorial, Governance Archive
            $table->string('course_code')->nullable();
            $table->foreignId('department_id')->nullable()->constrained('departments')->nullOnDelete();
            $table->string('file_path')->nullable();
            $table->string('external_link')->nullable();
            $table->string('file_size')->nullable();
            $table->unsignedInteger('downloads_count')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('academic_resources');
    }
};
