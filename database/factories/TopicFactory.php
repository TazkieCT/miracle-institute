<?php

namespace Database\Factories;

use App\Models\Course;
use App\Models\Topic;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class TopicFactory extends Factory
{
    protected $model = Topic::class;

    public function definition(): array
    {
        $name = $this->faker->unique()->words(2, true);

        return [
            'id' => (string) Str::uuid(),
            'course_id' => Course::factory(),
            'teacher_id' => User::factory(),
            'name' => $name,
            'slug' => Str::slug($name),
            'category' => 'General',
            'description' => $this->faker->sentence(),
            'poster' => 'topics/default.jpg',
            'visibility' => 'public',
            'status' => 'published',
            'sort_order' => 1,
        ];
    }
}