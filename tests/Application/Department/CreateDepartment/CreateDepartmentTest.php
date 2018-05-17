<?php

namespace Inventory\Management\Tests\Application\Department\CreateDepartment;

use Inventory\Management\Application\Department\CreateDepartment\CreateDepartment;
use Inventory\Management\Application\Department\CreateDepartment\CreateDepartmentCommand;
use Inventory\Management\Domain\Model\Entity\Department\Department;
use Inventory\Management\Domain\Service\Department\CheckNotExistNameDepartment;
use Inventory\Management\Infrastructure\Repository\Department\DepartmentRepository;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class CreateDepartmentTest extends TestCase
{
    /* @var MockObject $departmentRepository */
    private $departmentRepository;
    private $department;
    private $createDepartmentCommand;

    public function setUp(): void
    {
        $this->department = new Department('warehouse');
        $this->departmentRepository = $this->createMock(DepartmentRepository::class);
        $this->departmentRepository->method('createDepartment')
            ->with($this->department)
            ->willReturn($this->department);
        $this->createDepartmentCommand = new CreateDepartmentCommand('warehouse');
    }

    /**
     * @test
     */
    public function create_department_then_name_department_found_exception(): void
    {
        $name = 'warehouse';
        $this->departmentRepository->method('checkNotExistNameDepartment')
            ->with($name)
            ->willReturn($this->department);
        $checkNotExistNameDepartment = new CheckNotExistNameDepartment($this->departmentRepository);
        $createDepartment = new CreateDepartment($this->departmentRepository, $checkNotExistNameDepartment);
        $result = $createDepartment->handle($this->createDepartmentCommand);
        $this->assertEquals(
            [
                'data' => 'El departamento ya existe',
                'code' => 409
            ],
            $result
        );
    }

    /**
     * @test
     */
    public function create_department_then_ok_response(): void
    {
        $checkNotExistNameDepartment = new CheckNotExistNameDepartment($this->departmentRepository);
        $createDepartment = new CreateDepartment($this->departmentRepository, $checkNotExistNameDepartment);
        $result = $createDepartment->handle($this->createDepartmentCommand);
        $this->assertEquals(
            [
                'data' => 'Se ha creado el departamento con éxito',
                'code' => 200
            ],
            $result
        );
    }
}
