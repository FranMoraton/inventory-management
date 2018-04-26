<?php

namespace Inventory\Management\Domain\Model\Entity\Employee;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Inventory\Management\Infrastructure\Repository\Employee\EmployeeRepository")
 * @ORM\Table(name="employee")
 */
class Employee
{
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
     * @ORM\Column(type="string", length=9, nullable=false, unique=true, options={"default"="-"})
     */
    private $nif;

    /**
     * @ORM\Column(type="string", length=50, nullable=false)
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=50, nullable=false, options={"default"="-"})
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=30, nullable=false, unique=true, options={"default"="-"})
     */
    private $inSsNumber;

    /**
     * @ORM\Column(type="string", length=12, nullable=false, unique=true, options={"default"="-"})
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

    public function setEmployeeStatus(EmployeeStatus $employeeStatus): void
    {
        $this->employeeStatus = $employeeStatus;
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

    public function setNif(string $nif): void
    {
        $this->nif = $nif;
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

    public function setInSsNumber(string $inSsNumber): void
    {
        $this->inSsNumber = $inSsNumber;
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
