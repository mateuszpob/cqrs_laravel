<?php

namespace App\Commands;

use App\Events\UserDeletedEvent;
use App\Models\User;
use App\Services\AvatarService;
use Exception;

class DeleteUserHandler
{
    public function __construct(private AvatarService $avatarService)
    {
    }

    public function __invoke(DeleteUserCommand $command)
    {
    	$user = User::findOrFail($command->getId());
        try
        {
            $user->delete();
            event(new UserDeletedEvent($user));

        }
        catch(Exception $e)
        {

        }
    }


}
