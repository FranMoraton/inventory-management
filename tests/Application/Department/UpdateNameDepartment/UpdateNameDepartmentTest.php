<?php

namespace Inventory\Management\Tests\Application\Department\UpdateNameDepartment;

use Inventory\Management\Application\Department\UpdateNameDepartment\UpdateNameDepartment;
use Inventory\Management\Application\Department\UpdateNameDepartment\UpdateNameDepartmentCommand;
use Inventory\Management\Domain\Model\Entity\Department\Department;
use Inventory\Management\Domain\Service\Department\SearchDepartmentById;
use Inventory\Management\Infrastructure\Repository\Department\DepartmentRepository;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class UpdateNameDepartmentTest extends TestCase
{
    /* @var MockObject $departmentRepository */
    private $departmentRepository;
    private $searchDepartmentById;
    private $updateNameDepartmentCommand;

    public function setUp(): void
    {
        $this->departmentRepository = $this->createMock(DepartmentRepository::class);
        $this->searchDepartmentById = new SearchDepartmentById($this->departmentRepository);
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
        $updateNameDepartment = new UpdateNameDepartment($this->departmentRepository, $this->searchDepartmentById);
        $result = $updateNameDepartment->handle($this->updateNameDepartmentCommand);
        $this->assertEquals(['ko' => 'No se ha encontrado ningún departamento'], $result);
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
        $updateNameDepartment = new UpdateNameDepartment($this->departmentRepository, $this->searchDepartmentById);
        $result = $updateNameDepartment->handle($this->updateNameDepartmentCommand);
        $this->assertEquals(['ok' => 200], $result);
    }
}
