<?php

namespace Inventory\Management\Application\Employee\ShowByFirstResultEmployees;

use Inventory\Management\Domain\Model\Entity\Employee\EmployeeRepositoryInterface;

class ShowByFirstResultEmployees
{
    private $employeeRepository;
    private $showEmployeesTransform;

    public function __construct(
        EmployeeRepositoryInterface $employeeRepository,
        ShowByFirstResultEmployeesTransformInterface $showEmployeesTransform
    ) {
        $this->employeeRepository = $employeeRepository;
        $this->showEmployeesTransform = $showEmployeesTransform;
    }

    public function handle(ShowByFirstResultEmployeesCommand $showEmployeesCommand): array
    {
        $listEmployees = $this->employeeRepository->showByFirstResultEmployees(
            $showEmployeesCommand->firstResultPosition()
        );

        return [
            'data' => $this->showEmployeesTransform->transform($listEmployees),
            'code' => 200
        ];
    }
}
