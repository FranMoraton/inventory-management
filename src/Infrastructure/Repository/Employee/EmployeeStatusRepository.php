<?php

namespace Inventory\Management\Infrastructure\Repository\Employee;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Inventory\Management\Domain\Model\Entity\Employee\EmployeeStatus;
use Inventory\Management\Domain\Model\Entity\Employee\EmployeeStatusRepositoryInterface;

class EmployeeStatusRepository extends ServiceEntityRepository implements EmployeeStatusRepositoryInterface
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

    public function checkNotExistsCodeEmployeeStatus(string $codeEmployee): ?EmployeeStatus
    {
        /* @var EmployeeStatus $employeeStatus */
        $employeeStatus = $this->findOneBy(['codeEmployee' => $codeEmployee]);

        return $employeeStatus;
    }
}
