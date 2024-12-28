<?php

namespace App\Models;

use App\Enums\Confirmation\ConfirmationStatusEnum;
use App\Observers\ConfirmationObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[ObservedBy(ConfirmationObserver::class)]
class Confirmation extends Model
{
    /**
     * @var string[]
     */
    protected $fillable = [
        'user_id',
        'confirmation_type_id',
        'source_id',
        'message',
        'code',
        'action',
        'action_data',
        'status',
        'expires_at'
    ];

    /**
     * @var string[]
     */
    protected $casts = [
        'status' => ConfirmationStatusEnum::class,
        'action_data' => 'array',
        'expires_at' => 'datetime',
    ];

    /**
     * @return BelongsTo
     */
    public function confirmationType(): BelongsTo
    {
        return $this->belongsTo(ConfirmationType::class);
    }

    /**
     * @return BelongsTo
     */
    public function source(): BelongsTo
    {
        return $this->belongsTo(Source::class);
    }

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
