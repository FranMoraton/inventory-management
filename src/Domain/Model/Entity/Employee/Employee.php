<?php

namespace Inventory\Management\Domain\Model\Entity\Employee;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Inventory\Management\Infrastructure\Repository\Employee\EmployeeRepository")
 * @ORM\Table(name="employee")
 */
class Employee
{
    const URL_IMAGE = 'employee/';

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity="Inventory\Management\Domain\Model\Entity\Employee\EmployeeStatus")
     */
    private $employeeStatus;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $image;

    /**
     * @ORM\Column(type="string", length=9, nullable=false, unique=true)
     */
    private $nif;

    /**
     * @ORM\Column(type="string", length=70, nullable=false)
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=50, nullable=false)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=30, nullable=false, unique=true)
     */
    private $inSsNumber;

    /**
     * @ORM\Column(type="string", length=12, nullable=false, unique=true)
     */
    private $telephone;

    public function __construct($employeeStatus, $image, $nif, $password, $name, $inSsNumber, $telephone)
    {
        $this->employeeStatus = $employeeStatus;
        $this->image = $image;
        $this->nif = $nif;
        $this->password = $password;
        $this->name = $name;
        $this->inSsNumber = $inSsNumber;
        $this->telephone = $telephone;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getEmployeeStatus(): EmployeeStatus
    {
        return $this->employeeStatus;
    }

    public function getImage(): string
    {
        return $this->image;
    }

    public function setImage(string $image): void
    {
        $this->image = $image;
    }

    public function getNif(): string
    {
        return $this->nif;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getInSsNumber(): string
    {
        return $this->inSsNumber;
    }

    public function getTelephone(): string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): void
    {
        $this->telephone = $telephone;
    }
}
