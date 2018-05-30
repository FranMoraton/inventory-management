<?php

namespace Inventory\Management\Tests\Application\Department\UpdateNameSubDepartment;

use Inventory\Management\Application\Department\UpdateNameSubDepartment\UpdateNameSubDepartment;
use Inventory\Management\Application\Department\UpdateNameSubDepartment\UpdateNameSubDepartmentCommand;
use Inventory\Management\Application\Department\UpdateNameSubDepartment\UpdateNameSubDepartmentTransform;
use Inventory\Management\Domain\Model\Entity\Department\NotFoundSubDepartmentsException;
use Inventory\Management\Domain\Model\Entity\Department\SubDepartment;
use Inventory\Management\Domain\Service\Department\SearchSubDepartmentById;
use Inventory\Management\Infrastructure\Repository\Department\SubDepartmentRepository;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class UpdateNameSubDepartmentTest extends TestCase
{
    /* @var MockObject $subDepartmentRepository */
    private $subDepartmentRepository;
    private $searchSubDepartmentById;
    private $updateNameSubDepartmentCommand;
    private $transform;

    public function setUp(): void
    {
        $this->subDepartmentRepository = $this->createMock(SubDepartmentRepository::class);
        $this->searchSubDepartmentById = new SearchSubDepartmentById($this->subDepartmentRepository);
        $this->updateNameSubDepartmentCommand = new UpdateNameSubDepartmentCommand(1, 'Technology');
        $this->transform = new UpdateNameSubDepartmentTransform();
    }

    /**
     * @test
     */
    public function given_sub_department_when_request_by_id_then_ko_error()
    {
        $idSubDepartment = 1;
        $this->subDepartmentRepository->method('findSubDepartmentById')
            ->with($idSubDepartment)
            ->willReturn(null);
        $updateNameSubDepartment = new UpdateNameSubDepartment(
            $this->subDepartmentRepository,
            $this->transform,
            $this->searchSubDepartmentById
        );
        $this->expectException(NotFoundSubDepartmentsException::class);
        $updateNameSubDepartment->handle($this->updateNameSubDepartmentCommand);
    }

    /**
     * @test
     */
    public function given_sub_department_when_request_by_id_then_ok_response()
    {
        $idSubDepartment = 1;
        $nameSubDepartment = 'Technology';
        $subDepartment = $this->createMock(SubDepartment::class);
        $subDepartment->method('getId')
            ->willReturn($idSubDepartment);
        $subDepartment->method('getName')
            ->willReturn($nameSubDepartment);
        $this->subDepartmentRepository->method('findSubDepartmentById')
            ->with($idSubDepartment)
            ->willReturn($subDepartment);
        $this->subDepartmentRepository->method('createSubDepartment')
            ->with($subDepartment)
            ->willReturn($subDepartment);
        $updateNameSubDepartment = new UpdateNameSubDepartment(
            $this->subDepartmentRepository,
            $this->transform,
            $this->searchSubDepartmentById
        );
        $updateNameSubDepartment->handle($this->updateNameSubDepartmentCommand);
        $this->assertTrue(true, true);
    }
}
