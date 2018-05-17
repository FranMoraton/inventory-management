<?php

namespace Inventory\Management\Domain\Model\Entity\Employee;

use Doctrine\ORM\Mapping as ORM;
use Inventory\Management\Domain\Model\Entity\Department\Department;
use Inventory\Management\Domain\Model\Entity\Department\SubDepartment;

/**
 * @ORM\Entity(repositoryClass="Inventory\Management\Infrastructure\Repository\Employee\EmployeeStatusRepository")
 * @ORM\Table(name="employee_status")
 */
class EmployeeStatus
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer", nullable=false)
     */
    private $id;

    /**
     * @ORM\Column(type="integer", nullable=false, unique=true)
     */
    private $codeEmployee;

    /**
     * @ORM\Column(type="boolean", nullable=false)
     */
    private $disabledEmployee;

    /**
     * @ORM\Column(type="datetime", nullable=false)
     */
    private $firstContractDate;

    /**
     * @ORM\Column(type="datetime", nullable=false)
     */
    private $seniorityDate;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $expirationContractDate;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $possibleRenewal;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $availableHolidays;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $holidaysPendingToApplyFor;

    /**
     * @ORM\ManyToOne(targetEntity="Inventory\Management\Domain\Model\Entity\Department\Department")
     */
    private $department;

    /**
     * @ORM\ManyToOne(targetEntity="Inventory\Management\Domain\Model\Entity\Department\SubDepartment")
     */
    private $subDepartment;

    public function __construct(
        $codeEmployee,
        $firstContractDate,
        $seniorityDate,
        $department,
        $subDepartment
    ) {
        $this->codeEmployee = $codeEmployee;
        $this->firstContractDate = $firstContractDate;
        $this->seniorityDate = $seniorityDate;
        $this->department = $department;
        $this->subDepartment = $subDepartment;
        $this->disabledEmployee = false;
        $this->availableHolidays = 0;
        $this->holidaysPendingToApplyFor = 0;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getCodeEmployee(): int
    {
        return $this->codeEmployee;
    }

    public function getDisabledEmployee(): bool
    {
        return $this->disabledEmployee;
    }

    public function setDisabledEmployee(bool $disabledEmployee): void
    {
        $this->disabledEmployee = $disabledEmployee;
    }

    public function getFirstContractDate(): \DateTime
    {
        return $this->firstContractDate;
    }

    public function getSeniorityDate(): \DateTime
    {
        return $this->seniorityDate;
    }

    public function getExpirationContractDate(): ?\DateTime
    {
        return $this->expirationContractDate;
    }

    public function setExpirationContractDate($expirationContractDate): void
    {
        $this->expirationContractDate = $expirationContractDate;
    }

    public function getPossibleRenewal(): ?\DateTime
    {
        return $this->possibleRenewal;
    }

    public function setPossibleRenewal($possibleRenewal): void
    {
        $this->possibleRenewal = $possibleRenewal;
    }

    public function getAvailableHolidays()
    {
        return $this->availableHolidays;
    }

    public function setAvailableHolidays($availableHolidays): void
    {
        $this->availableHolidays = $availableHolidays;
    }

    public function getHolidaysPendingToApplyFor()
    {
        return $this->holidaysPendingToApplyFor;
    }

    public function setHolidaysPendingToApplyFor($holidaysPendingToApplyFor): void
    {
        $this->holidaysPendingToApplyFor = $holidaysPendingToApplyFor;
    }

    public function getDepartment(): Department
    {
        return $this->department;
    }

    public function setDepartment($department): void
    {
        $this->department = $department;
    }

    public function getSubDepartment(): SubDepartment
    {
        return $this->subDepartment;
    }

    public function setSubDepartment($subDepartment): void
    {
        $this->subDepartment = $subDepartment;
    }
}
