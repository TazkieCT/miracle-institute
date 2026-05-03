<?php

namespace Database\Factories;

use App\Models\QuestionOption;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class QuestionOptionFactory extends Factory
{
    protected $model = QuestionOption::class;

    public function definition(): array
    {
        return [
            'id' => (string) Str::uuid(),

            'question_id' => null,

            'option_text' => $this->faker->sentence(),

            'is_correct' => false,

            'sort_order' => 1,
        ];
    }
}