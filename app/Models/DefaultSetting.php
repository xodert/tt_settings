<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DefaultSetting extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = [
        'key',
        'value',
        'label',
        'editable'
    ];

    /**
     * @var string[]
     */
    protected $casts = [
        'value' => 'array'
    ];
}
