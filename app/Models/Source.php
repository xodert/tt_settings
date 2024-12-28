<?php

namespace App\Models;

use App\Enums\SourceEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Source extends Model
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
        'alias' => SourceEnum::class
    ];
}
