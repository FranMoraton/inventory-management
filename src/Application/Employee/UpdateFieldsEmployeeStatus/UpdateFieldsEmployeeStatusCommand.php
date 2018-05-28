<?php

namespace Inventory\Management\Application\Employee\UpdateFieldsEmployeeStatus;

class UpdateFieldsEmployeeStatusCommand
{
    private $nif;
    private $image;
    private $expirationContractDate;
    private $possibleRenewal;
    private $availableHolidays;
    private $holidaysPendingToApplyFor;
    private $department;
    private $subDepartment;

    public function __construct(
        $nif,
        $image,
        $expirationContractDate,
        $possibleRenewal,
        $availableHolidays,
        $holidaysPendingToApplyFor,
        $department,
        $subDepartment
    ) {
        $this->nif = $nif;
        $this->image = $image;
        $this->expirationContractDate = $expirationContractDate;
        $this->possibleRenewal = $possibleRenewal;
        $this->availableHolidays = $availableHolidays;
        $this->holidaysPendingToApplyFor = $holidaysPendingToApplyFor;
        $this->department = $department;
        $this->subDepartment = $subDepartment;
    }

    public function nif(): string
    {
        return $this->nif;
    }

    public function image()
    {
        return $this->image;
    }

    public function expirationContractDate(): string
    {
        return $this->expirationContractDate;
    }

    public function possibleRenewal(): string
    {
        return $this->possibleRenewal;
    }

    public function availableHolidays(): string
    {
        return $this->availableHolidays;
    }

    public function holidaysPendingToApplyFor(): string
    {
        return $this->holidaysPendingToApplyFor;
    }

    public function department(): int
    {
        return $this->department;
    }

    public function subDepartment(): int
    {
        return $this->subDepartment;
    }
}
