<?php

namespace Inventory\Management\Application\Employee\ChangeStatusToDisableEmployee;

use Inventory\Management\Domain\Model\Entity\Employee\EmployeeRepositoryInterface;
use Inventory\Management\Domain\Model\Entity\Employee\NotFoundEmployeesException;
use Inventory\Management\Domain\Service\Employee\SearchEmployeeByNif;

class ChangeStatusToDisableEmployee
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

    public function handle(ChangeStatusToDisableEmployeeCommand $disableEmployeeCommand): array
    {
        try {
            $employee = $this->searchEmployeeByNif->execute(
                $disableEmployeeCommand->nif()
            );
        } catch (NotFoundEmployeesException $notFoundEmployeesException) {
            return ['ko' => $notFoundEmployeesException->getMessage()];
        }
        $this->employeeRepository->changeStatusToDisableEmployee($employee);

        return ['ok' => 200];
    }
}