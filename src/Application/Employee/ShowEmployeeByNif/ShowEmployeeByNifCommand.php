<?php

namespace Inventory\Management\Application\Employee\ShowEmployeeByNif;

use Assert\Assertion;

class ShowEmployeeByNifCommand
{
    private const LENGTH_NIF = 9;
    private $nif;
    private $token;

    public function __construct($nif, $token)
    {
        Assertion::notBlank($nif, 'Tienes que especificar tu NIF');
        Assertion::string($nif, 'El NIF tiene que ser de tipo texto');
        Assertion::length($nif, self::LENGTH_NIF, 'El NIF tiene que contener 9 carácteres');

        $this->nif = $nif;
        $this->token = $token;
    }

    public function nif()
    {
        return $this->nif;
    }

    public function token()
    {
        return $this->token;
    }
}
