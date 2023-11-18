<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Aspirant>
 */
class AspirantFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name,
            'source' => fake()->word,
            'owner' => User::factory(),
            'created_by' => User::factory(),
            'created_at' => fake()->dateTime,
        ];
    }
}
