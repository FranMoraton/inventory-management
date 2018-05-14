<?php

namespace Inventory\Management\Application\Employee\CreateEmployee;

use Inventory\Management\Domain\Model\Entity\Department\NotFoundSubDepartmentsException;
use Inventory\Management\Domain\Model\Entity\Employee\Employee;
use Inventory\Management\Domain\Model\Entity\Employee\EmployeeRepositoryInterface;
use Inventory\Management\Domain\Model\Entity\Employee\EmployeeStatus;
use Inventory\Management\Domain\Model\Entity\Employee\EmployeeStatusRepositoryInterface;
use Inventory\Management\Domain\Model\Entity\Employee\FoundCodeEmployeeStatusException;
use Inventory\Management\Domain\Model\Entity\Employee\FoundInSsNumberEmployeeException;
use Inventory\Management\Domain\Model\Entity\Employee\FoundNifEmployeeException;
use Inventory\Management\Domain\Model\Entity\Employee\FoundTelephoneEmployeeException;
use Inventory\Management\Domain\Service\Department\SearchSubDepartmentById;
use Inventory\Management\Domain\Service\Employee\CheckNotExistsUniqueColumns;
use Inventory\Management\Domain\Service\Employee\EncryptPassword;

class CreateEmployee
{
    private $employeeRepository;
    private $employeeStatusRepository;
    private $searchSubDepartmentById;
    private $checkNotExistsUniqueColumns;
    private $encryptPassword;

    public function __construct(
        EmployeeRepositoryInterface $employeeRepository,
        EmployeeStatusRepositoryInterface $employeeStatusRepository,
        SearchSubDepartmentById $searchSubDepartmentById,
        CheckNotExistsUniqueColumns $checkNotExistsUniqueColumns,
        EncryptPassword $encryptPassword
    ) {
        $this->employeeRepository = $employeeRepository;
        $this->employeeStatusRepository = $employeeStatusRepository;
        $this->searchSubDepartmentById = $searchSubDepartmentById;
        $this->checkNotExistsUniqueColumns = $checkNotExistsUniqueColumns;
        $this->encryptPassword = $encryptPassword;
    }

    public function handle(CreateEmployeeCommand $createEmployeeCommand): array
    {
        try {
            $subDepartment = $this->searchSubDepartmentById->execute(
                $createEmployeeCommand->subDepartment()
            );
        } catch (NotFoundSubDepartmentsException $notFoundSubDepartmentsException) {
            return ['ko' => $notFoundSubDepartmentsException->getMessage()];
        }
        try {
            $this->checkNotExistsUniqueColumns->execute(
                $createEmployeeCommand->nif(),
                $createEmployeeCommand->inSsNumber(),
                $createEmployeeCommand->telephone(),
                $createEmployeeCommand->codeEmployee()
            );
        } catch (FoundNifEmployeeException $foundNifEmployeeException) {
            return ['ko' => $foundNifEmployeeException->getMessage()];
        } catch (FoundInSsNumberEmployeeException $foundInSsNumberEmployeeException) {
            return ['ko' => $foundInSsNumberEmployeeException->getMessage()];
        } catch (FoundTelephoneEmployeeException $foundTelephoneEmployeeException) {
            return ['ko' => $foundTelephoneEmployeeException->getMessage()];
        } catch (FoundCodeEmployeeStatusException $foundCodeEmployeeStatusException) {
            return ['ko' => $foundCodeEmployeeStatusException->getMessage()];
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

        return ['ok' => 200];
    }
}
