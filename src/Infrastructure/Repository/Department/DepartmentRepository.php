<?php

namespace Inventory\Management\Infrastructure\Repository\Department;

use Doctrine\ORM\EntityRepository;
use Inventory\Management\Domain\Model\Entity\Department\Department;

class DepartmentRepository extends EntityRepository
{
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
