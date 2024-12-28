<?php

namespace App\Data;

use Spatie\LaravelData\Data;

final class SettingDTO extends Data
{
    public int $id;
    public string $label;
    public string $key;
    public array $value;
    public bool $editable;
}
