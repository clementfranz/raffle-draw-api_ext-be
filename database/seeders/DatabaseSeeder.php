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

        $count100k = 100000;
        $multiplier100k = 1;
        $targetTotalParticipants = $count100k * $multiplier100k;
        $batchSize = 1000; // limited maximum number per generation due to base36 limitations of raffle code
        $created = 0;

        while ($created < $targetTotalParticipants) {
            usleep(100000); // 100,000 microseconds = 100 ms
            $remaining = $targetTotalParticipants - $created;
            $count = min($batchSize, $remaining);

            Participant::factory()->count($count)->create();
            $created += $count;

            // Delay for 100 milliseconds
        }


    }
}
