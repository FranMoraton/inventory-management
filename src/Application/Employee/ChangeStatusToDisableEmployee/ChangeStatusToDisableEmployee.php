<?php

namespace Inventory\Management\Application\Employee\ChangeStatusToDisableEmployee;

use Inventory\Management\Domain\Model\Entity\Employee\EmployeeRepositoryInterface;
use Inventory\Management\Domain\Model\HttpResponses\HttpResponses;
use Inventory\Management\Domain\Service\Employee\SearchEmployeeByNif;
use Inventory\Management\Domain\Util\Observer\ListExceptions;

class ChangeStatusToDisableEmployee
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

    public function handle(ChangeStatusToDisableEmployeeCommand $disableEmployeeCommand): array
    {
        $employee = $this->searchEmployeeByNif->execute(
            $disableEmployeeCommand->nif()
        );
        if (ListExceptions::instance()->checkForExceptions()) {
            return ListExceptions::instance()->firstException();
        }
        $this->employeeRepository->changeStatusToDisableEmployee($employee);

        return [
            'data' => 'Se ha deshabilitado el trabajador con éxito',
            'code' => HttpResponses::OK
        ];
    }
}
