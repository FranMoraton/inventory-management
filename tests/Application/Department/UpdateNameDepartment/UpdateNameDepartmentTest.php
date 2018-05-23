<?php

namespace Inventory\Management\Tests\Application\Department\UpdateNameDepartment;

use Inventory\Management\Application\Department\UpdateNameDepartment\UpdateNameDepartment;
use Inventory\Management\Application\Department\UpdateNameDepartment\UpdateNameDepartmentCommand;
use Inventory\Management\Domain\Model\Entity\Department\Department;
use Inventory\Management\Domain\Model\Entity\Department\NotFoundDepartmentsException;
use Inventory\Management\Domain\Service\Department\SearchDepartmentById;
use Inventory\Management\Domain\Service\JwtToken\CheckToken;
use Inventory\Management\Infrastructure\JwtToken\JwtTokenClass;
use Inventory\Management\Infrastructure\Repository\Department\DepartmentRepository;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class UpdateNameDepartmentTest extends TestCase
{
    /* @var MockObject $departmentRepository */
    private $departmentRepository;
    /* @var MockObject $jwtTokenClass */
    private $jwtTokenClass;
    private $checkToken;
    private $searchDepartmentById;
    private $updateNameDepartmentCommand;

    public function setUp(): void
    {
        $this->departmentRepository = $this->createMock(DepartmentRepository::class);
        $this->searchDepartmentById = new SearchDepartmentById($this->departmentRepository);
        $this->jwtTokenClass = $this->createMock(JwtTokenClass::class);
        $this->checkToken = new CheckToken($this->jwtTokenClass);
        $this->updateNameDepartmentCommand = new UpdateNameDepartmentCommand(1, 'Technology');
    }

    /**
     * @test
     */
    public function given_department_when_request_by_id_then_ko_error()
    {
        $idDepartment = 1;
        $this->departmentRepository->method('findDepartmentById')
            ->with($idDepartment)
            ->willReturn(null);
        $updateNameDepartment = new UpdateNameDepartment(
            $this->departmentRepository,
            $this->searchDepartmentById,
            $this->checkToken
        );
        $this->expectException(NotFoundDepartmentsException::class);
        $updateNameDepartment->handle($this->updateNameDepartmentCommand);
    }

    /**
     * @test
     */
    public function given_department_when_request_by_id_then_ok_response()
    {
        $idDepartment = 1;
        $nameDepartment = 'Technology';
        $department = $this->createMock(Department::class);
        $department->method('getId')
            ->willReturn($idDepartment);
        $department->method('getName')
            ->willReturn($nameDepartment);
        $this->departmentRepository->method('findDepartmentById')
            ->with($idDepartment)
            ->willReturn($department);
        $this->departmentRepository->method('createDepartment')
            ->with($department)
            ->willReturn($department);
        $updateNameDepartment = new UpdateNameDepartment(
            $this->departmentRepository,
            $this->searchDepartmentById,
            $this->checkToken
        );
        $result = $updateNameDepartment->handle($this->updateNameDepartmentCommand);
        $this->assertEquals(
            [
                'data' => 'Se ha actualizado el nombre del departamento con éxito',
                'code' => 200
            ],
            $result
        );
    }
}
