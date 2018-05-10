<?php

namespace Inventory\Management\Application\Employee\ShowByFirstResultEmployees;

use Inventory\Management\Domain\Model\Entity\Employee\Employee;

class ShowByFirstResultEmployeesTransform implements ShowByFirstResultEmployeesTransformInterface
{
    /**
     * @param array|Employee[] $employees
     * @return array
     */
    public function transform(array $employees): array
    {
        $listEmployees = [];
        foreach ($employees as $employee) {
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
            $listEmployees[] = [
                'id' => $employee->getId(),
                'image' => $employee->getImage(),
                'nif' => $employee->getNif(),
                'name' => $employee->getName(),
                'inSsNumber' => $employee->getInSsNumber(),
                'telephone' => $employee->getTelephone(),
                'employeeStatus' => $employeeStatus
            ];
        }

        return $listEmployees;
    }
}