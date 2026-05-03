<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('assessments', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->foreignUuid('topic_id')
                ->constrained('topics')
                ->cascadeOnDelete();

            $table->string('title');
            $table->unsignedTinyInteger('passing_grade')->default(70);
            $table->boolean('randomize_questions')->default(false);
            $table->unsignedSmallInteger('question_limit')->nullable();
            $table->unsignedSmallInteger('time_limit_minutes')->nullable();
            $table->enum('status', ['draft', 'active', 'archived'])->default('active');

            $table->timestamps();

            $table->index('topic_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('assessments');
    }
};