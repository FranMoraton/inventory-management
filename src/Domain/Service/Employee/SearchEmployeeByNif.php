<?php

namespace Inventory\Management\Domain\Service\Employee;

use Inventory\Management\Domain\Model\Entity\Employee\Employee;
use Inventory\Management\Domain\Model\Entity\Employee\EmployeeRepositoryInterface;
use Inventory\Management\Domain\Model\Entity\Employee\NotFoundEmployeesException;
use Inventory\Management\Domain\Service\Util\Observer\ListExceptions;
use Inventory\Management\Domain\Service\Util\Observer\Observer;

class SearchEmployeeByNif implements Observer
{
    private $stateException;
    private $employeeRepository;

    public function __construct(EmployeeRepositoryInterface $employeeRepository)
    {
        $this->stateException = false;
        $this->employeeRepository = $employeeRepository;
    }

    /**
     * @param string $nifEmployee
     * @return Employee
     */
    public function execute(string $nifEmployee): ?Employee
    {
        $resultEmployee = $this->employeeRepository->findEmployeeByNif(
            $nifEmployee
        );
        if (null === $resultEmployee) {
            $this->stateException = true;
            ListExceptions::instance()->notify();
        }

        return $resultEmployee;
    }

    /**
     * @throws NotFoundEmployeesException
     */
    public function update()
    {
        if ($this->stateException) {
            throw new NotFoundEmployeesException();
        }
    }
}
