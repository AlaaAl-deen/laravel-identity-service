<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use App\Modules\Identity\Models\User;

class UserFactory extends Factory
{
    protected $model = User::class; // ✅ هذا السطر كان مفقود

    protected static ?string $password;

    public function definition(): array
    {
        return [
            'university_id' => fake()->unique()->numberBetween(10000000, 99999999),

            'email' => fake()->optional()->safeEmail(),

            'email_verified_at' => now(),

            'password' => Hash::make('password'),

            'must_change_password' => true,
        ];
    }

    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}