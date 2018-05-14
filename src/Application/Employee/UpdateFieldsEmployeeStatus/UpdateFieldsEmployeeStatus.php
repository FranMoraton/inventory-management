<?php

namespace Inventory\Management\Application\Employee\UpdateFieldsEmployeeStatus;

use Inventory\Management\Domain\Model\Entity\Employee\EmployeeRepositoryInterface;
use Inventory\Management\Domain\Model\Entity\Employee\NotFoundEmployeesException;
use Inventory\Management\Domain\Service\Employee\SearchEmployeeByNif;

class UpdateFieldsEmployeeStatus
{
    private $employeeRepository;
    private $searchEmployeeByNif;

    public function __construct(
        EmployeeRepositoryInterface $employeeRepository,
        SearchEmployeeByNif $searchEmployeeByNif
    ) {
        $this->employeeRepository = $employeeRepository;
        $this->searchEmployeeByNif = $searchEmployeeByNif;
    }

    public function handle(UpdateFieldsEmployeeStatusCommand $updateFieldsEmployeeStatusCommand): array
    {
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
            $updateFieldsEmployeeStatusCommand
        );

        return ['ok' => 200];
    }
}
