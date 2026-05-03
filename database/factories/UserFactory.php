<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition(): array
    {
        return [
            'id' => (string) Str::uuid(),
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => Hash::make('Password123!'),
            'remember_token' => Str::random(10),
            'phone' => $this->faker->phoneNumber(),
            'gender' => $this->faker->randomElement(['Male', 'Female']),
            'dob' => $this->faker->date(),
            'image' => 'users/default.jpg',
        ];
    }

    public function student(): static
    {
        return $this->state(fn () => [
            'first_name' => $this->faker->firstName(),
            'last_name' => 'Student',
        ]);
    }

    public function disciples(): static
    {
        return $this->state(fn () => [
            'first_name' => $this->faker->firstName(),
            'last_name' => 'Disciple',
        ]);
    }

    public function admin(): static
    {
        return $this->state(fn () => [
            'first_name' => 'System',
            'last_name' => 'Admin',
        ]);
    }
}