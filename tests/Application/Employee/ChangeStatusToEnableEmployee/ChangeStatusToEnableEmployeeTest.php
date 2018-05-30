<?php

namespace Inventory\Management\Tests\Application\Employee\ChangeStatusToEnableEmployee;

use Inventory\Management\Application\Employee\ChangeStatusToEnableEmployee\ChangeStatusToEnableEmployee;
use Inventory\Management\Application\Employee\ChangeStatusToEnableEmployee\ChangeStatusToEnableEmployeeCommand;
use Inventory\Management\Application\Employee\ChangeStatusToEnableEmployee\ChangeStatusToEnableEmployeeTransform;
use Inventory\Management\Domain\Model\Entity\Employee\Employee;
use Inventory\Management\Domain\Model\Entity\Employee\EmployeeStatus;
use Inventory\Management\Domain\Model\Entity\Employee\NotFoundEmployeesException;
use Inventory\Management\Domain\Service\Employee\SearchEmployeeByNif;
use Inventory\Management\Infrastructure\Repository\Employee\EmployeeRepository;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class ChangeStatusToEnableEmployeeTest extends TestCase
{
    /* @var MockObject $employeeRepository */
    private $employeeRepository;
    private $searchEmployeeByNif;
    private $changeStatusEmployeeCommand;
    private $transform;

    public function setUp(): void
    {
        $this->employeeRepository = $this->createMock(EmployeeRepository::class);
        $this->searchEmployeeByNif = new SearchEmployeeByNif($this->employeeRepository);
        $this->changeStatusEmployeeCommand = new ChangeStatusToEnableEmployeeCommand('45678324F');
        $this->transform = new ChangeStatusToEnableEmployeeTransform();
    }

    /**
     * @test
     */
    public function change_status_to_enable_employee_then_not_found_exception(): void
    {
        $this->employeeRepository->method('findEmployeeByNif')
            ->with('45678324F')
            ->willReturn(null);
        $changeStatusEmployee = new ChangeStatusToEnableEmployee(
            $this->employeeRepository,
            $this->transform,
            $this->searchEmployeeByNif
        );
        $this->expectException(NotFoundEmployeesException::class);
        $changeStatusEmployee->handle($this->changeStatusEmployeeCommand);
    }

    /**
     * @test
     */
    public function change_status_to_enable_employee_then_ok_response(): void
    {
        $employeeStatus = $this->createMock(EmployeeStatus::class);
        $employee = $this->createMock(Employee::class);
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
        $this->employeeRepository->method('findEmployeeByNif')
            ->with('45678324F')
            ->willReturn($employee);
        $this->employeeRepository->method('changeStatusToDisableEmployee')
            ->with($employee)
            ->willReturn($employee);
        $changeStatusEmployee = new ChangeStatusToEnableEmployee(
            $this->employeeRepository,
            $this->transform,
            $this->searchEmployeeByNif
        );
        $changeStatusEmployee->handle($this->changeStatusEmployeeCommand);
        $this->assertTrue(true, true);
    }
}