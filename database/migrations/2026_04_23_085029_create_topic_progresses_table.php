<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('topic_progresses', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->foreignUuid('course_enrollment_id')
                ->constrained('course_enrollments')
                ->cascadeOnDelete();

            $table->foreignUuid('topic_id')
                ->constrained('topics')
                ->cascadeOnDelete();

            $table->string('status')->default('not_started'); // not_started, in_progress, completed
            $table->timestamp('started_at')->nullable();
            $table->timestamp('completed_at')->nullable();

            $table->timestamps();

            $table->unique(['course_enrollment_id', 'topic_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('topic_progresses');
    }
};