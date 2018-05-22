<?php

namespace Inventory\Management\Domain\Service\Employee;

use Inventory\Management\Domain\Model\Entity\Employee\Employee;
use Inventory\Management\Domain\Model\Entity\Employee\EmployeeRepositoryInterface;
use Inventory\Management\Domain\Model\Entity\Employee\NotFoundEmployeesException;

class SearchEmployeeByNif
{
    private $employeeRepository;

    public function __construct(EmployeeRepositoryInterface $employeeRepository)
    {
        $this->employeeRepository = $employeeRepository;
    }

    /**
     * @param string $nifEmployee
     * @return Employee|null
     * @throws NotFoundEmployeesException
     */
    public function execute(string $nifEmployee): ?Employee
    {
        $resultEmployee = $this->employeeRepository->findEmployeeByNif($nifEmployee);
        if (null === $resultEmployee) {
            throw new NotFoundEmployeesException();
        }

        return $resultEmployee;
    }
}
