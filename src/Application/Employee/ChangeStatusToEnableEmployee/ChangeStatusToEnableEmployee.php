<?php

namespace Inventory\Management\Application\Employee\ChangeStatusToEnableEmployee;

use Inventory\Management\Domain\Model\Entity\Employee\NotFoundEmployeesException;
use Inventory\Management\Domain\Service\Employee\SearchEmployeeByNif;
use Inventory\Management\Infrastructure\Repository\Employee\EmployeeRepository;

class ChangeStatusToEnableEmployee
{
    private $employeeRepository;
    private $searchEmployeeByNif;

    public function __construct(
        EmployeeRepository $employeeRepository,
        SearchEmployeeByNif $searchEmployeeByNif
    ) {
        $this->employeeRepository = $employeeRepository;
        $this->searchEmployeeByNif = $searchEmployeeByNif;
    }

    /**
     * @param ChangeStatusToEnableEmployeeCommand $enableEmployeeCommand
     * @return array
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
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
