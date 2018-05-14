<?php

namespace Inventory\Management\Infrastructure\Repository\Department;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Inventory\Management\Domain\Model\Entity\Department\Department;
use Inventory\Management\Domain\Model\Entity\Department\DepartmentRepositoryInterface;

class DepartmentRepository extends ServiceEntityRepository implements DepartmentRepositoryInterface
{
    /**
     * @param Department $department
     * @return Department
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function createDepartment(Department $department): Department
    {
        $this->getEntityManager()->persist($department);
        $this->getEntityManager()->flush();

        return $department;
    }

    /**
     * @param Department $department
     * @param string $name
     * @return Department
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function updateNameDepartment(Department $department, string $name): Department
    {
        $department->setName($name);
        $this->getEntityManager()->flush();

        return $department;
    }

    public function findDepartmentById(int $idDepartment): ?Department
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

    public function checkNotExistNameDepartment($name): ?Department
    {
        /* @var Department $department */
        $department = $this->findOneBy(['name' => $name]);

        return $department;
    }
}
