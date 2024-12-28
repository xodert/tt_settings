<?php

namespace Database\Seeders;

use App\Enums\Confirmation\ConfirmationTypeEnum;
use App\Models\ConfirmationType;
use Illuminate\Database\Seeder;

class ConfirmationTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $confirmationTypes = ConfirmationTypeEnum::toCollection()
            ->map(fn($item) => [
                'alias' => $item
            ])->toArray();

        ConfirmationType::factory()->createMany($confirmationTypes);
    }
}
