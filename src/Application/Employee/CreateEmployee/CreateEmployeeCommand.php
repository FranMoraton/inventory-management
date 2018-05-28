<?php

namespace Inventory\Management\Application\Employee\CreateEmployee;

use Assert\Assertion;

class CreateEmployeeCommand
{
    private const LENGTH_NIF = 9;
    private const LENGTH_IN_SS_NUMBER = 12;
    private const MIN_LENGTH_TELEPHONE = 9;

    private $image;
    private $nif;
    private $password;
    private $name;
    private $inSsNumber;
    private $telephone;
    private $codeEmployee;
    private $firstContractDate;
    private $seniorityDate;
    private $subDepartment;

    public function __construct(
        $image,
        $nif,
        $password,
        $name,
        $inSsNumber,
        $telephone,
        $codeEmployee,
        $firstContractDate,
        $seniorityDate,
        $subDepartment
    ) {
        Assertion::notBlank($image, 'Tienes que especificar una imagen');
        Assertion::notBlank($nif, 'Tienes que especificar un NIF');
        Assertion::string($nif, 'El NIF tiene que ser de tipo texto');
        Assertion::length($nif, self::LENGTH_NIF, 'El NIF tiene que contener 9 carácteres');
        Assertion::notBlank($name, 'Tienes que especificar un nombre');
        Assertion::notBlank($inSsNumber, 'Tienes que especificar un número de la seguridad social');
        Assertion::length($inSsNumber, self::LENGTH_IN_SS_NUMBER, 
            'El número de la seguridad social tiene que contener 12 carácteres');
        Assertion::notBlank($telephone, 'Tienes que especificar un teléfono');
        Assertion::minLength($telephone, self::MIN_LENGTH_TELEPHONE,
            'El teléfono tiene que contener como mínimo 9 caracteres');

        $this->image = $image;
        $this->nif = $nif;
        $this->password = $password;
        $this->name = $name;
        $this->inSsNumber = $inSsNumber;
        $this->telephone = $telephone;
        $this->codeEmployee = $codeEmployee;
        $this->firstContractDate = $firstContractDate;
        $this->seniorityDate = $seniorityDate;
        $this->subDepartment = $subDepartment;
    }

    public function image()
    {
        return $this->image;
    }

    public function nif(): string
    {
        return $this->nif;
    }

    public function password(): string
    {
        return $this->password;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function inSsNumber(): string
    {
        return $this->inSsNumber;
    }

    public function telephone(): string
    {
        return $this->telephone;
    }

    public function codeEmployee(): int
    {
        return $this->codeEmployee;
    }

    public function firstContractDate(): string
    {
        return $this->firstContractDate;
    }

    public function seniorityDate(): string
    {
        return $this->seniorityDate;
    }

    public function subDepartment(): int
    {
        return $this->subDepartment;
    }
}
