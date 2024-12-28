<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    /**
     * @var string[]
     */
    protected $fillable = [
        'label',
        'key',
        'value',
        'editable'
    ];

    /**
     * @var string[]
     */
    protected $casts = [
        'value' => 'array'
    ];
}
