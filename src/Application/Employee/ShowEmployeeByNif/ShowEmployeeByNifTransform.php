<?php

namespace Inventory\Management\Application\Employee\ShowEmployeeByNif;

use Inventory\Management\Domain\Model\Entity\Employee\Employee;

class ShowEmployeeByNifTransform implements ShowEmployeeByNifTransformInterface
{
    private const ATOM = "Y-m-d\TH:i:sP";

    public function transform(Employee $employee): array
    {
        $status = $employee->getEmployeeStatus();
        $employeeStatus = [
            'id' => $status->getId(),
            'codeEmployee' => $status->getCodeEmployee(),
            'disabledEmployee' => $status->getDisabledEmployee(),
            'firstContractDate' => $status->getFirstContractDate()->format(self::ATOM),
            'seniorityDate' => $status->getSeniorityDate()->format(self::ATOM),
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
