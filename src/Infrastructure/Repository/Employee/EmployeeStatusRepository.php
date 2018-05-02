<?php

namespace Inventory\Management\Infrastructure\Repository\Employee;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Inventory\Management\Domain\Model\Entity\Employee\EmployeeStatus;

class EmployeeStatusRepository extends ServiceEntityRepository
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
