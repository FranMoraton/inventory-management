<?php

namespace Inventory\Management\Application\Department\CreateDepartment;

use Inventory\Management\Domain\Model\Department\NotCreatedDepartmentException;
use Inventory\Management\Domain\Model\Entity\Department\Department;
use Inventory\Management\Infrastructure\Repository\Department\DepartmentRepository;

class CreateDepartment
{
    private $departmentRepository;
    private $createDepartmentTransform;

    public function __construct(DepartmentRepository $departmentRepository,
                                CreateDepartmentTransformInterface $createDepartmentTransform)
    {
        $this->departmentRepository = $departmentRepository;
        $this->createDepartmentTransform = $createDepartmentTransform;
    }

    /**
     * @param CreateDepartmentCommand $createDepartmentCommand
     * @return array
     * @throws NotCreatedDepartmentException
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function handle(CreateDepartmentCommand $createDepartmentCommand): array
    {
        $nameDepartment = $createDepartmentCommand->name();
        $department = new Department($nameDepartment);
        $this->departmentRepository->createDepartment($department);

        return $this->createDepartmentTransform
            ->transform();
    }
}
