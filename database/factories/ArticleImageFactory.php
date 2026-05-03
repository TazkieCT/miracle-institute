<?php

namespace Database\Factories;

use App\Models\Article;
use App\Models\ArticleImage;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ArticleImageFactory extends Factory
{
    protected $model = ArticleImage::class;

    public function definition(): array
    {
        return [
            'id' => (string) Str::uuid(),
            'article_id' => Article::factory(),
            'image' => 'articles/default.jpg',
        ];
    }
}