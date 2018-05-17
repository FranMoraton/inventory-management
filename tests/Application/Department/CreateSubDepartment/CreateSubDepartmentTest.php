<?php

namespace Inventory\Management\Tests\Application\Department\CreateSubDepartment;

use Inventory\Management\Application\Department\CreateSubDepartment\CreateSubDepartment;
use Inventory\Management\Application\Department\CreateSubDepartment\CreateSubDepartmentCommand;
use Inventory\Management\Domain\Model\Entity\Department\Department;
use Inventory\Management\Domain\Model\Entity\Department\NotFoundDepartmentsException;
use Inventory\Management\Domain\Model\Entity\Department\SubDepartment;
use Inventory\Management\Domain\Service\Department\CheckNotExistNameSubDepartment;
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
    public function create_sub_department_then_name_sub_department_found_exception(): void
    {
        $name = 'warehouse';
        $idDepartment = 1;
        $this->departmentRepository->method('findDepartmentById')
            ->with($idDepartment)
            ->willReturn(null);
        $department = $this->createMock(Department::class);
        $subDepartment = new SubDepartment($department, 'warehouse');
        $this->subDepartmentRepository->method('checkNotExistNameSubDepartment')
            ->with($name)
            ->willReturn($subDepartment);
        $checkNotExistNameSubDepartment = new CheckNotExistNameSubDepartment($this->subDepartmentRepository);
        $createSubDepartment = new CreateSubDepartment(
            $this->subDepartmentRepository,
            $this->searchDepartmentById,
            $checkNotExistNameSubDepartment
        );
        $result = $createSubDepartment->handle($this->createDepartmentCommand);
        $this->assertEquals(
            [
                'data' => 'El subdepartamento ya existe',
                'code' => 409
            ],
            $result
        );
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
        $checkNotExistNameSubDepartment = new CheckNotExistNameSubDepartment($this->subDepartmentRepository);
        $createSubDepartment = new CreateSubDepartment(
            $this->subDepartmentRepository,
            $this->searchDepartmentById,
            $checkNotExistNameSubDepartment
        );
        $result = $createSubDepartment->handle($this->createDepartmentCommand);
        $this->assertEquals(
            [
                'data' => 'No se ha encontrado ningún departamento',
                'code' => 404
            ],
            $result
        );
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
        $checkNotExistNameSubDepartment = new CheckNotExistNameSubDepartment($this->subDepartmentRepository);
        $createSubDepartment = new CreateSubDepartment(
            $this->subDepartmentRepository,
            $this->searchDepartmentById,
            $checkNotExistNameSubDepartment
        );
        $result = $createSubDepartment->handle($this->createDepartmentCommand);
        $this->assertEquals(
            [
                'data' => 'Se ha creado el subdepartamento con éxito',
                'code' => 200
            ],
            $result
        );
    }
}
