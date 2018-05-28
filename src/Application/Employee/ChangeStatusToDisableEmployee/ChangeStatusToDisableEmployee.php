<?php

namespace Inventory\Management\Application\Employee\ChangeStatusToDisableEmployee;

use Inventory\Management\Application\Util\Role\RoleAdmin;
use Inventory\Management\Domain\Model\Entity\Employee\EmployeeRepositoryInterface;
use Inventory\Management\Domain\Model\HttpResponses\HttpResponses;
use Inventory\Management\Domain\Service\Employee\SearchEmployeeByNif;
use Inventory\Management\Domain\Service\JwtToken\CheckToken;

class ChangeStatusToDisableEmployee extends RoleAdmin
{
    private $employeeRepository;
    private $searchEmployeeByNif;

    public function __construct(
        EmployeeRepositoryInterface $employeeRepository,
        SearchEmployeeByNif $searchEmployeeByNif,
        CheckToken $checkToken
    ) {
        parent::__construct($checkToken);
        $this->employeeRepository = $employeeRepository;
        $this->searchEmployeeByNif = $searchEmployeeByNif;
    }

    /**
     * @param ChangeStatusToDisableEmployeeCommand $disableEmployeeCommand
     * @return array
     * @throws \Inventory\Management\Domain\Model\Entity\Employee\NotFoundEmployeesException
     */
    public function handle(ChangeStatusToDisableEmployeeCommand $disableEmployeeCommand): array
    {
        $employee = $this->searchEmployeeByNif->execute(
            $disableEmployeeCommand->nif()
        );
        $this->employeeRepository->changeStatusToDisableEmployee($employee);

        return [
            'data' => 'Se ha deshabilitado el trabajador con éxito',
            'code' => HttpResponses::OK
        ];
    }
}
