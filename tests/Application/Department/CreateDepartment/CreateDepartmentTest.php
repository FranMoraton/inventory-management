<?php

namespace Inventory\Management\Tests\Application\Department\CreateDepartment;

use Doctrine\ORM\ORMException;
use Inventory\Management\Application\Department\CreateDepartment\CreateDepartment;
use Inventory\Management\Application\Department\CreateDepartment\CreateDepartmentCommand;
use Inventory\Management\Domain\Model\Entity\Department\CanNotCreateDepartmentException;
use Inventory\Management\Domain\Model\Entity\Department\Department;
use Inventory\Management\Infrastructure\Repository\Department\DepartmentRepository;
use PHPUnit\Framework\TestCase;

class CreateDepartmentTest extends TestCase
{
    /**
     * @test
     */
    public function create_department_then_can_not_create_exception(): void
    {
        $department = new Department('warehouse');
        $departmentRepository = $this->getMockBuilder(DepartmentRepository::class)
            ->disableOriginalConstructor()
            ->getMock();
        $departmentRepository->method('createDepartment')
            ->with($department)
            ->willThrowException(new ORMException());
        $createDepartment = new CreateDepartment($departmentRepository);
        $this->expectException(CanNotCreateDepartmentException::class);
        $createDepartmentCommand = new CreateDepartmentCommand('warehouse');
        $createDepartment->handle($createDepartmentCommand);
    }

    /**
     * @test
     */
    public function create_department_then_ok_response(): void
    {
        $department = new Department('warehouse');

        $departmentRepository = $this->getMockBuilder(DepartmentRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        $departmentRepository->method('createDepartment')
            ->with($department)
            ->willReturn($department);

        $createDepartment = new CreateDepartment($departmentRepository);

        $createDepartmentCommand = new CreateDepartmentCommand('warehouse');
        $createDepartment->handle($createDepartmentCommand);

        $this->assertTrue(true, true);
    }
}