<?php

namespace Inventory\Management\Domain\Service\Department;

use Inventory\Management\Domain\Model\Entity\Department\Department;
use Inventory\Management\Domain\Model\Entity\Department\DepartmentRepositoryInterface;
use Inventory\Management\Domain\Model\Entity\Department\NotFoundDepartmentsException;
use Inventory\Management\Domain\Util\Observer\ListExceptions;
use Inventory\Management\Domain\Util\Observer\Observer;

class SearchDepartmentById implements Observer
{
    private $stateException;
    private $departmentRepository;

    public function __construct(DepartmentRepositoryInterface $departmentRepository)
    {
        $this->stateException = false;
        $this->departmentRepository = $departmentRepository;
    }

    public function execute(int $department): ?Department
    {
        $department = $this->departmentRepository->findDepartmentById($department);
        if (null === $department) {
            $this->stateException = true;
            ListExceptions::instance()->notify();
        }

        return $department;
    }

    /**
     * @throws NotFoundDepartmentsException
     */
    public function update()
    {
        if ($this->stateException) {
            throw new NotFoundDepartmentsException();
        }
    }
}
