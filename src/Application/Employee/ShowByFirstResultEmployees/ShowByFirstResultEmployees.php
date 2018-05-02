<?php

namespace Inventory\Management\Application\Employee\ShowByFirstResultEmployees;

use Inventory\Management\Domain\Model\Entity\Employee\NotFoundEmployeesException;
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
     * @throws NotFoundEmployeesException
     */
    public function handle(ShowByFirstResultEmployeesCommand $showEmployeesCommand): array
    {
        $listEmployees = $this->employeeRepository->showByFirstResultEmployees(
            $showEmployeesCommand->firstResultPosition()
        );

        if (0 === count($listEmployees)) {
            throw new NotFoundEmployeesException('No se ha encontrado ningún trabajador');
        }

        return $this->showEmployeesTransform
            ->transform($listEmployees);
    }
}
