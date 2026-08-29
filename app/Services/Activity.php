<?php

namespace App\Services;

use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Activity
{
    public static function record(string $event, ?Model $subject = null, array $properties = []): ?ActivityLog
    {
        $user = auth()->user();
        if (! $user instanceof User) {
            return null;
        }

        return ActivityLog::create([
            'loggable_type' => $subject ? get_class($subject) : null,
            'loggable_id' => $subject?->getKey(),
            'event' => $event,
            'properties' => $properties ?: null,
            'user_id' => $user->id,
        ]);
    }
}
