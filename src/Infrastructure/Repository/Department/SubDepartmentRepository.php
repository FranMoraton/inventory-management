<?php

namespace Inventory\Management\Infrastructure\Repository\Department;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Inventory\Management\Domain\Model\Entity\Department\SubDepartment;
use Inventory\Management\Domain\Model\Entity\Department\SubDepartmentRepositoryInterface;

class SubDepartmentRepository extends ServiceEntityRepository implements SubDepartmentRepositoryInterface
{
    /**
     * @param SubDepartment $subDepartment
     * @return SubDepartment
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function createSubDepartment(SubDepartment $subDepartment): SubDepartment
    {
        $this->getEntityManager()->persist($subDepartment);
        $this->getEntityManager()->flush();

        return $subDepartment;
    }

    /**
     * @param SubDepartment $subDepartment
     * @param string $name
     * @return SubDepartment
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function updateNameSubDepartment(SubDepartment $subDepartment, string $name): SubDepartment
    {
        $subDepartment->setName($name);
        $this->getEntityManager()->flush();

        return $subDepartment;
    }

    public function findSubDepartmentById(int $idSubDepartment): ?SubDepartment
    {
        /* @var SubDepartment $subDepartment */
        $subDepartment = $this->find($idSubDepartment);

        return $subDepartment;
    }

    public function checkNotExistNameSubDepartment($name): ?SubDepartment
    {
        /* @var SubDepartment $subDepartment */
        $subDepartment = $this->findOneBy(['name' => $name]);

        return $subDepartment;
    }
}
