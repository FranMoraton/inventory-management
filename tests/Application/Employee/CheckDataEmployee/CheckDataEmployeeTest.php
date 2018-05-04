<?php

namespace Inventory\Management\Tests\Application\Employee\CheckDataEmployee;

use Inventory\Management\Application\Employee\CheckDataEmployee\CheckDataEmployee;
use Inventory\Management\Application\Employee\CheckDataEmployee\CheckDataEmployeeCommand;
use Inventory\Management\Domain\Model\Entity\Employee\Employee;
use Inventory\Management\Domain\Model\Entity\Employee\EmployeeStatus;
use Inventory\Management\Domain\Service\Employee\CheckDecryptPassword;
use Inventory\Management\Domain\Service\Employee\SearchEmployeeByNif;
use Inventory\Management\Infrastructure\Repository\Employee\EmployeeRepository;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class CheckDataEmployeeTest extends TestCase
{
    /* @var MockObject $employeeRepository */
    private $employeeRepository;
    private $checkDecryptPassword;
    private $checkDataEmployeeCommand;

    public function setUp(): void
    {
        $this->employeeRepository = $this->createMock(EmployeeRepository::class);
        $this->checkDecryptPassword = new CheckDecryptPassword();
        $this->checkDataEmployeeCommand = new CheckDataEmployeeCommand(
            '76852436D',
            '1234'
        );
    }

    /**
     * @test
     */
    public function given_employee_when_user_not_encountered_then_not_found_exception(): void
    {
        $this->employeeRepository->method('findEmployeeByNif')
            ->with('76852436D')
            ->willReturn(null);
        $searchEmployeeByNif = new SearchEmployeeByNif($this->employeeRepository);
        $checkDataEmployee = new CheckDataEmployee($searchEmployeeByNif, $this->checkDecryptPassword);
        $result = $checkDataEmployee->handle($this->checkDataEmployeeCommand);
        $this->assertEquals(['ko' => 'No se ha encontrado ningún trabajador'], $result);
    }

    /**
     * @test
     */
    public function given_employee_when_user_encountered_and_password_not_encountered_then_not_found_exception(): void
    {
        $this->employeeRepository->method('findEmployeeByNif')
            ->with('76852436D')
            ->willReturn($this->createMockEmployee());
        $searchEmployeeByNif = new SearchEmployeeByNif($this->employeeRepository);
        $checkDataEmployee = new CheckDataEmployee($searchEmployeeByNif, $this->checkDecryptPassword);
        $this->checkDataEmployeeCommand = new CheckDataEmployeeCommand(
            '76852436D',
            '12345'
        );
        $result = $checkDataEmployee->handle($this->checkDataEmployeeCommand);
        $this->assertEquals(['ko' => 'La contraseña introducida no es correcta'], $result);
    }

    /**
     * @test
     */
    public function given_employee_when_user_and_password_encountered_then_ok_response(): void
    {
        $this->employeeRepository->method('findEmployeeByNif')
            ->with('76852436D')
            ->willReturn($this->createMockEmployee());
        $searchEmployeeByNif = new SearchEmployeeByNif($this->employeeRepository);
        $checkDataEmployee = new CheckDataEmployee($searchEmployeeByNif, $this->checkDecryptPassword);
        $result = $checkDataEmployee->handle($this->checkDataEmployeeCommand);
        $this->assertEquals(['ok' => 200], $result);
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
            ->willReturn(456325789345);
        $employee->method('getTelephone')
            ->willReturn(649356871);
        $employee->method('getEmployeeStatus')
            ->willReturn($employeeStatus);

        return $employee;
    }
}
