<?php

namespace Database\Factories;

use App\Models\Certificate;
use App\Models\Course;
use App\Models\Topic;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CertificateFactory extends Factory
{
    protected $model = Certificate::class;

    public function definition(): array
    {
        return [
            'id' => (string) Str::uuid(),
            'certificate_number' => 'CERT-' . strtoupper(Str::random(10)),
            'user_id' => User::factory(),
            'type' => 'topic',
            'course_id' => Course::factory(),
            'topic_id' => Topic::factory(),
            'file_path' => null,
            'issued_at' => null,
            'status' => 'draft',
        ];
    }
}