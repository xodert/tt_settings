<?php

use App\Models\User;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('App.Models.Setting.{id}', function (User $user, $id) {
    return $user->settings->where('id', $id)->exists();
});