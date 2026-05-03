<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('assessment_attempts', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->foreignUuid('assessment_id')
                ->constrained('assessments')
                ->cascadeOnDelete();

            $table->foreignUuid('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->unsignedSmallInteger('attempt_no')->default(1);
            $table->unsignedSmallInteger('score')->nullable();
            $table->unsignedInteger('duration_seconds')->nullable();
            $table->boolean('passed')->default(false);

            $table->timestamp('started_at')->nullable();
            $table->timestamp('submitted_at')->nullable();

            $table->timestamps();

            $table->unique(['assessment_id', 'user_id', 'attempt_no']);
            $table->index(['assessment_id', 'user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('assessment_attempts');
    }
};