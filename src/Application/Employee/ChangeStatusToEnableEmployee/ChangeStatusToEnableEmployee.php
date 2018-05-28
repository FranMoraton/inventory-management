<?php

namespace Inventory\Management\Application\Employee\ChangeStatusToEnableEmployee;

use Inventory\Management\Application\Util\Role\RoleAdmin;
use Inventory\Management\Domain\Model\Entity\Employee\EmployeeRepositoryInterface;
use Inventory\Management\Domain\Model\HttpResponses\HttpResponses;
use Inventory\Management\Domain\Service\Employee\SearchEmployeeByNif;
use Inventory\Management\Domain\Service\JwtToken\CheckToken;

class ChangeStatusToEnableEmployee extends RoleAdmin
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
     * @param ChangeStatusToEnableEmployeeCommand $enableEmployeeCommand
     * @return array
     * @throws \Inventory\Management\Domain\Model\Entity\Employee\NotFoundEmployeesException
     */
    public function handle(ChangeStatusToEnableEmployeeCommand $enableEmployeeCommand): array
    {
        $employee = $this->searchEmployeeByNif->execute(
            $enableEmployeeCommand->nif()
        );
        $this->employeeRepository->changeStatusToEnableEmployee($employee);

        return [
            'data' => 'Se ha habilitado el trabajador con éxito',
            'code' => HttpResponses::OK
        ];
    }
}
