<?php

namespace Inventory\Management\Application\Department\CreateDepartment;

use Doctrine\ORM\ORMException;
use Inventory\Management\Domain\Model\Entity\Department\Department;
use Inventory\Management\Infrastructure\Repository\Department\DepartmentRepository;

class CreateDepartment
{
    private $departmentRepository;

    public function __construct(DepartmentRepository $departmentRepository)
    {
        $this->departmentRepository = $departmentRepository;
    }

    /**
     * @param CreateDepartmentCommand $createDepartmentCommand
     * @throws ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function handle(CreateDepartmentCommand $createDepartmentCommand): void
    {
        $department = new Department(
            $createDepartmentCommand->name()
        );
        $this->departmentRepository->createDepartment($department);
    }
}
