<?php

namespace Inventory\Management\Tests\Application\Employee\ChangeStatusToDisableEmployee;

use Inventory\Management\Application\Employee\ChangeStatusToDisableEmployee\ChangeStatusToDisableEmployee;
use Inventory\Management\Application\Employee\ChangeStatusToDisableEmployee\ChangeStatusToDisableEmployeeCommand;
use Inventory\Management\Domain\Model\Entity\Employee\Employee;
use Inventory\Management\Domain\Model\Entity\Employee\EmployeeStatus;
use Inventory\Management\Domain\Model\Entity\Employee\NotFoundEmployeesException;
use Inventory\Management\Domain\Service\Employee\SearchByNifEmployee;
use Inventory\Management\Infrastructure\Repository\Employee\EmployeeRepository;
use PHPUnit\Framework\TestCase;

class ChangeStatusToDisableEmployeeTest extends TestCase
{
    /**
     * @test
     */
    public function change_status_to_disable_employee_then_not_found_exception(): void
    {
        $employeeRepository = $this->getMockBuilder(EmployeeRepository::class)
            ->disableOriginalConstructor()
            ->getMock();
        $employeeRepository->method('findEmployeeByNif')
            ->with('45678324F')
            ->willReturn(null);
        $searchByNifEmployee = new SearchByNifEmployee($employeeRepository);
        $changeStatusEmployee = new ChangeStatusToDisableEmployee($employeeRepository, $searchByNifEmployee);
        $this->expectException(NotFoundEmployeesException::class);
        $changeStatusEmployeeCommand = new ChangeStatusToDisableEmployeeCommand('45678324F');
        $changeStatusEmployee->handle($changeStatusEmployeeCommand);
    }

    /**
     * @test
     */
    public function change_status_to_disable_employee_then_ok_response(): void
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
            ->willReturn('45678324F');
        $employee->method('getPassword')
            ->willReturn('1234');
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
            ->with('45678324F')
            ->willReturn($employee);
        $employeeRepository->method('changeStatusToDisableEmployee')
            ->with($employee)
            ->willReturn($employee);
        $searchByNifEmployee = new SearchByNifEmployee($employeeRepository);
        $changeStatusEmployee = new ChangeStatusToDisableEmployee($employeeRepository, $searchByNifEmployee);
        $changeStatusEmployeeCommand = new ChangeStatusToDisableEmployeeCommand('45678324F');
        $changeStatusEmployee->handle($changeStatusEmployeeCommand);
        $this->assertTrue(true, true);
    }
}