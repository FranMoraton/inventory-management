<?php

namespace Inventory\Management\Domain\Service\Employee;

use Inventory\Management\Domain\Model\Entity\Employee\Employee;
use Inventory\Management\Domain\Model\Entity\Employee\NotFoundEmployeesException;
use Inventory\Management\Infrastructure\Repository\Employee\EmployeeRepository;

class SearchByNifEmployee
{
    private $employeeRepository;

    public function __construct(EmployeeRepository $employeeRepository)
    {
        $this->employeeRepository = $employeeRepository;
    }

    /**
     * @param string $nifEmployee
     * @return Employee
     * @throws NotFoundEmployeesException
     */
    public function execute(string $nifEmployee): Employee
    {
        $resultEmployee = $this->employeeRepository->findEmployeeByNif(
            $nifEmployee
        );
        if (null === $resultEmployee) {
            throw new NotFoundEmployeesException('No se ha encontrado ningún trabajador');
        }

        return $resultEmployee;
    }
}
