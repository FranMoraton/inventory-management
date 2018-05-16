<?php

namespace Inventory\Management\Domain\Service\Util;

use Inventory\Management\Domain\Model\Entity\Employee\NotFoundPasswordEmployeeException;

class CheckDecryptPassword
{
    /**
     * @param string $password
     * @param string $passwordEncrypted
     * @throws NotFoundPasswordEmployeeException
     */
    public function execute(string $password, string $passwordEncrypted): void
    {
        $ifIsCorrectPassword = password_verify(
            $password,
            $passwordEncrypted
        );
        if (false === $ifIsCorrectPassword) {
            throw new NotFoundPasswordEmployeeException();
        }
    }
}
