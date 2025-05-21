<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\WhitelistedEmail;

class WhitelistedEmailSeeder extends Seeder
{
    public function run(): void
    {
        $emails = [
            [
                'email' => 'delossantos.clementfrancis@gmail.com',
                'first_name' => 'Clement Francis',
                'last_name' => 'Delos Santos'
            ],
            [
                'email' => 'admin@kpc.com.ph',
                'first_name' => 'KPC Admin',
                'last_name' => 'Blanca'
            ],
            [
                'email' => 'maintenance@clementfranz.com',
                'first_name' => 'Franz',
                'last_name' => 'Maintenance'
            ],
        ];

        foreach ($emails as $entry) {
            WhitelistedEmail::firstOrCreate(
                ['email' => $entry['email']],
                [
                    'first_name' => $entry['first_name'],
                    'last_name' => $entry['last_name']
                ]
            );
        }
    }
}
