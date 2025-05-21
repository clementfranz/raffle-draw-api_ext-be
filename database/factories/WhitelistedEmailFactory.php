<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\WhitelistedEmail>
 */
class WhitelistedEmailFactory extends Factory
{
    protected $model = \App\Models\WhitelistedEmail::class;

    public function definition(): array
    {
        return [
            'email' => $this->faker->unique()->safeEmail(),
        ];
    }
}
