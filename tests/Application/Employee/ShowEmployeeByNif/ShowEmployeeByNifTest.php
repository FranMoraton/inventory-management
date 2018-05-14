<?php

namespace Inventory\Management\Tests\Application\Employee\ShowEmployeeByNif;

use Inventory\Management\Application\Employee\ShowEmployeeByNif\ShowEmployeeByNif;
use Inventory\Management\Application\Employee\ShowEmployeeByNif\ShowEmployeeByNifCommand;
use Inventory\Management\Application\Employee\ShowEmployeeByNif\ShowEmployeeByNifTransform;
use Inventory\Management\Domain\Model\Entity\Employee\Employee;
use Inventory\Management\Domain\Model\Entity\Employee\EmployeeStatus;
use Inventory\Management\Domain\Service\Employee\SearchEmployeeByNif;
use Inventory\Management\Infrastructure\Repository\Employee\EmployeeRepository;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class ShowEmployeeByNifTest extends TestCase
{
    /* @var MockObject $employeeRepository */
    private $employeeRepository;
    private $showEmployeeByNifTransform;
    private $showEmployeeByNifCommand;

    public function setUp()
    {
        $this->employeeRepository = $this->createMock(EmployeeRepository::class);
        $this->showEmployeeByNifTransform = new ShowEmployeeByNifTransform();
        $this->showEmployeeByNifCommand = new ShowEmployeeByNifCommand('77685346D');
    }

    /**
     * @test
     */
    public function given_employee_when_nif_is_not_encountered_then_not_found_exception()
    {
        $this->employeeRepository->method('findEmployeeByNif')
            ->willReturn(null);
        $searchEmployeeByNif = new SearchEmployeeByNif($this->employeeRepository);
        $showEmployeeByNif = new ShowEmployeeByNif($this->showEmployeeByNifTransform, $searchEmployeeByNif);
        $result = $showEmployeeByNif->handle($this->showEmployeeByNifCommand);
        $this->assertEquals(['ko' => 'No se ha encontrado ningún trabajador'], $result);
    }

    /**
     * @test
     */
    public function given_employee_when_nif_is_encountered_then_ok_response()
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
        $this->employeeRepository->method('findEmployeeByNif')
            ->willReturn($employee);
        $searchEmployeeByNif = new SearchEmployeeByNif($this->employeeRepository);
        $showEmployeeByNif = new ShowEmployeeByNif($this->showEmployeeByNifTransform, $searchEmployeeByNif);
        $result = $showEmployeeByNif->handle($this->showEmployeeByNifCommand);
        $this->assertArraySubset(
            [
                'id' => 1,
                'nif' => '77685346D',
                'name' => 'Javier'
            ],
            $result
        );
    }
}
