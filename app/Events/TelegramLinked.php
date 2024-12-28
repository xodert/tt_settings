<?php

namespace App\Events;

use App\Services\UserService;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TelegramLinked implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user;
    public UserService $userService;

    /**
     * Create a new event instance.
     */
    public function __construct(
        int $userId,
    ) {
        $this->userService = app(UserService::class);

        $this->user = $this->userService->firstById($userId);
    }

    /**
     * @return Channel
     */
    public function broadcastOn(): Channel
    {
        return new Channel('App.Models.User.' . $this->user->id);
    }

    /**
     * @return array
     */
    public function broadcastWith(): array
    {
        return [
            'telegram_id' => $this->user->telegram_id,
        ];
    }
}
