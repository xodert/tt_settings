<?php

namespace App\Models;

use App\Enums\Confirmation\ConfirmationTypeEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConfirmationType extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = [
        'alias'
    ];

    /**
     * @var class-string[]
     */
    protected $casts = [
        'alias' => ConfirmationTypeEnum::class
    ];
}
