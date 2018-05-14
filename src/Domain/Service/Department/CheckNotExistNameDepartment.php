<?php

namespace Inventory\Management\Domain\Service\Department;

use Inventory\Management\Domain\Model\Entity\Department\DepartmentRepositoryInterface;
use Inventory\Management\Domain\Model\Entity\Department\FoundNameDepartmentException;

class CheckNotExistNameDepartment
{
    private $departmentRepository;

    public function __construct(DepartmentRepositoryInterface $departmentRepository)
    {
        $this->departmentRepository = $departmentRepository;
    }

    /**
     * @param string $name
     * @throws FoundNameDepartmentException
     */
    public function execute(string $name): void
    {
        $department = $this->departmentRepository->checkNotExistNameDepartment($name);
        if (null !== $department) {
            throw new FoundNameDepartmentException();
        }
    }
}
