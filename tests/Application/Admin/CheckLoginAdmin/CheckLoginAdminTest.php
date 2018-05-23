<?php

namespace Inventory\Management\Tests\Application\Admin\CheckLoginAdmin;

use Inventory\Management\Application\Admin\CheckLoginAdmin\CheckLoginAdmin;
use Inventory\Management\Application\Admin\CheckLoginAdmin\CheckLoginAdminCommand;
use Inventory\Management\Domain\Model\Entity\Admin\Admin;
use Inventory\Management\Domain\Model\Entity\Admin\NotFoundAdminsException;
use Inventory\Management\Domain\Model\JwtToken\Roles;
use Inventory\Management\Domain\Model\PasswordHash\IncorrectPasswordException;
use Inventory\Management\Domain\Service\Admin\SearchAdminByUsername;
use Inventory\Management\Domain\Service\JwtToken\CreateToken;
use Inventory\Management\Domain\Service\PasswordHash\CheckDecryptPassword;
use Inventory\Management\Infrastructure\JwtToken\JwtTokenClass;
use Inventory\Management\Infrastructure\Repository\Admin\AdminRepository;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class CheckLoginAdminTest extends TestCase
{
    /* @var MockObject $employeeRepository */
    private $adminRepository;
    /* @var MockObject $employee */
    private $admin;
    /* @var MockObject $jwtTokenClass */
    private $jwtTokenClass;
    private $createToken;
    private $checkDecryptPassword;
    private $checkLoginAdminCommand;

    public function setUp(): void
    {
        $this->adminRepository = $this->createMock(AdminRepository::class);
        $this->checkDecryptPassword = new CheckDecryptPassword();
        $this->jwtTokenClass = $this->createMock(JwtTokenClass::class);
        $this->jwtTokenClass->method('createToken')
            ->with(
                Roles::ROLE_ADMIN,
                [
                    'id' => 1,
                    'username' => 'Javier'
                ]
            )
            ->willReturn('h5O3P1cj9df.G9dg');
        $this->createToken = new CreateToken($this->jwtTokenClass);
        $this->checkLoginAdminCommand = new CheckLoginAdminCommand(
            'Javier',
            '1234'
        );
        $this->admin = $this->createMock(Admin::class);
        $this->admin->method('getId')
            ->willReturn(1);
        $this->admin->method('getUsername')
            ->willReturn('Javier');
        $this->admin->method('getPassword')
            ->willReturn(password_hash('1234', PASSWORD_DEFAULT));
    }

    /**
     * @test
     */
    public function given_employee_when_user_not_encountered_then_not_found_exception(): void
    {
        $this->adminRepository->method('findAdminByUsername')
            ->with('Javier')
            ->willReturn(null);
        $searchAdminByUsername = new SearchAdminByUsername($this->adminRepository);
        $checkLoginEmployee = new CheckLoginAdmin(
            $this->adminRepository,
            $searchAdminByUsername,
            $this->checkDecryptPassword,
            $this->createToken
        );
        $this->expectException(NotFoundAdminsException::class);
        $checkLoginEmployee->handle($this->checkLoginAdminCommand);
    }

    /**
     * @test
     */
    public function given_employee_when_user_encountered_and_password_is_incorrect_then_not_found_exception(): void
    {
        $this->adminRepository->method('findAdminByUsername')
            ->with('Javier')
            ->willReturn($this->admin);
        $searchAdminByUsername = new SearchAdminByUsername($this->adminRepository);
        $checkLoginEmployee = new CheckLoginAdmin(
            $this->adminRepository,
            $searchAdminByUsername,
            $this->checkDecryptPassword,
            $this->createToken
        );
        $this->checkLoginAdminCommand = new CheckLoginAdminCommand(
            'Javier',
            '12345'
        );
        $this->expectException(IncorrectPasswordException::class);
        $checkLoginEmployee->handle($this->checkLoginAdminCommand);
    }

    /**
     * @test
     */
    public function given_employee_when_user_and_password_encountered_then_ok_response(): void
    {
        $this->adminRepository->method('findAdminByUsername')
            ->with('Javier')
            ->willReturn($this->admin);
        $searchAdminByUsername = new SearchAdminByUsername($this->adminRepository);
        $checkLoginEmployee = new CheckLoginAdmin(
            $this->adminRepository,
            $searchAdminByUsername,
            $this->checkDecryptPassword,
            $this->createToken
        );
        $result = $checkLoginEmployee->handle($this->checkLoginAdminCommand);
        $this->assertEquals(
            [
                'data' => 'h5O3P1cj9df.G9dg',
                'code' => 200
            ],
            $result
        );
    }
}
