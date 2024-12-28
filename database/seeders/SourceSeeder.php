<?php

namespace Database\Seeders;

use App\Enums\SourceEnum;
use App\Models\Source;
use Illuminate\Database\Seeder;

class SourceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sources = SourceEnum::toCollection()
            ->map(fn($item) => [
                'alias' => $item
            ])->toArray();

        Source::factory()->createMany($sources);
    }
}
