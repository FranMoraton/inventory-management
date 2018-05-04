<?php

namespace Inventory\Management\Application\Employee\UpdateAllOfEmployee;

use Inventory\Management\Infrastructure\Repository\Employee\EmployeeRepository;

class UpdateAllOfEmployee
{
    private $employeeRepository;

    public function __construct(EmployeeRepository $employeeRepository)
    {
        $this->employeeRepository = $employeeRepository;
    }

    public function handle(UpdateAllOfEmployeeCommand $updateAllOfEmployeeCommand)
    {

    }
}
