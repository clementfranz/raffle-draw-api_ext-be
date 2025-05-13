<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use \App\Models\ParticipantBatch;
use \App\Models\Participant;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        ParticipantBatch::factory()->count(5)->create();

        Participant::factory()->count(10)->create();
        Participant::factory()->count(50000)->create();
        Participant::factory()->count(50000)->create();
        Participant::factory()->count(50000)->create();
        Participant::factory()->count(50000)->create();
        Participant::factory()->count(50000)->create();
        Participant::factory()->count(50000)->create();
    }
}
