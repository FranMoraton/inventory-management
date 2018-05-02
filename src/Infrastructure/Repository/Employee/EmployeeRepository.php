<?php

namespace Inventory\Management\Infrastructure\Repository\Employee;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Inventory\Management\Domain\Model\Entity\Employee\Employee;

class EmployeeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, string $entityClass)
    {
        parent::__construct($registry, Employee::class);
    }

    /**
     * @param Employee $employee
     * @return Employee
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function createEmployee(Employee $employee): Employee
    {
        $this->getEntityManager()->persist($employee);
        $this->getEntityManager()->flush();

        return $employee;
    }

    /**
     * @param string $nif
     * @return Employee
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function changeStatusToDisableEmployee(string $nif): Employee
    {
        $query = $this->createQueryBuilder('es')
            ->andWhere('es.nif = :nif')
            ->setParameter('nif', $nif)
            ->getQuery();
        $employees = $query->execute();
        $updatedEmployee = null;
        /* @var Employee $employee */
        foreach ($employees as $employee) {
            $employee->getEmployeeStatus()
                ->setDisabledEmployee(true);

            $updatedEmployee = $employee;
        }
        $this->getEntityManager()->flush();

        return $updatedEmployee;
    }
}
