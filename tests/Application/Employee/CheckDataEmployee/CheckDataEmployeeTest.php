<?php

namespace Inventory\Management\Tests\Application\Employee\CheckDataEmployee;

use Inventory\Management\Application\Employee\CheckDataEmployee\CheckDataEmployee;
use Inventory\Management\Application\Employee\CheckDataEmployee\CheckDataEmployeeCommand;
use Inventory\Management\Domain\Model\Entity\Employee\Employee;
use Inventory\Management\Domain\Model\Entity\Employee\EmployeeStatus;
use Inventory\Management\Domain\Model\Entity\Employee\NotFoundEmployeesException;
use Inventory\Management\Domain\Model\Entity\Employee\NotFoundPasswordEmployeeException;
use Inventory\Management\Domain\Service\Employee\CheckDecryptPassword;
use Inventory\Management\Domain\Service\Employee\SearchByNifEmployee;
use Inventory\Management\Infrastructure\Repository\Employee\EmployeeRepository;
use PHPUnit\Framework\TestCase;

class CheckDataEmployeeTest extends TestCase
{
    /**
     * @test
     */
    public function given_employee_when_user_not_encountered_then_not_found_exception(): void
    {
        $employeeRepository = $this->getMockBuilder(EmployeeRepository::class)
            ->disableOriginalConstructor()
            ->getMock();
        $employeeRepository->method('findEmployeeByNif')
            ->with('76852436D')
            ->willReturn(null);
        $searchByNifEmployee = new SearchByNifEmployee($employeeRepository);
        $checkDecryptPassword = new CheckDecryptPassword();
        $checkDataEmployee = new CheckDataEmployee($searchByNifEmployee, $checkDecryptPassword);
        $this->expectException(NotFoundEmployeesException::class);
        $checkDataEmployeeCommand = new CheckDataEmployeeCommand(
            '76852436D',
            '1234'
        );
        $checkDataEmployee->handle($checkDataEmployeeCommand);
    }

    /**
     * @test
     */
    public function given_employee_when_user_encountered_and_password_not_encountered_then_not_found_exception(): void
    {
        $employeeStatus = $this->getMockBuilder(EmployeeStatus::class)
            ->disableOriginalConstructor()
            ->getMock();
        $employee = $this->getMockBuilder(Employee::class)
            ->disableOriginalConstructor()
            ->getMock();
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
            ->willReturn(456325789345);
        $employee->method('getTelephone')
            ->willReturn(649356871);
        $employee->method('getEmployeeStatus')
            ->willReturn($employeeStatus);
        $employeeRepository = $this->getMockBuilder(EmployeeRepository::class)
            ->disableOriginalConstructor()
            ->getMock();
        $employeeRepository->method('findEmployeeByNif')
            ->with('76852436D')
            ->willReturn($employee);
        $searchByNifEmployee = new SearchByNifEmployee($employeeRepository);
        $checkDecryptPassword = new CheckDecryptPassword();
        $checkDataEmployee = new CheckDataEmployee($searchByNifEmployee, $checkDecryptPassword);
        $this->expectException(NotFoundPasswordEmployeeException::class);
        $checkDataEmployeeCommand = new CheckDataEmployeeCommand(
            '76852436D',
            '12345'
        );
        $checkDataEmployee->handle($checkDataEmployeeCommand);
    }

    /**
     * @test
     */
    public function given_employee_when_user_and_password_encountered_then_ok_response(): void
    {
        $employeeStatus = $this->getMockBuilder(EmployeeStatus::class)
            ->disableOriginalConstructor()
            ->getMock();
        $employee = $this->getMockBuilder(Employee::class)
            ->disableOriginalConstructor()
            ->getMock();
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
            ->willReturn(456325789345);
        $employee->method('getTelephone')
            ->willReturn(649356871);
        $employee->method('getEmployeeStatus')
            ->willReturn($employeeStatus);
        $employeeRepository = $this->getMockBuilder(EmployeeRepository::class)
            ->disableOriginalConstructor()
            ->getMock();
        $employeeRepository->method('findEmployeeByNif')
            ->with('76852436D')
            ->willReturn($employee);
        $searchByNifEmployee = new SearchByNifEmployee($employeeRepository);
        $checkDecryptPassword = new CheckDecryptPassword();
        $checkDataEmployee = new CheckDataEmployee($searchByNifEmployee, $checkDecryptPassword);
        $checkDataEmployeeCommand = new CheckDataEmployeeCommand(
            '76852436D',
            '1234'
        );
        $checkDataEmployee->handle($checkDataEmployeeCommand);
        $this->assertTrue(true, true);
    }
}
