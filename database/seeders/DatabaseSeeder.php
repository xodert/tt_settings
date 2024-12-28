<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            ConfirmationTypeSeeder::class,
            SourceSeeder::class,

            DefaultSettingsSeeder::class,
        ]);

        // User::factory(10)->create();

        if (app()->isLocal()) {
            User::factory()->create([
                'name' => 'Test User',
                'email' => 'test@test.com',
                'password' => bcrypt('test')
            ]);
        }
    }
}
