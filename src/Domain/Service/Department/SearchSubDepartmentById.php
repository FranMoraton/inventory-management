<?php

namespace Inventory\Management\Domain\Service\Department;

use Inventory\Management\Domain\Model\Entity\Department\NotFoundSubDepartmentsException;
use Inventory\Management\Domain\Model\Entity\Department\SubDepartment;
use Inventory\Management\Domain\Model\Entity\Department\SubDepartmentRepositoryInterface;
use Inventory\Management\Domain\Util\Observer\ListExceptions;
use Inventory\Management\Domain\Util\Observer\Observer;

class SearchSubDepartmentById implements Observer
{
    private $stateException;
    private $subDepartmentRepository;

    public function __construct(SubDepartmentRepositoryInterface $subDepartmentRepository)
    {
        $this->stateException = false;
        $this->subDepartmentRepository = $subDepartmentRepository;
    }

    public function execute(int $subDepartment): ?SubDepartment
    {
        $subDepartment = $this->subDepartmentRepository->findSubDepartmentById($subDepartment);
        if (null === $subDepartment) {
            $this->stateException = true;
            ListExceptions::instance()->notify();
        }

        return $subDepartment;
    }

    /**
     * @throws NotFoundSubDepartmentsException
     */
    public function update()
    {
        if ($this->stateException) {
            throw new NotFoundSubDepartmentsException();
        }
    }
}
