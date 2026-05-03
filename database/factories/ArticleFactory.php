<?php

namespace Database\Factories;

use App\Models\Article;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ArticleFactory extends Factory
{
    protected $model = Article::class;

    public function definition(): array
    {
        $title = $this->faker->sentence(4);

        return [
            'id' => (string) Str::uuid(),
            'title' => $title,
            'author' => $this->faker->name(),
            'content' => $this->faker->paragraphs(3, true),
            'status' => 'draft',
            'clicked' => 0,
        ];
    }
}