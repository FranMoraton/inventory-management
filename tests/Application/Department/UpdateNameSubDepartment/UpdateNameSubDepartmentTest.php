<?php

namespace Inventory\Management\Tests\Application\Department\UpdateNameSubDepartment;

use Inventory\Management\Application\Department\UpdateNameSubDepartment\UpdateNameSubDepartment;
use Inventory\Management\Application\Department\UpdateNameSubDepartment\UpdateNameSubDepartmentCommand;
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

    public function setUp(): void
    {
        $this->subDepartmentRepository = $this->createMock(SubDepartmentRepository::class);
        $this->searchSubDepartmentById = new SearchSubDepartmentById($this->subDepartmentRepository);
        $this->updateNameSubDepartmentCommand = new UpdateNameSubDepartmentCommand(1, 'Technology');
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
        $updateNameSubDepartment = new UpdateNameSubDepartment($this->subDepartmentRepository, $this->searchSubDepartmentById);
        $result = $updateNameSubDepartment->handle($this->updateNameSubDepartmentCommand);
        $this->assertEquals(
            [
                'data' => 'No se ha encontrado ningún subdepartamento',
                'code' => 404
            ],
            $result
        );
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
        $updateNameSubDepartment = new UpdateNameSubDepartment($this->subDepartmentRepository, $this->searchSubDepartmentById);
        $result = $updateNameSubDepartment->handle($this->updateNameSubDepartmentCommand);
        $this->assertEquals(
            [
                'data' => 'Se ha actualizado el nombre del subdepartamento con éxito',
                'code' => 200
            ],
            $result
        );
    }
}
