<?php

namespace App\Commands;

use App\Models\User;

class DeleteUserHandler
{
    public function __construct()
    {

    }

    public function __invoke(DeleteUserCommand $command)
    {
    	$user = User::findOrFail($command->getId());
        $user->delete();
    }


}
