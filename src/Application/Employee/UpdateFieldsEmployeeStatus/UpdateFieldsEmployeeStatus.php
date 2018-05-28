<?php

namespace Inventory\Management\Application\Employee\UpdateFieldsEmployeeStatus;

use Inventory\Management\Application\Util\Role\RoleAdmin;
use Inventory\Management\Domain\Model\Entity\Employee\Employee;
use Inventory\Management\Domain\Model\Entity\Employee\EmployeeRepositoryInterface;
use Inventory\Management\Domain\Model\HttpResponses\HttpResponses;
use Inventory\Management\Domain\Service\Department\SearchDepartmentById;
use Inventory\Management\Domain\Service\Department\SearchSubDepartmentById;
use Inventory\Management\Domain\Service\Employee\SearchEmployeeByNif;
use Inventory\Management\Domain\Service\File\UploadPhoto;
use Inventory\Management\Domain\Service\JwtToken\CheckToken;

class UpdateFieldsEmployeeStatus extends RoleAdmin
{
    private $employeeRepository;
    private $searchEmployeeByNif;
    private $searchDepartmentById;
    private $searchSubDepartmentById;
    private $uploadPhoto;

    public function __construct(
        EmployeeRepositoryInterface $employeeRepository,
        SearchEmployeeByNif $searchEmployeeByNif,
        SearchDepartmentById $searchDepartmentById,
        SearchSubDepartmentById $searchSubDepartmentById,
        UploadPhoto $uploadPhoto,
        CheckToken $checkToken
    ) {
        parent::__construct($checkToken);
        $this->employeeRepository = $employeeRepository;
        $this->searchEmployeeByNif = $searchEmployeeByNif;
        $this->searchDepartmentById = $searchDepartmentById;
        $this->searchSubDepartmentById = $searchSubDepartmentById;
        $this->uploadPhoto = $uploadPhoto;
    }

    /**
     * @param UpdateFieldsEmployeeStatusCommand $updateFieldsEmployeeStatusCommand
     * @return array
     * @throws \Inventory\Management\Domain\Model\Entity\Department\NotFoundDepartmentsException
     * @throws \Inventory\Management\Domain\Model\Entity\Department\NotFoundSubDepartmentsException
     * @throws \Inventory\Management\Domain\Model\Entity\Employee\NotFoundEmployeesException
     * @throws \Inventory\Management\Domain\Model\File\ImageCanNotUploadException
     */
    public function handle(UpdateFieldsEmployeeStatusCommand $updateFieldsEmployeeStatusCommand): array
    {
        $department = $this->searchDepartmentById->execute(
            $updateFieldsEmployeeStatusCommand->department()
        );
        $subDepartment = $this->searchSubDepartmentById->execute(
            $updateFieldsEmployeeStatusCommand->subDepartment()
        );
        $employee = $this->searchEmployeeByNif->execute(
            $updateFieldsEmployeeStatusCommand->nif()
        );
        $imageName = $this->uploadPhoto->execute(
            $updateFieldsEmployeeStatusCommand->image(),
            Employee::URL_IMAGE
        );
        $this->employeeRepository->updateFieldsEmployeeStatus(
            $employee,
            $imageName,
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
