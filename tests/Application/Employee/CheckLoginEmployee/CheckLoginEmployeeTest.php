<?php

namespace Inventory\Management\Tests\Application\Employee\CheckLoginEmployee;

use Inventory\Management\Application\Employee\CheckLoginEmployee\CheckLoginEmployee;
use Inventory\Management\Application\Employee\CheckLoginEmployee\CheckLoginEmployeeCommand;
use Inventory\Management\Domain\Model\Entity\Employee\Employee;
use Inventory\Management\Domain\Model\Entity\Employee\EmployeeStatus;
use Inventory\Management\Domain\Model\Entity\Employee\NotFoundEmployeesException;
use Inventory\Management\Domain\Model\JwtToken\Roles;
use Inventory\Management\Domain\Model\PasswordHash\IncorrectPasswordException;
use Inventory\Management\Domain\Service\JwtToken\CreateToken;
use Inventory\Management\Domain\Service\PasswordHash\CheckDecryptPassword;
use Inventory\Management\Domain\Service\Employee\SearchEmployeeByNif;
use Inventory\Management\Infrastructure\JwtToken\JwtTokenClass;
use Inventory\Management\Infrastructure\Repository\Employee\EmployeeRepository;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class CheckLoginEmployeeTest extends TestCase
{
    /* @var MockObject $employeeRepository */
    private $employeeRepository;
    /* @var MockObject $employee */
    private $employee;
    /* @var MockObject $jwtTokenClass */
    private $jwtTokenClass;
    private $createToken;
    private $checkDecryptPassword;
    private $checkDataEmployeeCommand;

    public function setUp(): void
    {
        $this->employeeRepository = $this->createMock(EmployeeRepository::class);
        $this->checkDecryptPassword = new CheckDecryptPassword();
        $this->jwtTokenClass = $this->createMock(JwtTokenClass::class);
        $this->jwtTokenClass->method('createToken')
            ->with(
                Roles::ROLE_EMPLOYEE,
                [
                    'id' => 1,
                    'nif' => '76852436D'
                ]
            )
            ->willReturn('h5O3P1cj9df.G9dg');
        $this->createToken = new CreateToken($this->jwtTokenClass);
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
        $checkLoginEmployee = new CheckLoginEmployee(
            $this->employeeRepository,
            $searchEmployeeByNif,
            $this->checkDecryptPassword,
            $this->createToken
        );
        $this->expectException(NotFoundEmployeesException::class);
        $checkLoginEmployee->handle($this->checkDataEmployeeCommand);
    }

    /**
     * @test
     */
    public function given_employee_when_user_encountered_and_password_is_incorrect_then_not_found_exception(): void
    {
        $this->employeeRepository->method('findEmployeeByNif')
            ->with('76852436D')
            ->willReturn($this->employee);
        $searchEmployeeByNif = new SearchEmployeeByNif($this->employeeRepository);
        $checkLoginEmployee = new CheckLoginEmployee(
            $this->employeeRepository,
            $searchEmployeeByNif,
            $this->checkDecryptPassword,
            $this->createToken
        );
        $this->checkDataEmployeeCommand = new CheckLoginEmployeeCommand(
            '76852436D',
            '12345'
        );
        $this->expectException(IncorrectPasswordException::class);
        $checkLoginEmployee->handle($this->checkDataEmployeeCommand);
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
        $checkLoginEmployee = new CheckLoginEmployee(
            $this->employeeRepository,
            $searchEmployeeByNif,
            $this->checkDecryptPassword,
            $this->createToken
        );
        $result = $checkLoginEmployee->handle($this->checkDataEmployeeCommand);
        $this->assertEquals(
            [
                'data' => 'h5O3P1cj9df.G9dg',
                'code' => 200
            ],
            $result
        );
    }
}
