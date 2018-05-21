<?php

namespace Inventory\Management\Application\Employee\CreateEmployee;

use Inventory\Management\Domain\Model\Entity\Employee\Employee;
use Inventory\Management\Domain\Model\Entity\Employee\EmployeeRepositoryInterface;
use Inventory\Management\Domain\Model\Entity\Employee\EmployeeStatus;
use Inventory\Management\Domain\Model\Entity\Employee\EmployeeStatusRepositoryInterface;
use Inventory\Management\Domain\Model\HttpResponses\HttpResponses;
use Inventory\Management\Domain\Service\Department\SearchSubDepartmentById;
use Inventory\Management\Domain\Service\Employee\CheckNotExistsUniqueFields;
use Inventory\Management\Domain\Service\Util\EncryptPassword;
use Inventory\Management\Domain\Util\Observer\ListExceptions;

class CreateEmployee
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
        EncryptPassword $encryptPassword
    ) {
        $this->employeeRepository = $employeeRepository;
        $this->employeeStatusRepository = $employeeStatusRepository;
        $this->searchSubDepartmentById = $searchSubDepartmentById;
        $this->checkNotExistsUniqueFields = $checkNotExistsUniqueFields;
        $this->encryptPassword = $encryptPassword;
        ListExceptions::instance()->restartExceptions();
        ListExceptions::instance()->attach($checkNotExistsUniqueFields);
        ListExceptions::instance()->attach($searchSubDepartmentById);
    }

    public function handle(CreateEmployeeCommand $createEmployeeCommand): array
    {
        $this->checkNotExistsUniqueFields->execute(
            $createEmployeeCommand->nif(),
            $createEmployeeCommand->inSsNumber(),
            $createEmployeeCommand->telephone(),
            $createEmployeeCommand->codeEmployee()
        );
        $subDepartment = $this->searchSubDepartmentById->execute(
            $createEmployeeCommand->subDepartment()
        );
        if (ListExceptions::instance()->checkForExceptions()) {
            return ListExceptions::instance()->firstException();
        }
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
