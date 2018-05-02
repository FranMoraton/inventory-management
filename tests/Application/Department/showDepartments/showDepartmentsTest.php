<?php

namespace Inventory\Management\Tests\Application\Department\showDepartments;

use Doctrine\Common\Collections\ArrayCollection;
use Inventory\Management\Application\Department\showDepartments\ShowDepartments;
use Inventory\Management\Application\Department\showDepartments\ShowDepartmentsTransform;
use Inventory\Management\Domain\Model\Entity\Department\Department;
use Inventory\Management\Domain\Model\Entity\Department\NotFoundDepartmentsException;
use Inventory\Management\Infrastructure\Repository\Department\DepartmentRepository;
use PHPUnit\Framework\TestCase;

class showDepartmentsTest extends TestCase
{
    /**
     * @test
     */
    public function given_departments_when_request_then_not_found_exception(): void
    {
        $departmentRepository = $this->getMockBuilder(DepartmentRepository::class)
            ->disableOriginalConstructor()
            ->getMock();
        $departmentRepository->method('showAllDepartments')
            ->willReturn([]);
        $showDepartmentsTransform = new ShowDepartmentsTransform();
        $showDepartments = new ShowDepartments($departmentRepository, $showDepartmentsTransform);
        $this->expectException(NotFoundDepartmentsException::class);
        $showDepartments->handle();
    }

    /**
     * @test
     */
    public function given_departments_when_request_then_show(): void
    {
        $department = $this->getMockBuilder(Department::class)
            ->disableOriginalConstructor()
            ->getMock();
        $department->method('getId')
            ->willReturn(1);
        $department->method('getName')
            ->willReturn('warehouse');
        $department->method('getSubDepartments')
            ->willReturn(new ArrayCollection());
        $departmentRepository = $this->getMockBuilder(DepartmentRepository::class)
            ->disableOriginalConstructor()
            ->getMock();
        $departmentRepository->method('showAllDepartments')
            ->willReturn([$department]);
        $showDepartmentsTransform = new ShowDepartmentsTransform();
        $showDepartments = new ShowDepartments($departmentRepository, $showDepartmentsTransform);
        $this->assertArraySubset(
            [
                0 => [
                    'id' => 1,
                    'name' => 'warehouse'
                ]
            ],
            $showDepartments->handle()
        );
    }
}
