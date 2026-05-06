<?php

namespace Database\Factories;

use App\Models\VideoSession;
use App\Models\Topic;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class VideoSessionFactory extends Factory
{
    protected $model = VideoSession::class;

    public function definition(): array
    {
        $startAt = $this->faker->dateTimeBetween('+1 days', '+7 days');
        $endAt = (clone $startAt)->modify('+1 hour');

        return [
            'id' => (string) Str::uuid(),
            'topic_id' => Topic::factory(),
            'title' => 'Session ' . $this->faker->words(2, true),
            'zoom_link' => 'https://zoom.us/j/' . $this->faker->numerify('##########'),
            'record_link' => null,
            'start_at' => $startAt,
            'end_at' => $endAt,
            'reminder_sent_at' => null,
            'status' => 'scheduled',
        ];
    }
}