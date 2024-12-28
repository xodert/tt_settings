<?php

namespace Database\Factories;

use App\Models\DefaultSetting;
use Illuminate\Database\Eloquent\Factories\Factory;

class DefaultSettingFactory extends Factory
{
    protected $model = DefaultSetting::class;

    public function definition(): array
    {
        return [
            'label' => $this->faker->word(),
            'key' => $this->faker->unique()->word(),
            'value' => [
                'type' => 'string',
                'value' => $this->faker->word(),
            ],
        ];
    }
}
