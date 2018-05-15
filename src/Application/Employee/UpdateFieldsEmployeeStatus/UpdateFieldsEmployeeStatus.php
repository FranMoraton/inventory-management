<?php

namespace Inventory\Management\Application\Employee\UpdateFieldsEmployeeStatus;

use Inventory\Management\Domain\Model\Entity\Department\NotFoundDepartmentsException;
use Inventory\Management\Domain\Model\Entity\Department\NotFoundSubDepartmentsException;
use Inventory\Management\Domain\Model\Entity\Employee\EmployeeRepositoryInterface;
use Inventory\Management\Domain\Model\Entity\Employee\NotFoundEmployeesException;
use Inventory\Management\Domain\Service\Department\SearchDepartmentById;
use Inventory\Management\Domain\Service\Department\SearchSubDepartmentById;
use Inventory\Management\Domain\Service\Employee\SearchEmployeeByNif;

class UpdateFieldsEmployeeStatus
{
    private $employeeRepository;
    private $searchEmployeeByNif;
    private $searchDepartmentById;
    private $searchSubDepartmentById;

    public function __construct(
        EmployeeRepositoryInterface $employeeRepository,
        SearchEmployeeByNif $searchEmployeeByNif,
        SearchDepartmentById $searchDepartmentById,
        SearchSubDepartmentById $searchSubDepartmentById
    ) {
        $this->employeeRepository = $employeeRepository;
        $this->searchEmployeeByNif = $searchEmployeeByNif;
        $this->searchDepartmentById = $searchDepartmentById;
        $this->searchSubDepartmentById = $searchSubDepartmentById;
    }

    public function handle(UpdateFieldsEmployeeStatusCommand $updateFieldsEmployeeStatusCommand): array
    {
        try {
            $department = $this->searchDepartmentById->execute(
                $updateFieldsEmployeeStatusCommand->department()
            );
        } catch (NotFoundDepartmentsException $notFoundDepartmentsException) {
            return ['ko' => $notFoundDepartmentsException->getMessage()];
        }
        try {
            $subDepartment = $this->searchSubDepartmentById->execute(
                $updateFieldsEmployeeStatusCommand->subDepartment()
            );
        } catch (NotFoundSubDepartmentsException $notFoundSubDepartmentsException) {
            return ['ko' => $notFoundSubDepartmentsException->getMessage()];
        }
        try {
            $employee = $this->searchEmployeeByNif->execute(
                $updateFieldsEmployeeStatusCommand->nif()
            );
        } catch (NotFoundEmployeesException $notFoundEmployeesException) {
            return ['ko' => $notFoundEmployeesException->getMessage()];
        }
        $this->employeeRepository->updateFieldsEmployeeStatus(
            $employee,
            $updateFieldsEmployeeStatusCommand->image(),
            new \DateTime($updateFieldsEmployeeStatusCommand->expirationContractDate()),
            new \DateTime($updateFieldsEmployeeStatusCommand->possibleRenewal()),
            $updateFieldsEmployeeStatusCommand->availableHolidays(),
            $updateFieldsEmployeeStatusCommand->holidaysPendingToApplyFor(),
            $department,
            $subDepartment
        );

        return ['ok' => 200];
    }
}
