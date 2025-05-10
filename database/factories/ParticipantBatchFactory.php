<?php

namespace Database\Factories;

use App\Models\ParticipantBatch;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ParticipantBatch>
 */
class ParticipantBatchFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Generate 9 random letters
        $letters = strtoupper($this->faker->lexify('?????????'));

        // Generate 1 random digit
        $digit = $this->faker->randomDigit();

        // Append the digit to the letters and shuffle
        $raffle_code = $letters . $digit;

        // Shuffle and make sure it is 10 characters
        return [
            'raffle_week_code' => strtoupper(str_shuffle($raffle_code)),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
