<?php

namespace Inventory\Management\Domain\Service\PasswordHash;

class EncryptPassword
{
    public function execute(string $password): string
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }
}
