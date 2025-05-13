<?php

namespace Database\Factories;

use App\Models\ParticipantBatch;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ParticipantBatch>
 */
class ParticipantBatchFactory extends Factory
{
    protected $model = ParticipantBatch::class;

    public function definition(): array
    {
        // Generate random 9 uppercase letters
        $letters = strtoupper($this->faker->lexify('?????????'));

        // Generate 1 random digit (0-9)
        $digit = $this->faker->randomDigit();

        // Combine and shuffle to make 10 chars
        $raffle_code = strtoupper(str_shuffle($letters . $digit));

        return [
            'raffle_week_code' => $raffle_code,
            // ❌ created_at and updated_at are handled automatically by Laravel (timestamps)
            // so we don't need to manually set them here. Cleaner!
        ];
    }
}
