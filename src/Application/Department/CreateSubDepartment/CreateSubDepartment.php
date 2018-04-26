<?php

namespace Inventory\Management\Application\Department\CreateSubDepartment;

use Inventory\Management\Domain\Model\Department\NotCreatedDepartmentException;
use Inventory\Management\Domain\Model\Entity\Department\SubDepartment;
use Inventory\Management\Infrastructure\Repository\Department\DepartmentRepository;
use Inventory\Management\Infrastructure\Repository\Department\SubDepartmentRepository;

class CreateSubDepartment
{
    private $departmentRepository;
    private $subDepartmentRepository;
    private $createSubDepartmentTransform;

    public function __construct(DepartmentRepository $departmentRepository,
                                SubDepartmentRepository $subDepartmentRepository,
                                CreateSubDepartmentTransformInterface $createSubDepartmentTransform)
    {
        $this->departmentRepository = $departmentRepository;
        $this->subDepartmentRepository = $subDepartmentRepository;
        $this->createSubDepartmentTransform = $createSubDepartmentTransform;
    }

    /**
     * @param CreateSubDepartmentCommand $createSubDepartmentCommand
     * @return array
     * @throws NotCreatedDepartmentException
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function handle(CreateSubDepartmentCommand $createSubDepartmentCommand): array
    {
        $idDepartment = $createSubDepartmentCommand->department();
        $nameSubDepartment = $createSubDepartmentCommand->name();
        $searchedDepartment = $this->departmentRepository->searchByIdDepartment($idDepartment);
        $subDepartment = new SubDepartment(
            $searchedDepartment,
            $nameSubDepartment
        );
        $this->subDepartmentRepository->createSubDepartment($subDepartment);

        return $this->createSubDepartmentTransform
            ->transform();
    }
}
