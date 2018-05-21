<?php

namespace Inventory\Management\Domain\Service\Department;

use Inventory\Management\Domain\Model\Entity\Department\DepartmentRepositoryInterface;
use Inventory\Management\Domain\Model\Entity\Department\FoundNameDepartmentException;
use Inventory\Management\Domain\Util\Observer\ListExceptions;
use Inventory\Management\Domain\Util\Observer\Observer;

class CheckNotExistNameDepartment implements Observer
{
    private $stateException;
    private $departmentRepository;

    public function __construct(DepartmentRepositoryInterface $departmentRepository)
    {
        $this->stateException = false;
        $this->departmentRepository = $departmentRepository;
    }

    public function execute(string $name): void
    {
        $department = $this->departmentRepository->checkNotExistNameDepartment($name);
        if (null !== $department) {
            $this->stateException = true;
            ListExceptions::instance()->notify();
        }
    }

    /**
     * @throws FoundNameDepartmentException
     */
    public function update()
    {
        if ($this->stateException) {
            throw new FoundNameDepartmentException();
        }
    }
}
