<?php

namespace Database\Factories;

use App\Models\StudyProgram;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class StudyProgramFactory extends Factory
{
    protected $model = StudyProgram::class;

    public function definition(): array
    {
        $title = $this->faker->unique()->words(2, true);

        return [
            'id' => (string) Str::uuid(),
            'title' => $title,
            'slug' => Str::slug($title),
            'description' => $this->faker->sentence(),
            'status' => 'active',
        ];
    }
}