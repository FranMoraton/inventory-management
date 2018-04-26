<?php

namespace Inventory\Management\Domain\Model\Entity\Employee;

use Doctrine\ORM\Mapping as ORM;

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
     * @@ORM\Column(type="boolean", nullable=false, options={"default":false})
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
     * @ORM\Column(type="integer", nullable=true, options={"default"=0})
     */
    private $availableHolidays;

    /**
     * @ORM\Column(type="integer", nullable=true, options={"default"=0})
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

    public function __construct($firstContractDate, $seniorityDate,
                                $department, $subDepartment)
    {
        $this->firstContractDate = $firstContractDate;
        $this->seniorityDate = $seniorityDate;
        $this->department = $department;
        $this->subDepartment = $subDepartment;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getDisabledEmployee(): bool
    {
        return $this->disabledEmployee;
    }

    public function setDisabledEmployee(bool $disabledEmployee): void
    {
        $this->disabledEmployee = $disabledEmployee;
    }

    public function getFirstContractDate()
    {
        return $this->firstContractDate;
    }

    public function setFirstContractDate($firstContractDate): void
    {
        $this->firstContractDate = $firstContractDate;
    }

    public function getSeniorityDate()
    {
        return $this->seniorityDate;
    }

    public function setSeniorityDate($seniorityDate): void
    {
        $this->seniorityDate = $seniorityDate;
    }

    public function getExpirationContractDate()
    {
        return $this->expirationContractDate;
    }

    public function setExpirationContractDate($expirationContractDate): void
    {
        $this->expirationContractDate = $expirationContractDate;
    }

    public function getPossibleRenewal()
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

    public function getDepartment()
    {
        return $this->department;
    }

    public function setDepartment($department): void
    {
        $this->department = $department;
    }

    public function getSubDepartment()
    {
        return $this->subDepartment;
    }

    public function setSubDepartment($subDepartment): void
    {
        $this->subDepartment = $subDepartment;
    }
}
