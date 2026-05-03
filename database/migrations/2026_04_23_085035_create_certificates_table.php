<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('certificates', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->string('certificate_number')->unique();

            $table->foreignUuid('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->string('type'); // topic, course

            $table->foreignUuid('course_id')
                ->nullable()
                ->constrained('courses')
                ->nullOnDelete();

            $table->foreignUuid('topic_id')
                ->nullable()
                ->constrained('topics')
                ->nullOnDelete();

            $table->string('file_path')->nullable();
            $table->dateTime('issued_at')->nullable();
            $table->string('status')->default('draft'); // draft, issued, revoked

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('certificates');
    }
};