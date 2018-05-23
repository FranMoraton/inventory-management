<?php

namespace Inventory\Management\Application\Employee\ShowEmployeeByNif;

use Inventory\Management\Domain\Model\Entity\Employee\Employee;

class ShowEmployeeByNifTransform implements ShowEmployeeByNifTransformInterface
{
    private const ATOM = "d-m-Y";

    public function transform(Employee $employee): array
    {
        $status = $employee->getEmployeeStatus();
        $employeeStatus = [
            'expirationContractDate' => null !== $status->getExpirationContractDate()
                ? $status->getExpirationContractDate()->format(self::ATOM) : null,
            'possibleRenewal' => null !== $status->getPossibleRenewal()
                ? $status->getPossibleRenewal()->format(self::ATOM) : null,
            'availableHolidays' => $status->getAvailableHolidays(),
            'holidaysPendingToApplyFor' => $status->getHolidaysPendingToApplyFor(),
            'department' => $status->getDepartment()->getName(),
            'subDepartment' => $status->getSubDepartment()->getName()
        ];
        $listEmployee = [
            'image' => $employee->getImage(),
            'nif' => $employee->getNif(),
            'name' => $employee->getName(),
            'employeeStatus' => $employeeStatus
        ];

        return $listEmployee;
    }
}
