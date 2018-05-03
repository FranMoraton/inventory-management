<?php

namespace Inventory\Management\Application\Employee\ChangeStatusToEnableEmployee;

use Inventory\Management\Domain\Model\Entity\Employee\NotFoundEmployeesException;
use Inventory\Management\Domain\Service\Employee\SearchByNifEmployee;
use Inventory\Management\Infrastructure\Repository\Employee\EmployeeRepository;

class ChangeStatusToEnableEmployee
{
    private $employeeRepository;
    private $searchByNifEmployee;

    public function __construct(
        EmployeeRepository $employeeRepository,
        SearchByNifEmployee $searchByNifEmployee
    ) {
        $this->employeeRepository = $employeeRepository;
        $this->searchByNifEmployee = $searchByNifEmployee;
    }

    /**
     * @param ChangeStatusToEnableEmployeeCommand $enableEmployeeCommand
     * @throws NotFoundEmployeesException
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function handle(ChangeStatusToEnableEmployeeCommand $enableEmployeeCommand): void
    {
        $employee = $this->searchByNifEmployee->execute(
            $enableEmployeeCommand->nif()
        );
        $this->employeeRepository->changeStatusToEnableEmployee($employee);
    }
}
