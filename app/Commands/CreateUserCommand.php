<?php

namespace App\Commands;

class CreateUserCommand
{
    public function __construct(
        private string $email,
        private string $password,
        private ?string $first_name = null,
        private ?string $last_name = null
    )
    {
    }

    public function getFirstName(): ?string
    {
        return $this->first_name;
    }

    public function getLastName(): ?string
    {
        return $this->last_name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }
}
