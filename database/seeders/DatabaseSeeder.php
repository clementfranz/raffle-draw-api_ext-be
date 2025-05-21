<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\ParticipantBatch;
use App\Models\Participant;

use Illuminate\Support\Facades\Hash; // Make sure this is at the top

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Add a test user
        User::factory()->create([
            'first_name' => 'Kevin',
            'last_name' => 'Conrado',
            'picture' => null,
            'email' => 'kevin.conrado@kpc.com.ph',
            'password' => Hash::make('kopikoblanca'), // 🔐 Hashed password
        ]);

        // Create at least one participant batch
        ParticipantBatch::factory()->count(1)->create();

        // 🌱 Seed whitelist emails
        $this->call([
            WhitelistedEmailSeeder::class,
        ]);

        // 🔁 Conditionally create fake participants
        $initiateFakeParticipants = false;

        if ($initiateFakeParticipants) {
            $count100k = 100000;
            $multiplier100k = 1;
            $targetTotalParticipants = $count100k * $multiplier100k;
            $batchSize = 1000; // Due to base36 raffle code limitations
            $created = 0;

            while ($created < $targetTotalParticipants) {
                usleep(100000); // 100 ms
                $remaining = $targetTotalParticipants - $created;
                $count = min($batchSize, $remaining);

                Participant::factory()->count($count)->create();
                $created += $count;
            }
        }
    }
}
