<?php

namespace Inventory\Management\Domain\Service\Department;

use Inventory\Management\Domain\Model\Entity\Department\NotFoundSubDepartmentsException;
use Inventory\Management\Domain\Model\Entity\Department\SubDepartment;
use Inventory\Management\Domain\Model\Entity\Department\SubDepartmentRepositoryInterface;

class SearchSubDepartmentById
{
    private $subDepartmentRepository;

    public function __construct(SubDepartmentRepositoryInterface $subDepartmentRepository)
    {
        $this->subDepartmentRepository = $subDepartmentRepository;
    }

    /**
     * @param int $subDepartment
     * @return SubDepartment|null
     * @throws NotFoundSubDepartmentsException
     */
    public function execute(int $subDepartment): ?SubDepartment
    {
        $subDepartment = $this->subDepartmentRepository->findSubDepartmentById($subDepartment);
        if (null === $subDepartment) {
            throw new NotFoundSubDepartmentsException();
        }

        return $subDepartment;
    }
}
