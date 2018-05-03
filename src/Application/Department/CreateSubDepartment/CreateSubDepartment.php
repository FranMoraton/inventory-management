<?php

namespace Inventory\Management\Application\Department\CreateSubDepartment;

use Doctrine\ORM\ORMException;
use Inventory\Management\Domain\Model\Entity\Department\NotFoundDepartmentsException;
use Inventory\Management\Domain\Model\Entity\Department\SubDepartment;
use Inventory\Management\Infrastructure\Repository\Department\DepartmentRepository;
use Inventory\Management\Infrastructure\Repository\Department\SubDepartmentRepository;

class CreateSubDepartment
{
    private $departmentRepository;
    private $subDepartmentRepository;

    public function __construct(
        DepartmentRepository $departmentRepository,
        SubDepartmentRepository $subDepartmentRepository
    ) {
        $this->departmentRepository = $departmentRepository;
        $this->subDepartmentRepository = $subDepartmentRepository;
    }

    /**
     * @param CreateSubDepartmentCommand $createSubDepartmentCommand
     * @throws NotFoundDepartmentsException
     * @throws ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function handle(CreateSubDepartmentCommand $createSubDepartmentCommand): void
    {
        $department = $this->departmentRepository->findDepartmentById(
            $createSubDepartmentCommand->department()
        );
        if (null === $department) {
            throw new NotFoundDepartmentsException('No se ha encontrado el departamento');
        }
        $subDepartment = new SubDepartment(
            $department,
            $createSubDepartmentCommand->name()
        );
        $this->subDepartmentRepository->createSubDepartment($subDepartment);
    }
}
