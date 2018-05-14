<?php

namespace Inventory\Management\Application\Employee\ChangeStatusToEnableEmployee;

use Inventory\Management\Domain\Model\Entity\Employee\EmployeeRepositoryInterface;
use Inventory\Management\Domain\Model\Entity\Employee\NotFoundEmployeesException;
use Inventory\Management\Domain\Service\Employee\SearchEmployeeByNif;

class ChangeStatusToEnableEmployee
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

    public function handle(ChangeStatusToEnableEmployeeCommand $enableEmployeeCommand): array
    {
        try {
            $employee = $this->searchEmployeeByNif->execute(
                $enableEmployeeCommand->nif()
            );
        } catch (NotFoundEmployeesException $notFoundEmployeesException) {
            return ['ko' => $notFoundEmployeesException->getMessage()];
        }
        $this->employeeRepository->changeStatusToEnableEmployee($employee);

        return ['ok' => 200];
    }
}
