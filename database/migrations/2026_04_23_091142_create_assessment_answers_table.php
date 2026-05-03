<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('assessment_answers', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->foreignUuid('attempt_id')
                ->constrained('assessment_attempts')
                ->cascadeOnDelete();

            $table->foreignUuid('question_id')
                ->constrained('questions')
                ->cascadeOnDelete();

            $table->foreignUuid('question_option_id')
                ->nullable()
                ->constrained('question_options')
                ->nullOnDelete();

            $table->text('answer_text')->nullable();
            $table->boolean('is_correct')->default(false);

            $table->timestamps();

            $table->unique(['attempt_id', 'question_id']);
            $table->index(['attempt_id', 'question_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('assessment_answers');
    }
};