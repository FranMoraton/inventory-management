<?php

namespace Inventory\Management\Tests\Application\Employee\ShowByFirstResultEmployees;

use Inventory\Management\Application\Employee\ShowByFirstResultEmployees\ShowByFirstResultEmployees;
use Inventory\Management\Application\Employee\ShowByFirstResultEmployees\ShowByFirstResultEmployeesCommand;
use Inventory\Management\Application\Employee\ShowByFirstResultEmployees\ShowByFirstResultEmployeesTransform;
use Inventory\Management\Domain\Model\Entity\Employee\Employee;
use Inventory\Management\Domain\Model\Entity\Employee\EmployeeStatus;
use Inventory\Management\Domain\Service\JwtToken\CheckToken;
use Inventory\Management\Infrastructure\JwtToken\JwtTokenClass;
use Inventory\Management\Infrastructure\Repository\Employee\EmployeeRepository;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class ShowByFirstResultEmployeesTest extends TestCase
{
    /* @var MockObject $employeeRepository */
    private $employeeRepository;
    /* @var MockObject $jwtTokenClass */
    private $jwtTokenClass;
    private $checkToken;
    private $showByFirstResultEmployeesTransform;
    private $showByFirstResultEmployeesCommand;

    public function setUp(): void
    {
        $this->employeeRepository = $this->createMock(EmployeeRepository::class);
        $this->showByFirstResultEmployeesTransform = new ShowByFirstResultEmployeesTransform();
        $this->jwtTokenClass = $this->createMock(JwtTokenClass::class);
        $this->checkToken = new CheckToken($this->jwtTokenClass);
        $this->showByFirstResultEmployeesCommand = new ShowByFirstResultEmployeesCommand(0, 'Javier', 173, 1, 1);
    }

    /**
     * @test
     */
    public function given_employees_when_request_by_first_result_then_show(): void
    {
        $employeeStatus = $this->createMock(EmployeeStatus::class);
        $employee = $this->createMock(Employee::class);
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
            ->willReturn('456325789345');
        $employee->method('getTelephone')
            ->willReturn('649356871');
        $employee->method('getEmployeeStatus')
            ->willReturn($employeeStatus);
        $this->employeeRepository->method('showByFirstResultFilterEmployees')
            ->willReturn([$employee]);
        $showByFirstResultEmployees = new ShowByFirstResultEmployees(
            $this->employeeRepository,
            $this->showByFirstResultEmployeesTransform,
            $this->checkToken
        );
        $result = $showByFirstResultEmployees->handle($this->showByFirstResultEmployeesCommand);
        $this->assertArraySubset(
            [
                'data' => [
                    0 => [
                        'id' => 1,
                        'nif' => '77685346D',
                        'name' => 'Javier'
                    ]
                ]
            ],
            $result
        );
    }
}
