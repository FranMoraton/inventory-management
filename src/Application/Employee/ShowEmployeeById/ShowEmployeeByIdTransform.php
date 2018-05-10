<?php

namespace Inventory\Management\Application\Employee\ShowEmployeeById;

use Inventory\Management\Domain\Model\Entity\Employee\Employee;

class ShowEmployeeByIdTransform implements ShowEmployeeByIdTransformInterface
{
    public function transform(Employee $employee): array
    {
        $status = $employee->getEmployeeStatus();
        $employeeStatus = [
            'id' => $status->getId(),
            'codeEmployee' => $status->getCodeEmployee(),
            'disabledEmployee' => $status->getDisabledEmployee(),
            'firstContractDate' => $status->getFirstContractDate(),
            'seniorityDate' => $status->getSeniorityDate(),
            'expirationContractDate' => $status->getExpirationContractDate(),
            'possibleRenewal' => $status->getPossibleRenewal(),
            'availableHolidays' => $status->getAvailableHolidays(),
            'holidaysPendingToApplyFor' => $status->getHolidaysPendingToApplyFor(),
            'department' => $status->getDepartment()->getName(),
            'subDepartment' => $status->getSubDepartment()->getName()
        ];
        $listEmployee = [
            'id' => $employee->getId(),
            'image' => $employee->getImage(),
            'nif' => $employee->getNif(),
            'name' => $employee->getName(),
            'inSsNumber' => $employee->getInSsNumber(),
            'telephone' => $employee->getTelephone(),
            'employeeStatus' => $employeeStatus
        ];

        return $listEmployee;
    }
}
