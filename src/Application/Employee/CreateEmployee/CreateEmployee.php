<?php

namespace Inventory\Management\Application\Employee\CreateEmployee;

use Inventory\Management\Domain\Model\Entity\Department\NotFoundDepartmentsException;
use Inventory\Management\Domain\Model\Entity\Employee\Employee;
use Inventory\Management\Domain\Model\Entity\Employee\EmployeeStatus;
use Inventory\Management\Domain\Service\Employee\EncryptPassword;
use Inventory\Management\Infrastructure\Repository\Department\SubDepartmentRepository;
use Inventory\Management\Infrastructure\Repository\Employee\EmployeeRepository;
use Inventory\Management\Infrastructure\Repository\Employee\EmployeeStatusRepository;

class CreateEmployee
{
    private $employeeRepository;
    private $employeeStatusRepository;
    private $subDepartmentRepository;
    private $encryptPassword;

    public function __construct(
        EmployeeRepository $employeeRepository,
        EmployeeStatusRepository $employeeStatusRepository,
        SubDepartmentRepository $subDepartmentRepository,
        EncryptPassword $encryptPassword
    ) {
        $this->employeeRepository = $employeeRepository;
        $this->employeeStatusRepository = $employeeStatusRepository;
        $this->subDepartmentRepository = $subDepartmentRepository;
        $this->encryptPassword = $encryptPassword;
    }

    /**
     * @param CreateEmployeeCommand $createEmployeeCommand
     * @throws NotFoundDepartmentsException
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function handle(CreateEmployeeCommand $createEmployeeCommand): void
    {
        $idSubDepartment = $createEmployeeCommand->subDepartment();
        $subDepartment = $this->subDepartmentRepository->findSubDepartmentById($idSubDepartment);
        if (null === $subDepartment) {
            throw new NotFoundDepartmentsException('No se ha encontrado el subdepartamento');
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
    }
}
