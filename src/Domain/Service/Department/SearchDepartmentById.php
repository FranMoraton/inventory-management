<?php

namespace Inventory\Management\Domain\Service\Department;

use Inventory\Management\Domain\Model\Entity\Department\Department;
use Inventory\Management\Domain\Model\Entity\Department\DepartmentRepositoryInterface;
use Inventory\Management\Domain\Model\Entity\Department\NotFoundDepartmentsException;

class SearchDepartmentById
{
    private $departmentRepository;

    public function __construct(DepartmentRepositoryInterface $departmentRepository)
    {
        $this->departmentRepository = $departmentRepository;
    }

    /**
     * @param int $department
     * @return Department|null
     * @throws NotFoundDepartmentsException
     */
    public function execute(int $department): ?Department
    {
        $department = $this->departmentRepository->findDepartmentById($department);
        if (null === $department) {
            throw new NotFoundDepartmentsException();
        }

        return $department;
    }
}
