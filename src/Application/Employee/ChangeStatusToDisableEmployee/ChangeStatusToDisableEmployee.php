<?php

namespace Inventory\Management\Application\Employee\ChangeStatusToDisableEmployee;

use Inventory\Management\Domain\Model\Entity\Employee\NotFoundEmployeesException;
use Inventory\Management\Domain\Service\Employee\SearchByNifEmployee;
use Inventory\Management\Infrastructure\Repository\Employee\EmployeeRepository;

class ChangeStatusToDisableEmployee
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
     * @param ChangeStatusToDisableEmployeeCommand $disableEmployeeCommand
     * @throws NotFoundEmployeesException
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function handle(ChangeStatusToDisableEmployeeCommand $disableEmployeeCommand): void
    {
        $employee = $this->searchByNifEmployee->execute(
            $disableEmployeeCommand->nif()
        );
        $this->employeeRepository->changeStatusToDisableEmployee($employee);
    }
}
