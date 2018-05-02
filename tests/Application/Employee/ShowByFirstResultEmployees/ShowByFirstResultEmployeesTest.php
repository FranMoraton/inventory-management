<?php

namespace Inventory\Management\Tests\Application\Employee\ShowByFirstResultEmployees;

use Inventory\Management\Application\Employee\ShowByFirstResultEmployees\ShowByFirstResultEmployees;
use Inventory\Management\Application\Employee\ShowByFirstResultEmployees\ShowByFirstResultEmployeesCommand;
use Inventory\Management\Application\Employee\ShowByFirstResultEmployees\ShowByFirstResultEmployeesTransform;
use Inventory\Management\Domain\Model\Entity\Employee\Employee;
use Inventory\Management\Domain\Model\Entity\Employee\EmployeeStatus;
use Inventory\Management\Domain\Model\Entity\Employee\NotFoundEmployeesException;
use Inventory\Management\Infrastructure\Repository\Employee\EmployeeRepository;
use PHPUnit\Framework\TestCase;

class ShowByFirstResultEmployeesTest extends TestCase
{
    /**
     * @test
     */
    public function given_employees_when_request_by_first_result_then_not_found_exception()
    {
        $firstResultPosition = 0;
        $employeeRepository = $this->getMockBuilder(EmployeeRepository::class)
            ->disableOriginalConstructor()
            ->getMock();
        $employeeRepository->method('showByFirstResultEmployees')
            ->willReturn([]);
        $showByFirstResultEmployeesTransform = new ShowByFirstResultEmployeesTransform();
        $showByFirstResultEmployees = new ShowByFirstResultEmployees(
            $employeeRepository,
            $showByFirstResultEmployeesTransform
        );
        $this->expectException(NotFoundEmployeesException::class);
        $showByFirstResultEmployeesCommand = new ShowByFirstResultEmployeesCommand($firstResultPosition);
        $showByFirstResultEmployees->handle($showByFirstResultEmployeesCommand);
    }

    /**
     * @test
     */
    public function given_employees_when_request_by_first_result_then_show()
    {
        $firstResultPosition = 0;
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
            ->willReturn('77685346D');
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
        $employeeRepository->method('showByFirstResultEmployees')
            ->willReturn([$employee]);
        $showByFirstResultEmployeesTransform = new ShowByFirstResultEmployeesTransform();
        $showByFirstResultEmployees = new ShowByFirstResultEmployees(
            $employeeRepository,
            $showByFirstResultEmployeesTransform
        );
        $showByFirstResultEmployeesCommand = new ShowByFirstResultEmployeesCommand($firstResultPosition);
        $this->assertArraySubset(
            [
                0 => [
                    'id' => 1,
                    'nif' => '77685346D',
                    'name' => 'Javier'
                ]
            ],
            $showByFirstResultEmployees->handle($showByFirstResultEmployeesCommand)
        );
    }
}
