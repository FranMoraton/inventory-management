<?php

namespace Inventory\Management\Application\Employee\ShowByFirstResultEmployees;

use Inventory\Management\Infrastructure\Repository\Employee\EmployeeRepository;

class ShowByFirstResultEmployees
{
    private $employeeRepository;
    private $showEmployeesTransform;

    public function __construct(
        EmployeeRepository $employeeRepository,
        ShowByFirstResultEmployeesTransformInterface $showEmployeesTransform
    ) {
        $this->employeeRepository = $employeeRepository;
        $this->showEmployeesTransform = $showEmployeesTransform;
    }

    /**
     * @param ShowByFirstResultEmployeesCommand $showEmployeesCommand
     * @return array
     */
    public function handle(ShowByFirstResultEmployeesCommand $showEmployeesCommand): array
    {
        $listEmployees = $this->employeeRepository->showByFirstResultEmployees(
            $showEmployeesCommand->firstResultPosition()
        );
        if (0 === count($listEmployees)) {
            return ['ko' => 'No se han encontrado trabajadores'];
        }

        return $this->showEmployeesTransform
            ->transform($listEmployees);
    }
}
