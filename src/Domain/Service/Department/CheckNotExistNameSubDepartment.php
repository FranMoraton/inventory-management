<?php

namespace Inventory\Management\Domain\Service\Department;

use Inventory\Management\Domain\Model\Entity\Department\FoundNameSubDepartmentException;
use Inventory\Management\Domain\Model\Entity\Department\SubDepartmentRepositoryInterface;

class CheckNotExistNameSubDepartment
{
    private $subDepartmentRepository;

    public function __construct(SubDepartmentRepositoryInterface $subDepartmentRepository)
    {
        $this->subDepartmentRepository = $subDepartmentRepository;
    }

    /**
     * @param string $name
     * @throws FoundNameSubDepartmentException
     */
    public function execute(string $name): void
    {
        $subDepartment = $this->subDepartmentRepository->checkNotExistNameSubDepartment($name);
        if (null !== $subDepartment) {
            throw new FoundNameSubDepartmentException();
        }
    }
}
