<?php

namespace Inventory\Management\Infrastructure\Repository\Employee;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Inventory\Management\Domain\Model\Entity\Employee\EmployeeStatus;

class EmployeeStatusRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, string $entityClass)
    {
        parent::__construct($registry, EmployeeStatus::class);
    }

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
