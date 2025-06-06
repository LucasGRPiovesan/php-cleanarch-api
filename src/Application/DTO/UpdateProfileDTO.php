<?php

namespace Application\DTO;

use Domain\Entities\Profile;
use InvalidArgumentException;

class UpdateProfileDTO
{
    private array $fields = [];
    private const ALLOWED_FIELDS = ['profile', 'description'];

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

    public function applyTo(Profile $profile): void
    {
        foreach ($this->fields as $field => $value) {
            $method = 'set' . ucfirst($field);
            if (method_exists($profile, $method)) {
              $profile->$method($value);
            }
        }
    }
}
