<?php

namespace Inventory\Management\Application\Employee\ChangeStatusToDisableEmployee;

use Assert\Assertion;

class ChangeStatusToDisableEmployeeCommand
{
    private const LENGTH_NIF = 9;

    private $nif;

    public function __construct($nif)
    {
        Assertion::notBlank($nif, 'Tienes que especificar tu NIF');
        Assertion::string($nif, 'El NIF tiene que ser de tipo texto');
        Assertion::length($nif, self::LENGTH_NIF, 'El NIF tiene que contener 9 carácteres');

        $this->nif = $nif;
    }

    public function nif(): string
    {
        return $this->nif;
    }
}
