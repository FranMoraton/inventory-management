<?php

namespace Inventory\Management\Tests\Application\Department\CreateSubDepartment;

use Inventory\Management\Application\Department\CreateSubDepartment\CreateSubDepartment;
use Inventory\Management\Application\Department\CreateSubDepartment\CreateSubDepartmentCommand;
use Inventory\Management\Domain\Model\Entity\Department\Department;
use Inventory\Management\Domain\Model\Entity\Department\NotFoundDepartmentsException;
use Inventory\Management\Domain\Model\Entity\Department\SubDepartment;
use Inventory\Management\Domain\Service\Department\SearchDepartmentById;
use Inventory\Management\Infrastructure\Repository\Department\DepartmentRepository;
use Inventory\Management\Infrastructure\Repository\Department\SubDepartmentRepository;
use PHPUnit\Framework\MockObject\MockBuilder;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class CreateSubDepartmentTest extends TestCase
{
    /* @var MockObject $departmentRepository */
    private $departmentRepository;
    /* @var MockObject $subDepartmentRepository */
    private $subDepartmentRepository;
    private $searchDepartmentById;
    private $createDepartmentCommand;

    public function setUp(): void
    {
        $this->departmentRepository = $this->createMock(DepartmentRepository::class);
        $this->subDepartmentRepository = $this->createMock(SubDepartmentRepository::class);
        $this->searchDepartmentById = new SearchDepartmentById($this->departmentRepository);
        $this->createDepartmentCommand = new CreateSubDepartmentCommand(1, 'warehouse');
    }

    /**
     * @test
     */
    public function create_sub_department_then_department_not_found_exception(): void
    {
        $idDepartment = 1;
        $this->departmentRepository->method('findDepartmentById')
            ->with($idDepartment)
            ->willReturn(null);
        $createSubDepartment = new CreateSubDepartment($this->subDepartmentRepository, $this->searchDepartmentById);
        $result = $createSubDepartment->handle($this->createDepartmentCommand);
        $this->assertEquals(['ko' => 'No se ha encontrado ningún departamento'], $result);
    }

    /**
     * @test
     */
    public function create_sub_department_then_ok_response(): void
    {
        $idDepartment = 1;
        $department = $this->createMock(Department::class);
        $subDepartment = new SubDepartment($department, 'warehouse');
        $this->departmentRepository->method('findDepartmentById')
            ->with($idDepartment)
            ->willReturn($department);
        $this->subDepartmentRepository->method('createSubDepartment')
            ->with($subDepartment)
            ->willReturn($subDepartment);
        $createSubDepartment = new CreateSubDepartment($this->subDepartmentRepository, $this->searchDepartmentById);
        $result = $createSubDepartment->handle($this->createDepartmentCommand);
        $this->assertEquals(['ok' => 200], $result);
    }
}
