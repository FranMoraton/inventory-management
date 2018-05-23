<?php

namespace Inventory\Management\Application\Employee\UpdateFieldsEmployeeStatus;

use Inventory\Management\Application\Util\Role\RoleAdmin;
use Inventory\Management\Domain\Model\Entity\Employee\EmployeeRepositoryInterface;
use Inventory\Management\Domain\Model\HttpResponses\HttpResponses;
use Inventory\Management\Domain\Service\Department\SearchDepartmentById;
use Inventory\Management\Domain\Service\Department\SearchSubDepartmentById;
use Inventory\Management\Domain\Service\Employee\SearchEmployeeByNif;
use Inventory\Management\Domain\Service\JwtToken\CheckToken;

class UpdateFieldsEmployeeStatus extends RoleAdmin
{
    private $employeeRepository;
    private $searchEmployeeByNif;
    private $searchDepartmentById;
    private $searchSubDepartmentById;

    public function __construct(
        EmployeeRepositoryInterface $employeeRepository,
        SearchEmployeeByNif $searchEmployeeByNif,
        SearchDepartmentById $searchDepartmentById,
        SearchSubDepartmentById $searchSubDepartmentById,
        CheckToken $checkToken
    ) {
        parent::__construct($checkToken);
        $this->employeeRepository = $employeeRepository;
        $this->searchEmployeeByNif = $searchEmployeeByNif;
        $this->searchDepartmentById = $searchDepartmentById;
        $this->searchSubDepartmentById = $searchSubDepartmentById;
    }

    /**
     * @param UpdateFieldsEmployeeStatusCommand $updateFieldsEmployeeStatusCommand
     * @return array
     * @throws \Inventory\Management\Domain\Model\Entity\Department\NotFoundDepartmentsException
     * @throws \Inventory\Management\Domain\Model\Entity\Department\NotFoundSubDepartmentsException
     * @throws \Inventory\Management\Domain\Model\Entity\Employee\NotFoundEmployeesException
     */
    public function handle(UpdateFieldsEmployeeStatusCommand $updateFieldsEmployeeStatusCommand): array
    {
        $this->checkToken();
        $department = $this->searchDepartmentById->execute(
            $updateFieldsEmployeeStatusCommand->department()
        );
        $subDepartment = $this->searchSubDepartmentById->execute(
            $updateFieldsEmployeeStatusCommand->subDepartment()
        );
        $employee = $this->searchEmployeeByNif->execute(
            $updateFieldsEmployeeStatusCommand->nif()
        );
        $this->employeeRepository->updateFieldsEmployeeStatus(
            $employee,
            $updateFieldsEmployeeStatusCommand->image(),
            new \DateTime($updateFieldsEmployeeStatusCommand->expirationContractDate()),
            new \DateTime($updateFieldsEmployeeStatusCommand->possibleRenewal()),
            $updateFieldsEmployeeStatusCommand->availableHolidays(),
            $updateFieldsEmployeeStatusCommand->holidaysPendingToApplyFor(),
            $department,
            $subDepartment
        );

        return [
            'data' => 'Se ha actualizado el estado del trabajador con éxito',
            'code' => HttpResponses::OK
        ];
    }
}
