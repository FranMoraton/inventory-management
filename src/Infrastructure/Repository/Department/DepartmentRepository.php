<?php

namespace Inventory\Management\Infrastructure\Repository\Department;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Inventory\Management\Domain\Model\Entity\Department\Department;

class DepartmentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, string $entityClass)
    {
        parent::__construct($registry, Department::class);
    }

    /**
     * @param Department $department
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function createDepartment(Department $department): Department
    {
        $this->getEntityManager()->persist($department);
        $this->getEntityManager()->flush();

        return $department;
    }

    public function searchByIdDepartment(int $idDepartment): Department
    {
        /* @var Department $department */
        $department = $this->find($idDepartment);

        return $department;
    }

    public function showAllDepartments(): array
    {
        $departments = $this->findAll();

        return $departments;
    }
}
