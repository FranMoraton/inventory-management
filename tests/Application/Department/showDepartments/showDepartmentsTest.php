<?php

namespace Inventory\Management\Tests\Application\Department\showDepartments;

use Doctrine\Common\Collections\ArrayCollection;
use Inventory\Management\Application\Department\showDepartments\ShowDepartments;
use Inventory\Management\Application\Department\showDepartments\ShowDepartmentsTransform;
use Inventory\Management\Domain\Model\Entity\Department\Department;
use Inventory\Management\Infrastructure\Repository\Department\DepartmentRepository;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class showDepartmentsTest extends TestCase
{
    /* @var MockObject */
    private $departmentRepository;
    private $showDepartmentsTransform;

    public function setUp(): void
    {
        $this->departmentRepository = $this->createMock(DepartmentRepository::class);
        $this->showDepartmentsTransform = new ShowDepartmentsTransform();
    }

    /**
     * @test
     */
    public function given_departments_when_request_then_show(): void
    {
        $department = $this->createMock(Department::class);
        $department->method('getId')
            ->willReturn(1);
        $department->method('getName')
            ->willReturn('warehouse');
        $department->method('getSubDepartments')
            ->willReturn(new ArrayCollection());
        $this->departmentRepository->method('showAllDepartments')
            ->willReturn([$department]);
        $showDepartments = new ShowDepartments($this->departmentRepository, $this->showDepartmentsTransform);
        $result = $showDepartments->handle();
        $this->assertArraySubset(
            [
                'data' => [
                    0 => [
                        'id' => 1,
                        'name' => 'warehouse'
                    ]
                ]
            ],
            $result
        );
    }
}
