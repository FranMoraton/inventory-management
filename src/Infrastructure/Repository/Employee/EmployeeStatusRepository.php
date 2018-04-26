<?php

namespace Inventory\Management\Infrastructure\Repository\Employee;

use Doctrine\ORM\EntityRepository;
use Inventory\Management\Domain\Model\Entity\Employee\EmployeeStatus;

class EmployeeStatusRepository extends EntityRepository
{
    /**
     * @param EmployeeStatus $employeeStatus
     * @return EmployeeStatus
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function createEmployeeStatus(EmployeeStatus $employeeStatus): EmployeeStatus
    {
        $this->getEntityManager()->persist($employeeStatus);
        $this->getEntityManager()->flush();

        return $employeeStatus;
    }
}
