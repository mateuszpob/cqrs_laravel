<?php

namespace App\Commands;

use Illuminate\Http\UploadedFile;

class EditUserCommand
{
    public function __construct(
        private int $id,
        private string $email,
        private ?string $first_name = null,
        private ?string $last_name = null,
        private ?string $password = null,
        private ?UploadedFile $avatar = null
    )
    {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->first_name;
    }

    public function getLastName(): ?string
    {
        return $this->last_name;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function getAvatar(): ?UploadedFile
    {
        return $this->avatar;
    }
}
