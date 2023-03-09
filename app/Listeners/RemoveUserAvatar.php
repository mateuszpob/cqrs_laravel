<?php

namespace App\Listeners;

use App\Services\AvatarService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class RemoveUserAvatar
{
    /**
     * Create the event listener.
     */
    public function __construct(private AvatarService $avatarService)
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        $this->avatarService->deleteAvatar($event->user);
    }
}
