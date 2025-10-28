<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Submission>
 */
class SubmissionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'receipt_number' => fake()->unique()->numerify('INV-########'),
            'user_id' => \App\Models\User::factory(),
            'status' => 'pending',
            'note' => null,
            'admin_id' => null,
            'uuid' => Str::uuid(),
        ];
    }

    /**
     * Create a new factory instance for the model with the accepted status.
     */
    public function accepted(): static
    {
        return $this->state([
            'status' => 'accepted',
            'admin_id' => \App\Models\Admin::factory(),
        ]);
    }

    /**
     * Create a new factory instance for the model with the rejected status.
     */
    public function rejected(): static
    {
        return $this->state([
            'status' => 'rejected',
            'admin_id' => \App\Models\Admin::factory(),
        ]);
    }
}
