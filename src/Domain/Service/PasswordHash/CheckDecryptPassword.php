<?php

namespace Inventory\Management\Domain\Service\PasswordHash;

use Inventory\Management\Domain\Model\PasswordHash\IncorrectPasswordException;

class CheckDecryptPassword
{
    /**
     * @param string $password
     * @param string $passwordEncrypted
     * @throws IncorrectPasswordException
     */
    public function execute(string $password, string $passwordEncrypted): void
    {
        $ifIsCorrectPassword = password_verify(
            $password,
            $passwordEncrypted
        );
        if (false === $ifIsCorrectPassword) {
            throw new IncorrectPasswordException();
        }
    }
}
