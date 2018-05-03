<?php

namespace Inventory\Management\Tests\Application\Employee\CreateEmployee;

use Inventory\Management\Application\Employee\CreateEmployee\CreateEmployee;
use Inventory\Management\Application\Employee\CreateEmployee\CreateEmployeeCommand;
use Inventory\Management\Domain\Model\Entity\Department\Department;
use Inventory\Management\Domain\Model\Entity\Department\NotFoundDepartmentsException;
use Inventory\Management\Domain\Model\Entity\Department\SubDepartment;
use Inventory\Management\Domain\Model\Entity\Employee\Employee;
use Inventory\Management\Domain\Model\Entity\Employee\EmployeeStatus;
use Inventory\Management\Domain\Service\Employee\EncryptPassword;
use Inventory\Management\Infrastructure\Repository\Department\SubDepartmentRepository;
use Inventory\Management\Infrastructure\Repository\Employee\EmployeeRepository;
use Inventory\Management\Infrastructure\Repository\Employee\EmployeeStatusRepository;
use PHPUnit\Framework\TestCase;

class CreateEmployeeTest extends TestCase
{
    /**
     * @test
     */
    public function create_employee_then_sub_department_not_found_exception(): void
    {
        $subDepartmentRepository = $this->getMockBuilder(SubDepartmentRepository::class)
            ->disableOriginalConstructor()
            ->getMock();
        $idSubDepartment = 1;
        $subDepartmentRepository->method('findSubDepartmentById')
            ->with($idSubDepartment)
            ->willReturn(null);
        $employeeStatusRepository = $this->getMockBuilder(EmployeeStatusRepository::class)
            ->disableOriginalConstructor()
            ->getMock();
        $employeeRepository = $this->getMockBuilder(EmployeeRepository::class)
            ->disableOriginalConstructor()
            ->getMock();
        $encryptPassword = $this->getMockBuilder(EncryptPassword::class)
            ->disableOriginalConstructor()
            ->getMock();
        $createEmployee = new CreateEmployee(
            $employeeRepository,
            $employeeStatusRepository,
            $subDepartmentRepository,
            $encryptPassword
        );
        $this->expectException(NotFoundDepartmentsException::class);
        $createEmployeeCommand = new CreateEmployeeCommand(
            'image.jpg',
            '75689345D',
            '1234',
            'Name',
            '453871239865',
            '675963458',
            564,
            '03-05-2018',
            '03-05-2018',
            1
        );
        $createEmployee->handle($createEmployeeCommand);
    }

    /**
     * @test
     */
    public function create_employee_then_ok_response(): void
    {
        $department = $this->getMockBuilder(Department::class)
            ->disableOriginalConstructor()
            ->getMock();
        $department->method('getId')
            ->willReturn(1);
        $department->method('getName')
            ->willReturn('Technology');
        $subDepartment = $this->getMockBuilder(SubDepartment::class)
            ->disableOriginalConstructor()
            ->getMock();
        $subDepartment->method('getId')
            ->willReturn(1);
        $subDepartment->method('getName')
            ->willReturn('Technology');
        $subDepartment->method('getDepartment')
            ->willReturn($department);
        $subDepartmentRepository = $this->getMockBuilder(SubDepartmentRepository::class)
            ->disableOriginalConstructor()
            ->getMock();
        $idSubDepartment = 1;
        $subDepartmentRepository->method('findSubDepartmentById')
            ->with($idSubDepartment)
            ->willReturn($subDepartment);
        $codeEmployee = 564;
        $firstContractDate = new \DateTime('03-05-2018');
        $seniorityDate = new \DateTime('03-05-2018');
        $employeeStatus = new EmployeeStatus(
            $codeEmployee,
            $firstContractDate,
            $seniorityDate,
            $department,
            $subDepartment
        );
        $employeeStatusRepository = $this->getMockBuilder(EmployeeStatusRepository::class)
            ->disableOriginalConstructor()
            ->getMock();
        $employeeStatusRepository->method('createEmployeeStatus')
            ->with($employeeStatus)
            ->willReturn($employeeStatus);
        $employee = new Employee(
            $employeeStatus,
            'image.jpg',
            '75689345D',
            '$2afs58erg2g68wj1ol2g89t3f1dgf4g7g5gd2',
            'Name',
            '453871239865',
            '675963458'
        );
        $employeeRepository = $this->getMockBuilder(EmployeeRepository::class)
            ->disableOriginalConstructor()
            ->getMock();
        $employeeRepository->method('createEmployee')
            ->with($employee)
            ->willReturn($employee);
        $encryptPassword = $this->getMockBuilder(EncryptPassword::class)
            ->disableOriginalConstructor()
            ->getMock();
        $encryptPassword->method('execute')
            ->with('1234')
            ->willReturn('$2afs58erg2g68wj1ol2g89t3f1dgf4g7g5gd2');
        $createEmployee = new CreateEmployee(
            $employeeRepository,
            $employeeStatusRepository,
            $subDepartmentRepository,
            $encryptPassword
        );
        $createEmployeeCommand = new CreateEmployeeCommand(
            'image.jpg',
            '75689345D',
            '1234',
            'Name',
            '453871239865',
            '675963458',
            564,
            '03-05-2018',
            '03-05-2018',
            1
        );
        $createEmployee->handle($createEmployeeCommand);
        $this->assertTrue(true, true);
    }
}
