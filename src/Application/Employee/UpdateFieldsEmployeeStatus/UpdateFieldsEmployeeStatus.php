<?php

namespace Inventory\Management\Application\Employee\UpdateFieldsEmployeeStatus;

use Inventory\Management\Domain\Model\Entity\Employee\EmployeeRepositoryInterface;
use Inventory\Management\Domain\Model\HttpResponses\HttpResponses;
use Inventory\Management\Domain\Service\Department\SearchDepartmentById;
use Inventory\Management\Domain\Service\Department\SearchSubDepartmentById;
use Inventory\Management\Domain\Service\Employee\SearchEmployeeByNif;
use Inventory\Management\Domain\Util\Observer\ListExceptions;

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
        ListExceptions::instance()->restartExceptions();
        ListExceptions::instance()->attach($searchEmployeeByNif);
        ListExceptions::instance()->attach($searchDepartmentById);
        ListExceptions::instance()->attach($searchSubDepartmentById);
    }

    public function handle(UpdateFieldsEmployeeStatusCommand $updateFieldsEmployeeStatusCommand): array
    {
        $department = $this->searchDepartmentById->execute(
            $updateFieldsEmployeeStatusCommand->department()
        );
        $subDepartment = $this->searchSubDepartmentById->execute(
            $updateFieldsEmployeeStatusCommand->subDepartment()
        );
        $employee = $this->searchEmployeeByNif->execute(
            $updateFieldsEmployeeStatusCommand->nif()
        );
        if (ListExceptions::instance()->checkForExceptions()) {
            return ListExceptions::instance()->firstException();
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

        return [
            'data' => 'Se ha actualizado el estado del trabajador con éxito',
            'code' => HttpResponses::OK
        ];
    }
}
