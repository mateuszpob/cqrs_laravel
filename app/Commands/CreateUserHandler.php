<?php

namespace App\Commands;

use App\Models\User;

class CreateUserHandler
{
    public function __invoke(CreateUserCommand $command)
    {
    	$user = new User();
    	$user->first_name = $command->getFirstName();
    	$user->last_name = $command->getLastName();
    	$user->email = $command->getEmail();
        $user->password = bcrypt($command->getPassword());
    	$user->save();
    }
}
