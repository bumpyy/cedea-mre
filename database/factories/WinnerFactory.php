<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Winner>
 */
class WinnerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'submission_id' => \App\Models\Submission::factory(),
            'prize' => fake()->randomElement(['Car', 'Bike', 'TV', 'Laptop', 'Phone']),
            'status' => 'pending',
            'note' => null,
        ];
    }

    /**
     * Create a new factory instance for the model with the given status.
     */
    public function status(string $status): static
    {
        return $this->state([
            'status' => fake()->randomElement(['pending', 'contacted', 'claimed', 'unclaimed']),
        ]);
    }
}
