<?php

namespace Inventory\Management\Application\Employee\ChangeStatusToDisableEmployee;

use Inventory\Management\Domain\Model\Employee\NotFoundEmployeeException;
use Inventory\Management\Infrastructure\Repository\Employee\EmployeeRepository;

class ChangeStatusToDisableEmployee
{
    private $employeeRepository;
    private $changeStatusToDisableEmployeeTransform;

    public function __construct(
        EmployeeRepository $employeeRepository,
        ChangeStatusToDisableEmployeeTransformInterface $changeStatusToDisableEmployeeTransform
    ) {
        $this->employeeRepository = $employeeRepository;
        $this->changeStatusToDisableEmployeeTransform = $changeStatusToDisableEmployeeTransform;
    }

    /**
     * @param ChangeStatusToDisableEmployeeCommand $disableEmployeeCommand
     * @return array
     * @throws NotFoundEmployeeException
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function handle(ChangeStatusToDisableEmployeeCommand $disableEmployeeCommand): array
    {
        $nif = $disableEmployeeCommand->nif();
        $updatedEmployee = $this->employeeRepository->changeStatusToDisableEmployee($nif);
        if (null === $updatedEmployee) {
            throw new NotFoundEmployeeException('No se ha encontrado ningún trabajador');
        }

        return $this->changeStatusToDisableEmployeeTransform
            ->transform();
    }
}
