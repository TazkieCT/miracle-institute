<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('topics', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->foreignUuid('course_id')
                ->constrained('courses')
                ->cascadeOnDelete();

            $table->foreignUuid('teacher_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->string('name');
            $table->string('slug');
            $table->string('category')->nullable();
            $table->longText('description')->nullable();
            $table->string('poster')->nullable();

            $table->string('visibility')->default('public'); // public, private, role_based, etc.
            $table->string('status')->default('draft');      // draft, published, archived
            $table->unsignedInteger('sort_order')->default(0);

            $table->timestamps();

            $table->unique(['course_id', 'slug']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('topics');
    }
};