<?php

namespace Inventory\Management\Application\Employee\CheckLoginEmployee;

use Assert\Assertion;

class CheckLoginEmployeeCommand
{
    private const LENGTH_NIF = 9;
    private const MIN_LENGTH_PASSWORD = 4;

    private $nif;
    private $password;

    public function __construct($nif, $password)
    {
        Assertion::notBlank($nif, 'Tienes que especificar tu NIF');
        Assertion::string($nif, 'El NIF tiene que ser de tipo texto');
        Assertion::length($nif, self::LENGTH_NIF, 'El NIF tiene que contener 9 carácteres');

        Assertion::notBlank($password, 'Tienes que especificar una contraseña');
        Assertion::string($password, 'La contraseña tiene que ser de tipo texto');
        Assertion::minLength($password, self::MIN_LENGTH_PASSWORD, 'La contraseña tiene que tener como mínimo 4 carácteres');

        $this->nif = $nif;
        $this->password = $password;
    }

    public function nif(): string
    {
        return $this->nif;
    }

    public function password(): string
    {
        return $this->password;
    }
}
