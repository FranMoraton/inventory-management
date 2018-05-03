<?php

namespace Inventory\Management\Tests\Application\Department\CreateSubDepartment;

use Inventory\Management\Application\Department\CreateSubDepartment\CreateSubDepartment;
use Inventory\Management\Application\Department\CreateSubDepartment\CreateSubDepartmentCommand;
use Inventory\Management\Domain\Model\Entity\Department\Department;
use Inventory\Management\Domain\Model\Entity\Department\NotFoundDepartmentsException;
use Inventory\Management\Domain\Model\Entity\Department\SubDepartment;
use Inventory\Management\Infrastructure\Repository\Department\DepartmentRepository;
use Inventory\Management\Infrastructure\Repository\Department\SubDepartmentRepository;
use PHPUnit\Framework\TestCase;

class CreateSubDepartmentTest extends TestCase
{
    /**
     * @test
     */
    public function create_sub_department_then_department_not_found_exception(): void
    {
        $idDepartment = 1;
        $departmentRepository = $this->getMockBuilder(DepartmentRepository::class)
            ->disableOriginalConstructor()
            ->getMock();
        $departmentRepository->method('findDepartmentById')
            ->with($idDepartment)
            ->willReturn(null);
        $subDepartmentRepository = $this->getMockBuilder(SubDepartmentRepository::class)
            ->disableOriginalConstructor()
            ->getMock();
        $createSubDepartment = new CreateSubDepartment($departmentRepository, $subDepartmentRepository);
        $this->expectException(NotFoundDepartmentsException::class);
        $createDepartmentCommand = new CreateSubDepartmentCommand(1, 'warehouse');
        $createSubDepartment->handle($createDepartmentCommand);
    }

    /**
     * @test
     */
    public function create_sub_department_then_ok_response(): void
    {
        $idDepartment = 1;
        $department = $this->getMockBuilder(Department::class)
            ->disableOriginalConstructor()
            ->getMock();
        $subDepartment = new SubDepartment($department, 'warehouse');
        $departmentRepository = $this->getMockBuilder(DepartmentRepository::class)
            ->disableOriginalConstructor()
            ->getMock();
        $departmentRepository->method('findDepartmentById')
            ->with($idDepartment)
            ->willReturn($department);
        $subDepartmentRepository = $this->getMockBuilder(SubDepartmentRepository::class)
            ->disableOriginalConstructor()
            ->getMock();
        $subDepartmentRepository->method('createSubDepartment')
            ->with($subDepartment)
            ->willReturn($subDepartment);
        $createSubDepartment = new CreateSubDepartment($departmentRepository, $subDepartmentRepository);
        $createDepartmentCommand = new CreateSubDepartmentCommand(1, 'warehouse');
        $createSubDepartment->handle($createDepartmentCommand);
        $this->assertTrue(true, true);
    }
}
