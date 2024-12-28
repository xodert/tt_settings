<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserSetting extends Model
{
    /**
     * @var string[]
     */
    protected $fillable = [
        'user_id',
        'setting_id'
    ];

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsTo
     */
    public function setting(): BelongsTo
    {
        return $this->belongsTo(Setting::class);
    }
}
