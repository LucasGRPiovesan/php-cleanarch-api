<?php

namespace Application\DTO;

class CreateUserDTO
{
    public string $uuid_profile;
    public string $name;
    public string $email;
    public string $password;

    public function __construct(
        string $uuid_profile,
        string $name,
        string $email,
        string $password
    ) {
        $this->uuid_profile = $uuid_profile;
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            $data['uuid_profile'],
            $data['name'],
            $data['email'],
            $data['password']
        );
    }
}
