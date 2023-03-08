<?php

namespace App\Queries;

use App\Models\User;

class UserByIdQuery
{
    private $userId;

    public function __construct(int $userId)
    {
        $this->userId = $userId;
    }

    public function getData(): array
    {
        $user = User::findOrFail($this->userId);
        return [
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'email' => $user->email,
            'avatar' => $user->avatar
        ];
    }
}
