<?php

namespace Database\Seeders\Assessment;

use App\Models\Assessment;
use App\Models\Topic;
use Illuminate\Database\Seeder;

class AssessmentSeeder extends Seeder
{
    public function run(): void
    {
        foreach (Topic::all() as $topic) {
            Assessment::factory()->create([
                'topic_id' => $topic->id,
                'title' => $topic->name . ' Post Test',
            ]);
        }
    }
}