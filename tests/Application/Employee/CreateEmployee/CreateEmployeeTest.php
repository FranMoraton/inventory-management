<?php

namespace Inventory\Management\Tests\Application\Employee\CreateEmployee;

use Inventory\Management\Application\Employee\CreateEmployee\CreateEmployee;
use Inventory\Management\Application\Employee\CreateEmployee\CreateEmployeeCommand;
use Inventory\Management\Domain\Model\Entity\Department\Department;
use Inventory\Management\Domain\Model\Entity\Department\SubDepartment;
use Inventory\Management\Domain\Model\Entity\Employee\Employee;
use Inventory\Management\Domain\Model\Entity\Employee\EmployeeStatus;
use Inventory\Management\Domain\Service\Department\SearchSubDepartmentById;
use Inventory\Management\Domain\Service\Employee\CheckNotExistsUniqueColumns;
use Inventory\Management\Domain\Service\Employee\EncryptPassword;
use Inventory\Management\Infrastructure\Repository\Department\SubDepartmentRepository;
use Inventory\Management\Infrastructure\Repository\Employee\EmployeeRepository;
use Inventory\Management\Infrastructure\Repository\Employee\EmployeeStatusRepository;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class CreateEmployeeTest extends TestCase
{
    /* @var MockObject $subDepartmentRepository */
    private $subDepartmentRepository;
    /* @var MockObject $employeeStatusRepository */
    private $employeeStatusRepository;
    /* @var MockObject $employeeRepository */
    private $employeeRepository;
    /* @var MockObject $encryptPassword */
    private $encryptPassword;
    private $createEmployeeCommand;

    public function setUp(): void
    {
        $this->subDepartmentRepository = $this->createMock(SubDepartmentRepository::class);
        $this->employeeStatusRepository = $this->createMock(EmployeeStatusRepository::class);
        $this->employeeRepository = $this->createMock(EmployeeRepository::class);
        $this->encryptPassword = $this->createMock(EncryptPassword::class);
        $this->createEmployeeCommand = new CreateEmployeeCommand(
            'image.jpg',
            '76852436D',
            '1234',
            'Name',
            '456325789345',
            '649356871',
            564,
            '03-05-2018',
            '03-05-2018',
            1
        );
    }

    /**
     * @test
     */
    public function create_employee_then_sub_department_not_found_exception(): void
    {
        $idSubDepartment = 1;
        $this->subDepartmentRepository->method('findSubDepartmentById')
            ->with($idSubDepartment)
            ->willReturn(null);
        $checkNotExistsUniqueColumns = new CheckNotExistsUniqueColumns(
            $this->employeeRepository,
            $this->employeeStatusRepository
        );
        $searchSubDepartmentById = new SearchSubDepartmentById($this->subDepartmentRepository);
        $createEmployee = new CreateEmployee(
            $this->employeeRepository,
            $this->employeeStatusRepository,
            $searchSubDepartmentById,
            $checkNotExistsUniqueColumns,
            $this->encryptPassword
        );
        $result = $createEmployee->handle($this->createEmployeeCommand);
        $this->assertEquals(['ko' => 'No se ha encontrado ningún subdepartamento'], $result);
    }

    /**
     * @test
     */
    public function create_employee_then_nif_found_exception(): void
    {
        $idSubDepartment = 1;
        $nif = '76852436D';
        $department = $this->createMock(Department::class);
        $department->method('getId')
            ->willReturn(1);
        $department->method('getName')
            ->willReturn('Technology');
        $this->employeeRepository->method('checkNotExistsNifEmployee')
            ->with($nif)
            ->willReturn($this->createMockEmployee());
        $this->subDepartmentRepository->method('findSubDepartmentById')
            ->with($idSubDepartment)
            ->willReturn($this->createMockSubDepartment($department));
        $checkNotExistsUniqueColumns = new CheckNotExistsUniqueColumns(
            $this->employeeRepository,
            $this->employeeStatusRepository
        );
        $searchSubDepartmentById = new SearchSubDepartmentById($this->subDepartmentRepository);
        $createEmployee = new CreateEmployee(
            $this->employeeRepository,
            $this->employeeStatusRepository,
            $searchSubDepartmentById,
            $checkNotExistsUniqueColumns,
            $this->encryptPassword
        );
        $result = $createEmployee->handle($this->createEmployeeCommand);
        $this->assertEquals(['ko' => 'El NIF introducido ya existe'], $result);
    }

    /**
     * @test
     */
    public function create_employee_then_in_ss_number_found_exception(): void
    {
        $idSubDepartment = 1;
        $inSsNumber = '456325789345';
        $department = $this->createMock(Department::class);
        $department->method('getId')
            ->willReturn(1);
        $department->method('getName')
            ->willReturn('Technology');
        $this->employeeRepository->method('checkNotExistsInSsNumberEmployee')
            ->with($inSsNumber)
            ->willReturn($this->createMockEmployee());
        $this->subDepartmentRepository->method('findSubDepartmentById')
            ->with($idSubDepartment)
            ->willReturn($this->createMockSubDepartment($department));
        $checkNotExistsUniqueColumns = new CheckNotExistsUniqueColumns(
            $this->employeeRepository,
            $this->employeeStatusRepository
        );
        $searchSubDepartmentById = new SearchSubDepartmentById($this->subDepartmentRepository);
        $createEmployee = new CreateEmployee(
            $this->employeeRepository,
            $this->employeeStatusRepository,
            $searchSubDepartmentById,
            $checkNotExistsUniqueColumns,
            $this->encryptPassword
        );
        $result = $createEmployee->handle($this->createEmployeeCommand);
        $this->assertEquals(['ko' => 'El número de la seguridad social introducido ya existe'], $result);
    }

    /**
     * @test
     */
    public function create_employee_then_telephone_found_exception(): void
    {
        $idSubDepartment = 1;
        $telephone = '649356871';
        $department = $this->createMock(Department::class);
        $department->method('getId')
            ->willReturn(1);
        $department->method('getName')
            ->willReturn('Technology');
        $this->employeeRepository->method('checkNotExistsTelephoneEmployee')
            ->with($telephone)
            ->willReturn($this->createMockEmployee());
        $this->subDepartmentRepository->method('findSubDepartmentById')
            ->with($idSubDepartment)
            ->willReturn($this->createMockSubDepartment($department));
        $checkNotExistsUniqueColumns = new CheckNotExistsUniqueColumns(
            $this->employeeRepository,
            $this->employeeStatusRepository
        );
        $searchSubDepartmentById = new SearchSubDepartmentById($this->subDepartmentRepository);
        $createEmployee = new CreateEmployee(
            $this->employeeRepository,
            $this->employeeStatusRepository,
            $searchSubDepartmentById,
            $checkNotExistsUniqueColumns,
            $this->encryptPassword
        );
        $result = $createEmployee->handle($this->createEmployeeCommand);
        $this->assertEquals(['ko' => 'El teléfono introducido ya existe'], $result);
    }

    /**
     * @test
     */
    public function create_employee_then_code_found_exception(): void
    {
        $idSubDepartment = 1;
        $code = 564;
        $department = $this->createMock(Department::class);
        $department->method('getId')
            ->willReturn(1);
        $department->method('getName')
            ->willReturn('Technology');
        $this->employeeRepository->method('checkNotExistsCodeEmployeeStatus')
            ->with($code)
            ->willReturn($this->createMockEmployee());
        $this->subDepartmentRepository->method('findSubDepartmentById')
            ->with($idSubDepartment)
            ->willReturn($this->createMockSubDepartment($department));
        $checkNotExistsUniqueColumns = new CheckNotExistsUniqueColumns(
            $this->employeeRepository,
            $this->employeeStatusRepository
        );
        $searchSubDepartmentById = new SearchSubDepartmentById($this->subDepartmentRepository);
        $createEmployee = new CreateEmployee(
            $this->employeeRepository,
            $this->employeeStatusRepository,
            $searchSubDepartmentById,
            $checkNotExistsUniqueColumns,
            $this->encryptPassword
        );
        $result = $createEmployee->handle($this->createEmployeeCommand);
        $this->assertEquals(['ko' => 'El código de trabajador introducido ya existe'], $result);
    }

    private function createMockEmployee(): MockObject
    {
        $employeeStatus = $this->createMock(EmployeeStatus::class);
        $employee = $this->createMock(Employee::class);
        $employee->method('getId')
            ->willReturn(1);
        $employee->method('getImage')
            ->willReturn('image.jpg');
        $employee->method('getNif')
            ->willReturn('76852436D');
        $employee->method('getPassword')
            ->willReturn(password_hash('1234', PASSWORD_DEFAULT));
        $employee->method('getName')
            ->willReturn('Javier');
        $employee->method('getInSsNumber')
            ->willReturn('456325789345');
        $employee->method('getTelephone')
            ->willReturn('649356871');
        $employee->method('getEmployeeStatus')
            ->willReturn($employeeStatus);

        return $employee;
    }

    /**
     * @test
     */
    public function create_employee_then_ok_response(): void
    {
        $department = $this->createMock(Department::class);
        $department->method('getId')
            ->willReturn(1);
        $department->method('getName')
            ->willReturn('Technology');
        $idSubDepartment = 1;
        $this->subDepartmentRepository->method('findSubDepartmentById')
            ->with($idSubDepartment)
            ->willReturn($this->createMockSubDepartment($department));
        $codeEmployee = 564;
        $firstContractDate = new \DateTime('03-05-2018');
        $seniorityDate = new \DateTime('03-05-2018');
        $employeeStatus = new EmployeeStatus(
            $codeEmployee,
            $firstContractDate,
            $seniorityDate,
            $department,
            $this->createMockSubDepartment($department)
        );
        $this->employeeStatusRepository->method('createEmployeeStatus')
            ->with($employeeStatus)
            ->willReturn($employeeStatus);
        $employee = new Employee(
            $employeeStatus,
            'image.jpg',
            '76852436D',
            '$2afs58erg2g68wj1ol2g89t3f1dgf4g7g5gd2',
            'Name',
            '456325789345',
            '649356871'
        );
        $this->employeeRepository->method('createEmployee')
            ->with($employee)
            ->willReturn($employee);
        $this->encryptPassword->method('execute')
            ->with('1234')
            ->willReturn('$2afs58erg2g68wj1ol2g89t3f1dgf4g7g5gd2');
        $checkNotExistsUniqueColumns = new CheckNotExistsUniqueColumns(
            $this->employeeRepository,
            $this->employeeStatusRepository
        );
        $searchSubDepartmentById = new SearchSubDepartmentById($this->subDepartmentRepository);
        $createEmployee = new CreateEmployee(
            $this->employeeRepository,
            $this->employeeStatusRepository,
            $searchSubDepartmentById,
            $checkNotExistsUniqueColumns,
            $this->encryptPassword
        );
        $result = $createEmployee->handle($this->createEmployeeCommand);
        $this->assertEquals(['ok' => 200], $result);
    }

    private function createMockSubDepartment(MockObject $department): MockObject
    {
        $subDepartment = $this->createMock(SubDepartment::class);
        $subDepartment->method('getId')
            ->willReturn(1);
        $subDepartment->method('getName')
            ->willReturn('Technology');
        $subDepartment->method('getDepartment')
            ->willReturn($department);

        return $subDepartment;
    }
}
