<?php

namespace Inventory\Management\Application\Employee\ChangeStatusToEnableEmployee;

use Inventory\Management\Domain\Model\Entity\Employee\EmployeeRepositoryInterface;
use Inventory\Management\Domain\Model\Entity\Employee\NotFoundEmployeesException;
use Inventory\Management\Domain\Service\Employee\SearchEmployeeByNif;
use Inventory\Management\Domain\Service\Util\Observer\ListExceptions;

class ChangeStatusToEnableEmployee
{
    private $employeeRepository;
    private $searchEmployeeByNif;

    public function __construct(
        EmployeeRepositoryInterface $employeeRepository,
        SearchEmployeeByNif $searchEmployeeByNif
    ) {
        $this->employeeRepository = $employeeRepository;
        $this->searchEmployeeByNif = $searchEmployeeByNif;
        ListExceptions::instance()->restartExceptions();
        ListExceptions::instance()->attach($searchEmployeeByNif);
    }

    public function handle(ChangeStatusToEnableEmployeeCommand $enableEmployeeCommand): array
    {
        $employee = $this->searchEmployeeByNif->execute(
            $enableEmployeeCommand->nif()
        );
        if (ListExceptions::instance()->checkForExceptions()) {
            return ListExceptions::instance()->firstException();
        }
        $this->employeeRepository->changeStatusToEnableEmployee($employee);

        return [
            'data' => 'Se ha habilitado el trabajador con éxito',
            'code' => 200
        ];
    }
}
