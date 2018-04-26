<?php

namespace Inventory\Management\Application\Employee\CreateEmployee;

use Inventory\Management\Domain\Model\Entity\Department\Department;
use Inventory\Management\Domain\Model\Entity\Department\SubDepartment;
use Inventory\Management\Domain\Model\Entity\Employee\Employee;
use Inventory\Management\Domain\Model\Entity\Employee\EmployeeStatus;
use Inventory\Management\Infrastructure\Repository\Department\SubDepartmentRepository;
use Inventory\Management\Infrastructure\Repository\Employee\EmployeeRepository;
use Inventory\Management\Infrastructure\Repository\Employee\EmployeeStatusRepository;

class CreateEmployee
{
    private const DATETIME_TYPE_ATOM = "Y-m-d\TH:i:sP";

    private $employeeRepository;
    private $employeeStatusRepository;
    private $subDepartmentRepository;
    private $createEmployeeTransform;

    public function __construct(EmployeeRepository $employeeRepository,
                                EmployeeStatusRepository $employeeStatusRepository,
                                SubDepartmentRepository $subDepartmentRepository,
                                CreateEmployeeTransformInterface $createEmployeeTransform)
    {
        $this->employeeRepository = $employeeRepository;
        $this->employeeStatusRepository = $employeeStatusRepository;
        $this->subDepartmentRepository = $subDepartmentRepository;
        $this->createEmployeeTransform = $createEmployeeTransform;
    }

    /**
     * @param CreateEmployeeCommand $createEmployeeCommand
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function handle(CreateEmployeeCommand $createEmployeeCommand)
    {
        $idSubDepartment = $createEmployeeCommand->subDepartment();
        $subDepartment = $this->subDepartmentRepository->searchByIdSubDepartment($idSubDepartment);
        $department = $subDepartment->getDepartment();
        $firstContractDate = new \DateTime($createEmployeeCommand->firstContractDate());
        $firstContractDate->format(self::DATETIME_TYPE_ATOM);
        $seniorityDate = new \DateTime($createEmployeeCommand->seniorityDate());
        $seniorityDate->format(self::DATETIME_TYPE_ATOM);
        $employeeStatus = new EmployeeStatus(
            $firstContractDate,
            $seniorityDate,
            $department,
            $subDepartment
        );
        $createdEmployeeStatus = $this->employeeStatusRepository->createEmployeeStatus($employeeStatus);
        $employee = new Employee(
            $createdEmployeeStatus,
            $createEmployeeCommand->image(),
            $createEmployeeCommand->nif(),
            $createEmployeeCommand->password(),
            $createEmployeeCommand->name(),
            $createEmployeeCommand->inSsNumber(),
            $createEmployeeCommand->telephone()
        );
        $this->employeeRepository->createEmployee($employee);

        return $this->createEmployeeTransform
            ->transform();
    }
}
