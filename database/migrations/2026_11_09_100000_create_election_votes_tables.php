<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // One row per voter: guarantees a ballot can be submitted only once.
        Schema::create('election_ballots', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained()->cascadeOnDelete();
            $table->timestamp('submitted_at');
            $table->timestamps();
        });

        // One row per office the voter chose a candidate for.
        Schema::create('election_votes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('election_candidate_id')->constrained('election_candidates')->cascadeOnDelete();
            $table->string('office');
            $table->timestamps();

            $table->unique(['user_id', 'office']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('election_votes');
        Schema::dropIfExists('election_ballots');
    }
};
