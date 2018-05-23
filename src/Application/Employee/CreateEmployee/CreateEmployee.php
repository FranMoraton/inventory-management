<?php

namespace Inventory\Management\Application\Employee\CreateEmployee;

use Inventory\Management\Application\Util\Role\RoleAdmin;
use Inventory\Management\Domain\Model\Entity\Employee\Employee;
use Inventory\Management\Domain\Model\Entity\Employee\EmployeeRepositoryInterface;
use Inventory\Management\Domain\Model\Entity\Employee\EmployeeStatus;
use Inventory\Management\Domain\Model\Entity\Employee\EmployeeStatusRepositoryInterface;
use Inventory\Management\Domain\Model\HttpResponses\HttpResponses;
use Inventory\Management\Domain\Service\Department\SearchSubDepartmentById;
use Inventory\Management\Domain\Service\Employee\CheckNotExistsUniqueFields;
use Inventory\Management\Domain\Service\JwtToken\CheckToken;
use Inventory\Management\Domain\Service\PasswordHash\EncryptPassword;

class CreateEmployee extends RoleAdmin
{
    private $employeeRepository;
    private $employeeStatusRepository;
    private $searchSubDepartmentById;
    private $checkNotExistsUniqueFields;
    private $encryptPassword;

    public function __construct(
        EmployeeRepositoryInterface $employeeRepository,
        EmployeeStatusRepositoryInterface $employeeStatusRepository,
        SearchSubDepartmentById $searchSubDepartmentById,
        CheckNotExistsUniqueFields $checkNotExistsUniqueFields,
        EncryptPassword $encryptPassword,
        CheckToken $checkToken
    ) {
        parent::__construct($checkToken);
        $this->employeeRepository = $employeeRepository;
        $this->employeeStatusRepository = $employeeStatusRepository;
        $this->searchSubDepartmentById = $searchSubDepartmentById;
        $this->checkNotExistsUniqueFields = $checkNotExistsUniqueFields;
        $this->encryptPassword = $encryptPassword;
    }

    /**
     * @param CreateEmployeeCommand $createEmployeeCommand
     * @return array
     * @throws \Inventory\Management\Domain\Model\Entity\Department\NotFoundSubDepartmentsException
     * @throws \Inventory\Management\Domain\Model\Entity\Employee\FoundCodeEmployeeStatusException
     * @throws \Inventory\Management\Domain\Model\Entity\Employee\FoundInSsNumberEmployeeException
     * @throws \Inventory\Management\Domain\Model\Entity\Employee\FoundNifEmployeeException
     * @throws \Inventory\Management\Domain\Model\Entity\Employee\FoundTelephoneEmployeeException
     */
    public function handle(CreateEmployeeCommand $createEmployeeCommand): array
    {
        $this->checkToken();
        $this->checkNotExistsUniqueFields->execute(
            $createEmployeeCommand->nif(),
            $createEmployeeCommand->inSsNumber(),
            $createEmployeeCommand->telephone(),
            $createEmployeeCommand->codeEmployee()
        );
        $subDepartment = $this->searchSubDepartmentById->execute(
            $createEmployeeCommand->subDepartment()
        );
        $employeeStatus = new EmployeeStatus(
            $createEmployeeCommand->codeEmployee(),
            new \DateTime($createEmployeeCommand->firstContractDate()),
            new \DateTime($createEmployeeCommand->seniorityDate()),
            $subDepartment->getDepartment(),
            $subDepartment
        );
        $createdEmployeeStatus = $this->employeeStatusRepository->createEmployeeStatus($employeeStatus);
        $password = $this->encryptPassword->execute(
            $createEmployeeCommand->password()
        );
        $employee = new Employee(
            $createdEmployeeStatus,
            $createEmployeeCommand->image(),
            $createEmployeeCommand->nif(),
            $password,
            $createEmployeeCommand->name(),
            $createEmployeeCommand->inSsNumber(),
            $createEmployeeCommand->telephone()
        );
        $this->employeeRepository->createEmployee($employee);

        return [
            'data' => 'Se ha creado el trabajador con éxito',
            'code' => HttpResponses::OK_CREATED
        ];
    }
}
