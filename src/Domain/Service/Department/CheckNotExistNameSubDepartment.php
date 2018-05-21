<?php

namespace Inventory\Management\Domain\Service\Department;

use Inventory\Management\Domain\Model\Entity\Department\FoundNameSubDepartmentException;
use Inventory\Management\Domain\Model\Entity\Department\SubDepartmentRepositoryInterface;
use Inventory\Management\Domain\Util\Observer\ListExceptions;
use Inventory\Management\Domain\Util\Observer\Observer;

class CheckNotExistNameSubDepartment implements Observer
{
    private $stateException;
    private $subDepartmentRepository;

    public function __construct(SubDepartmentRepositoryInterface $subDepartmentRepository)
    {
        $this->stateException = false;
        $this->subDepartmentRepository = $subDepartmentRepository;
    }

    public function execute(string $name): void
    {
        $subDepartment = $this->subDepartmentRepository->checkNotExistNameSubDepartment($name);
        if (null !== $subDepartment) {
            $this->stateException = true;
            ListExceptions::instance()->notify();
        }
    }

    /**
     * @throws FoundNameSubDepartmentException
     */
    public function update()
    {
        if ($this->stateException) {
            throw new FoundNameSubDepartmentException();
        }
    }
}
