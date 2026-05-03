<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\UserDocument;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserDocumentFactory extends Factory
{
    protected $model = UserDocument::class;

    public function definition(): array
    {
        return [
            'id' => (string) Str::uuid(),
            'user_id' => User::factory(),
            'name' => $this->faker->words(3, true),
            'image' => 'documents/default.jpg',
            'type' => 'avatar',
            'status' => 'active',
        ];
    }
}