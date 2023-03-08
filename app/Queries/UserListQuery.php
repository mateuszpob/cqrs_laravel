<?php

namespace App\Queries;

use App\Models\User;

class UserListQuery
{
    public function __construct(
        private int $limit,
        private int $offset
    )
    {
    }

    public function getData(): array
    {
        $users = User::orderBy('created_at')->take($this->limit)->offset($this->offset)->get();
        return $users->map(function(User $user) {
            return [
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'email' => $user->email
            ];
        })->toArray();
    }
}
