<?php

namespace Inventory\Management\Application\Department\UpdateNameDepartment;

use Inventory\Management\Domain\Model\Entity\Department\DepartmentRepositoryInterface;
use Inventory\Management\Domain\Service\Department\SearchDepartmentById;
use Inventory\Management\Domain\Service\Util\Observer\ListExceptions;

class UpdateNameDepartment
{
    private $departmentRepository;
    private $searchDepartmentById;

    public function __construct(
        DepartmentRepositoryInterface $departmentRepository,
        SearchDepartmentById $searchDepartmentById
    ) {
        $this->departmentRepository = $departmentRepository;
        $this->searchDepartmentById = $searchDepartmentById;
        ListExceptions::instance()->restartExceptions();
        ListExceptions::instance()->attach($searchDepartmentById);
    }

    public function handle(UpdateNameDepartmentCommand $updateNameDepartmentCommand): array
    {
        $department = $this->searchDepartmentById->execute(
            $updateNameDepartmentCommand->department()
        );
        if (ListExceptions::instance()->checkForExceptions()) {
            return ListExceptions::instance()->firstException();
        }
        $this->departmentRepository->updateNameDepartment(
            $department,
            $updateNameDepartmentCommand->name()
        );

        return [
            'data' => 'Se ha actualizado el nombre del departamento con éxito',
            'code' => 200
        ];
    }
}
