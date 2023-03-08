<?php

namespace App\Commands;

class DeleteUserCommand
{
    public function __construct(
        private int $id,
        ){

        }

    public function getId(): int
    {
        return $this->id;
    }
}
