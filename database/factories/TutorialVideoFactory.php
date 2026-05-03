<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class TutorialVideoFactory extends Factory
{
    public function definition(): array
    {
        return [
            'id' => (string) Str::uuid(),
            'video_link' => $this->faker->url(),
            'video_name' => $this->faker->sentence(3),
        ];
    }
}