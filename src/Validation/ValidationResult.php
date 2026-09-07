<?php

namespace App\Validation;

class ValidationResult
{
    public function __construct(
        private array $errors = [],
        private array $data = []
    ) {
    }

    public function isValid(): bool
    {
        return empty($this->errors);
    }


    public function errors(): array
    {
        return $this->errors;
    }

    public function data(): array
    {
        return $this->data;
    }
}