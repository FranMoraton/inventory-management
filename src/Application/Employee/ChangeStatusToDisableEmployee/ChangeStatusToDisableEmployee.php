<?php

namespace Inventory\Management\Application\Employee\ChangeStatusToDisableEmployee;

use Inventory\Management\Domain\Model\Entity\Employee\NotFoundEmployeesException;
use Inventory\Management\Domain\Service\Employee\SearchEmployeeByNif;
use Inventory\Management\Infrastructure\Repository\Employee\EmployeeRepository;

class ChangeStatusToDisableEmployee
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
     * @param ChangeStatusToDisableEmployeeCommand $disableEmployeeCommand
     * @return array
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
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
