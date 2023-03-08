<?php

namespace App\Commands;

use App\Models\User;
use App\Services\AvatarService;

class EditUserHandler
{
    public function __construct(private AvatarService $avatarService)
    {

    }

    public function __invoke(EditUserCommand $command)
    {
    	$user = User::findOrFail($command->getId());
    	$user->first_name = $command->getFirstName();
    	$user->last_name = $command->getLastName();
    	$user->email = $command->getEmail();

        if(!is_null($command->getPassword())) {
            $user->password = bcrypt($command->getPassword());
        }
        if(!is_null($command->getAvatar())) {
            $this->avatarService->processAvatar($user, $command->getAvatar());
        }
        $user->save();
    }


}
