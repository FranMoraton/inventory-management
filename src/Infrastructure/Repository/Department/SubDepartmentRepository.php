<?php

namespace Inventory\Management\Infrastructure\Repository\Department;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Inventory\Management\Domain\Model\Entity\Department\SubDepartment;

class SubDepartmentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, string $entityClass)
    {
        parent::__construct($registry, SubDepartment::class);
    }

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

    public function searchByIdSubDepartment(int $idSubDepartment): SubDepartment
    {
        /* @var SubDepartment $subDepartment */
        $subDepartment = $this->find($idSubDepartment);

        return $subDepartment;
    }
}
