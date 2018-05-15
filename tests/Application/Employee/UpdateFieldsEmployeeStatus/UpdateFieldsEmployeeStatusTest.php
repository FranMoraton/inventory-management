<?php

namespace Inventory\Management\Tests\Application\Employee\UpdateFieldsEmployeeStatus;

use Inventory\Management\Application\Employee\UpdateFieldsEmployeeStatus\UpdateFieldsEmployeeStatus;
use Inventory\Management\Application\Employee\UpdateFieldsEmployeeStatus\UpdateFieldsEmployeeStatusCommand;
use Inventory\Management\Domain\Model\Entity\Department\Department;
use Inventory\Management\Domain\Model\Entity\Department\SubDepartment;
use Inventory\Management\Domain\Model\Entity\Employee\Employee;
use Inventory\Management\Domain\Model\Entity\Employee\EmployeeStatus;
use Inventory\Management\Domain\Service\Department\SearchDepartmentById;
use Inventory\Management\Domain\Service\Department\SearchSubDepartmentById;
use Inventory\Management\Domain\Service\Employee\SearchEmployeeByNif;
use Inventory\Management\Infrastructure\Repository\Department\DepartmentRepository;
use Inventory\Management\Infrastructure\Repository\Department\SubDepartmentRepository;
use Inventory\Management\Infrastructure\Repository\Employee\EmployeeRepository;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class UpdateFieldsEmployeeStatusTest extends TestCase
{
    /* @var MockObject $employeeRepository */
    private $employeeRepository;
    /* @var MockObject $subDepartmentRepository */
    private $departmentRepository;
    /* @var MockObject $subDepartmentRepository */
    private $subDepartmentRepository;
    /* @var UpdateFieldsEmployeeStatusCommand $updateFieldsEmployeeStatusCommand */
    private $updateFieldsEmployeeStatusCommand;

    public function setUp(): void
    {
        $this->employeeRepository = $this->createMock(EmployeeRepository::class);
        $this->departmentRepository = $this->createMock(DepartmentRepository::class);
        $this->subDepartmentRepository = $this->createMock(SubDepartmentRepository::class);
        $this->updateFieldsEmployeeStatusCommand = new UpdateFieldsEmployeeStatusCommand(
            '75693124D',
            'image.jpg',
            '15-05-2018',
            '15-05-2018',
            2,
            2,
            1,
            1
        );
    }

    /**
     * @test
     */
    public function given_employee_status_when_nif_is_or_not_encountered_then_department_not_found_exception(): void
    {
        $idDepartment = 1;
        $this->departmentRepository->method('findDepartmentById')
            ->with($idDepartment)
            ->willReturn(null);
        $searchEmployeeByNif = new SearchEmployeeByNif($this->employeeRepository);
        $searchDepartmentById = new SearchDepartmentById($this->departmentRepository);
        $searchSubDepartmentById = new SearchSubDepartmentById($this->subDepartmentRepository);
        $updateFieldsEmployeeStatus = new UpdateFieldsEmployeeStatus(
            $this->employeeRepository,
            $searchEmployeeByNif,
            $searchDepartmentById,
            $searchSubDepartmentById
        );
        $result = $updateFieldsEmployeeStatus->handle($this->updateFieldsEmployeeStatusCommand);
        $this->assertEquals(['ko' => 'No se ha encontrado ningún departamento'], $result);
    }

    /**
     * @test
     */
    public function given_employee_status_when_nif_is_or_not_encountered_then_sub_department_not_found_exception(): void
    {
        $idDepartment = 1;
        $idSubDepartment = 1;
        $department = $this->createMock(Department::class);
        $this->departmentRepository->method('findDepartmentById')
            ->with($idDepartment)
            ->willReturn($department);
        $this->subDepartmentRepository->method('findSubDepartmentById')
            ->with($idSubDepartment)
            ->willReturn(null);
        $searchEmployeeByNif = new SearchEmployeeByNif($this->employeeRepository);
        $searchDepartmentById = new SearchDepartmentById($this->departmentRepository);
        $searchSubDepartmentById = new SearchSubDepartmentById($this->subDepartmentRepository);
        $updateFieldsEmployeeStatus = new UpdateFieldsEmployeeStatus(
            $this->employeeRepository,
            $searchEmployeeByNif,
            $searchDepartmentById,
            $searchSubDepartmentById
        );
        $result = $updateFieldsEmployeeStatus->handle($this->updateFieldsEmployeeStatusCommand);
        $this->assertEquals(['ko' => 'No se ha encontrado ningún subdepartamento'], $result);
    }

    /**
     * @test
     */
    public function given_employee_status_when_nif_is_not_encountered_then_employee_not_found_exception(): void
    {
        $idDepartment = 1;
        $idSubDepartment = 1;
        $nif = '75693124D';
        $department = $this->createMock(Department::class);
        $this->departmentRepository->method('findDepartmentById')
            ->with($idDepartment)
            ->willReturn($department);
        $subDepartment = $this->createMock(SubDepartment::class);
        $this->subDepartmentRepository->method('findSubDepartmentById')
            ->with($idSubDepartment)
            ->willReturn($subDepartment);
        $this->employeeRepository->method('findEmployeeByNif')
            ->with($nif)
            ->willReturn(null);
        $searchEmployeeByNif = new SearchEmployeeByNif($this->employeeRepository);
        $searchDepartmentById = new SearchDepartmentById($this->departmentRepository);
        $searchSubDepartmentById = new SearchSubDepartmentById($this->subDepartmentRepository);
        $updateFieldsEmployeeStatus = new UpdateFieldsEmployeeStatus(
            $this->employeeRepository,
            $searchEmployeeByNif,
            $searchDepartmentById,
            $searchSubDepartmentById
        );
        $result = $updateFieldsEmployeeStatus->handle($this->updateFieldsEmployeeStatusCommand);
        $this->assertEquals(['ko' => 'No se ha encontrado ningún trabajador'], $result);
    }

    /**
     * @test
     */
    public function given_employee_status_when_nif_is_encountered_then_update(): void
    {
        $idDepartment = 1;
        $idSubDepartment = 1;
        $nif = '75693124D';
        $department = $this->createMock(Department::class);
        $this->departmentRepository->method('findDepartmentById')
            ->with($idDepartment)
            ->willReturn($department);
        $subDepartment = $this->createMock(SubDepartment::class);
        $this->subDepartmentRepository->method('findSubDepartmentById')
            ->with($idSubDepartment)
            ->willReturn($subDepartment);
        $employeeStatus = $this->createMock(EmployeeStatus::class);
        $employee = $this->createMock(Employee::class);
        $employee->method('getId')
            ->willReturn(1);
        $employee->method('getEmployeeStatus')
            ->willReturn($employeeStatus);
        $this->employeeRepository->method('findEmployeeByNif')
            ->with($nif)
            ->willReturn($employee);
        $this->employeeRepository->method('updateFieldsEmployeeStatus')
            ->with(
                $employee,
                'image.jpg',
                new \DateTime($this->updateFieldsEmployeeStatusCommand->expirationContractDate()),
                new \DateTime($this->updateFieldsEmployeeStatusCommand->possibleRenewal()),
                $this->updateFieldsEmployeeStatusCommand->availableHolidays(),
                $this->updateFieldsEmployeeStatusCommand->holidaysPendingToApplyFor(),
                $department,
                $subDepartment
            )
            ->willReturn($employee);
        $searchEmployeeByNif = new SearchEmployeeByNif($this->employeeRepository);
        $searchDepartmentById = new SearchDepartmentById($this->departmentRepository);
        $searchSubDepartmentById = new SearchSubDepartmentById($this->subDepartmentRepository);
        $updateFieldsEmployeeStatus = new UpdateFieldsEmployeeStatus(
            $this->employeeRepository,
            $searchEmployeeByNif,
            $searchDepartmentById,
            $searchSubDepartmentById
        );
        $result = $updateFieldsEmployeeStatus->handle($this->updateFieldsEmployeeStatusCommand);
        $this->assertEquals(['ok' => 200], $result);
    }
}
