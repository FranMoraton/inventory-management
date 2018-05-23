<?php

namespace Inventory\Management\Tests\Application\Employee\ShowDataEmployee;

use Inventory\Management\Application\Employee\ShowDataEmployee\ShowDataEmployee;
use Inventory\Management\Application\Employee\ShowDataEmployee\ShowDataEmployeeTransform;
use Inventory\Management\Domain\Model\Entity\Employee\Employee;
use Inventory\Management\Domain\Model\Entity\Employee\EmployeeStatus;
use Inventory\Management\Domain\Model\Entity\Employee\NotFoundEmployeesException;
use Inventory\Management\Domain\Model\JwtToken\Roles;
use Inventory\Management\Domain\Service\Employee\SearchEmployeeByNif;
use Inventory\Management\Domain\Service\JwtToken\CheckToken;
use Inventory\Management\Infrastructure\JwtToken\JwtTokenClass;
use Inventory\Management\Infrastructure\Repository\Employee\EmployeeRepository;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class ShowDataEmployeeTest extends TestCase
{
    /* @var MockObject $employeeRepository */
    private $employeeRepository;
    /* @var MockObject $jwtTokenClass */
    private $jwtTokenClass;
    private $checkToken;
    private $showEmployeeByNifTransform;

    public function setUp()
    {
        $this->employeeRepository = $this->createMock(EmployeeRepository::class);
        $this->showEmployeeByNifTransform = new ShowDataEmployeeTransform();
        $dataToken = ['nif' => '77685346D'];
        $dataTokenDecode = json_decode(json_encode($dataToken));
        $this->jwtTokenClass = $this->createMock(JwtTokenClass::class);
        $this->jwtTokenClass->method('checkToken')
            ->with(Roles::ROLE_EMPLOYEE)
            ->willReturn($dataTokenDecode);
        $this->checkToken = new CheckToken($this->jwtTokenClass);
    }

    /**
     * @test
     */
    public function given_employee_when_nif_is_not_encountered_then_not_found_exception()
    {
        $this->employeeRepository->method('findEmployeeByNif')
            ->willReturn(null);
        $searchEmployeeByNif = new SearchEmployeeByNif($this->employeeRepository);
        $showEmployeeByNif = new ShowDataEmployee(
            $this->showEmployeeByNifTransform,
            $searchEmployeeByNif,
            $this->checkToken
        );
        $this->expectException(NotFoundEmployeesException::class);
        $showEmployeeByNif->handle();
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
        $showEmployeeByNif = new ShowDataEmployee(
            $this->showEmployeeByNifTransform,
            $searchEmployeeByNif,
            $this->checkToken
        );
        $result = $showEmployeeByNif->handle();
        $this->assertArraySubset(
            [
                'data' => [
                    'name' => 'Javier'
                ]
            ],
            $result
        );
    }
}
