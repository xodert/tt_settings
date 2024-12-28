<?php

namespace Database\Seeders;

use App\Models\DefaultSetting;
use Illuminate\Database\Seeder;

class DefaultSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DefaultSetting::factory(5)->create();
    }
}
