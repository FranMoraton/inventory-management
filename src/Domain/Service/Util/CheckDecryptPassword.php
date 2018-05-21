<?php

namespace Inventory\Management\Domain\Service\Util;

use Inventory\Management\Domain\Model\Entity\Employee\NotFoundPasswordEmployeeException;
use Inventory\Management\Domain\Util\Observer\ListExceptions;
use Inventory\Management\Domain\Util\Observer\Observer;

class CheckDecryptPassword implements Observer
{
    private $stateException;

    public function __construct()
    {
        $this->stateException = false;
    }

    public function execute(string $password, string $passwordEncrypted): void
    {
        $ifIsCorrectPassword = password_verify(
            $password,
            $passwordEncrypted
        );
        if (false === $ifIsCorrectPassword) {
            $this->stateException = true;
            ListExceptions::instance()->notify();
        }
    }

    /**
     * @throws NotFoundPasswordEmployeeException
     */
    public function update()
    {
        if ($this->stateException) {
            throw new NotFoundPasswordEmployeeException();
        }
    }
}
