<?php

namespace Inventory\Management\Tests\Application\Employee\CheckDataEmployee;

use Inventory\Management\Application\Employee\CheckLoginEmployee\CheckLoginEmployee;
use Inventory\Management\Application\Employee\CheckLoginEmployee\CheckLoginEmployeeCommand;
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
    /* @var MockObject $employee */
    private $employee;
    private $checkDecryptPassword;
    private $checkDataEmployeeCommand;

    public function setUp(): void
    {
        $this->employeeRepository = $this->createMock(EmployeeRepository::class);
        $this->checkDecryptPassword = new CheckDecryptPassword();
        $this->checkDataEmployeeCommand = new CheckLoginEmployeeCommand(
            '76852436D',
            '1234'
        );
        $employeeStatus = $this->createMock(EmployeeStatus::class);
        $this->employee = $this->createMock(Employee::class);
        $this->employee->method('getId')
            ->willReturn(1);
        $this->employee->method('getImage')
            ->willReturn('image.jpg');
        $this->employee->method('getNif')
            ->willReturn('76852436D');
        $this->employee->method('getPassword')
            ->willReturn(password_hash('1234', PASSWORD_DEFAULT));
        $this->employee->method('getName')
            ->willReturn('Javier');
        $this->employee->method('getInSsNumber')
            ->willReturn(456325789345);
        $this->employee->method('getTelephone')
            ->willReturn(649356871);
        $this->employee->method('getEmployeeStatus')
            ->willReturn($employeeStatus);
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
        $checkDataEmployee = new CheckLoginEmployee($searchEmployeeByNif, $this->checkDecryptPassword);
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
            ->willReturn($this->employee);
        $searchEmployeeByNif = new SearchEmployeeByNif($this->employeeRepository);
        $checkDataEmployee = new CheckLoginEmployee($searchEmployeeByNif, $this->checkDecryptPassword);
        $this->checkDataEmployeeCommand = new CheckLoginEmployeeCommand(
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
            ->willReturn($this->employee);
        $searchEmployeeByNif = new SearchEmployeeByNif($this->employeeRepository);
        $checkDataEmployee = new CheckLoginEmployee($searchEmployeeByNif, $this->checkDecryptPassword);
        $result = $checkDataEmployee->handle($this->checkDataEmployeeCommand);
        $this->assertEquals(['ok' => 200], $result);
    }
}
