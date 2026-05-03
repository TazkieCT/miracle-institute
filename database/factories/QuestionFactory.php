<?php

namespace Database\Factories;

use App\Models\Question;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class QuestionFactory extends Factory
{
    protected $model = Question::class;

    public function definition(): array
    {
        return [
            'id' => (string) Str::uuid(),

            'assessment_id' => null,

            'question_type' => 'mcq',

            'question' => $this->faker->sentence(),

            'correct_text_answer' => null,

            'explanation' => $this->faker->sentence(),

            'sort_order' => 1,
        ];
    }

    public function text()
    {
        return $this->state(fn () => [
            'question_type' => 'text',
            'correct_text_answer' => fake()->word(),
        ]);
    }

    public function mcq()
    {
        return $this->state(fn () => [
            'question_type' => 'mcq',
            'correct_text_answer' => null,
        ]);
    }
}