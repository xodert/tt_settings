<?php

namespace App\Events;

use App\Services\SettingService;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SettingEditToggled implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $setting;
    public SettingService $settingService;

    /**
     * Create a new event instance.
     */
    public function __construct(
        int $settingId,
    ) {
        $this->settingService = app(SettingService::class);

        $this->setting = $this->settingService->firstById($settingId);
    }

    /**
     * @return Channel
     */
    public function broadcastOn(): Channel
    {
        return new Channel('App.Models.Setting.' . $this->setting->id);
    }

    /**
     * @return array
     */
    public function broadcastWith(): array
    {
        return [
            'editable' => $this->setting->editable,
        ];
    }
}
