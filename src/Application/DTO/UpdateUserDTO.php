<?php

namespace Application\DTO;

use Domain\Entities\Profile;
use Domain\Entities\User;
use InvalidArgumentException;

class UpdateUserDTO
{
    private array $fields = [];
    private const ALLOWED_FIELDS = ['uuid_profile', 'name', 'email', 'password'];

    private function __construct(array $fields)
    {
        $this->fields = $fields;
    }

    public static function fromArray(array $data): self
    {
        $filtered = [];

        foreach ($data as $key => $value) {
            if (!in_array($key, self::ALLOWED_FIELDS, true)) {
                throw new InvalidArgumentException("Campo '{$key}' não é permitido para atualização.");
            }

            if ($value === null || $value === '') {
                continue;
            }

            $filtered[$key] = $value;
        }

        if (empty($filtered)) {
            throw new InvalidArgumentException("Nenhum campo válido foi informado para atualização.");
        }

        return new self($filtered);
    }

    public function getFields(): array
    {
        return $this->fields;
    }

    public function applyTo(User $user, ?Profile $profile): void
    {
        if (isset($this->fields['uuid_profile']) && $profile) {
            $user->setProfile($profile);
        }

        if (isset($this->fields['name'])) {
            $user->setName($this->fields['name']);
        }

        if (isset($this->fields['email'])) {
            $user->setEmail($this->fields['email']);
        }

        if (isset($this->fields['password'])) {
            $user->setPassword($this->fields['password']);
        }
    }
}
